<?php

namespace App\Listeners;

use App\Events\MatchCreated;
use App\Http\Services\BracketGameService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddBracketGame
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly BracketGameService $bracketGameService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(MatchCreated $event): void
    {
        $match = $event->partido;

        $this->bracketGameService->addBracketGame($match);
    }
}
