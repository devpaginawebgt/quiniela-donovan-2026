<?php

namespace App\Http\Services;

use App\Mail\SystemNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ErrorService {

    public static function notify(
        ?string $subject = 'No subject attached',
        ?string $body = 'No message attached'
    )
    {
        Log::warning($subject . ' :: ' . $body);

        $to = config('quiniela.system_notifications_email');

        if (empty($to)) return;

        Mail::to($to)->send(new SystemNotification($subject, $body));
    }

}