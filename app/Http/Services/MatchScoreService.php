<?php

namespace App\Http\Services;

use App\Mail\SystemNotification;
use App\Models\MatchScoreRequest;
use App\Models\Partido;
use App\Models\PushNotification;
use App\Models\PushNotificationType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class MatchScoreService
{
    public function scheduleScorePolling(Partido $partido): ?MatchScoreRequest
    {
        $existing = MatchScoreRequest::where('partido_id', $partido->id)->first();

        if ($existing && in_array($existing->status, MatchScoreRequest::ACTIVE_STATUSES, true)) {
            return $existing;
        }

        if (! $partido->fecha_partido || ! $partido->api_fixture_id) {
            $this->notify(
                'MatchScoreService::scheduleScorePolling — Datos insuficientes',
                "No se puede agendar polling para Partido id={$partido->id}: fecha_partido=" .
                ($partido->fecha_partido?->toIso8601String() ?? 'null') .
                ", api_fixture_id=" . ($partido->api_fixture_id ?? 'null') . '.'
            );
            return null;
        }

        $payload = [
            'partido_id'      => $partido->id,
            'api_fixture_id'  => $partido->api_fixture_id,
            'status'          => MatchScoreRequest::STATUS_PENDING,
            'scheduled_at'    => $partido->fecha_partido->copy()->addMinutes(MatchScoreRequest::INITIAL_OFFSET_MINUTES),
            'attempts'        => 0,
            'last_goals_home' => 0,
            'last_goals_away' => 0,
        ];

        if ($existing) {
            $existing->update($payload + [
                'last_attempted_at' => null,
                'last_status_short' => null,
                'last_status_long'  => null,
                'last_notified_at'  => null,
                'last_error'        => null,
                'completed_at'      => null,
            ]);
            return $existing->refresh();
        }

        return MatchScoreRequest::create($payload);
    }

    public function cancelScorePolling(Partido $partido): bool
    {
        $request = MatchScoreRequest::where('partido_id', $partido->id)
            ->whereIn('status', MatchScoreRequest::ACTIVE_STATUSES)
            ->first();

        if (! $request) return false;

        $request->status = MatchScoreRequest::STATUS_CANCELED;
        $request->save();

        return true;
    }

    public function processScoreRequest(MatchScoreRequest $request): void
    {
        $claimed = MatchScoreRequest::where('id', $request->id)
            ->whereIn('status', [MatchScoreRequest::STATUS_PENDING, MatchScoreRequest::STATUS_POLLING])
            ->update([
                'status'            => MatchScoreRequest::STATUS_FETCHING,
                'last_attempted_at' => now(),
            ]);

        if ($claimed === 0) return;

        $request->refresh();

        try {
            $result = app(ApiFootballService::class)->getFixture($request->api_fixture_id);

            if ($result['error'] === true || ! $result['fixture']) {
                $this->bumpFailedAttempt($request, 'API request failed or returned empty.');
                return;
            }

            $fixture = $result['fixture'];

            $request->last_status_short = $fixture->status_short;
            $request->last_status_long  = $fixture->status_long;

            $homeGoals = (int) ($fixture->goals_home ?? 0);
            $awayGoals = (int) ($fixture->goals_away ?? 0);

            $scoreChanged = $homeGoals !== (int) $request->last_goals_home
                || $awayGoals !== (int) $request->last_goals_away;

            if ($scoreChanged) {
                $this->dispatchGoalNotification($request, $homeGoals, $awayGoals);
                $request->last_goals_home = $homeGoals;
                $request->last_goals_away = $awayGoals;
                $request->last_notified_at = now();
            }

            $finished = in_array($fixture->status_short, ['FT', 'AET', 'PEN'], true);

            if ($finished) {
                $request->status       = MatchScoreRequest::STATUS_COMPLETED;
                $request->completed_at = now();
                $request->save();
                return;
            }

            $request->attempts++;

            if ($request->attempts >= MatchScoreRequest::MAX_ATTEMPTS) {
                $request->status     = MatchScoreRequest::STATUS_FAILED;
                $request->last_error = "Max attempts reached. Last status: {$fixture->status_short}.";
            } else {
                $request->status       = MatchScoreRequest::STATUS_POLLING;
                $request->scheduled_at = now()->addMinutes(MatchScoreRequest::RETRY_INTERVAL_MINUTES);
            }

            $request->save();
        } catch (Throwable $e) {
            $this->notify(
                'MatchScoreService::processScoreRequest — Excepción',
                "Request id={$request->id}, api_fixture_id={$request->api_fixture_id}. " .
                $e->getMessage() . "\n" . $e->getTraceAsString()
            );

            $this->bumpFailedAttempt($request, $e->getMessage());
        }
    }

    private function dispatchGoalNotification(
        MatchScoreRequest $request,
        int $homeGoals,
        int $awayGoals
    ): void {
        $partido = $request->partido()->with('equipos.equipoUno:id,nombre', 'equipos.equipoDos:id,nombre')->first();

        if (! $partido || ! $partido->equipos) {
            $this->notify(
                'MatchScoreService::dispatchGoalNotification — Partido/equipos faltantes',
                "Request id={$request->id} no tiene partido/equipos. No se envió notificación."
            );
            return;
        }

        $nombre1 = $partido->equipos->equipoUno?->nombre ?? 'Local';
        $nombre2 = $partido->equipos->equipoDos?->nombre ?? 'Visitante';

        $title = "¡GOL! {$nombre1} {$homeGoals} - {$awayGoals} {$nombre2}";
        $body  = $this->randomGoalBody($nombre1, $nombre2, $homeGoals, $awayGoals);

        $matchType = PushNotificationType::where('slug', PushNotificationType::MATCH)->first();

        $pushNotification = PushNotification::create([
            'push_notification_type_id' => $matchType?->id,
            'partido_id'   => $partido->id,
            'title'        => $title,
            'description'  => $body,
            'status'       => PushNotification::STATUS_SENDING,
            'scheduled_at' => now(),
            'from_system'  => true,
        ]);

        $result = app(PushNotificationService::class)->sendLiveScoreNotification($pushNotification);

        $pushNotification->update([
            'status'     => $result['success'] ? PushNotification::STATUS_SENT : PushNotification::STATUS_FAILED,
            'sent_at'    => now(),
            'recipients' => $result['total'],
            'success'    => $result['success'],
            'failed'     => $result['failed'],
            'comment'    => $result['error'],
        ]);
    }

    private function randomGoalBody(string $nombre1, string $nombre2, int $homeGoals, int $awayGoals): string
    {
        $isDraw    = $homeGoals === $awayGoals;
        $homeLeads = $homeGoals > $awayGoals;
        $leader    = $homeLeads ? $nombre1 : $nombre2;
        $trailer   = $homeLeads ? $nombre2 : $nombre1;

        $bodies = [
            "¡El balón no deja de moverse! {$nombre1} vs {$nombre2} está imparable. No te lo puedes perder. ⚽🔥",
            "¡Atención! Algo está pasando en {$nombre1} vs {$nombre2}. Enciende la tele y vive la emoción. 📺⚡",
            "El marcador cambió en {$nombre1} vs {$nombre2}. ¿Vas a dejar que te cuenten lo que pasó? 👀",
            "¡Esto se pone bueno! {$nombre1} {$homeGoals} - {$awayGoals} {$nombre2}. La adrenalina está al máximo. 💥",
            "¡{$nombre1} y {$nombre2} están regalando un partidazo! Súmate y vive cada jugada. 🏟️🔥",
            "¡Un nuevo gol sacude el partido! Corre a verlo, {$nombre1} vs {$nombre2} está que arde. 🚨",
            "El estadio explota: {$nombre1} {$homeGoals} - {$awayGoals} {$nombre2}. ¿Lo estás viendo? 🤯",
            "¡Drama puro en {$nombre1} vs {$nombre2}! Quien parpadee se pierde lo mejor. 😱",
        ];

        if (! $isDraw) {
            $leaderGoals  = $homeLeads ? $homeGoals : $awayGoals;
            $trailerGoals = $homeLeads ? $awayGoals : $homeGoals;
            $bodies[] = "¡{$leader} se adelanta {$leaderGoals} - {$trailerGoals}! ¿{$trailer} podrá reaccionar? Velo en vivo. 🔥";
            $bodies[] = "¡{$leader} está al frente! El marcador no miente: {$nombre1} {$homeGoals} - {$awayGoals} {$nombre2}. Conéctate ya. ⚽";
            $bodies[] = "{$trailer} necesita despertar… {$leader} ya golpea primero. ¿Habrá remontada? 👀🔥";
        } else {
            $bodies[] = "¡Empate dramático! {$nombre1} {$homeGoals} - {$awayGoals} {$nombre2}. Cualquiera puede ganarlo. 🔥";
            $bodies[] = "¡Iguales en el marcador! {$nombre1} vs {$nombre2} promete final de película. 💓";
        }

        return $bodies[array_rand($bodies)];
    }

    private function bumpFailedAttempt(MatchScoreRequest $request, string $error): void
    {
        $request->attempts++;
        $request->last_error = $error;

        if ($request->attempts >= MatchScoreRequest::MAX_ATTEMPTS) {
            $request->status = MatchScoreRequest::STATUS_FAILED;
        } else {
            $request->status       = MatchScoreRequest::STATUS_POLLING;
            $request->scheduled_at = now()->addMinutes(MatchScoreRequest::RETRY_INTERVAL_MINUTES);
        }

        $request->save();
    }

    private function notify(string $subject, string $body): void
    {
        Log::warning($subject . ' :: ' . $body);

        $to = config('quiniela.system_notifications_email');

        if (empty($to)) return;

        Mail::to($to)->send(new SystemNotification($subject, $body));
    }
}
