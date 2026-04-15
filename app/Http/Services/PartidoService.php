<?php

namespace App\Http\Services;

use App\Models\EquipoPartido;
use App\Models\Jornada;
use App\Models\Partido;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PartidoService {

    public function getJornadas()
    {
        return Jornada::whereHas('partidos')->get();
    }

    public function getJornada(int $jornada)
    {
        return Jornada::find($jornada);
    }

    public function getPartidosJornada(int $jornada)
    {

        $partidos = EquipoPartido::select('id', 'equipo_1', 'equipo_2', 'partido_id')
            ->whereHas('partido', function(Builder $query) use($jornada) {
                $query->where('jornada_id', $jornada);
            })
            ->with([
                'partido:id,fase,jornada_id,fecha_partido,jugado,estado,brand_id',
                'partido.brand',
                'equipoUno:id,nombre,imagen,grupo',
                'equipoDos:id,nombre,imagen,grupo'
            ])
            ->get();

        return $partidos;

    }

    public function getJornadasGrupo(string $grupo)
    {
        $jornadas_obtener = collect([1, 2, 3]);
        
        $jornadas = collect([]);

        $jornadas_obtener->each(function($jornada) use($grupo, $jornadas) {

            $jornada_db = $this->getJornada($jornada);

            $partidosJornada = EquipoPartido::select('id', 'equipo_1', 'equipo_2', 'partido_id')
                ->whereHas('partido', function(Builder $query) use($jornada) {
                    $query->where('jornada_id', $jornada);
                })
                ->whereHas('equipoUno', function(Builder $query) use($grupo) {
                    $query->where('grupo', $grupo);
                })
                ->whereHas('equipoDos', function(Builder $query) use($grupo) {
                    $query->where('grupo', $grupo);
                })
                ->with([
                    'partido:id,fase,jornada_id,fecha_partido,jugado,estado,brand_id',
                    'partido.brand',
                    'equipoUno:id,nombre,imagen,grupo',
                    'equipoDos:id,nombre,imagen,grupo'
                ])
                ->get();

            $jornada_db->partidos = $partidosJornada;

            $jornadas->push($jornada_db);

        });

        return $jornadas;
    }
    
    
    // Actualizar el estado de los partidos, si la hora ya ha pasado

    public function actualizarPartidosPasados()
    {

        return Partido::select('id', 'fecha_partido', 'estado')
            ->whereDate('fecha_partido', Carbon::today())
            ->where('fecha_partido', '<', Carbon::now())
            ->where('estado', 0)
            ->update(['estado' => 2]);

    }

    // Actualizar los puntos de los equipos cuyo estado de partido no sea 1 (puntos actualizados)

    public function actualizarPuntosEquipos()
    {
        $partidosJugados = EquipoPartido::select('id', 'equipo_1', 'equipo_2', 'partido_id')
            ->with(['partido', 'equipoUno', 'equipoDos', 'resultado'])
            ->has('resultado')
            ->whereHas('partido', function(Builder $query) {
                $query->whereNot('estado', 1);
            })
            ->get();

        foreach ($partidosJugados as $partido) {

            $equipo1 = $partido->equipoUno;
            $equipo2 = $partido->equipoDos;

            $goles_e1 = (int)$partido->resultado->goles_equipo_1;
            $goles_e2 = (int)$partido->resultado->goles_equipo_2;

            // Goles a favor y en contra

            $equipo1->increment('goles_favor', $goles_e1);
            $equipo1->increment('goles_contra', $goles_e2);
            $equipo1->increment('partidos_jugados');

            $equipo2->increment('goles_favor', $goles_e2);
            $equipo2->increment('goles_contra', $goles_e1);
            $equipo2->increment('partidos_jugados');

            // Determinar resultado

            $gano_equipo_1 = $goles_e1 > $goles_e2;
            $gano_equipo_2 = $goles_e2 > $goles_e1;
            $empate = $goles_e1 === $goles_e2;

            if ($gano_equipo_1) {
                $equipo1->increment('partidos_ganados');
                $equipo1->increment('puntos', 3);
                $equipo2->increment('partidos_perdidos');
            } elseif ($gano_equipo_2) {
                $equipo2->increment('partidos_ganados');
                $equipo2->increment('puntos', 3);
                $equipo1->increment('partidos_perdidos');
            } elseif ($empate) {
                $equipo1->increment('partidos_empatados');
                $equipo1->increment('puntos');
                $equipo2->increment('partidos_empatados');
                $equipo2->increment('puntos');
            }

            // Marcar partido como procesado
            $partido->partido->estado = 1;
            $partido->partido->jugado = 1;
            $partido->partido->save();
        }
    }

}