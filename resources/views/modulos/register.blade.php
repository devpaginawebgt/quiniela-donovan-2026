<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Quiniela') }} - Registro</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        @vite(['resources/css/app.css', 'resources/css/styles.css', 'resources/js/app.js', 'resources/js/views/register.js'])
    </head>
    <body class="font-sans text-light antialiased bg-complementary-primary">
        <div class="min-h-screen w-full flex flex-col justify-center items-center p-6">
            <div class="w-full max-w-2xl">
                    {{-- Logo --}}
                    <div class="mb-6">
                        <img
                            src="/images/logos/logo-liga.png"
                            class="w-full max-w-48 aspect-square object-contain mx-auto"
                            alt="{{ config('app.name', 'Quiniela') }}"
                        >
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl text-center font-bold text-light mb-3">Crear cuenta</h1>

                    {{-- Subtitle --}}
                    <p class="text-center text-complementary-light text-sm lg:text-base mb-6 max-w-sm lg:max-w-lg mx-auto">
                        Uso exclusivo para profesionales de la salud y dependientes de farmacia. Se reserva el derecho de uso de la aplicación.
                    </p>

                    {{-- Toast Errors --}}
                    <x-toast-errors :errors="$errors" :message-error="$message_error ?? null" />

                    {{-- Tabs pills --}}
                    <div class="mb-6 max-w-xl mx-auto">
                        <ul
                            class="flex text-base font-semibold text-center bg-red-900/60 rounded-full"
                            id="register-tab"
                            data-tabs-toggle="#register-tab-content"
                            data-tabs-type="pills"
                            data-tabs-active-classes="bg-red-600/60 text-light"
                            data-tabs-inactive-classes="text-complementary-light"
                            role="tablist"
                        >
                            <li class="flex-1" role="presentation">
                                <button
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-full"
                                    id="doctor-tab"
                                    data-tabs-target="#doctor-panel"
                                    type="button"
                                    role="tab"
                                    aria-controls="doctor-panel"
                                    aria-selected="true"
                                >
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    Doctor
                                </button>
                            </li>
                            <li class="flex-1" role="presentation">
                                <button
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-full"
                                    id="dependiente-tab"
                                    data-tabs-target="#dependiente-panel"
                                    type="button"
                                    role="tab"
                                    aria-controls="dependiente-panel"
                                    aria-selected="false"
                                >
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    Dependiente
                                </button>
                            </li>
                        </ul>
                    </div>            

                    {{-- Tab Content --}}
                    <div id="register-tab-content">
                        <div class="hidden" id="dependiente-panel" role="tabpanel" aria-labelledby="dependiente-tab">
                            <x-register-dependent-form
                                :companies="$companies"
                                :visitors="$visitors"
                                :country="$country"
                            />
                        </div>
                        <div class="hidden" id="doctor-panel" role="tabpanel" aria-labelledby="doctor-tab">
                            <x-register-doctor-form
                                :visitors="$visitors"
                                :country="$country"
                            />
                        </div>
                    </div>

                    {{-- Login link --}}
                    <div class="text-center mt-6">
                        <p class="text-complementary-light text-sm mb-2">¿Ya tienes cuenta?</p>
                        <a href="{{ route('ingresa') }}" class="text-light font-bold text-base hover:text-secondary">
                            Iniciar Sesión
                        </a>
                    </div>
            </div>
        </div>

        {{-- Terms & Conditions Modal --}}
        <x-terms-modal :terms="$terms" />
    </body>
</html>
