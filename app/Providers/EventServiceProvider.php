<?php

namespace App\Providers;

use App\Events\JourneyCompleted;
use App\Events\MatchCreated;
use App\Events\ResultCreated;
use App\Listeners\AddBracketGame;
use App\Listeners\AddBracketGameResult;
use App\Listeners\DeactivateInvalidFcmToken;
use App\Listeners\ScheduleMatchPushNotification;
use App\Listeners\SendWelcomeEmail;
use App\Listeners\UpdateCurrentJourney;
use App\Listeners\UpdateGroupPoints;
use App\Listeners\UpdatePredictionPoints;
use App\Listeners\VerifyJourneyStatus;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Notifications\Events\NotificationFailed;
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
            ScheduleMatchPushNotification::class,
        ],
        ResultCreated::class => [
            AddBracketGameResult::class,
            UpdatePredictionPoints::class,
            UpdateGroupPoints::class,
            VerifyJourneyStatus::class,
        ],
        JourneyCompleted::class => [
            UpdateCurrentJourney::class,
        ],
        NotificationFailed::class => [
            DeactivateInvalidFcmToken::class,
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
