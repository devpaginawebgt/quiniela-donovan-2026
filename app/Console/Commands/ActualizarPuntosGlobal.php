<?php

namespace App\Console\Commands;

use App\Http\Services\PrediccionService;
use Illuminate\Console\Command;

class ActualizarPuntosGlobal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:actualizar-puntos-global';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza los puntos de todos los participantes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $service = new PrediccionService();
            $service->actualizarPuntosGlobalChunked();

            $this->info('Puntos actualizados correctamente.');
        } catch (\Exception $e) {
            $this->error('Error al actualizar puntos: ' . $e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
