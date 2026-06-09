<?php

namespace App\Console\Commands;

use App\Models\Partido;
use App\Models\PushNotification;
use App\Models\PushNotificationType;
use App\Models\SystemSetting;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;

class ScheduleMatchPushNotification extends Command
{
    protected $signature = 'push:schedule-match {match_id : ID del partido a agendar}';

    protected $description = 'Agenda la push notification de un partido. Aborta si ya existe una notificación para ese partido.';

    public function handle(): int
    {
        $matchId = (int) $this->argument('match_id');

        if ($matchId <= 0) {
            $this->error('Especifica un match_id válido.');
            return self::INVALID;
        }

        $partido = Partido::with('equipos.equipoUno', 'equipos.equipoDos')->find($matchId);

        if (! $partido) {
            $this->error("No se encontró un partido con id {$matchId}.");
            return self::INVALID;
        }

        if (PushNotification::where('partido_id', $partido->id)->whereIN('status', ['pending', 'sending'])->exists()) {
            $this->warn("Ya existe una push notification para el partido {$partido->id}, skip.");
            return self::INVALID;
        }

        if (empty($partido->fecha_partido) || empty($partido->equipos)) {
            $this->error('El partido no tiene fecha o equipos asignados.');
            return self::INVALID;
        }

        $offsetSeconds = SystemSetting::getInt('partido_notification_offset_seconds', 3600);
        $scheduledAt = $partido->fecha_partido->copy()->subSeconds($offsetSeconds);

        if ($scheduledAt->isPast()) {
            $this->error("El trigger ({$scheduledAt}) ya está en el pasado, no se agenda.");
            return self::INVALID;
        }

        $type = PushNotificationType::where('slug', PushNotificationType::MATCH)->first();

        if (! $type) {
            $this->error('Tipo "match" no existe. Ejecuta el seeder PushNotificationTypeSeeder.');
            return self::FAILURE;
        }

        $equipoUno = $partido->equipos->equipoUno?->nombre ?? 'Equipo 1';
        $equipoDos = $partido->equipos->equipoDos?->nombre ?? 'Equipo 2';

        $humanOffset = CarbonInterval::seconds($offsetSeconds)
            ->cascade()
            ->forHumans(['locale' => 'es']);

        $pushNotification = PushNotification::create([
            'push_notification_type_id' => $type->id,
            'partido_id'   => $partido->id,
            'title'        => "¡{$equipoUno} vs {$equipoDos} hoy!",
            'description'  => "El partido arranca en {$humanOffset}. ¡No te lo pierdas!",
            'status'       => PushNotification::STATUS_PENDING,
            'scheduled_at' => $scheduledAt,
            'from_system'  => true,
        ]);

        $this->info("Push notification #{$pushNotification->id} agendada para {$scheduledAt}.");
        return self::SUCCESS;
    }
}
