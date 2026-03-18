<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserRankingResource;
use App\Http\Resources\User\UserRankResource;
use App\Http\Resources\User\UserResource;
use App\Http\Services\BrandService;
use App\Http\Services\UserService;
use App\Models\Brand;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly UserService $userService,
        private readonly BrandService $brandService,
    ) {}

    // API responses

    public function getUsers()
    {

        $participantes = $this->userService->getUsers();

        $participantes = UserResource::collection($participantes);

        return $this->successResponse($participantes);

    }
    
    public function getUser(Request $request)
    {
        $user = $request->user();
        
        $user = $this->userService->getUserRank($user);

        $user = $this->userService->getUserPredictionsCount($user);

        $user = new UserRankResource($user);

        return $this->successResponse($user);

    }

    public function getUserRank(Request $request)
    {
        $user = $request->user();

        $user = $this->userService->getUserRank($user);

        $user = $this->userService->getUserPredictionsCount($user);

        $user = new UserRankResource($user);

        return $this->successResponse($user);

    }

    public function getRanking(Request $request)
    {
        $user = $request->user();

        $id_pais = (int) $user->pais_id;

        $participantes = $this->userService->getRanking($id_pais);

        $participantes = $this->userService->setUserBrands($participantes);

        $participantes = UserRankingResource::collection($participantes);

        return $this->successResponse($participantes);

    }

    // Funciones para la web

    public function indexWeb() 
    {
        $user = Auth::user();

        $id_pais = (int) $user->pais_id;

        $participantes = $this->userService->getRanking($id_pais);

        return view('modulos.tabla-resultados', [
            'participantes' => $participantes
        ]);

    }

    public function verParticipantes()
    {

        $participantes = $this->userService->getUsers();

        return view('modulos.participantes', [
            'participantes' => $participantes
        ]);

    }    
}
