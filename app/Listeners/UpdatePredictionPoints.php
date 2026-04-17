<?php

namespace App\Listeners;

use App\Events\ResultCreated;
use App\Http\Services\PrediccionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdatePredictionPoints
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly PrediccionService $prediccionService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(ResultCreated $event): void
    {
        $this->prediccionService->actualizarPuntosGlobalChunked();
    }
}
