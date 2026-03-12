<?php

namespace App\Http\Controllers;

use App\Http\Resources\Estadio\EstadioResource;
use App\Http\Services\ModuleService;
use App\Http\Services\UserService;
use App\Models\Estadio;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EstadioController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly UserService $userService,
        private readonly ModuleService $moduleService,        
    ) {}

    public function getEstadios()
    {

        $estadios = Estadio::all();

        $estadios = EstadioResource::collection($estadios);

        return $this->successResponse($estadios);

    }

    public function estadiosWeb()
    {
        // Banners

        $banners = $this->moduleService->getBanners(10);        

        // User Info

        $user = Auth::user();
        
        $user = $this->userService->getUserRank($user);

        $user = $this->userService->getUserPredictionsCount($user);

        $estadios = Estadio::all();

        return view('modulos.estadios', [
            'banners'  => $banners,
            'user'     => $user,
            'estadios' => $estadios
        ]);

    }
}
