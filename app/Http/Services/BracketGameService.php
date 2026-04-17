<?php

namespace App\Http\Services;

use App\Mail\SystemNotification;
use App\Models\BracketGame;
use App\Models\Partido;
use App\Models\ResultadoPartido;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class BracketGameService {

    public function addBracketGame(Partido $partido): void
    {
        $journey_id = $partido->jornada_id;

        // Prevenir agregar partidos de las primeras tres jornadas
        if (in_array($journey_id, [1, 2, 3])) {
            return;
        }

        // Evitar duplicados si el evento se dispara más de una vez
        if (BracketGame::where('match_id', $partido->id)->exists()) {
            return;
        }

        if (empty($partido->equipos)) {
            $this->notify(
                "Nuevo Partido - Equipos no encontrados — partido {$partido->id}",
                "El Partido ID {$partido->id} no tiene relación 'equipos' (EquipoPartido). Jornada {$journey_id}."
            );

            return;
        }

        $nextBracketGame = BracketGame::where('journey_id', $journey_id)
            ->where('status', 0)
            ->orderBy('bracket_position', 'asc')
            ->first();

        if (empty($nextBracketGame)) {
            $this->notify(
                "Nuevo Partido - Bracket sin slot disponible — jornada {$journey_id}",
                "No se encontró un BracketGame con status=0 para la jornada {$journey_id}. Partido ID: {$partido->id}."
            );

            return;
        }

        try {
            $nextBracketGame->update([
                'match_id'    => $partido->id,
                'team_one_id' => $partido->equipos->equipo_1,
                'team_two_id' => $partido->equipos->equipo_2,
                'status'      => 1,
            ]);
        } catch (Throwable $e) {
            $this->notify(
                "Nuevo Partido - Error al actualizar bracket game — {$nextBracketGame->id}",
                "No se pudo actualizar el bracket game para la jornada {$journey_id}. Partido ID: {$partido->id}. Error: {$e->getMessage()}"
            );
        }
    }

    public function addBracketGameResult(ResultadoPartido $resultado): void
    {
        if (empty($resultado->partido)) {
            $this->notify(
                "Nuevo resultado - Partido no encontrado — resultado {$resultado->id}",
                "El ResultadoPartido ID {$resultado->id} no tiene relación 'partido'."
            );

            return;
        }

        $match_id = $resultado->partido_id;
        $journey_id = $resultado->partido->jornada_id;

        // Prevenir agregar resultados de las primeras tres jornadas
        if (in_array($journey_id, [1, 2, 3])) {
            return;
        }

        $bracketGame = BracketGame::where('match_id', $match_id)
            ->where('status', 1)
            ->first();

        if (empty($bracketGame)) {
            $this->notify(
                "Nuevo resultado - BracketGame no encontrado — partido {$match_id}",
                "No se encontró un BracketGame con status=1 y match_id={$match_id} para la jornada {$journey_id}."
            );

            return;
        }

        try {
            $bracketGame->update([
                'result_id' => $resultado->id,
                'status'    => 2,
            ]);
        } catch (Throwable $e) {
            $this->notify(
                "Nuevo resultado - Error al actualizar bracket game — {$bracketGame->id}",
                "No se pudo agregar el resultado del bracket game para la jornada {$journey_id}. Partido ID: {$match_id}. Error: {$e->getMessage()}"
            );

            return;
        }

        $winner_id = $resultado->equipo_ganador_id;

        if (empty($winner_id)) {
            return;
        }

        // Agregar equipo ganador al/los siguientes bracket games

        $childBracketGames = BracketGame::where('local_game_id', $bracketGame->id)
            ->orWhere('visitor_game_id', $bracketGame->id)
            ->get();

        if ($childBracketGames->isEmpty()) {
            return;
        }

        // Calcular perdedor desde EquipoPartido (el que no es ganador)
        $equipos = $resultado->equiposPartido;
        $loser_id = null;

        if (!empty($equipos)) {
            $loser_id = (int)$equipos->equipo_1 === (int)$winner_id
                ? $equipos->equipo_2
                : $equipos->equipo_1;
        }

        foreach ($childBracketGames as $childBracketGame) {
            $updateFields = [];

            if ((int)$childBracketGame->local_game_id === (int)$bracketGame->id) {
                $updateFields['team_one_id'] = $childBracketGame->local_source === 'perdedor'
                    ? $loser_id
                    : $winner_id;
            }

            if ((int)$childBracketGame->visitor_game_id === (int)$bracketGame->id) {
                $updateFields['team_two_id'] = $childBracketGame->visitor_source === 'perdedor'
                    ? $loser_id
                    : $winner_id;
            }

            if (empty($updateFields)) {
                continue;
            }

            try {
                $childBracketGame->update($updateFields);
            } catch (Throwable $e) {
                $this->notify(
                    "Partido derivado - Error al actualizar bracket game derivado — {$childBracketGame->id}",
                    "No se pudo agregar el equipo derivado del bracket game {$bracketGame->id} para la jornada {$journey_id}. Error: {$e->getMessage()}"
                );
            }
        }
    }

    protected function notify(string $subject, string $body): void
    {
        Log::warning("[BracketGameService] {$subject} — {$body}");

        Mail::to(config('quiniela.system_notifications_email'))
            ->send(new SystemNotification(
                customSubject: $subject,
                body: $body,
            ));
    }

}
