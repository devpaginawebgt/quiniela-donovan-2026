<?php

namespace App\Console\Commands;

use App\Models\BracketGame;
use App\Models\Partido;
use App\Models\ResultadoPartido;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class RegenerarBracketJornada extends Command
{
    protected $signature = 'bracket:regenerar-jornada
                            {--jornada= : Jornada a regenerar (4-9)}
                            {--dry-run : Simula en transacción y hace rollback al final}';

    protected $description = 'Borra y recrea los bracket_games de una jornada de knockout desde los Partido existentes, en orden por partido.id ASC. No dispara eventos.';

    public function handle(): int
    {
        $jornadaOpt = $this->option('jornada');
        $dryRun     = (bool) $this->option('dry-run');

        if ($jornadaOpt === null || ! ctype_digit((string) $jornadaOpt)) {
            $this->error('El parámetro --jornada es obligatorio y debe ser un entero.');

            return Command::FAILURE;
        }

        $jornada = (int) $jornadaOpt;

        if ($jornada < 4 || $jornada > 9) {
            $this->error('El parámetro --jornada debe estar entre 4 y 9.');

            return Command::FAILURE;
        }

        $partidos = Partido::with('equipos')
            ->where('jornada_id', $jornada)
            ->orderBy('id')
            ->get();

        $this->info("Jornada {$jornada}: {$partidos->count()} partido(s) encontrados.");

        if (! $dryRun && ! $this->confirm("Se borrarán TODOS los bracket_games de la jornada {$jornada} y se recrearán desde los Partido existentes. ¿Continuar?", false)) {
            $this->warn('Operación cancelada.');

            return Command::FAILURE;
        }

        DB::beginTransaction();

        try {
            $deleted = BracketGame::where('journey_id', $jornada)->delete();
            $this->info("BracketGame eliminados de la jornada {$jornada}: {$deleted}.");

            $creados     = 0;
            $conResultado = 0;
            $skipped     = 0;
            $pos         = 0;

            foreach ($partidos as $partido) {
                if (empty($partido->equipos)) {
                    $skipped++;
                    $this->warn("  Partido {$partido->id}: sin relación 'equipos' (EquipoPartido). Saltado.");
                    continue;
                }

                $pos++;

                $bracketGame = BracketGame::create([
                    'journey_id'       => $jornada,
                    'bracket_position' => $pos,
                    'match_id'         => $partido->id,
                    'team_one_id'      => (int) $partido->equipos->equipo_1,
                    'team_two_id'      => (int) $partido->equipos->equipo_2,
                    'status'           => 1,
                ]);

                $creados++;

                $resultado = ResultadoPartido::where('partido_id', $partido->id)->first();

                if ($resultado) {
                    $bracketGame->update([
                        'result_id' => $resultado->id,
                        'status'    => 2,
                    ]);
                    $conResultado++;
                }
            }

            $this->newLine();
            $this->info("BracketGame creados: {$creados} (con resultado: {$conResultado}, sin resultado: " . ($creados - $conResultado) . ").");

            if ($skipped > 0) {
                $this->warn("Partidos saltados por falta de equipos: {$skipped}.");
            }

            if ($dryRun) {
                DB::rollBack();
                $this->warn('DRY-RUN: rollback aplicado. Nada persistido.');
            } else {
                DB::commit();
                $this->info('Regeneración aplicada.');
            }

            return Command::SUCCESS;
        } catch (Throwable $e) {
            DB::rollBack();
            $this->error("Error durante la regeneración: {$e->getMessage()}");
            $this->error('Transacción revertida.');

            return Command::FAILURE;
        }
    }
}
