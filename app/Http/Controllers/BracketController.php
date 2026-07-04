<?php

namespace App\Http\Controllers;

use App\Models\BracketGame;
use App\Models\Grupo;
use App\Models\Jornada;
use Illuminate\Support\Collection;

class BracketController extends Controller
{
    /** Slots visuales esperados por jornada de knockout. */
    private const EXPECTED_SLOTS = [
        4 => 16, // 16avos
        5 => 8,  // Octavos
        6 => 4,  // Cuartos
        7 => 2,  // Semis
        8 => 1,  // Tercer lugar
        9 => 1,  // Final
    ];

    public function show()
    {
        return view('modulos.bracket-public', $this->buildData());
    }

    public function showWeb()
    {
        return view('modulos.bracket', $this->buildData());
    }

    private function buildData(): array
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

        $rondas = $this->fillPlaceholders($rondas);

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

        $jornadas = Jornada::all()->keyBy('id');

        return compact('rondas', 'grupos', 'jornadas');
    }

    /**
     * Rellena con stubs in-memory (no persistidos) los slots faltantes de cada
     * ronda para que el árbol se pinte completo aunque aún no existan bracket_games.
     * Los stubs no tienen teamOne/teamTwo/feeders, así que match-card los renderiza
     * como "Por definir".
     */
    private function fillPlaceholders(Collection $rondas): Collection
    {
        foreach (self::EXPECTED_SLOTS as $journey => $count) {
            $existing = $rondas->get($journey, collect());

            if ($existing->count() >= $count) {
                continue;
            }

            $maxPos = (int) ($existing->max('bracket_position') ?? 0);

            for ($p = $maxPos + 1; $p <= $count; $p++) {
                $stub = new BracketGame([
                    'journey_id'       => $journey,
                    'bracket_position' => $p,
                    'status'           => 0,
                ]);
                $existing->push($stub);
            }

            $rondas->put($journey, $existing->sortBy('bracket_position')->values());
        }

        return $rondas;
    }
}
