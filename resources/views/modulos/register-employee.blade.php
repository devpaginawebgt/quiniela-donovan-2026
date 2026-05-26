<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Quiniela') }} - Registro de empleados</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        @vite(['resources/css/app.css', 'resources/css/styles.css', 'resources/js/app.js', 'resources/js/views/register.js'])
    </head>
    <body class="font-sans text-light antialiased bg-complementary-primary">
        <div class="min-h-screen w-full flex flex-col justify-center items-center p-6">
            <div class="w-full max-w-xl">
                    {{-- Logo --}}
                    <div class="mb-6">
                        <img
                            src="/images/logos/logo-liga.png"
                            class="w-full max-w-48 aspect-square object-contain mx-auto"
                            alt="{{ config('app.name', 'Quiniela') }}"
                        >
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl text-center font-bold text-light mb-3">Registro Donovan</h1>

                    {{-- Subtitle --}}
                    <p class="text-center text-complementary-light text-sm lg:text-base mb-6 max-w-lg mx-auto">
                        Acceso exclusivo para colaboradores del Laboratorio Donovan. Selecciona tu nombre en la lista para activar tu cuenta.
                    </p>

                    {{-- Toast Errors --}}
                    <x-toast-errors :errors="$errors" :message-error="$message_error ?? null" />

                    <form
                        method="POST"
                        action="{{ route('register.employee') }}"
                        class="formulario-auth flex flex-col gap-6 w-full max-w-xl mx-auto"
                    >
                        @csrf

                        <input type="hidden" name="accepted_terms_version" value="">

                        <x-auth-select label="Colaborador a activar" id="employee_id" name="employee_id" :required="true">
                            <x-slot name="prefix">
                                <span class="icon-[material-symbols--person] w-5 h-5"></span>
                            </x-slot>
                            <option value="">Selecciona tu nombre</option>
                            @foreach ($employees as $employee)
                                <option 
                                    value="{{ $employee->id }}" 
                                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}
                                    data-position="{{ $employee->puesto }}"
                                >
                                    {{ $employee->nombres }} {{ $employee->apellidos }}
                                </option>
                            @endforeach
                        </x-auth-select>

                        <x-auth-input
                            label="Puesto"
                            id="employee_position"
                            name="employee_position"
                            placeholder="Puesto del colaborador"
                            :disabled="true"
                        >
                            <x-slot name="prefix">
                                <span class="icon-[material-symbols--work] w-5 h-5"></span>
                            </x-slot>
                        </x-auth-input>

                        <x-auth-input
                            label="{{ ($country->document_name ?? 'Número de documento') . ' del colaborador' }}"
                            id="lab_numero_documento"
                            name="numero_documento"
                            placeholder="Ingrese su {{ $country->document_name ?? 'Número de documento' }}"
                            maxlength="20"
                            pattern="{{ $country->document_regex }}"
                            title="{{ $country->document_regex_message }}"
                            :required="true"
                        >
                            <x-slot name="prefix">
                                <span class="icon-[material-symbols--id-card] w-5 h-5"></span>
                            </x-slot>
                        </x-auth-input>

                        {{-- Submit --}}
                        <div class="mt-2">
                            <button
                                type="button"
                                class="btn-crear-cuenta w-full bg-red-600/80 text-light font-bold rounded-full text-lg px-6 py-3.5 hover:brightness-[1.1] focus:ring-3 focus:ring-white flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                </svg>
                                Activar Colaborador
                            </button>
                        </div>
                    </form>


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
