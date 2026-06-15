<?php

namespace App\Listeners;

use App\Events\ResultCreated;
use App\Http\Services\MatchService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyResultCreated
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly MatchService $matchService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(ResultCreated $event): void
    {
        $result = $event->result;

        $this->matchService->dispatchResultNotification($result);
    }
}
