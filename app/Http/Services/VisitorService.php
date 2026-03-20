<?php

namespace App\Http\Services;

use App\Models\Visitor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VisitorService {

    public function getVisitorsByCountry($country_id)
    {
        return Visitor::where('is_active', true)
            ->when(is_numeric($country_id), function (Builder $query) use($country_id) {
                return $query->where('country_id', $country_id);
            })
            ->get();
    }

}