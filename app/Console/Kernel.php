<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:work --stop-when-empty --timeout=30 --max-time=55')
             ->everyMinute()
             ->withoutOverlapping()
             ->runInBackground();

        $schedule->command('push:dispatch-scheduled')
            ->everyMinute()
            ->withoutOverlapping()
            ->runInBackground();

        $schedule->command('app:obtener-resultados-pendientes')
            ->everyMinute()
            ->withoutOverlapping()
            ->runInBackground();

        $schedule->command('app:obtener-marcadores-pendientes')
            ->everyMinute()
            ->withoutOverlapping()
            ->runInBackground();

        $schedule->command('app:sincronizar-rondas')
            ->dailyAt('07:30')
            ->timezone('America/Mexico_City')
            ->withoutOverlapping()
            ->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
