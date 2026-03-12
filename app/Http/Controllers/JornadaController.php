<?php

namespace App\Http\Controllers;

use App\Http\Resources\Jornada\JornadaResource;
use App\Http\Resources\Partido\PartidoResource;
use App\Http\Services\EquipoService;
use App\Http\Services\ModuleService;
use App\Http\Services\PartidoService;
use App\Http\Services\PrediccionService;
use App\Http\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JornadaController extends Controller
{
    use ApiResponse;
    
    public function __construct(
        private readonly UserService $userService,
        private readonly ModuleService $moduleService,
        private readonly PartidoService $partidoService,
        private readonly EquipoService $equipoService,
        private readonly PrediccionService $prediccionService
    ) {}
        
    public function getJornadas() 
    {

        $jornadas = $this->partidoService->getJornadas();

        $jornadas = JornadaResource::collection($jornadas);

        return $this->successResponse($jornadas);

    }

    public function getPartidosJornada(Request $request, string $get_jornada)
    {
        
        $get_jornada = (int)$get_jornada;

        if ( empty($get_jornada) ) {

            return $this->errorResponse('No se encontró la jornada', 422);

        }

        $jornada = $this->partidoService->getJornada($get_jornada);

        if ( empty($jornada) ) {

            return $this->errorResponse('No se encontró la jornada', 422);

        }

        $partidos = $this->partidoService->getPartidosJornada($get_jornada);

        $partidos = PartidoResource::collection($partidos);

        return $this->successResponse($partidos);

    }

    // Funciones de la web

    public function proximosPartidosWeb(Request $request)
    {
        // Banners

        $banners = $this->moduleService->getBanners(7);

        // User Info

        $user = $request->user();
        
        $user = $this->userService->getUserRank($user);

        $user = $this->userService->getUserPredictionsCount($user);

        // Jornadas

        $jornadas = $this->partidoService->getJornadas();

        $jornada_activa = $jornadas->firstWhere('is_current', true);

        $jornada_filtrada = (int)$request->get('jornada') ?: $jornada_activa->id;

        // Partidos con predicciones del usuario

        $partidosJornada = $this->prediccionService->getPrediccionesJornada($jornada_filtrada, $user->id);

        return view('modulos.proximos-partidos', [
            'jornadas'        => $jornadas,
            'banners'         => $banners,
            'user'            => $user,
            'jornada_activa'  => $jornada_filtrada,
            'partidosJornada' => $partidosJornada,
        ]);
    }

    public function jornadasWeb() {

        $jornadas = $this->partidoService->getJornadas();

        return view('modulos.calendario', [ 'jornadas' => $jornadas ]);

    }

    public function partidosJornada(string $get_jornada)
    {

        $get_jornada = (int)$get_jornada;

        if ( empty($get_jornada) ) {

            return $this->errorResponse('No se encontró la jornada', 422);

        }

        $jornada = $this->partidoService->getJornada($get_jornada);

        if ( empty($jornada) ) {

            return $this->errorResponse('No se encontró la jornada', 422);

        }

        $partidos = $this->partidoService->getPartidosJornada($get_jornada);

        $partidos = PartidoResource::collection($partidos);

        return $this->successResponse($partidos);

        // $partidosJornada = DB::select(
        //     "SELECT 
        //         * 
        //     FROM 
        //         equipo_partidos epar
        //     INNER JOIN 
        //         equipos e ON epar.equipo_1 = e.id OR epar.equipo_2 = e.id
        //     INNER JOIN 
        //         partidos par ON epar.partido_id = par.id
        //     WHERE 
        //         par.jornada_id = {$jornada}"
        // );

        // return json_encode($partidosJornada);

    }
}
