<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserRankingResource;
use App\Http\Resources\User\UserRankResource;
use App\Http\Resources\User\UserResource;
use App\Http\Services\BrandService;
use App\Http\Services\TermsService;
use App\Http\Services\UserService;
use App\Models\Brand;
use App\Models\BrandPosition;
use App\Models\Country;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly UserService $userService,
        private readonly BrandService $brandService,
        private readonly TermsService $termsService,
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

    public function perfil()
    {
        $user = Auth::user();

        $user = $this->userService->getUserRank($user);
        $user = $this->userService->getUserPredictionsCount($user);

        $terms = $this->termsService->getTerms();

        return view('modulos.perfil', [
            'user' => $user,
            'terms' => $terms,
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
