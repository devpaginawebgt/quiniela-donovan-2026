<?php

namespace App\Listeners;

use App\Models\PushNotification;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\MessageTarget;
use Kreait\Firebase\Messaging\SendReport;
use NotificationChannels\Fcm\FcmChannel;

class LogFailedPushNotification
{
    public function handle(NotificationFailed $event): void
    {
        if ($event->channel !== FcmChannel::class) {
            return;
        }

        $report = $event->data['report'] ?? null;
        if (! $report instanceof SendReport) {
            return;
        }

        $target = $report->target();
        $error  = $report->error();

        $pushNotification   = $event->notification->pushNotification ?? null;
        $pushNotificationId = $pushNotification?->id;

        Log::channel('push-notifications-failed')->warning('[FCM failed]', [
            'push_notification_id' => $pushNotificationId,
            'notification_class'   => $event->notification::class,
            'user_id'              => $event->notifiable->id ?? null,
            'token'                => $target->type() === MessageTarget::TOKEN ? $target->value() : null,
            'target_type'          => $target->type(),
            'error_class'          => $error ? $error::class : null,
            'error_message'        => $error?->getMessage(),
        ]);

        if ($pushNotificationId) {
            PushNotification::where('id', $pushNotificationId)->increment('failed');
        }
    }
}
