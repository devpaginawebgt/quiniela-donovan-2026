<?php

namespace Database\Seeders;

use App\Models\BracketGame;
use Illuminate\Database\Seeder;

class BracketGameSeeder extends Seeder
{
    public function run()
    {
        $map = [];

        $r32 = [
            ['1A', '2B'],
            ['1C', '2D'],
            ['1E', '2F'],
            ['1G', '2H'],
            ['1I', '2J'],
            ['1K', '2L'],
            ['2A', '1B'],
            ['2C', '1D'],
            ['2E', '1F'],
            ['2G', '1H'],
            ['2I', '1J'],
            ['2K', '1L'],
            ['3A', '3B'],
            ['3C', '3D'],
            ['3E', '3F'],
            ['3G', '3H'],
        ];

        foreach ($r32 as $i => [$localLabel, $visitorLabel]) {
            $game = BracketGame::create([
                'journey_id' => 4,
                'bracket_position' => $i + 1,
                'local_slot_label' => $localLabel,
                'visitor_slot_label' => $visitorLabel,
            ]);
            $map[4][$i + 1] = $game->id;
        }

        foreach ([5 => 8, 6 => 4, 7 => 2] as $journeyId => $count) {
            $prevJourney = $journeyId - 1;
            for ($k = 1; $k <= $count; $k++) {
                $game = BracketGame::create([
                    'journey_id' => $journeyId,
                    'bracket_position' => $k,
                    'local_game_id' => $map[$prevJourney][2 * $k - 1],
                    'visitor_game_id' => $map[$prevJourney][2 * $k],
                ]);
                $map[$journeyId][$k] = $game->id;
            }
        }

        $tercer = BracketGame::create([
            'journey_id' => 8,
            'bracket_position' => 1,
            'local_game_id' => $map[7][1],
            'visitor_game_id' => $map[7][2],
            'local_source' => 'perdedor',
            'visitor_source' => 'perdedor',
        ]);
        $map[8][1] = $tercer->id;

        $final = BracketGame::create([
            'journey_id' => 9,
            'bracket_position' => 1,
            'local_game_id' => $map[7][1],
            'visitor_game_id' => $map[7][2],
        ]);
        $map[9][1] = $final->id;
    }
}
