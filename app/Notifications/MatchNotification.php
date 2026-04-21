<?php

namespace App\Notifications;

use App\Models\PushNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotificationResource;

class MatchNotification extends Notification
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
        $resource = FcmNotificationResource::create()
            ->title($this->pushNotification->title)
            ->body($this->pushNotification->description);

        if ($this->pushNotification->image_path) {
            $resource->image(asset('storage/' . $this->pushNotification->image_path));
        }

        return FcmMessage::create()->notification($resource);
    }
}
