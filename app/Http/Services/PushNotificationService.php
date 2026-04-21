<?php

namespace App\Http\Services;

use App\Models\PushNotification;
use App\Models\User;
use App\Notifications\AdminNotification;
use App\Notifications\MatchWithPredictionNotification;
use App\Notifications\MatchWithoutPredictionNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Throwable;

class PushNotificationService
{
    /**
     * Filtro base: usuarios activos con al menos un push token activo.
     * Usado por el controlador admin para contar destinatarios antes de crear
     * el registro.
     *
     * @param  array{country_id?: int|null, user_type_id?: int|null}  $filters
     */
    public function filterRecipients(array $filters): Collection
    {
        return $this->baseRecipientsQuery()
            ->when($filters['country_id'] ?? null,   fn ($q, $id) => $q->where('pais_id', $id))
            ->when($filters['user_type_id'] ?? null, fn ($q, $id) => $q->where('user_type_id', $id))
            ->get();
    }

    /**
     * Envía la notificación creada desde el panel admin. Aplica filtros de
     * audiencia (user_type_id, country_id) y despacha AdminNotification.
     *
     * @return array{success: bool, total: int, failed: int, error: ?string}
     */
    public function sendAdminNotification(PushNotification $pushNotification): array
    {
        $recipients = $this->baseRecipientsQuery()
            ->when($pushNotification->country_id,   fn ($q, $id) => $q->where('pais_id', $id))
            ->when($pushNotification->user_type_id, fn ($q, $id) => $q->where('user_type_id', $id))
            ->get();

        return $this->dispatch(
            $pushNotification,
            $recipients,
            new AdminNotification($pushNotification),
        );
    }

    /**
     * Envía la notificación de partido a los usuarios que YA hicieron
     * predicción para ese partido. Ignora filtros de audiencia.
     *
     * @return array{success: bool, total: int, failed: int, error: ?string}
     */
    public function sendMatchWithPredictionNotification(PushNotification $pushNotification): array
    {
        $recipients = $this->baseRecipientsQuery()
            ->whereHas('predictions', fn ($q) => $q->where('partido_id', $pushNotification->partido_id))
            ->get();

        return $this->dispatch(
            $pushNotification,
            $recipients,
            new MatchWithPredictionNotification($pushNotification),
        );
    }

    /**
     * Envía la notificación de partido a los usuarios que NO hicieron
     * predicción para ese partido. Ignora filtros de audiencia.
     *
     * @return array{success: bool, total: int, failed: int, error: ?string}
     */
    public function sendMatchWithoutPredictionNotification(PushNotification $pushNotification): array
    {
        $recipients = $this->baseRecipientsQuery()
            ->whereDoesntHave('predictions', fn ($q) => $q->where('partido_id', $pushNotification->partido_id))
            ->get();

        return $this->dispatch(
            $pushNotification,
            $recipients,
            new MatchWithoutPredictionNotification($pushNotification),
        );
    }

    /**
     * Query base: usuarios activos con al menos un token FCM activo.
     */
    protected function baseRecipientsQuery()
    {
        return User::query()
            ->where('status_user', 1)
            ->whereHas('pushTokens', fn ($q) => $q->where('is_active', true));
    }

    /**
     * Lógica común de despacho: captura fallos por token, maneja excepciones
     * globales y registra logs.
     *
     * @return array{success: bool, total: int, failed: int, error: ?string}
     */
    protected function dispatch(PushNotification $pushNotification, Collection $recipients, BaseNotification $notification): array
    {
        $total = $recipients->count();

        if ($total === 0) {
            return [
                'success' => true,
                'total'   => 0,
                'failed'  => 0,
                'error'   => null,
            ];
        }

        $failures = [];
        Event::listen(NotificationFailed::class, function (NotificationFailed $event) use (&$failures) {
            $failures[] = [
                'channel' => $event->channel,
                'data'    => $event->data,
            ];
        });

        try {
            Notification::send($recipients, $notification);
        } catch (Throwable $e) {
            Log::channel('push-notifications')->error('[PushNotificationService] Falló el envío de push notifications', [
                'push_notification_id' => $pushNotification->id,
                'notification_class'   => $notification::class,
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

        Log::channel('push-notifications')->info('[PushNotificationService] Push notification enviada', [
            'push_notification_id' => $pushNotification->id,
            'notification_class'   => $notification::class,
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
