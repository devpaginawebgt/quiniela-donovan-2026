<?php

namespace App\Http\Services;

use App\Http\Resources\Partido\PartidoResource;
use App\Models\Equipo;
use App\Models\EquipoPartido;
use App\Models\Preccion;
use App\Models\ResultadoPartido;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;

class PrediccionService {

    public function getPrediccionesJornada(int $id_jornada, int $user_id)
    {
        $predicciones_usuario = EquipoPartido::select([
            'equipo_partidos.id', 
            'equipo_partidos.equipo_1', 
            'equipo_partidos.equipo_2', 
            'equipo_partidos.partido_id',
        ])
            ->whereHas('partido', function(Builder $query) use($id_jornada) {
                $query ->where('jornada_id', $id_jornada)
                    ->whereNot('estado', 1);
            })
            ->with([
                'partido:id,fase,jornada_id,fecha_partido,jugado,estado,brand_id',
                'partido.brand',
                'equipoUno:id,nombre,imagen,grupo',
                'equipoDos:id,nombre,imagen,grupo',
                'prediccion' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id)
                        ->select('id','partido_id','goles_equipo_1','goles_equipo_2');
                }
            ])
            ->get();

        return $predicciones_usuario;
    }

    public function getPrediccionesById(array $id_partidos, int $user_id)
    {
        $predicciones_usuario = EquipoPartido::select([
            'equipo_partidos.id', 
            'equipo_partidos.equipo_1', 
            'equipo_partidos.equipo_2', 
            'equipo_partidos.partido_id',
        ])
            ->whereHas('partido', function(Builder $query) use($id_partidos) {
                $query->whereIn('id', $id_partidos);
            })
            ->with([
                'partido:id,fase,jornada_id,fecha_partido,jugado,estado,brand_id',
                'partido.brand',
                'equipoUno:id,nombre,imagen,grupo',
                'equipoDos:id,nombre,imagen,grupo',
                'prediccion' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id)
                        ->select('id','partido_id','goles_equipo_1','goles_equipo_2');
                }
            ])
            ->get();

        return $predicciones_usuario;

    }

    public function validatePrediccionesUsuario($predicciones_nuevas, $predicciones_usuario) {

        // Iteramos para hacer verificación de partidos y separamos errores

        $predicciones_rechazadas = collect([]);

        $predicciones_permitidas = collect([]);

        $predicciones_nuevas->each(function($prediccion_nueva) use( $predicciones_usuario, &$predicciones_rechazadas, &$predicciones_permitidas ) {

            $prediccion_usuario = $predicciones_usuario->firstWhere('partido_id', $prediccion_nueva['id_partido']);

            if ($prediccion_nueva['prediccion_equipo_uno'] === null) {

                $prediccion_usuario->message = 'No se puede guardar la predicción: la predicción de marcador del primer equipo está vacía.';

                $predicciones_rechazadas->push($prediccion_usuario);

                return;

            }

            if ($prediccion_nueva['prediccion_equipo_dos'] === null) {

                $prediccion_usuario->message = 'No se puede guardar la predicción: la predicción de marcador del segundo equipo está vacía.';

                $predicciones_rechazadas->push($prediccion_usuario);

                return;

            }

            $estado = $prediccion_usuario->partido->estado;

            if ($estado === 1) {

                $prediccion_usuario->message = 'No se puede guardar la predicción: el partido ha finalizado.';

                $predicciones_rechazadas->push($prediccion_usuario);

                return;

            }

            if ($estado === 2) {

                $prediccion_usuario->message = 'No se puede guardar la predicción: ¡el partido está en juego!';

                $predicciones_rechazadas->push($prediccion_usuario);

                return;

            }

            $fecha_partido = $prediccion_usuario->partido->fecha_partido;

            $fecha_actual = Carbon::now();

            if ($fecha_actual->greaterThan($fecha_partido)) {

                $prediccion_usuario->message = 'No se puede guardar la predicción: la fecha del partido ya ha pasado.';

                $predicciones_rechazadas->push($prediccion_usuario);

                return;

            }

            $fecha_limite = $fecha_partido->subMinutes(10);

            if ($fecha_actual->greaterThan($fecha_limite)) {

                $prediccion_usuario->message = 'No se puede guardar la predicción: el partido está por comenzar (menos de 10 minutos).';

                $predicciones_rechazadas->push($prediccion_usuario);

                return;

            }

            $predicciones_permitidas->push($prediccion_usuario);

        });

        return [
            'rechazadas' => $predicciones_rechazadas,
            'permitidas' => $predicciones_permitidas
        ];

    }

    public function savePredicciones($predicciones_nuevas, $predicciones_usuario, $user_id)
    {
        $predicciones_nuevas->each(function($prediccion_nueva) use(&$predicciones_usuario, $user_id) {

            $prediccion_usuario = $predicciones_usuario->firstWhere('partido_id', $prediccion_nueva['id_partido']);

            // Si no existe la predicción, la creamos

            if ( empty($prediccion_usuario->prediccion) ) {

                $prediccion_creada = Preccion::create([
                    'user_id' => $user_id,
                    'partido_id' => $prediccion_nueva['id_partido'],
                    'goles_equipo_1' => $prediccion_nueva['prediccion_equipo_uno'],
                    'goles_equipo_2' => $prediccion_nueva['prediccion_equipo_dos'],
                ]);

                // Actualizamos la predicción del usuario

                $prediccion_usuario->prediccion = $prediccion_creada;
                $prediccion_usuario->message = 'Tu pronóstico ha sido guardado con éxito.';

                return;

            }

            // Si ya existe una prediccion de este usuario, buscamos el registro            

            $prediccion_db = Preccion::find($prediccion_usuario->prediccion->id);
            $prediccion_db->goles_equipo_1 = $prediccion_nueva['prediccion_equipo_uno'];
            $prediccion_db->goles_equipo_2 = $prediccion_nueva['prediccion_equipo_dos'];

            // Actualizamos el registro en caso se haya modificado

            if ($prediccion_db->isDirty()) {

                $prediccion_db->save();
                $prediccion_usuario->prediccion = $prediccion_db;
                $prediccion_usuario->message = 'Tu pronóstico ha sido actualizado con éxito.';

                return;

            }

            // Si los marcadores son los mismos no se toma acción

            $prediccion_usuario->message = 'Tu pronóstico ha mantenido el mismo marcador.';

            return;

        });

        return $predicciones_usuario;

    }

    public function getResultados(int $id_jornada, int $user_id)
    {
        $registros = EquipoPartido::select([
            'equipo_partidos.id', 
            'equipo_partidos.equipo_1', 
            'equipo_partidos.equipo_2', 
            'equipo_partidos.partido_id',
        ])
            ->has('resultado')
            ->whereHas('partido', function(Builder $query) use($id_jornada) {
                $query->where('jornada_id', $id_jornada)
                    ->where('estado', 1);
            })
            ->with([
                'partido:id,fase,jornada_id,fecha_partido,jugado,estado,brand_id',
                'partido.brand',
                'equipoUno:id,nombre,imagen,grupo',
                'equipoDos:id,nombre,imagen,grupo',
                'resultado:id,partido_id,goles_equipo_1,goles_equipo_2',
                'prediccion' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id)
                        ->select('id','partido_id','goles_equipo_1','goles_equipo_2');
                }
            ])
            ->get();

        $registros->each(function($registro) {

            if ( empty($registro->prediccion) ) {                

                $registro->puntos = 0;

                $registro->mensaje = 'No has realizado una predicción.';

                return;

            }

            $puntos = $this->getResultadoPrediccion($registro->prediccion, $registro->resultado);

            $registro->puntos = $puntos;

            $registro->mensaje = "Ganaste: {$puntos} puntos";

        });

        return $registros;

    }

    public function getResultadoPrediccion($prediccion, $resultado)
    {

        $pred_e_uno = $prediccion?->goles_equipo_1;
        $pred_e_dos = $prediccion?->goles_equipo_2;

        $res_e_uno = $resultado?->goles_equipo_1;
        $res_e_dos = $resultado?->goles_equipo_2;

        // Acertó en goles

        $acerto_goles_uno = boolval($pred_e_uno === $res_e_uno);
        $acerto_goles_dos = boolval($pred_e_dos === $res_e_dos);

        $acerto_marcadores = boolval($acerto_goles_uno && $acerto_goles_dos);
        $acerto_un_marcador = boolval($acerto_goles_uno || $acerto_goles_dos);

        // Acertó en equipo ganador

        $acerto_ganador_uno = boolval($res_e_uno > $res_e_dos && $pred_e_uno > $pred_e_dos);
        $acerto_ganador_dos = boolval($res_e_dos > $res_e_uno && $pred_e_dos > $pred_e_uno);

        $acerto_equipo_ganador = boolval($acerto_ganador_uno || $acerto_ganador_dos);

        // Acertó empate

        $resultado_empate = boolval($res_e_uno === $res_e_dos);
        $prediccion_empate = boolval($pred_e_uno === $pred_e_dos);

        $predijo_empate = boolval($resultado_empate && $prediccion_empate);

        // Validaciones de predicción

        if ($acerto_marcadores) return 5;

        if ($acerto_equipo_ganador && $acerto_un_marcador) return 4; 

        if ($acerto_equipo_ganador) return 2;

        if ($predijo_empate) return 2;

        if ($acerto_un_marcador) return 1;

        return 0;
    
    }

    // Funciones para la web

    public function getResultadosWeb(int $id_jornada, int $user_id)
    {
        $registros = EquipoPartido::select([
            'equipo_partidos.id', 
            'equipo_partidos.equipo_1', 
            'equipo_partidos.equipo_2', 
            'equipo_partidos.partido_id',            
        ])
            ->whereHas('partido', function(Builder $query) use($id_jornada) {
                $query->where('jornada_id', $id_jornada);
            })
            ->with([
                'partido:id,fase,jornada_id,fecha_partido,jugado,estado,brand_id',
                'partido.brand',
                'equipoUno:id,nombre,imagen,grupo',
                'equipoDos:id,nombre,imagen,grupo',
                'resultado:id,partido_id,goles_equipo_1,goles_equipo_2',
                'prediccion' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id)
                        ->select('id','partido_id','goles_equipo_1','goles_equipo_2');
                }
            ])
            ->get();

        $registros->each(function($registro) {

            if ( empty($registro->prediccion) ) {

                $registro->partido->puntos = 0;

                $registro->partido->mensaje = 'No has realizado una predicción.';

                return;

            }

            $puntos = $this->getResultadoPrediccion($registro->prediccion, $registro->resultado);

            $registro->partido->puntos = $puntos;

            $registro->partido->mensaje = "Ganaste: {$puntos} puntos";

        });

        return $registros;

    }

    // public function prediccionesParticipante($jornada, $user_id)
    // {
    
    //     $partidosJornada = DB::select(
    //         "SELECT 
    //             par.id as partido_id,
    //             par.jornada_id,
    //             par.estado,
    //             par.fecha_partido,
    //             ep.equipo_1,
    //             ep.equipo_2
    //         FROM 
    //             partidos par
    //         INNER JOIN 
    //             equipo_partidos ep ON par.id = ep.partido_id
    //         WHERE 
    //             par.jornada_id = $jornada 
    //         ORDER BY 
    //             par.fecha_partido ASC"
    //     );


    //     foreach ($partidosJornada as $partido) {

    //         $equipo_1 = Equipo::find($partido->equipo_1);
    //         $equipo_2 = Equipo::find($partido->equipo_2);

    //         $partido->nombre_equipo_1 = $equipo_1->nombre;
    //         $partido->imagen_equipo_1 = $equipo_1->imagen;

    //         $partido->nombre_equipo_2 = $equipo_2->nombre;
    //         $partido->imagen_equipo_2 = $equipo_2->imagen;

    //         // Información de predicción

    //         $prediccion = Preccion::where('partido_id', $partido->partido_id)
    //             ->where('user_id', $user_id)
    //             ->first();

    //         $partido->pdg_equipo_1 = $prediccion->goles_equipo_1 ?? '';
    //         $partido->pdg_equipo_2 = $prediccion->goles_equipo_2 ?? '';

    //         // Información de resultado

    //         $resultado = ResultadoPartido::where('partido_id', $partido->partido_id)
    //             ->first();

    //         $partido->goles_equipo_1 = $resultado->goles_equipo_1 ?? '';
    //         $partido->goles_equipo_2 = $resultado->goles_equipo_2 ?? '';
            
    //         $partido->fecha_partido = Carbon::create($partido->fecha_partido);

    //         if ($partido->estado == 1 && isset($prediccion)) {

    //             if ($partido->pdg_equipo_1 == $partido->goles_equipo_1 && $partido->pdg_equipo_2 == $partido->goles_equipo_2) {

    //                 $partido->puntos = 5;

    //             } elseif (($partido->pdg_equipo_1 > $partido->pdg_equipo_2 && $partido->goles_equipo_1 > $partido->goles_equipo_2) &&

    //                 ($partido->pdg_equipo_1 == $partido->goles_equipo_1 || $partido->pdg_equipo_2 == $partido->goles_equipo_2)

    //             ) {

    //                 $partido->puntos = 4;

    //             } elseif (($partido->pdg_equipo_2 > $partido->pdg_equipo_1 && $partido->goles_equipo_2 > $partido->goles_equipo_1) &&
    //                 ($partido->pdg_equipo_1 == $partido->goles_equipo_1 || $partido->pdg_equipo_2 == $partido->goles_equipo_2)
    //             ) {

    //                 $partido->puntos = 4;

    //             } elseif (($partido->pdg_equipo_1 > $partido->pdg_equipo_2 && $partido->goles_equipo_1 > $partido->goles_equipo_2) ||
    //                 ($partido->pdg_equipo_2 > $partido->pdg_equipo_1 && $partido->goles_equipo_2 > $partido->goles_equipo_1)
    //             ) {

    //                 $partido->puntos = 2;

    //             } elseif ($partido->pdg_equipo_2 == $partido->pdg_equipo_1 && $partido->goles_equipo_2 == $partido->goles_equipo_1) {

    //                 $partido->puntos = 2;

    //             } elseif ($partido->pdg_equipo_1 == $partido->goles_equipo_1 || $partido->pdg_equipo_2 == $partido->goles_equipo_2) {

    //                 $partido->puntos = 1;
    //             } else {
    //                 $partido->puntos = 0;
    //             }


    //         }
    //     }

    //     return $partidosJornada;
    // }

    public function actualizarPuntosParticipantes($user_id)
    {

        $predicciones_resultados = DB::select(
            "SELECT 
                pre.id,
                pre.goles_equipo_1 as p_equipo_1, 
                pre.goles_equipo_2 as p_equipo_2, 
                pre.partido_id,
                res.goles_equipo_1,
                res.goles_equipo_2
            FROM 
                preccions pre
            INNER JOIN 
                resultado_partidos res on pre.partido_id = res.partido_id
            WHERE 
                user_id = $user_id 
            AND 
                status = 0"
        );

        foreach ($predicciones_resultados as $prediccion) {

            $usuario = User::find($user_id);

            if ($prediccion->p_equipo_1 == $prediccion->goles_equipo_1 && $prediccion->p_equipo_2 == $prediccion->goles_equipo_2) {

                $usuario->puntos += 5;
                
            } elseif (($prediccion->p_equipo_1 > $prediccion->p_equipo_2 && $prediccion->goles_equipo_1 > $prediccion->goles_equipo_2) &&
                ($prediccion->p_equipo_1 == $prediccion->goles_equipo_1 || $prediccion->p_equipo_2 == $prediccion->goles_equipo_2)
            ) {

                $usuario->puntos += 4;
                
            } elseif (($prediccion->p_equipo_2 > $prediccion->p_equipo_1 && $prediccion->goles_equipo_2 > $prediccion->goles_equipo_1) &&
                ($prediccion->p_equipo_1 == $prediccion->goles_equipo_1 || $prediccion->p_equipo_2 == $prediccion->goles_equipo_2)
            ) {

                $usuario->puntos += 4;
                
            } elseif (($prediccion->p_equipo_1 > $prediccion->p_equipo_2 && $prediccion->goles_equipo_1 > $prediccion->goles_equipo_2) ||
                ($prediccion->p_equipo_2 > $prediccion->p_equipo_1 && $prediccion->goles_equipo_2 > $prediccion->goles_equipo_1)
            ) {

                $usuario->puntos += 2;
                
            } elseif ($prediccion->p_equipo_2 == $prediccion->p_equipo_1 && $prediccion->goles_equipo_2 == $prediccion->goles_equipo_1) {

                $usuario->puntos += 2;
                
            } elseif ($prediccion->p_equipo_1 == $prediccion->goles_equipo_1 || $prediccion->p_equipo_2 == $prediccion->goles_equipo_2) {

                $usuario->puntos += 1;
                
            } else {
                $usuario->puntos += 0;
                
            }
            $usuario->save();

            $prediccion_guardada = Preccion::find($prediccion->id);
            $prediccion_guardada->status = 1;
            $prediccion_guardada->save();
        }
    }
}