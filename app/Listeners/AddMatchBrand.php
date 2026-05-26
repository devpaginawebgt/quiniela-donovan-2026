<?php

namespace App\Listeners;

use App\Events\MatchCreated;
use App\Http\Services\BrandService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddMatchBrand
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly BrandService $brandService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(MatchCreated $event): void
    {
        $match = $event->partido;

        $this->brandService->addMatchBrand($match);
    }
}
