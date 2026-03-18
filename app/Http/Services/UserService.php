<?php

namespace App\Http\Services;

use App\Http\Requests\Auth\ApiLoginRequest;
use App\Models\Brand;
use App\Models\Country;
use App\Models\EquipoPartido;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService {

    public function getUsers()
    {

        $participantes = User::where('status_user', 1)->get();

        return $participantes;

    }

    public function getUser(int $userId)
    {
        return User::find($userId);
    }

    public function getUserLogin(ApiLoginRequest $request)
    {
        return User::where('numero_documento', $request->numero_documento)
            ->select('id', 'email', 'password', 'nombres', 'apellidos', 'pais_id', 'numero_documento', 'email', 'telefono', 'puntos', 'status_user', 'created_at')
            ->first();
    }

    public function getRanking($id_pais)
    {
        $participantes = User::select('id', 'nombres', 'apellidos', 'pais_id', 'numero_documento', 'email', 'telefono', 'puntos', 'created_at')
            ->selectRaw('RANK() OVER (ORDER BY puntos DESC, nombres ASC) as posicion')
            ->has('predictions')
            ->where('status_user', 1)
            ->where('pais_id', $id_pais)
            ->where('puntos', '>', 0)
            ->get();

        return $participantes;

    }

    public function getUserRank($user)
    {
        $rankingQuery = User::select('id', 'nombres', 'apellidos', 'pais_id', 'puntos', 'created_at')
            ->selectRaw('RANK() OVER (ORDER BY puntos DESC, nombres ASC) as posicion')
            ->has('predictions')
            ->where('status_user', 1)
            ->where('pais_id', $user->pais_id)
            ->where('puntos', '>', 0);
        
        $rank = DB::query()
            ->fromSub($rankingQuery, 'ranking')
            ->where('id', $user->id)
            ->value('posicion');

        $user->posicion = $rank;



        return $user;
    }

    public function getUserPredictionsCount($user)
    {
        $partidos_existentes = EquipoPartido::whereHas('partido')->count();

        $predicciones_realizadas = $user->predictions->count();

        $predicciones_pendientes = $partidos_existentes - $predicciones_realizadas;

        $partidos = [
            'total_partidos' => $partidos_existentes,
            'predicciones' => $predicciones_realizadas,
            'predicciones_pendientes' => $predicciones_pendientes
        ];

        $user->partidos = (object) $partidos;

        return $user;
    }

    public function setUserBrands($participantes) 
    {
        $brand = Brand::find(1);

        $participantes->each(function ($user) use ($brand) {
            $user->brand = $user->posicion === 1 ? $brand : null;
        });

        return $participantes;
    }

}