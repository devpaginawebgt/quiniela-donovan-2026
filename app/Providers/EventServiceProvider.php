<?php

namespace App\Providers;

use App\Events\MatchCreated;
use App\Events\ResultCreated;
use App\Listeners\AddBracketGame;
use App\Listeners\AddBracketGameResult;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            // SendEmailVerificationNotification::class,
            SendWelcomeEmail::class,
        ],
        MatchCreated::class => [
            AddBracketGame::class,
        ],
        ResultCreated::class => [
            AddBracketGameResult::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
