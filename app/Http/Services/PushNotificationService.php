<?php

namespace App\Http\Services;

use App\Models\PushNotification;
use App\Models\User;
use App\Notifications\AdminNotification;
use App\Notifications\LiveScoreNotification;
use App\Notifications\MatchWithPredictionNotification;
use App\Notifications\MatchWithoutPredictionNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Throwable;

class PushNotificationService
{
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
     * Si se reciben los `$recipients` ya resueltos (caso del controlador admin),
     * se reutilizan para evitar una segunda consulta. Si llega null (caso del
     * comando programado), se resuelven aquí.
     *
     * @return array{success: bool, total: int, failed: int, error: ?string}
     */
    public function sendAdminNotification(PushNotification $pushNotification, ?Collection $recipients = null): array
    {
        $recipients ??= $this->baseRecipientsQuery()
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
     * Envía la notificación de cambio de marcador a TODOS los usuarios activos
     * con token FCM activo. Sin filtros de audiencia.
     *
     * @return array{success: bool, total: int, failed: int, error: ?string}
     */
    public function sendLiveScoreNotification(PushNotification $pushNotification): array
    {
        $recipients = $this->baseRecipientsQuery()->get();

        return $this->dispatch(
            $pushNotification,
            $recipients,
            new LiveScoreNotification($pushNotification),
        );
    }

    /**
     * Lógica común de despacho: encola la notificación en la cola configurada
     * (la entrega real a FCM ocurre en `queue:work`) y registra el resultado
     * del encolado. El conteo de fallos por token ya no se trackea aquí: una
     * vez encolado, el éxito/fracaso de cada envío vive en la cola/logs de los
     * workers.
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

        try {
            Notification::send($recipients, $notification);
        } catch (Throwable $e) {
            Log::channel('push-notifications')->error('[PushNotificationService] Falló al encolar push notifications', [
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

        Log::channel('push-notifications')->info('[PushNotificationService] Push notification encolada', [
            'push_notification_id' => $pushNotification->id,
            'notification_class'   => $notification::class,
            'recipients'           => $total,
        ]);

        return [
            'success' => true,
            'total'   => $total,
            'failed'  => 0,
            'error'   => null,
        ];
    }
}
