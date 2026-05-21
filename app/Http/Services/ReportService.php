<?php

namespace App\Http\Services;

use App\Models\Preccion;
use App\Models\User;

class ReportService
{
    public function getUsuarios()
    {
        return User::with(['country', 'type', 'company', 'visitor', 'pushTokens'])
            ->select('users.*')
            ->orderBy('puntos', 'desc');
    }

    public function getPronosticos()
    {
        return Preccion::with([
            'user.country',
            'user.type',
            'user.company',
            'user.visitor',
            'partido.jornada',
            'partido.equipos.equipoUno',
            'partido.equipos.equipoDos',
            'resultado',
        ])
            ->select('preccions.*')
            ->orderBy('preccions.created_at', 'desc');
    }
}
