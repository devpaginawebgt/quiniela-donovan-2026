<?php

namespace App\Http\Controllers;

use App\Models\BracketGame;

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

        return view('embed.bracket', compact('rondas'));
    }
}
