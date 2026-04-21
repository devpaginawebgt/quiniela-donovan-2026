<?php

namespace App\Notifications;

use App\Models\PushNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotificationResource;

class TestPushNotification extends Notification
{
    use Queueable;

    public function __construct(public ?PushNotification $pushNotification = null)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [FcmChannel::class];
    }

    public function toFcm(object $notifiable): FcmMessage
    {
        $resource = FcmNotificationResource::create();

        if ($this->pushNotification) {
            $resource->title($this->pushNotification->title)
                     ->body($this->pushNotification->description);

            if ($this->pushNotification->image_path) {
                $resource->image(asset('storage/' . $this->pushNotification->image_path));
            }
        } else {
            $userName = "{$notifiable->nombres} {$notifiable->apellidos}";
            $resource->title("¡Hola, {$userName}!")
                     ->body('Notificación de prueba desde API Donovan!');
        }

        return FcmMessage::create()->notification($resource);
    }

}
