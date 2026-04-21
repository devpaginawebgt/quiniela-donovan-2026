<?php

namespace App\Http\Services;

use App\Models\User;

class ReportService
{
    public function getUsuarios()
    {
        return User::with(['country', 'type', 'company', 'visitor', 'pushTokens'])
            ->select('users.*')
            ->orderBy('puntos', 'desc');
    }
}
