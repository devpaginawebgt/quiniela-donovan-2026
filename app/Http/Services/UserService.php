<?php

namespace App\Http\Services;

use App\Http\Requests\Auth\ApiLoginRequest;
use App\Models\Brand;
use App\Models\BrandPosition;
use App\Models\Country;
use App\Models\EquipoPartido;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UserService {

    public function getGuestCountry()
    {
        $cached = session('guest_country');
        
        if ($cached instanceof Country) {
            return $cached;
        }

        $ip = request()->ip();
        // $ip = '45.164.150.249'; // GT
        // $ip = '190.181.222.119'; // HN
        // $ip = '190.62.80.251'; // SV
        // $ip = '152.231.33.166'; // NI

        $country_code = 'GT';

        try {
            $response = Http::timeout(3)->get("http://api.ipinfo.io/lite/{$ip}", [
                'token' => config('services.geolocation.key'),
            ]);

            if ($response->ok() && !empty($response->json('country_code'))) {
                $country_code = $response->json('country_code');
            }
        } catch (\Exception $e) {
            // fallback silencioso, $country_code ya es 'GT'
        }

        $country = Country::where('country_code', $country_code)->first()
            ?? Country::where('country_code', 'GT')->first();

        session(['guest_country' => $country]);

        return $country;
    }

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

    public function getRankingGrupos(string|int $id_pais, string|int $type_id)
    {
        return User::select('*')
            ->selectRaw('RANK() OVER (ORDER BY puntos_grupos DESC, nombres ASC) as posicion')
            ->where('pais_id', $id_pais)
            ->where('user_type_id', $type_id)
            ->where(function (Builder $query) {
                return $query
                    ->has('predictions')
                    ->orHas('quizzes');
            })
            ->where('status_user', 1)
            ->get();
    }

    public function getRanking(string|int $id_pais, string|int $type_id)
    {
        return User::select('id', 'nombres', 'apellidos', 'pais_id', 'numero_documento', 'email', 'telefono', 'puntos', 'created_at')
            ->selectRaw('RANK() OVER (ORDER BY puntos DESC, nombres ASC) as posicion')
            ->where('pais_id', $id_pais)
            ->where('user_type_id', $type_id)
            ->where(function (Builder $query) {
                return $query
                    ->has('predictions')
                    ->orHas('quizzes');
            })
            ->where('status_user', 1)
            ->get();
    }

    public function getRankingGruposWeb(string|int $id_pais, string|int $type_id, int $perPage = 100)
    {
        return User::select('id', 'nombres', 'apellidos', 'puntos_grupos', 'pais_id', 'numero_documento', 'email', 'telefono', 'created_at')
            ->selectRaw('RANK() OVER (ORDER BY puntos_grupos DESC, nombres ASC) as posicion')
            ->where('pais_id', $id_pais)
            ->where('user_type_id', $type_id)
            ->where(function (Builder $query) {
                return $query
                    ->has('predictions')
                    ->orHas('quizzes');
            })
            ->where('status_user', 1)
            ->simplePaginate($perPage);
    }

    public function getRankingWeb(string|int $id_pais, string|int $type_id, $perPage = 100)
    {
        return User::select('id', 'nombres', 'apellidos', 'puntos', 'pais_id', 'numero_documento', 'email', 'telefono', 'created_at')
            ->selectRaw('RANK() OVER (ORDER BY puntos DESC, nombres ASC) as posicion')
            ->where('pais_id', $id_pais)
            ->where('user_type_id', $type_id)
            ->where(function (Builder $query) {
                return $query
                    ->has('predictions')
                    ->orHas('quizzes');
            })
            ->where('status_user', 1)
            ->simplePaginate($perPage);
    }

    public function getUserRank(User $user)
    {
        $rankingQuery = User::select('id', 'nombres', 'apellidos', 'pais_id', 'puntos', 'created_at')
            ->selectRaw('RANK() OVER (ORDER BY puntos DESC, nombres ASC) as posicion')
            ->where('pais_id', $user->pais_id)
            ->where('user_type_id', $user->user_type_id)
            ->where(function (Builder $query) {
                return $query
                    ->has('predictions')
                    ->orHas('quizzes');
            })
            ->where('status_user', 1);
        
        $rank = DB::query()
            ->fromSub($rankingQuery, 'ranking')
            ->where('id', $user->id)
            ->value('posicion');

        $user->posicion = $rank;

        return $user;
    }

    public function getUserPredictionsCount(User $user)
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

    public function setUserBrands($users, $country_id) 
    {
        $first_position = BrandPosition::where('country_id', $country_id)
            ->where('position', 1)
            ->first();

        if (isset($first_position) && ! empty($first_position)) {

            $first_position_brand = $first_position->brand;
    
            $users->each(function ($user) use ($first_position_brand) {
                $user->brand = $user->posicion === 1 ? $first_position_brand : null;
            });

        }

        return $users;
    }

    public function updateGlobalPoints()
    {
        User::where('puntos_trivias', '>', 0)
            ->orWhere('puntos_predicciones', '>', 0)
            ->chunkById(500, function ($users) {
                foreach ($users as $user) {
                    $user->puntos = $user->puntos_predicciones + $user->puntos_trivias;
                    $user->save();
                }
            });
    }

}