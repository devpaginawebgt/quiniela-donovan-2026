<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Quiniela') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/styles.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="font-sans text-light antialiased">
            {{ $slot }}
        </div>
        <script>
            try {
                let messageContent = document.querySelector('#message-view');
                    setTimeout(function() {
                        messageContent.classList.add('hidden');
                    }, 5000);
            } catch (error) {
                console.log(error);
            }


            
            setTimeout(() => {
                btnAceptar.classList.remove('hidden');
            }, 500);

            const hideElement = (element) => {
                element.remove();
            }
        </script>
    </body>
</html>
