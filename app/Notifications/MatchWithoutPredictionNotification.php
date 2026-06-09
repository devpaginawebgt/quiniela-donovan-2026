<?php

namespace App\Notifications;

use App\Models\PushNotification;
use App\Models\SystemSetting;
use Carbon\CarbonInterval;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotificationResource;

class MatchWithoutPredictionNotification extends Notification
{
    use Queueable;

    public function __construct(public PushNotification $pushNotification)
    {
        //
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [FcmChannel::class];
    }

    public function toFcm(object $notifiable): FcmMessage
    {
        $partido = $this->pushNotification->partido;
        $equipoUno = $partido?->equipos?->equipoUno?->nombre ?? 'Equipo 1';
        $equipoDos = $partido?->equipos?->equipoDos?->nombre ?? 'Equipo 2';

        $offset = SystemSetting::getInt('partido_notification_offset_seconds', 3600);
        $humanOffset = CarbonInterval::seconds($offset)->cascade()->forHumans(['locale' => 'es']);

        $title = "¡{$equipoUno} vs {$equipoDos} arranca pronto!";
        $body  = $this->randomBody($equipoUno, $equipoDos, $humanOffset);

        $resource = FcmNotificationResource::create()->title($title)->body($body);

        if ($this->pushNotification->image_path) {
            $resource->image(asset('storage/' . $this->pushNotification->image_path));
        }

        return FcmMessage::create()->notification($resource);
    }

    private function randomBody(string $equipoUno, string $equipoDos, string $humanOffset): string
    {
        $bodies = [
            "El partido {$equipoUno} vs {$equipoDos} arranca en {$humanOffset}. Aún no registras tu predicción — ¡no te quedes fuera de la jugada y suma puntos al ranking! 🏆",
            "¡Atención! En {$humanOffset} rueda el balón en {$equipoUno} vs {$equipoDos} y tu predicción sigue vacía. Acertar te acerca al premio — entra ahora y elige tu favorito. 🔥",
            "Faltan {$humanOffset} para {$equipoUno} vs {$equipoDos}. No dejes pasar la oportunidad de pronosticar: cada acierto te sube en la tabla y te acerca a los premios. 🔥",
            "{$equipoUno} vs {$equipoDos} en {$humanOffset}. ¿Tienes corazonada del marcador? Regístrala ya — los puntos no esperan y el ranking se mueve rápido. 🥇",
            "Sin predicción aún para {$equipoUno} vs {$equipoDos}. Quedan {$humanOffset} para el pitazo inicial. Toma 30 segundos, decide tu resultado y compite por los premios. ⚽",
        ];

        return $bodies[array_rand($bodies)];
    }
}
