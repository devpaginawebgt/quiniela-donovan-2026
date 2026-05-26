<?php

namespace App\Listeners;

use App\Models\UserPushToken;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\Messaging\InvalidMessage;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Messaging\MessageTarget;
use Kreait\Firebase\Messaging\SendReport;
use NotificationChannels\Fcm\FcmChannel;

class DeactivateInvalidFcmToken
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    
    public function handle(NotificationFailed $event): void
    {
        if ($event->channel !== FcmChannel::class) {
            return;
        }

        $report = $event->data['report'] ?? null;
        if (! $report instanceof SendReport) {
            return;
        }

        if ($report->target()->type() !== MessageTarget::TOKEN) {
            return;
        }

        $token = $report->target()->value();
        $error = $report->error();

        $isPermanent = $error instanceof NotFound
            || $error instanceof InvalidMessage;

        if (! $isPermanent) {
            Log::channel('push-notifications-deactivate')->warning('FCM send falló con error transitorio, token no desactivado', [
                'token' => $token,
                'error' => $error?->getMessage(),
            ]);
            return;
        }

        $affected = UserPushToken::where('device_token', $token)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        Log::channel('push-notifications-deactivate')->info('FCM token desactivado', [
            'token' => $token,
            'affected_rows' => $affected,
            'reason' => $error ? $error::class : 'unknown',
        ]);
    }
}
