<?php

namespace App\Console\Commands;

use App\Http\Services\TestingService;
use App\Http\Services\TestService;
use App\Models\Partido;
use App\Models\ResultadoPartido;
use Illuminate\Console\Command;

class TestResultadoPartido extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:resultado-partido {--partido=} {--jornada=}';

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

        // $this->error('Comando deshabilitado.');
    
        // return Command::FAILURE;

        $id_partido = (int) $this->option('partido');

        $id_jornada = (int) $this->option('jornada');

        if (empty($id_partido) && empty($id_jornada)) {

            $this->error('Especifica un partido o jornada a ejecutar.');
            
            return Command::INVALID;
        
        }

        if (!empty($id_partido)) {

            $resultado = TestService::guardarResultadoPartido($id_partido);

            if (isset($resultado['error'])) {

                $this->error($resultado['error']);

                return Command::FAILURE;

            }
                

            $this->info($resultado['message']);

            return Command::SUCCESS;
            
        }

        $partidos_jornada = [];

        switch($id_jornada) {
            case 1:
                $partidos_jornada = TestService::jornadaUno();
                break;
            case 2:
                $partidos_jornada = TestService::jornadaDos();
                break;
            case 3: 
                $partidos_jornada = TestService::jornadaTres();
                break;
            case 4: 
                $partidos_jornada = TestService::dieciseisavos();
                break;
            case 5: 
                $partidos_jornada = TestService::octavos();
                break;
            case 6: 
                $partidos_jornada = TestService::cuartos();
                break;
            case 7: 
                $partidos_jornada = TestService::semifinales();
                break;
            case 8: 
                $partidos_jornada = TestService::tercerLugar();
                break;
            case 9: 
                $partidos_jornada = TestService::finales();
                break;
            default:
                $partidos_jornada = [];
        }

        if (empty($partidos_jornada)) {

            $this->error('No se encontró la jornada a ejecutar');

            return Command::FAILURE;
        }
            

        foreach($partidos_jornada as $partido_test) {

            $id_partido = $partido_test['id'];

            $partido_db = Partido::find($id_partido);

            if (empty($partido_db)) {

                $this->error('Error al encontrar el partido en base de datos.');

                return Command::FAILURE;
            }
                

            $resultado_db = ResultadoPartido::where('partido_id', $id_partido)->first();

            if (! empty($resultado_db)) {

                $this->error("Este partido ya tiene un resultado ingresado ({$id_partido}).");

                return Command::FAILURE;
            }
                

            $resultado = ResultadoPartido::create([
                'partido_id' => $id_partido,
                'goles_equipo_1' => $partido_test['goles_equipo_1'],
                'goles_equipo_2' => $partido_test['goles_equipo_2'],
                'equipo_ganador_id' => $partido_test['equipo_ganador_id'],
            ]);

            if (empty($resultado)) {

                $this->error('Error al guardar resultado del partido.');

                return Command::FAILURE;
            }
                

        }

        $this->info('Se ha procesado la jornada con éxito');

        return Command::SUCCESS;
    }

    // public function handle()
    // {

    //     $this->error('Comando deshabilitado.');
    
    //     return Command::FAILURE;

    //     $id_partido = (int) $this->option('partido');

    //     $id_jornada = (int) $this->option('jornada');

    //     if (empty($id_partido) && empty($id_jornada)) {

    //         $this->error('Especifica un partido o jornada a ejecutar.');
            
    //         return Command::INVALID;
        
    //     }

    //     if (!empty($id_partido)) {

    //         $resultado = TestingService::guardarResultadoPartido($id_partido);

    //         if (isset($resultado['error'])) {

    //             $this->error($resultado['error']);

    //             return Command::FAILURE;

    //         }
                

    //         $this->info($resultado['message']);

    //         return Command::SUCCESS;
            
    //     }

    //     $partidos_jornada = [];

    //     switch($id_jornada) {
    //         case 1:
    //             $partidos_jornada = TestingService::jornadaUno();
    //             break;
    //         case 2:
    //             $partidos_jornada = TestingService::jornadaDos();
    //             break;
    //         case 3: 
    //             $partidos_jornada = TestingService::jornadaTres();
    //             break;
    //         case 4: 
    //             $partidos_jornada = TestingService::dieciseisavos();
    //             break;
    //         case 5: 
    //             $partidos_jornada = TestingService::octavos();
    //             break;
    //         case 6: 
    //             $partidos_jornada = TestingService::cuartos();
    //             break;
    //         case 7: 
    //             $partidos_jornada = TestingService::semifinales();
    //             break;
    //         case 8: 
    //             $partidos_jornada = TestingService::tercerLugar();
    //             break;
    //         case 9: 
    //             $partidos_jornada = TestingService::finales();
    //             break;
    //         default:
    //             $partidos_jornada = [];
    //     }

    //     if (empty($partidos_jornada)) {

    //         $this->error('No se encontró la jornada a ejecutar');

    //         return Command::FAILURE;
    //     }
            

    //     foreach($partidos_jornada as $partido_test) {

    //         $id_partido = $partido_test['id'];

    //         $partido_db = Partido::find($id_partido);

    //         if (empty($partido_db)) {

    //             $this->error('Error al encontrar el partido en base de datos.');

    //             return Command::FAILURE;
    //         }
                

    //         $resultado_db = ResultadoPartido::find($id_partido);

    //         if (! empty($resultado_db)) {

    //             $this->error('Este partido ya tiene un resultado ingresado.');

    //             return Command::FAILURE;
    //         }
                

    //         $resultado = ResultadoPartido::create([
    //             'partido_id' => $id_partido,
    //             'goles_equipo_1' => $partido_test['goles_equipo_1'],
    //             'goles_equipo_2' => $partido_test['goles_equipo_2'],
    //             'equipo_ganador_id' => $partido_test['equipo_ganador_id'],
    //         ]);

    //         if (empty($resultado)) {

    //             $this->error('Error al guardar resultado del partido.');

    //             return Command::FAILURE;
    //         }
                

    //     }

    //     $this->info('Se ha procesado la jornada con éxito');

    //     return Command::SUCCESS;
    // }
}
