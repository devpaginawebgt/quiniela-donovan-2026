<?php

namespace App\Http\Services;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CompanyService {

    public function getCompaniesByCountry($country_id)
    {
        return Company::when(is_numeric($country_id), function (Builder $query) use($country_id) {
                return $query->where('country_id', $country_id);
            })
            ->get();
    }

}