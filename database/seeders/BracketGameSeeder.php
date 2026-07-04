<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Los `BracketGame` ya no se pre-siembran.
 *
 * Se crean bajo demanda:
 *   - Vía el comando `php artisan bracket:regenerar-jornada --jornada=X`
 *     (borra y recrea los bracket_games de esa jornada desde los Partido existentes).
 *   - Vía el listener `AddBracketGame` cuando el sync del API dispara `MatchCreated`
 *     y no existe aún un bracket_game para ese par de equipos en esa jornada.
 *
 * Feeders (`local_game_id`/`visitor_game_id`) y slot labels no se auto-populan —
 * quedan NULL. El admin reordena `bracket_position` manualmente si quiere que el
 * árbol visual coincida con la topología real del torneo.
 */
class BracketGameSeeder extends Seeder
{
    public function run(): void
    {
        //
    }
}
