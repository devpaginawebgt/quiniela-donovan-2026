<?php

namespace App\Listeners;

use App\Events\MatchCreated;
use App\Models\PushNotification;
use App\Models\PushNotificationType;
use App\Models\SystemSetting;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Log;

class ScheduleMatchPushNotification
{
    public function handle(MatchCreated $event): void
    {
        $partido = $event->partido;

        // Requiere la fecha del partido y los equipos para poder componer el mensaje.
        if (empty($partido->fecha_partido) || empty($partido->equipos)) {
            return;
        }

        // Evitar duplicados: un partido solo puede tener una push notification registrada.
        if (PushNotification::where('partido_id', $partido->id)->exists()) {
            Log::channel('push-notifications')->info(
                '[ScheduleMatchPushNotification] Ya existe una notificación para este partido, skip.',
                ['partido_id' => $partido->id]
            );
            return;
        }

        $offsetSeconds = SystemSetting::getInt('partido_notification_offset_seconds', 3600);
        $scheduledAt = $partido->fecha_partido->copy()->subSeconds($offsetSeconds);

        // No agendar notificaciones para partidos cuyo trigger ya pasó.
        if ($scheduledAt->isPast()) {
            return;
        }

        $type = PushNotificationType::where('slug', PushNotificationType::MATCH)->first();

        if (! $type) {
            Log::channel('push-notifications')->warning(
                '[ScheduleMatchPushNotification] Tipo "match" no existe, ejecuta el seeder PushNotificationTypeSeeder.',
                ['partido_id' => $partido->id]
            );
            return;
        }

        $equipos   = $partido->equipos;
        $equipoUno = $equipos->equipoUno?->nombre ?? 'Equipo 1';
        $equipoDos = $equipos->equipoDos?->nombre ?? 'Equipo 2';

        $humanOffset = CarbonInterval::seconds($offsetSeconds)
            ->cascade()
            ->forHumans(['locale' => 'es']);

        PushNotification::create([
            'push_notification_type_id' => $type->id,
            'partido_id'   => $partido->id,
            'title'        => "¡{$equipoUno} vs {$equipoDos} hoy!",
            'description'  => "El partido arranca en {$humanOffset}. ¡No te lo pierdas!",
            'status'       => PushNotification::STATUS_PENDING,
            'scheduled_at' => $scheduledAt,
            'from_system'  => true,
        ]);
    }
}
