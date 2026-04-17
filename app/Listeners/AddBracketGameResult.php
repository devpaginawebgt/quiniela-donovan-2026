<?php

namespace App\Listeners;

use App\Events\ResultCreated;
use App\Http\Services\BracketGameService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddBracketGameResult
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
    public function handle(ResultCreated $event): void
    {
        $result = $event->result;

        $this->bracketGameService->addBracketGameResult($result);
    }
}
