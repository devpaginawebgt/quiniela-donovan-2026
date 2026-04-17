<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\TestPushNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\Fcm\FcmChannel;

class SendNotification extends Command
{
    protected $signature = 'app:send-notification {user_id} {--all}';

    protected $description = 'Envía una notificación push de prueba a un usuario. Por defecto solo al último token; con --all a todos sus tokens activos.';

    public function handle()
    {
        $this->error("Comando deshabilitado.");
        return self::FAILURE;


        $user = User::find($this->argument('user_id'));

        if (! $user) {
            $this->error("Usuario {$this->argument('user_id')} no encontrado.");
            return self::FAILURE;
        }

        if ($this->option('all')) {
            $count = $user->pushTokens()->where('is_active', true)->count();

            if ($count === 0) {
                $this->warn("El usuario {$user->id} no tiene tokens activos.");
                return self::FAILURE;
            }

            $user->notify(new TestPushNotification());
            $this->info("Notificación enviada a {$count} token(s) del usuario {$user->id}.");
            return self::SUCCESS;
        }

        $latest = $user->latestPushToken;

        if (! $latest) {
            $this->warn("El usuario {$user->id} no tiene tokens activos.");
            return self::FAILURE;
        }

        Notification::route(FcmChannel::class, $latest->device_token)
            ->notify(new TestPushNotification());

        $this->info("Notificación enviada al último token del usuario {$user->id} ({$latest->device_platform}).");
        return self::SUCCESS;
    }
}
