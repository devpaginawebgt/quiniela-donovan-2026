<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendNotification extends Command
{
    protected $signature = 'app:send-notification {user_id} {--all}';

    protected $description = 'Comando deshabilitado. Usar push:dispatch-scheduled para el flujo scheduled.';

    public function handle()
    {
        $this->error('Comando deshabilitado.');
        return self::FAILURE;
    }
}
