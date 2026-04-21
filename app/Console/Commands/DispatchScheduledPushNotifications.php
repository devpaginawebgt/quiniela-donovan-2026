<?php

namespace App\Console\Commands;

use App\Http\Services\PushNotificationService;
use App\Models\PushNotification;
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
            // Intento atómico de claim: solo una corrida puede moverla a 'sending'.
            $claimed = PushNotification::where('id', $pushNotification->id)
                ->where('status', PushNotification::STATUS_PENDING)
                ->update(['status' => PushNotification::STATUS_SENDING]);

            if (! $claimed) {
                $this->line("  - #{$pushNotification->id} ya tomada por otro proceso, skip.");
                continue;
            }

            $pushNotification->refresh();

            $recipients = $service->filterRecipients([
                'user_type_id' => $pushNotification->user_type_id,
                'country_id'   => $pushNotification->country_id,
            ]);

            if ($recipients->isEmpty()) {
                $pushNotification->update([
                    'status'     => PushNotification::STATUS_SENT,
                    'sent_at'    => now(),
                    'recipients' => 0,
                    'success'    => true,
                    'failed'     => 0,
                    'comment'    => 'Sin destinatarios con tokens activos.',
                ]);

                Log::channel('push-notifications')->info(
                    '[DispatchScheduledPushNotifications] Sin destinatarios',
                    ['push_notification_id' => $pushNotification->id]
                );

                $this->line("  - #{$pushNotification->id} sin destinatarios, marcada como sent (0).");
                continue;
            }

            $result = $service->send($pushNotification, $recipients);

            $pushNotification->update([
                'status'     => $result['success'] ? PushNotification::STATUS_SENT : PushNotification::STATUS_FAILED,
                'sent_at'    => now(),
                'recipients' => $recipients->count(),
                'success'    => $result['success'],
                'failed'     => $result['failed'],
                'comment'    => $result['error'],
            ]);

            $this->line("  - #{$pushNotification->id} → {$pushNotification->status} (recipients: {$recipients->count()}, failed: {$result['failed']}).");
        }

        return self::SUCCESS;
    }
}
