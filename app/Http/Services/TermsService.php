<?php

namespace App\Http\Services;

use App\Http\Resources\Term\TermResource;
use App\Models\Term;

class TermsService
{

    public function getTerms()
    {
        return Term::where('is_active', true)->first();
    }
}
