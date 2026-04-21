<?php

namespace App\Http\Services;

use App\Models\PushNotification;
use App\Models\User;
use App\Notifications\TestPushNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Throwable;

class PushNotificationService
{
    /**
     * Filtra los destinatarios según los parámetros recibidos.
     * Solo usuarios activos y con al menos un push token activo.
     *
     * @param  array{country_id?: int|null, user_type_id?: int|null}  $filters
     */
    public function filterRecipients(array $filters): Collection
    {
        return User::query()
            ->when($filters['country_id'] ?? null,   fn ($q, $id) => $q->where('pais_id', $id))
            ->when($filters['user_type_id'] ?? null, fn ($q, $id) => $q->where('user_type_id', $id))
            ->whereHas('pushTokens', fn ($q) => $q->where('is_active', true))
            ->where('status_user', 1)
            ->get();
    }

    /**
     * Envía la notificación push a los destinatarios y devuelve el resumen.
     *
     * @return array{success: bool, total: int, failed: int, error: ?string}
     */
    public function send(PushNotification $pushNotification, Collection $recipients): array
    {
        $total = $recipients->count();

        // Capturamos los fallos individuales dispachados por el canal FCM.

        $failures = [];

        Event::listen(NotificationFailed::class, function (NotificationFailed $event) use (&$failures) {
            $failures[] = [
                'channel' => $event->channel,
                'data'    => $event->data,
            ];
        });

        

        try {
            Notification::send($recipients, new TestPushNotification($pushNotification));
        } catch (Throwable $e) {
            Log::error('[PushNotificationService] Falló el envío de push notifications', [
                'push_notification_id' => $pushNotification->id,
                'recipients'           => $total,
                'exception'            => $e::class,
                'message'              => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'total'   => $total,
                'failed'  => $total,
                'error'   => $e->getMessage(),
            ];
        }

        $failedCount = count($failures);

        Log::info('[PushNotificationService] Push notification enviada', [
            'push_notification_id' => $pushNotification->id,
            'recipients'           => $total,
            'failures'             => $failedCount,
        ]);

        return [
            'success' => true,
            'total'   => $total,
            'failed'  => $failedCount,
            'error'   => null,
        ];
    }
}
