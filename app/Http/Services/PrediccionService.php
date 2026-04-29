<?php

namespace App\Http\Services;

use App\Models\EquipoPartido;
use App\Models\Partido;
use App\Models\Preccion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

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
            ->orderBy(
                Partido::select('fecha_partido')
                    ->whereColumn('partidos.id', 'equipo_partidos.partido_id')
            )
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

            // if ($estado === 2) {

            //     $prediccion_usuario->message = 'No se puede guardar la predicción: ¡el partido está en juego!';

            //     $predicciones_rechazadas->push($prediccion_usuario);

            //     return;

            // }

            $fecha_partido = $prediccion_usuario->partido->fecha_partido;

            $fecha_actual = Carbon::now();

            // if ($fecha_actual->greaterThan($fecha_partido)) {

            //     $prediccion_usuario->message = 'No se puede guardar la predicción: la fecha del partido ya ha pasado.';

            //     $predicciones_rechazadas->push($prediccion_usuario);

            //     return;

            // }

            $fecha_limite = $fecha_partido->addMinutes(10);

            if ($fecha_actual->greaterThan($fecha_limite)) {

                $prediccion_usuario->message = 'No se puede guardar la predicción: ¡el partido ya ha comenzado! (más de 10 minutos).';

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
            ->orderByDesc(
                Partido::select('fecha_partido')
                    ->whereColumn('partidos.id', 'equipo_partidos.partido_id')
            )
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

        if (is_null($pred_e_uno) || is_null($pred_e_dos) || is_null($res_e_uno) || is_null($res_e_dos)) {
            return 0;
        }

        // Acertó en goles

        $acerto_goles_uno = boolval($pred_e_uno === $res_e_uno);
        $acerto_goles_dos = boolval($pred_e_dos === $res_e_dos);

        $acerto_marcadores = boolval($acerto_goles_uno && $acerto_goles_dos);
        // $acerto_un_marcador = boolval($acerto_goles_uno || $acerto_goles_dos);

        // Acertó en equipo ganador

        $acerto_ganador_uno = boolval($res_e_uno > $res_e_dos && $pred_e_uno > $pred_e_dos);
        $acerto_ganador_dos = boolval($res_e_dos > $res_e_uno && $pred_e_dos > $pred_e_uno);

        $acerto_equipo_ganador = boolval($acerto_ganador_uno || $acerto_ganador_dos);

        // Acertó empate

        $resultado_empate = boolval($res_e_uno === $res_e_dos);
        $prediccion_empate = boolval($pred_e_uno === $pred_e_dos);

        $predijo_empate = boolval($resultado_empate && $prediccion_empate);

        // Validaciones de predicción

        if ($acerto_marcadores) return 3;

        if ($acerto_equipo_ganador) return 1;

        if ($predijo_empate) return 1;

        return 0;

        // if ($acerto_equipo_ganador && $acerto_un_marcador) return 4; 

        // if ($acerto_un_marcador) return 1;
    
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

    public function actualizarPuntosParticipante(string|int $user_id)
    {
        $predicciones = Preccion::where('user_id', $user_id)
            ->where('status', 0)
            ->whereHas('resultado')
            ->with('resultado', 'user')
            ->get();

        if ($predicciones->isEmpty()) {
            return;
        }

        $usuario = $predicciones->first()->user;

        foreach ($predicciones as $prediccion) {
            $puntos = $this->getResultadoPrediccion($prediccion, $prediccion->resultado);

            $usuario->puntos_predicciones += $puntos;

            $prediccion->status = 1;
            $prediccion->save();
        }

        $usuario->puntos = $usuario->puntos_bonus + $usuario->puntos_trivias + $usuario->puntos_predicciones;

        $usuario->save();
    }

    /**
     * Versión optimizada de actualizarPuntosGlobal usando chunks.
     * Diseñada para el comando artisan con grandes volúmenes de datos.
     */
    public function actualizarPuntosGlobalChunked()
    {
        Preccion::where('status', 0)
            ->whereHas('resultado')
            ->with('partido', 'resultado', 'user')
            ->chunkById(1000, function ($predicciones) {
                $porUsuario = $predicciones->groupBy('user_id');
                $prediccionIds = [];

                foreach ($porUsuario as $prediccionesUsuario) {

                    $usuario = $prediccionesUsuario->first()->user;

                    $puntosGrupos = 0;
                    $puntosEliminatorias = 0;

                    foreach ($prediccionesUsuario as $prediccion) {
                        
                        $puntos_prediccion = $this->getResultadoPrediccion($prediccion, $prediccion->resultado);

                        $prediccion->partido->jornada_id > 3
                            ? $puntosEliminatorias += $puntos_prediccion
                            : $puntosGrupos += $puntos_prediccion;

                        $prediccionIds[] = $prediccion->id;

                    }

                    $usuario->puntos_predicciones_grupos += $puntosGrupos;
                    $usuario->puntos_predicciones += $puntosEliminatorias;

                    $usuario->puntos_grupos = 
                        $usuario->puntos_bonus_grupos + 
                        $usuario->puntos_trivias_grupos + 
                        $usuario->puntos_predicciones_grupos;

                    $usuario->puntos = 
                        $usuario->puntos_bonus + 
                        $usuario->puntos_trivias + 
                        $usuario->puntos_predicciones;

                    $usuario->save();
                }

                Preccion::whereIn('id', $prediccionIds)->update(['status' => 1]);
            });
    }
}