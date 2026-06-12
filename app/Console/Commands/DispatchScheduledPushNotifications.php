<?php

namespace App\Console\Commands;

use App\Http\Services\PushNotificationService;
use App\Models\PushNotification;
use App\Models\PushNotificationType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DispatchScheduledPushNotifications extends Command
{
    protected $signature = 'push:dispatch-scheduled {--limit=50 : Máximo de notificaciones a procesar por corrida}';

    protected $description = 'Despacha las push notifications pendientes cuyo scheduled_at ya venció.';

    public function handle(PushNotificationService $service): int
    {
        $limit = (int) $this->option('limit');

        $pending = PushNotification::query()
            ->with('type')
            ->where('status', PushNotification::STATUS_PENDING)
            ->where('scheduled_at', '<=', now())
            ->orderBy('scheduled_at')
            ->limit($limit)
            ->get();

        if ($pending->isEmpty()) {
            $this->info('Sin notificaciones pendientes que procesar.');
            return self::SUCCESS;
        }

        $this->info("Procesando {$pending->count()} notificación(es) pendiente(s).");

        foreach ($pending as $pushNotification) {
            // Claim atómico: solo una corrida puede moverla a 'sending'.
            $claimed = PushNotification::where('id', $pushNotification->id)
                ->where('status', PushNotification::STATUS_PENDING)
                ->update(['status' => PushNotification::STATUS_SENDING]);

            if (! $claimed) {
                $this->line("  - #{$pushNotification->id} ya tomada por otro proceso, skip.");
                continue;
            }

            $pushNotification->refresh();
            $slug = $pushNotification->type?->slug;

            $result = match ($slug) {
                PushNotificationType::ADMIN => $service->sendAdminNotification($pushNotification),
                PushNotificationType::MATCH => $this->dispatchMatchNotification($service, $pushNotification),
                default                     => $this->handleUnknownType($pushNotification, $slug),
            };

            $pushNotification->update([
                'status'     => $result['success'] ? PushNotification::STATUS_SENT : PushNotification::STATUS_FAILED,
                'sent_at'    => now(),
                'recipients' => $result['total'],
                'success'    => $result['success'],
                'failed'     => $result['failed'],
                'comment'    => $result['error'],
            ]);

            $this->line("  - #{$pushNotification->id} [{$slug}] → {$pushNotification->status} (recipients: {$result['total']}, failed: {$result['failed']}).");
        }

        return self::SUCCESS;
    }

    /**
     * Para el tipo match se hacen dos despachos independientes (con y sin
     * predicción) y se agregan los resultados en uno solo.
     *
     * @return array{success: bool, total: int, failed: int, error: ?string}
     */
    protected function dispatchMatchNotification(PushNotificationService $service, PushNotification $pushNotification): array
    {
        $withPrediction    = $service->sendMatchWithPredictionNotification($pushNotification);
        $withoutPrediction = $service->sendMatchWithoutPredictionNotification($pushNotification);

        $errors = array_filter([
            $withPrediction['error'] ? "with_prediction: {$withPrediction['error']}" : null,
            $withoutPrediction['error'] ? "without_prediction: {$withoutPrediction['error']}" : null,
        ]);

        return [
            'success' => $withPrediction['success'] && $withoutPrediction['success'],
            'total'   => $withPrediction['total'] + $withoutPrediction['total'],
            'failed'  => $withPrediction['failed'] + $withoutPrediction['failed'],
            'error'   => $errors ? implode(' | ', $errors) : null,
        ];
    }

    /**
     * @return array{success: bool, total: int, failed: int, error: ?string}
     */
    protected function handleUnknownType(PushNotification $pushNotification, ?string $slug): array
    {
        $message = "Tipo de notificación desconocido: '" . ($slug ?? 'null') . "'.";

        Log::channel('push-notifications')->error(
            '[DispatchScheduledPushNotifications] Tipo desconocido',
            ['push_notification_id' => $pushNotification->id, 'slug' => $slug]
        );

        return [
            'success' => false,
            'total'   => 0,
            'failed'  => 0,
            'error'   => $message,
        ];
    }
}
