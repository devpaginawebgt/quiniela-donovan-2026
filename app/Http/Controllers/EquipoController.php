<?php

namespace App\Http\Controllers;

use App\Http\Resources\Equipo\EquipoResource;
use App\Http\Services\EquipoService;
use App\Http\Services\ModuleService;
use App\Http\Services\PartidoService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly UserService $userService,
        private readonly ModuleService $moduleService,        
        private readonly PartidoService $partidoService,
        private readonly EquipoService $equipoService
    ) {}

    // Respuestas de API

    public function index(Request $request)
    {
        $equipos = $this->equipoService->getEquipos();

        $equipos = EquipoResource::collection($equipos);

        return $this->successResponse($equipos);
    }


    // Funciones para la web

    public function equiposWeb()
    {
        // Banners

        $banners = $this->moduleService->getBanners(12);        

        // User Info

        $user = Auth::user();
        
        $user = $this->userService->getUserRank($user);

        $user = $this->userService->getUserPredictionsCount($user);

        $equipos = $this->equipoService->getEquipos();

        return view('modulos.equipos', [
            'banners' => $banners,
            'user'    => $user,
            'equipos' => $equipos
        ]);

    }
}
