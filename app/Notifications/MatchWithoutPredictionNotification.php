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
        $body  = "Inicia en {$humanOffset}. ¡Aún tienes tiempo de hacer tu predicción!";

        $resource = FcmNotificationResource::create()->title($title)->body($body);

        if ($this->pushNotification->image_path) {
            $resource->image(asset('storage/' . $this->pushNotification->image_path));
        }

        return FcmMessage::create()->notification($resource);
    }
}
