<?php

namespace App\Console\Commands;

use App\Models\Jornada;
use App\Models\Partido;
use App\Models\Preccion;
use App\Models\User;
use Illuminate\Console\Command;

class GenerarPrediccionesJornada extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generar-predicciones-jornada {jornada_id : ID de la jornada para la que se generarán predicciones ficticias}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera predicciones ficticias para todos los usuarios registrados en los partidos de una jornada';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jornadaId = (int) $this->argument('jornada_id');

        if ($jornadaId <= 0) {
            $this->error('El jornada_id debe ser un entero positivo.');
            return Command::FAILURE;
        }

        $jornada = Jornada::find($jornadaId);

        if (empty($jornada)) {
            $this->error("No se encontró la jornada con id {$jornadaId}.");
            return Command::FAILURE;
        }

        $partidoIds = Partido::where('jornada_id', $jornadaId)->pluck('id');

        if ($partidoIds->isEmpty()) {
            $this->warn("No hay partidos registrados en la jornada {$jornadaId}.");
            return Command::SUCCESS;
        }

        $users = User::where('status_user', 1)->get();

        if ($users->isEmpty()) {
            $this->warn('No hay usuarios activos en la base de datos.');
            return Command::SUCCESS;
        }

        $existing = Preccion::whereIn('partido_id', $partidoIds)
            ->select('user_id', 'partido_id')
            ->get()
            ->groupBy('user_id')
            ->map(fn ($items) => $items->pluck('partido_id')->all())
            ->all();

        $records = [];
        $totalInserted = 0;
        $skipRate = 0.05;
        $skipped = 0;

        foreach ($users as $user) {
            if (fake()->boolean($skipRate * 100)) {
                $skipped++;
                continue;
            }

            $userExisting = $existing[$user->id] ?? [];

            foreach ($partidoIds as $partidoId) {
                if (in_array($partidoId, $userExisting, true)) {
                    continue;
                }

                $records[] = [
                    'user_id'        => $user->id,
                    'partido_id'     => $partidoId,
                    'goles_equipo_1' => fake()->numberBetween(0, 6),
                    'goles_equipo_2' => fake()->numberBetween(0, 6),
                    'status'         => 0,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }

            if (count($records) >= 1000) {
                Preccion::insert($records);
                $totalInserted += count($records);
                $records = [];
            }
        }

        if (count($records) > 0) {
            Preccion::insert($records);
            $totalInserted += count($records);
            $records = [];
        }

        $this->info("Jornada {$jornadaId}: {$partidoIds->count()} partidos, {$users->count()} usuarios activos.");
        $this->info("Se insertaron {$totalInserted} predicciones (usuarios omitidos por skip aleatorio: {$skipped}).");

        return Command::SUCCESS;
    }
}
