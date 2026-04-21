<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Quiniela Application Settings
    |--------------------------------------------------------------------------
    |
    | Configuraciones específicas de la aplicación Quiniela Donovan.
    | Los valores se leen desde el archivo .env.
    |
    */

    'system_notifications_email' => env('SYSTEM_NOTIFICATIONS_EMAIL'),

    /*
    |--------------------------------------------------------------------------
    | Push Notifications
    |--------------------------------------------------------------------------
    |
    | Mapa de slug (tabla push_notification_types) a la clase Notification que
    | se debe usar al despachar la push. Si un slug no está mapeado se usa
    | TestPushNotification como fallback seguro.
    |
    */

    'push_notification_classes' => [
        'system' => \App\Notifications\TestPushNotification::class,
        'match'  => \App\Notifications\MatchNotification::class,
    ],

];
