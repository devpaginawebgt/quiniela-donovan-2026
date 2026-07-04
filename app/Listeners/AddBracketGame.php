<?php

namespace App\Listeners;

use App\Events\MatchCreated;
use App\Http\Services\BracketGameService;
use Illuminate\Support\Facades\Log;
use Throwable;

class AddBracketGame
{
    public function __construct(
        private readonly BracketGameService $bracketGameService
    ) {}

    /**
     * Handle the event.
     *
     * Nota: cualquier excepción se atrapa y loguea para no interrumpir los
     * siguientes listeners de MatchCreated (AddMatchBrand,
     * VerifyJourneyStatusOnMatch, ScheduleMatchPushNotification).
     */
    public function handle(MatchCreated $event): void
    {
        try {
            $this->bracketGameService->addBracketGame($event->partido);
        } catch (Throwable $e) {
            Log::error('[AddBracketGame] Falla procesando MatchCreated', [
                'partido_id' => $event->partido?->id,
                'exception'  => $e->getMessage(),
            ]);
        }
    }
}
