<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">

        <title>{{ config('app.name', 'Quiniela') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/css/styles.css',
            'resources/js/app.js',
            'resources/js/functions-views.js',
            'resources/js/functions.js'
        ])
    </head>
    <body class="font-sans antialiased text-light overflow-x-hidden">
        {{-- Fondo responsive --}}
        <div class="fixed inset-0 -z-10 bg-cover bg-center bg-complementary-primary lg:hidden"
             style="background-image: url({{ asset('images/decoracion/main-bg.png') }});"></div>
        <div class="fixed inset-0 -z-10 bg-cover bg-center bg-complementary-primary hidden lg:block"
             style="background-image: url({{ asset('images/decoracion/bg-main-web.png') }});"></div>
        <div class="fixed inset-0 -z-10 bg-black/60"></div>

        <div class="min-h-screen pb-16">
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @include('components.navigation')
    </body>
</html>
