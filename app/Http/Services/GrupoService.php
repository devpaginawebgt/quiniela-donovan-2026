<?php 

namespace App\Http\Services;

use App\Models\Equipo;
use App\Models\Grupo;
use Illuminate\Database\Eloquent\Builder;

class GrupoService {

    public function getGrupos()
    {
        return Grupo::all();
    }

    public function getGrupo($grupo_id)
    {
        return Grupo::find($grupo_id);
    }

    public function getEquiposGrupo(int $grupo)
    {
        return Equipo::select([
            'id', 
            'nombre', 
            'imagen', 
            'descripcion', 
            'goles_favor', 
            'goles_contra', 
            'partidos_jugados', 
            'partidos_ganados', 
            'partidos_perdidos', 
            'partidos_empatados', 
            'puntos'
        ])
            ->where('grupo', $grupo)
            ->orderBy('puntos', 'desc')
            ->orderByRaw('(goles_favor - goles_contra) desc')
            ->orderBy('goles_favor', 'desc')
            ->orderBy('nombre', 'asc')
            ->get();
    }
}