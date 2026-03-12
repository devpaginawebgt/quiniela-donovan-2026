<?php

namespace App\Http\Controllers;

use App\Http\Resources\Equipo\EquipoGrupoResource;
use App\Http\Resources\Grupo\GrupoEquiposResource;
use App\Http\Resources\Grupo\GrupoResource;
use App\Http\Resources\Jornada\JornadaGrupoResource;
use App\Http\Services\EquipoService;
use App\Http\Services\GrupoService;
use App\Http\Services\PartidoService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly GrupoService $grupoService,
        private readonly EquipoService $equipoService,
        private readonly PartidoService $partidoService,
    ) {}

    public function getGrupos(Request $request)
    {
        $grupos = $this->grupoService->getGrupos();

        $grupos = GrupoResource::collection($grupos);

        return $this->successResponse($grupos);
    }

    public function getEquiposGrupo(string $get_grupo)
    {        
        $get_grupo = (int)$get_grupo;

        if ( empty($get_grupo) ) {

            return $this->errorResponse('No se encontró el grupo', 422);

        }

        $grupo = $this->grupoService->getGrupo($get_grupo);

        if ( empty($grupo) ) {

            return $this->errorResponse('No se encontró el grupo', 422);

        }

        $equipos = $this->grupoService->getEquiposGrupo($get_grupo);

        $grupo->equipos = $equipos;

        $grupo = new GrupoEquiposResource($grupo);

        return $this->successResponse($grupo);
    }

    public function getJornadasGrupo(string $get_grupo)
    {
        $get_grupo = (int)$get_grupo;

        if ( empty($get_grupo) ) {

            return $this->errorResponse('No se encontró el grupo', 422);

        }

        $grupo = $this->grupoService->getGrupo($get_grupo);

        if ( empty($grupo) ) {

            return $this->errorResponse('No se encontró el grupo', 422);

        }

        $jornadas = $this->partidoService->getJornadasGrupo($get_grupo);

        $jornadas = JornadaGrupoResource::collection($jornadas);

        return $this->successResponse($jornadas);
    }

    // Funciones para la web

    public function gruposWeb()
    {

        $this->partidoService->actualizarPuntosEquipos();

        // Obtenemos los grupos disponibles

        $grupos = $this->grupoService->getGrupos();

        // Obtenemos el grupo a mostrar por defecto

        $id_grupo_actual = (int) ($grupos->firstWhere('is_current', true))->id;        

        // Obtenemos los equipos del grupo a mostrar por defecto

        $equipos_grupo = $this->grupoService->getEquiposGrupo($id_grupo_actual);

        // Obtenemos las jornadas del grupo a mostrar por defecto

        $jornadas = $this->partidoService->getJornadasGrupo($id_grupo_actual);

        $jornada_uno = $jornadas->firstWhere('id', 1);
        $jornada_dos = $jornadas->firstWhere('id', 2);
        $jornada_tres = $jornadas->firstWhere('id', 3);

        return view('modulos.grupos', [
            'grupos' => $grupos,
            'equipos_grupo' => $equipos_grupo,
            'jornada_uno' => $jornada_uno,
            'jornada_dos' => $jornada_dos,
            'jornada_tres' => $jornada_tres
        ]);

    }

    public function getEquiposWeb(Request $request, string $grupo_id)
    {

        $grupo_id = (int)$grupo_id;

        if ( empty($grupo_id) ) {

            return $this->errorResponse('No se encontró el grupo', 422);

        }

        $grupo = $this->grupoService->getGrupo($grupo_id);

        if ( empty($grupo) ) {

            return $this->errorResponse('No se encontró el grupo', 422);

        }

        $equipos = $this->grupoService->getEquiposGrupo($grupo_id);

        $equipos = EquipoGrupoResource::collection($equipos);

        $grupo['equipos'] = $equipos;

        return $this->successResponse($grupo);

        // $grupo = strtoupper($grupoJornada->grupo);

        // $jornada = $grupoJornada->jornada;              

        // $partidosGrupo = DB::select(
        //     "SELECT 
        //         * 
        //     FROM 
        //         equipo_partidos epar
        //     INNER JOIN 
        //         equipos e ON epar.equipo_1 = e.id OR epar.equipo_2 = e.id
        //     INNER JOIN 
        //         partidos par ON epar.partido_id = par.id
        //     WHERE 
        //         e.grupo = '{$grupo}'
        //     AND
        //         par.jornada = {$jornada}"
        // );

        // return json_encode($partidosGrupo);

    }

    public function getJornadasWeb(Request $request, string $grupo_id)
    {

        $grupo_id = (int)$grupo_id;

        if ( empty($grupo_id) ) {

            return $this->errorResponse('No se encontró el grupo', 422);

        }

        $grupo = $this->grupoService->getGrupo($grupo_id);

        if ( empty($grupo) ) {

            return $this->errorResponse('No se encontró el grupo', 422);

        }

        $jornadas = $this->partidoService->getJornadasGrupo($grupo_id);

        $jornadas = JornadaGrupoResource::collection($jornadas);

        return $this->successResponse($jornadas);

        // $grupo = strtoupper($grupoJornada->grupo);

        // $jornada = $grupoJornada->jornada;              

        // $partidosGrupo = DB::select(
        //     "SELECT 
        //         * 
        //     FROM 
        //         equipo_partidos epar
        //     INNER JOIN 
        //         equipos e ON epar.equipo_1 = e.id OR epar.equipo_2 = e.id
        //     INNER JOIN 
        //         partidos par ON epar.partido_id = par.id
        //     WHERE 
        //         e.grupo = '{$grupo}'
        //     AND
        //         par.jornada = {$jornada}"
        // );

        // return json_encode($partidosGrupo);
        
    }
}
