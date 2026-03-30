<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Quiniela') }} - Iniciar Sesión</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        @vite(['resources/css/app.css', 'resources/css/styles.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-light antialiased bg-complementary-primary">
        {{-- Full screen background --}}
        <div class="relative min-h-screen w-full">
            {{-- Background: main-bg hasta lg, bg-main-web desde lg --}}
            <div class="absolute inset-0 bg-cover bg-center lg:hidden"
                 style="background-image: url({{ asset('images/decoracion/main-bg.png') }});"></div>
            <div class="absolute inset-0 bg-cover bg-center hidden lg:block"
                 style="background-image: url({{ asset('images/decoracion/bg-main-web.png') }});"></div>
            {{-- Overlay oscuro --}}
            <div class="absolute inset-0 bg-black/50"></div>

            {{-- Mobile: bottom drawer / lg+: centered modal --}}
            <div
                class="
                    relative z-10 min-h-screen flex flex-col justify-end items-center
                    lg:justify-center lg:items-center lg:p-6
                "
            >
                {{-- Drawer / Modal panel --}}
                <div
                    class="
                        w-full rounded-t-3xl bg-complementary-primary/90 p-8
                        lg:max-w-lg lg:rounded-3xl lg:shadow-2xl lg:w-full
                    "
                >
                    {{-- Logo --}}
                    <div class="mb-8">
                        <img
                            src="/images/logos/logo-white.png"
                            class="w-full max-w-92 mx-auto"
                            alt="{{ config('app.name', 'Quiniela') }}"
                        >
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl text-center font-bold text-light mb-8">Iniciar Sesión</h1>

                    {{-- Session Status --}}
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    {{-- Toast Errors --}}
                    <x-toast-errors :errors="$errors" />

                    {{-- Login Form --}}
                    <form
                        method="POST"
                        action="{{ route('login') }}"
                        class="formulario-auth w-full max-w-108 lg:max-w-108 mx-auto"
                    >
                        @csrf

                        <div class="mb-6">
                            <div class="relative">
                                <div class="absolute inset-y-0 inset-s-0 flex items-center ps-3.5 pointer-events-none">
                                    <span class="icon-[material-symbols--mail-rounded] w-5 h-5 text-base"></span>
                                </div>
                                <input
                                    id="documento"
                                    type="text"
                                    name="numero_documento"
                                    value="{{ old('numero_documento') }}"
                                    required
                                    autofocus
                                    maxlength="13"
                                    placeholder="Ingrese su número de documento"
                                    class="w-full ps-11 py-3 bg-transparent border-0 border-b-2 border-secondary text-light placeholder-complementary-light focus:ring-0 focus:border-secondary text-base"
                                >
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-secondary text-dark font-bold rounded-full text-lg px-6 py-3.5 hover:brightness-110 focus:ring-4 focus:ring-secondary/50 flex items-center justify-center gap-2"
                        >
                            <span class="icon-[fa-solid--right-to-bracket] w-5 h-5"></span>
                            Iniciar Sesión
                        </button>
                    </form>

                    {{-- Register link --}}
                    <div class="text-center mt-8">
                        <p class="text-complementary-light text-sm mb-2">¿No tienes cuenta?</p>
                        <a href="{{ route('register') }}" class="text-light font-bold text-base hover:text-secondary">
                            Regístrate
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>
