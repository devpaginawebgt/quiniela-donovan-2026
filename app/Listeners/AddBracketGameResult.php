<?php

namespace App\Listeners;

use App\Events\ResultCreated;
use App\Http\Services\BracketGameService;
use Illuminate\Support\Facades\Log;
use Throwable;

class AddBracketGameResult
{
    public function __construct(
        private readonly BracketGameService $bracketGameService
    ) {}

    /**
     * Handle the event.
     *
     * Nota: cualquier excepción se atrapa y loguea para no interrumpir los
     * siguientes listeners de ResultCreated (UpdatePredictionPoints,
     * UpdateGroupPoints, VerifyJourneyStatus, NotifyResultCreated).
     */
    public function handle(ResultCreated $event): void
    {
        try {
            $this->bracketGameService->addBracketGameResult($event->result);
        } catch (Throwable $e) {
            Log::error('[AddBracketGameResult] Falla procesando ResultCreated', [
                'resultado_id' => $event->result?->id,
                'partido_id'   => $event->result?->partido_id,
                'exception'    => $e->getMessage(),
            ]);
        }
    }
}
