<?php

namespace App\Console\Commands;

use App\Models\Partido;
use App\Models\ResultadoPartido;
use Illuminate\Console\Command;

class TestResultado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-resultado {--partido=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para testear el registro del resultado de un partido sistemáticamente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id_partido = (int) $this->option('partido');        

        if (empty($id_partido)) {

            $this->error('Especifica un partido o jornada a ejecutar.');
            
            return Command::INVALID;
        
        }

        $partido = Partido::find($id_partido);

        if (empty($id_partido)) {

            $this->error('No se ha encontrado el partido en la base de datos.');
            
            return Command::INVALID;
        
        }

        $resultado = ResultadoPartido::where('partido_id', $id_partido)->first();

        if (!empty($resultado)) {

            $this->error('Este partido ya tiene un resultado.');
            
            return Command::INVALID;
        
        }

        $resultado_creado = ResultadoPartido::create([
            'partido_id'     => $id_partido,
            'goles_equipo_1' => fake()->numberBetween(0, 4),
            'goles_equipo_2' => fake()->numberBetween(0, 4)
        ]);

        if (empty($resultado_creado)) {

            $this->error('Ocurrió un error al generar el resultado.');
            
            return Command::INVALID;
        
        }

        $this->info('Se ha generado el resultado con éxito');

        return Command::SUCCESS;

    }
}
