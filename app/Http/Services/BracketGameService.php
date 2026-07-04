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

        // Prevenir agregar partidos de las primeras tres jornadas (fase de grupos)
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

        $team_one = (int) $partido->equipos->equipo_1;
        $team_two = (int) $partido->equipos->equipo_2;

        // Si ya existe un bracket_game en esta jornada con el mismo par de equipos
        // (en cualquier orden), no hacer nada.
        $existente = BracketGame::where('journey_id', $journey_id)
            ->where(function ($q) use ($team_one, $team_two) {
                $q->where(function ($qq) use ($team_one, $team_two) {
                    $qq->where('team_one_id', $team_one)->where('team_two_id', $team_two);
                })->orWhere(function ($qq) use ($team_one, $team_two) {
                    $qq->where('team_one_id', $team_two)->where('team_two_id', $team_one);
                });
            })
            ->exists();

        if ($existente) {
            return;
        }

        $nextPosition = ((int) BracketGame::where('journey_id', $journey_id)->max('bracket_position')) + 1;

        try {
            BracketGame::create([
                'journey_id'       => $journey_id,
                'bracket_position' => $nextPosition,
                'match_id'         => $partido->id,
                'team_one_id'      => $team_one,
                'team_two_id'      => $team_two,
                'status'           => 1,
            ]);
        } catch (Throwable $e) {
            $this->notify(
                "Nuevo Partido - Error al crear bracket game — partido {$partido->id}",
                "No se pudo crear el bracket game para la jornada {$journey_id}. Partido ID: {$partido->id}. Equipos: {$team_one} vs {$team_two}. Error: {$e->getMessage()}"
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

        $match_id   = $resultado->partido_id;
        $journey_id = $resultado->partido->jornada_id;

        // Prevenir agregar resultados de las primeras tres jornadas
        if (in_array($journey_id, [1, 2, 3])) {
            return;
        }

        $bracketGame = BracketGame::where('match_id', $match_id)->first();

        if (empty($bracketGame)) {
            $this->notify(
                "Nuevo resultado - BracketGame no encontrado — partido {$match_id}",
                "No se encontró un BracketGame con match_id={$match_id} para la jornada {$journey_id}."
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
