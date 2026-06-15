<?php

namespace App\Notifications;

use App\Models\PushNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotificationResource;

class MatchResultNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public PushNotification $pushNotification) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [FcmChannel::class];
    }

    public function toFcm(object $notifiable): FcmMessage
    {
        $title = $this->pushNotification->title ?? '¡Resultado Registrado!';
        $body  = $this->pushNotification->description ?? '';

        $resource = FcmNotificationResource::create()->title($title)->body($body);

        return FcmMessage::create()->notification($resource);
    }
}
