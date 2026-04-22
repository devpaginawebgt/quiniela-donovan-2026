<?php

namespace App\Http\Services;

use App\Models\Premio;
use Illuminate\Database\Eloquent\Builder;

class PremioService {

    public function getPremios($id_pais, $id_user_type)
    {
        return Premio::where('pais_id', $id_pais)
            ->where('user_type_id', $id_user_type)
            ->get();
    }

}