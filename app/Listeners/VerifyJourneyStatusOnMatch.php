<?php

namespace App\Listeners;

use App\Events\MatchCreated;
use App\Http\Services\PartidoService;

class VerifyJourneyStatusOnMatch
{
    public function __construct(
        private readonly PartidoService $partidoService
    ) {}

    /**
     * Re-evalúa la transición de jornada actual cada vez que se crea un partido.
     * Cubre el caso de bracket: cuando termina la última fecha de una ronda, los
     * partidos de la siguiente aún no existen (la API entrega placeholders); al
     * llegar y crearse esos partidos, este listener dispara la verificación que
     * el `ResultCreated` no pudo completar en su momento.
     */
    public function handle(MatchCreated $event): void
    {
        $this->partidoService->verifyJourneyStatus();
    }
}
