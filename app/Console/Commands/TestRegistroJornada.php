<?php

namespace App\Console\Commands;

use App\Http\Services\TestingService;
use App\Http\Services\TestService;
use App\Models\EquipoPartido;
use App\Models\Partido;
use Illuminate\Console\Command;

class TestRegistroJornada extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:registro-jornada {--jornada=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para testear el registro de una jornada sistemáticamente';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // $this->error('Comando deshabilitado.');

        // return Command::FAILURE;

        $id_jornada = (int) $this->option('jornada');
        
        if (!empty($id_jornada)) {

            $partidos_jornada = [];
            
            switch($id_jornada) {
                // case 1:
                //     $partidos_jornada = TestService::jornadaUno();
                //     break;
                // case 2:
                //     $partidos_jornada = TestService::jornadaDos();
                //     break;
                // case 3: 
                //     $partidos_jornada = TestService::jornadaTres();
                //     break;
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
    
            foreach($partidos_jornada as $partido) {
    
                $equipo_1 = $partido['equipo_1'];
                $equipo_2 = $partido['equipo_2'];
                
                unset($partido['equipo_1']);
                unset($partido['equipo_2']);
                unset($partido['goles_equipo_1']);
                unset($partido['goles_equipo_2']);
                unset($partido['equipo_ganador_id']);
    
                $partido_db = Partido::create($partido);
    
                $equipo_partido = EquipoPartido::create([
                    'partido_id' => $partido_db->id,
                    'equipo_1' => $equipo_1,
                    'equipo_2' => $equipo_2
                ]);
    
            }

            $this->info('Se ha procesado la jornada con éxito');

            return Command::SUCCESS;

        }

        // $jornada1 = TestingService::jornadaUno();
        // $jornada2 = TestingService::jornadaDos();
        // $jornada3 = TestingService::jornadaTres();
        $deciseisavos = TestService::dieciseisavos();
        $octavos = TestService::octavos();
        $cuartos = TestService::cuartos();
        $semifinales = TestService::semifinales();
        $tercer_lugar = TestService::tercerLugar();
        $finales = TestService::finales();

        $partidos = array_merge(
            // $jornada1,
            // $jornada2,
            // $jornada3,
            $deciseisavos,
            $octavos,
            $cuartos,
            $semifinales,
            $tercer_lugar,
            $finales
        );

        foreach($partidos as $partido) {

            $equipo_1 = $partido['equipo_1'];
            $equipo_2 = $partido['equipo_2'];
            
            unset($partido['equipo_1']);
            unset($partido['equipo_2']);
            unset($partido['goles_equipo_1']);
            unset($partido['goles_equipo_2']);
            unset($partido['equipo_ganador_id']);

            $partido_db = Partido::create($partido);

            if (empty($partido_db)) {
    
                $this->error('Error guardar el partido en db');
    
                return Command::FAILURE;
            }

            $equipo_partido = EquipoPartido::create([
                'partido_id' => $partido_db->id,
                'equipo_1' => $equipo_1,
                'equipo_2' => $equipo_2
            ]);

            if (empty($equipo_partido)) {
    
                $this->error('Error al guardar los equipos del partido en db');
    
                return Command::FAILURE;
            }

        }

        $this->info('Se han procesado todas las jornadas con éxito');

        return Command::SUCCESS;

    }

    // public function handle()
    // {

    //     $this->error('Comando deshabilitado.');

    //     return Command::FAILURE;

    //     $id_jornada = (int) $this->option('jornada');
        
    //     if (!empty($id_jornada)) {

    //         $partidos_jornada = [];
            
    //         switch($id_jornada) {
    //             case 1:
    //                 $partidos_jornada = TestingService::jornadaUno();
    //                 break;
    //             case 2:
    //                 $partidos_jornada = TestingService::jornadaDos();
    //                 break;
    //             case 3: 
    //                 $partidos_jornada = TestingService::jornadaTres();
    //                 break;
    //             case 4: 
    //                 $partidos_jornada = TestingService::dieciseisavos();
    //                 break;
    //             case 5: 
    //                 $partidos_jornada = TestingService::octavos();
    //                 break;
    //             case 6: 
    //                 $partidos_jornada = TestingService::cuartos();
    //                 break;
    //             case 7: 
    //                 $partidos_jornada = TestingService::semifinales();
    //                 break;
    //             case 8: 
    //                 $partidos_jornada = TestingService::tercerLugar();
    //                 break;
    //             case 9: 
    //                 $partidos_jornada = TestingService::finales();
    //                 break;
    //             default:
    //                 $partidos_jornada = [];
    //         }
    
    //         if (empty($partidos_jornada)) {
    
    //             $this->error('No se encontró la jornada a ejecutar');
    
    //             return Command::FAILURE;
    //         }
    
    //         foreach($partidos_jornada as $partido) {
    
    //             $equipo_1 = $partido['equipo_1'];
    //             $equipo_2 = $partido['equipo_2'];
                
    //             unset($partido['equipo_1']);
    //             unset($partido['equipo_2']);
    //             unset($partido['goles_equipo_1']);
    //             unset($partido['goles_equipo_2']);
    //             unset($partido['equipo_ganador_id']);
    
    //             $partido_db = Partido::create($partido);
    
    //             $equipo_partido = EquipoPartido::create([
    //                 'partido_id' => $partido_db->id,
    //                 'equipo_1' => $equipo_1,
    //                 'equipo_2' => $equipo_2
    //             ]);
    
    //         }

    //         $this->info('Se ha procesado la jornada con éxito');

    //         return Command::SUCCESS;

    //     }

    //     $jornada1 = TestingService::jornadaUno();
    //     $jornada2 = TestingService::jornadaDos();
    //     $jornada3 = TestingService::jornadaTres();
    //     $deciseisavos = TestingService::dieciseisavos();
    //     $octavos = TestingService::octavos();
    //     $cuartos = TestingService::cuartos();
    //     $semifinales = TestingService::semifinales();
    //     $tercer_lugar = TestingService::tercerLugar();
    //     $finales = TestingService::finales();

    //     $partidos = array_merge(
    //         $jornada1,
    //         $jornada2,
    //         $jornada3,
    //         $deciseisavos,
    //         $octavos,
    //         $cuartos,
    //         $semifinales,
    //         $tercer_lugar,
    //         $finales
    //     );

    //     foreach($partidos as $partido) {

    //         $equipo_1 = $partido['equipo_1'];
    //         $equipo_2 = $partido['equipo_2'];
            
    //         unset($partido['equipo_1']);
    //         unset($partido['equipo_2']);
    //         unset($partido['goles_equipo_1']);
    //         unset($partido['goles_equipo_2']);
    //         unset($partido['equipo_ganador_id']);

    //         $partido_db = Partido::create($partido);

    //         if (empty($partido_db)) {
    
    //             $this->error('Error guardar el partido en db');
    
    //             return Command::FAILURE;
    //         }

    //         $equipo_partido = EquipoPartido::create([
    //             'partido_id' => $partido_db->id,
    //             'equipo_1' => $equipo_1,
    //             'equipo_2' => $equipo_2
    //         ]);

    //         if (empty($equipo_partido)) {
    
    //             $this->error('Error al guardar los equipos del partido en db');
    
    //             return Command::FAILURE;
    //         }

    //     }

    //     $this->info('Se han procesado todas las jornadas con éxito');

    //     return Command::SUCCESS;

    // }
}
