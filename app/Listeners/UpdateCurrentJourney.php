<?php

namespace App\Listeners;

use App\Events\JourneyCompleted;
use App\Http\Services\PartidoService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateCurrentJourney
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
    public function handle(JourneyCompleted $event): void
    {
        $this->partidoService->updateCurrentJourney($event->journey);
    }
}
