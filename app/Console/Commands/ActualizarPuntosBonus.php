<?php

namespace App\Console\Commands;

use App\Http\Services\UserBonusService;
use Illuminate\Console\Command;

class ActualizarPuntosBonus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:actualizar-puntos-bonus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
        public function handle()
    {
        try {
            $service = new UserBonusService();
            $service->updateUserBonusPointsChunked();

            $this->info('Puntos actualizados correctamente.');
        } catch (\Exception $e) {
            $this->error('Error al actualizar puntos: ' . $e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
