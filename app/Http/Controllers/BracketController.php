<?php

namespace App\Http\Controllers;

use App\Models\BracketGame;
use App\Models\Grupo;

class BracketController extends Controller
{
    public function show()
    {
        $rondas = BracketGame::with([
                'teamOne:id,nombre,imagen,codigo_iso',
                'teamTwo:id,nombre,imagen,codigo_iso',
                'result',
                'localFeeder:id,bracket_position',
                'visitorFeeder:id,bracket_position',
            ])
            ->orderBy('journey_id')
            ->orderBy('bracket_position')
            ->get()
            ->groupBy('journey_id');

        $grupos = Grupo::with(['equipos' => function ($q) {
                $q->select([
                        'id', 'nombre', 'imagen', 'grupo',
                        'goles_favor', 'goles_contra', 'puntos',
                    ])
                    ->orderBy('puntos', 'desc')
                    ->orderByRaw('(goles_favor - goles_contra) desc')
                    ->orderBy('goles_favor', 'desc')
                    ->orderBy('nombre', 'asc');
            }])
            ->orderBy('name')
            ->get();

        return view('embed.bracket', compact('rondas', 'grupos'));
    }
}
