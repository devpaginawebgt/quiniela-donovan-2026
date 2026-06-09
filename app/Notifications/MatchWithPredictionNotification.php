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

class MatchWithPredictionNotification extends Notification
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
            "{$equipoUno} vs {$equipoDos} arranca en {$humanOffset}. Tu predicción ya está lista — ¡cruza los dedos y prepárate para sumar puntos! 🍀",
            "¡Es la hora! En {$humanOffset} rueda el balón en {$equipoUno} vs {$equipoDos}. Tu pronóstico está en juego, no te pierdas ni un minuto. 📺",
            "Faltan {$humanOffset} para {$equipoUno} vs {$equipoDos}. Cada gol cuenta para tu predicción — vívelo en vivo y celebra tus aciertos. 🎉",
            "Tu predicción para {$equipoUno} vs {$equipoDos} está en marcha. Arranca en {$humanOffset} — sintoniza, vive el partido y mira cómo subes en el ranking. 📈",
            "{$equipoUno} vs {$equipoDos} en {$humanOffset}. Apostaste por tu favorito — ahora sólo queda disfrutar el partido y ver si tus puntos llegan. 🏆",
        ];

        return $bodies[array_rand($bodies)];
    }
}
