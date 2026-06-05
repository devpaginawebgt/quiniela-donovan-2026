<?php

namespace App\Http\Services;

use App\Events\MatchCreated;
use App\Events\ResultCreated;
use App\Mail\SystemNotification;
use App\Models\ApiFixture;
use App\Models\Equipo;
use App\Models\EquipoPartido;
use App\Models\Jornada;
use App\Models\MatchResultRequest;
use App\Models\Partido;
use App\Models\ResultadoPartido;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class MatchService
{
    /**
     * Sincroniza Partidos locales contra una colección de ApiFixtures.
     *
     * 1) Match por `partidos.api_fixture_id`.
     * 2) Si no, match por jornada + mismos equipos (order-agnostic). Backfill
     *    de `api_fixture_id` para los partidos seedeados (fase de grupos).
     * 3) Si tampoco, crea Partido + EquipoPartido y dispara `MatchCreated`.
     *
     * Para existentes (steps 1 y 2), actualiza `api_fixture_id` y/o
     * `fecha_partido` si cambiaron. Por cada partido creado/enlazado agenda
     * una MatchResultRequest; si cambia la fecha, recalcula `scheduled_at`.
     *
     * @param  Collection<int,ApiFixture> $fixtures
     * @return array{error: bool, created: int, linked: int, updated: int, skipped: int}
     */
    public function getMatches(Collection $fixtures): array
    {
        $created = 0;
        $linked  = 0;
        $updated = 0;
        $skipped = 0;

        try {
            foreach ($fixtures as $fixture) {
                $jornada = Jornada::where('api_round', $fixture->round)->first();

                if (! $jornada) {
                    $this->notify(
                        'MatchService::getMatches — Jornada no encontrada',
                        "No existe Jornada con api_round '{$fixture->round}' (api_fixture_id={$fixture->api_fixture_id})."
                    );
                    $skipped++;
                    continue;
                }

                $equipo_1 = Equipo::where('api_team_id', $fixture->api_home_team_id)->value('id');
                $equipo_2 = Equipo::where('api_team_id', $fixture->api_away_team_id)->value('id');

                if (! $equipo_1 || ! $equipo_2) {
                    $this->notify(
                        'MatchService::getMatches — Equipo no enlazado',
                        "Fixture api_fixture_id={$fixture->api_fixture_id}: home={$fixture->api_home_team_id} away={$fixture->api_away_team_id}. Falta enlace en equipos.api_team_id."
                    );
                    $skipped++;
                    continue;
                }

                $partido = Partido::where('api_fixture_id', $fixture->api_fixture_id)->first();

                $matchedByTeams = false;

                if (! $partido) {
                    $candidates = Partido::where('jornada_id', $jornada->id)
                        ->whereHas('equipos', function ($q) use ($equipo_1, $equipo_2) {
                            $q->where(function ($qq) use ($equipo_1, $equipo_2) {
                                $qq->where('equipo_1', $equipo_1)->where('equipo_2', $equipo_2);
                            })->orWhere(function ($qq) use ($equipo_1, $equipo_2) {
                                $qq->where('equipo_1', $equipo_2)->where('equipo_2', $equipo_1);
                            });
                        })
                        ->orderBy('id')
                        ->get();

                    if ($candidates->count() > 1) {
                        $this->notify(
                            'MatchService::getMatches — Múltiples partidos por teams',
                            "Jornada {$jornada->id} tiene {$candidates->count()} partidos con equipos {$equipo_1} vs {$equipo_2} (api_fixture_id={$fixture->api_fixture_id}). Se toma el de menor id."
                        );
                    }

                    $partido = $candidates->first();

                    if ($partido) {
                        if ($partido->api_fixture_id && $partido->api_fixture_id !== $fixture->api_fixture_id) {
                            $this->notify(
                                'MatchService::getMatches — Conflicto api_fixture_id',
                                "Partido id={$partido->id} ya tiene api_fixture_id={$partido->api_fixture_id}, pero el fixture entrante es {$fixture->api_fixture_id}. Se omite."
                            );
                            $skipped++;
                            continue;
                        }
                        $matchedByTeams = true;
                    }
                }

                if (! $partido) {
                    DB::transaction(function () use ($fixture, $jornada, $equipo_1, $equipo_2) {
                        $partido = Partido::create([
                            'jornada_id'     => $jornada->id,
                            'fecha_partido'  => $fixture->date,
                            'estadio_id'     => 1,
                            'fase'           => null,
                            'brand_id'       => null,
                            'jugado'         => 0,
                            'estado'         => 0,
                            'api_fixture_id' => $fixture->api_fixture_id,
                        ]);

                        EquipoPartido::create([
                            'partido_id' => $partido->id,
                            'equipo_1'   => $equipo_1,
                            'equipo_2'   => $equipo_2,
                        ]);

                        $this->scheduleResultRequest($partido);

                        $partido->load('equipos');
                        MatchCreated::dispatch($partido);
                    });

                    $created++;
                    continue;
                }

                $changes = [];

                if ($matchedByTeams && ! $partido->api_fixture_id) {
                    $changes['api_fixture_id'] = $fixture->api_fixture_id;
                }

                if ($fixture->date && (! $partido->fecha_partido || ! $partido->fecha_partido->equalTo($fixture->date))) {
                    $changes['fecha_partido'] = $fixture->date;
                }

                if (empty($changes)) {
                    $skipped++;
                    continue;
                }

                $partido->update($changes);

                if (array_key_exists('api_fixture_id', $changes)) {
                    $this->scheduleResultRequest($partido->refresh());
                    $linked++;
                }

                if (array_key_exists('fecha_partido', $changes)) {
                    $this->rescheduleResultRequest($partido);
                    $updated++;
                }
            }

            return [
                'error'   => false,
                'created' => $created,
                'linked'  => $linked,
                'updated' => $updated,
                'skipped' => $skipped,
            ];
        } catch (Throwable $e) {
            $this->notify(
                'MatchService::getMatches — Excepción',
                $e->getMessage() . "\n" . $e->getTraceAsString()
            );

            return [
                'error'   => true,
                'created' => $created,
                'linked'  => $linked,
                'updated' => $updated,
                'skipped' => $skipped,
            ];
        }
    }

    /**
     * Crea ResultadoPartido para cada ApiFixture finalizado (FT/AET/PEN) cuyo
     * Partido local exista y aún no tenga resultado. Marcador guardado:
     * **fulltime** (`ft_goals_*`) — alargue y penales se ignoran.
     *
     * @param  Collection<int,ApiFixture> $fixtures
     * @return array{error: bool, created: int, skipped: int}
     */
    public function getMatchesResult(Collection $fixtures): array
    {
        $created = 0;
        $skipped = 0;

        try {
            foreach ($fixtures as $fixture) {
                $finished = in_array($fixture->status_short, ['FT', 'AET', 'PEN'], true)
                    && $fixture->ft_goals_home !== null
                    && $fixture->ft_goals_away !== null;

                if (! $finished) {
                    $skipped++;
                    continue;
                }

                $partido = Partido::where('api_fixture_id', $fixture->api_fixture_id)->first();

                if (! $partido) {
                    $this->notify(
                        'MatchService::getMatchesResult — Partido no encontrado',
                        "No existe Partido con api_fixture_id={$fixture->api_fixture_id}. ¿Olvidaste correr getMatches primero?"
                    );
                    $skipped++;
                    continue;
                }

                if (ResultadoPartido::where('partido_id', $partido->id)->exists()) {
                    $skipped++;
                    continue;
                }

                $equipos = EquipoPartido::with(['equipoUno:id,nombre', 'equipoDos:id,nombre'])
                    ->where('partido_id', $partido->id)
                    ->first();

                if (! $equipos) {
                    $this->notify(
                        'MatchService::getMatchesResult — EquipoPartido faltante',
                        "Partido id={$partido->id} (api_fixture_id={$fixture->api_fixture_id}) no tiene registro en equipo_partidos."
                    );
                    $skipped++;
                    continue;
                }

                $ganador_id = null;

                if ($fixture->ft_goals_home > $fixture->ft_goals_away) {
                    $ganador_id = $equipos->equipo_1;
                } elseif ($fixture->ft_goals_home < $fixture->ft_goals_away) {
                    $ganador_id = $equipos->equipo_2;
                }

                $resultado = ResultadoPartido::create([
                    'partido_id'        => $partido->id,
                    'goles_equipo_1'    => $fixture->ft_goals_home,
                    'goles_equipo_2'    => $fixture->ft_goals_away,
                    'equipo_ganador_id' => $ganador_id,
                ]);

                $nombre1 = $equipos->equipoUno?->nombre ?? "Equipo #{$equipos->equipo_1}";
                $nombre2 = $equipos->equipoDos?->nombre ?? "Equipo #{$equipos->equipo_2}";
                $ganadorTexto = match (true) {
                    $ganador_id === null                  => 'Empate al 90',
                    $ganador_id === $equipos->equipo_1    => $nombre1,
                    $ganador_id === $equipos->equipo_2    => $nombre2,
                    default                                => "Equipo #{$ganador_id}",
                };

                $emailTo = config('quiniela.system_notifications_email');

                if (! empty($emailTo)) {
                    $subject = "Resultado registrado — {$nombre1} {$fixture->ft_goals_home} - {$fixture->ft_goals_away} {$nombre2}";
                    $body    = "Se registró un nuevo resultado de partido:\n\n" .
                        "Partido id:     {$partido->id} (api_fixture_id: {$fixture->api_fixture_id})\n" .
                        "Jornada id:     {$partido->jornada_id}\n" .
                        "Marcador FT:    {$nombre1} {$fixture->ft_goals_home} - {$fixture->ft_goals_away} {$nombre2}\n" .
                        "Ganador:        {$ganadorTexto}\n" .
                        "Status API:     {$fixture->status_short} ({$fixture->status_long})";

                    Mail::to($emailTo)->send(new SystemNotification($subject, $body));
                }

                ResultCreated::dispatch($resultado);

                $created++;
            }

            return ['error' => false, 'created' => $created, 'skipped' => $skipped];
        } catch (Throwable $e) {
            $this->notify(
                'MatchService::getMatchesResult — Excepción',
                $e->getMessage() . "\n" . $e->getTraceAsString()
            );

            return ['error' => true, 'created' => $created, 'skipped' => $skipped];
        }
    }

    public function scheduleResultRequest(Partido $partido): ?MatchResultRequest
    {
        $existing = MatchResultRequest::where('partido_id', $partido->id)->first();

        if ($existing) return $existing;

        if (! $partido->fecha_partido || ! $partido->api_fixture_id) {
            $this->notify(
                'MatchService::scheduleResultRequest — Datos insuficientes',
                "No se puede agendar request para Partido id={$partido->id}: fecha_partido=" .
                ($partido->fecha_partido?->toIso8601String() ?? 'null') .
                ", api_fixture_id=" . ($partido->api_fixture_id ?? 'null') . '.'
            );
            return null;
        }

        return MatchResultRequest::create([
            'partido_id'     => $partido->id,
            'api_fixture_id' => $partido->api_fixture_id,
            'status'         => MatchResultRequest::STATUS_PENDING,
            'scheduled_at'   => $partido->fecha_partido->copy()->addMinutes(MatchResultRequest::OFFSET_MINUTES),
            'attempts'       => 0,
        ]);
    }

    public function rescheduleResultRequest(Partido $partido): void
    {
        if (! $partido->fecha_partido) return;

        MatchResultRequest::where('partido_id', $partido->id)
            ->update([
                'scheduled_at' => $partido->fecha_partido->copy()->addMinutes(MatchResultRequest::OFFSET_MINUTES),
            ]);
    }

    public function processResultRequest(MatchResultRequest $request): void
    {
        $claimed = MatchResultRequest::where('id', $request->id)
            ->where('status', MatchResultRequest::STATUS_PENDING)
            ->update([
                'status'            => MatchResultRequest::STATUS_FETCHING,
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
            $request->last_goals_home   = $fixture->goals_home;
            $request->last_goals_away   = $fixture->goals_away;

            $finished = in_array($fixture->status_short, ['FT', 'AET', 'PEN'], true)
                && $fixture->ft_goals_home !== null
                && $fixture->ft_goals_away !== null;

            if ($finished) {
                $this->getMatchesResult(collect([$fixture]));

                $request->status       = MatchResultRequest::STATUS_COMPLETED;
                $request->completed_at = now();
                $request->save();
                return;
            }

            $request->attempts++;

            if ($request->attempts >= MatchResultRequest::MAX_ATTEMPTS) {
                $request->status     = MatchResultRequest::STATUS_FAILED;
                $request->last_error = "Max attempts reached. Last status: {$fixture->status_short}.";
            } else {
                $request->status       = MatchResultRequest::STATUS_PENDING;
                $request->scheduled_at = now()->addMinutes(MatchResultRequest::RETRY_INTERVAL_MINUTES);
            }

            $request->save();
        } catch (Throwable $e) {
            $this->notify(
                'MatchService::processResultRequest — Excepción',
                "Request id={$request->id}, api_fixture_id={$request->api_fixture_id}. " .
                $e->getMessage() . "\n" . $e->getTraceAsString()
            );

            $this->bumpFailedAttempt($request, $e->getMessage());
        }
    }

    private function bumpFailedAttempt(MatchResultRequest $request, string $error): void
    {
        $request->attempts++;
        $request->last_error = $error;

        if ($request->attempts >= MatchResultRequest::MAX_ATTEMPTS) {
            $request->status = MatchResultRequest::STATUS_FAILED;
        } else {
            $request->status       = MatchResultRequest::STATUS_PENDING;
            $request->scheduled_at = now()->addMinutes(MatchResultRequest::RETRY_INTERVAL_MINUTES);
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
