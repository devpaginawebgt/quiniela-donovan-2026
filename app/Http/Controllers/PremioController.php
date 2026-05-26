<?php

namespace App\Http\Controllers;

use App\Http\Resources\Premio\PremioResource;
use App\Http\Services\PremioService;
use App\Http\Services\UserService;
use App\Models\Brand;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PremioController extends Controller
{   
    use ApiResponse;

    public function __construct(
        private readonly UserService $userService,
        private readonly PremioService $premioService,
    ) {}

    // API Responses

    public function getPremios(Request $request)
    {

        $user = $request->user();

        $id_pais = (int) $user->pais_id;
        $id_user_type = (int) $user->user_type_id;

        $premios = $this->premioService->getPremios($id_pais, $id_user_type);

        $premios = PremioResource::collection($premios);

        return $this->successResponse($premios);

    }

    // Funciones para la web

    public function recompensas()
    {
        $user = Auth::user();
        $id_pais = $user->pais_id;
        $id_user_type = $user->user_type_id;

        $user = $this->userService->getUserRank($user);
        $user = $this->userService->getUserPredictionsCount($user);

        $premios = $this->premioService->getPremios($id_pais, $id_user_type);

        $brands = Brand::all();

        return view('modulos.recompensas', [
            'premios' => $premios,
            'brands' => $brands,
            'user' => $user,
        ]);
    }

}
