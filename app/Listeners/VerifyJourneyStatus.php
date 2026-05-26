<?php

namespace App\Listeners;

use App\Events\ResultCreated;
use App\Http\Services\PartidoService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class VerifyJourneyStatus
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly PartidoService $partidoService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(ResultCreated $event): void
    {
        $this->partidoService->verifyJourneyStatus();
    }
}
