@props(['partido'])

@php
    $equipoUno = $partido['equipoUno'];
    $equipoDos = $partido['equipoDos'];
    $marca     = $partido['marca'] ?? null;
    $estado    = $partido['estado'];

    $fecha = new \DateTime($partido['fechaPartido']);
    $intl  = new \IntlDateFormatter('es_GT', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
    $fechaFormateada = $intl->format($fecha);
    $horaFormateada  = $fecha->format('g:i a');
@endphp

<li
    class="match-card bg-complementary-primary border border-secondary rounded-3xl flex flex-col overflow-hidden w-full min-w-72 max-w-xl"
    data-equipos="{{ strtolower($equipoUno['nombre'] . ' ' . $equipoDos['nombre']) }}"
>

    {{-- Brand --}}
    @if($marca)
        <div class="flex">
            <div class="bg-red-700/80 flex items-center py-2 px-3 shrink-0">
                <span class="text-light text-sm font-medium whitespace-nowrap">Patrocinado por</span>
            </div>
            <div class="flex-1 flex items-center justify-center p-2 bg-green-700">
                <img
                    src="{{ asset($marca['image']) }}"
                    alt="{{ $marca['name'] }}"
                    class="w-full max-w-28 object-contain"
                >
            </div>
        </div>
    @endif

    <div class="flex flex-col flex-1 pt-6 px-6 pb-6 gap-4">

        {{-- Equipos VS --}}
        <div class="flex items-center justify-between w-full gap-2">

            <div class="flex flex-col items-center gap-2 flex-1">
                <img
                    src="{{ asset($equipoUno['imagen']) }}"
                    alt="{{ $equipoUno['nombre'] }}"
                    class="w-full max-w-20 lg:max-w-24 aspect-6/4 object-cover rounded-xl shadow-md"
                >
                <p class="font-semibold text-sm text-center leading-tight">{{ $equipoUno['nombre'] }}</p>
            </div>

            <span class="font-bold text-2xl shrink-0">VS</span>

            <div class="flex flex-col items-center gap-2 flex-1">
                <img
                    src="{{ asset($equipoDos['imagen']) }}"
                    alt="{{ $equipoDos['nombre'] }}"
                    class="w-full max-w-20 lg:max-w-24 aspect-6/4 object-cover rounded-xl shadow-md"
                >
                <p class="font-semibold text-sm text-center leading-tight">{{ $equipoDos['nombre'] }}</p>
            </div>

        </div>

        {{-- Fecha y hora --}}
        <div class="flex flex-col items-center gap-1 text-complementary-light text-sm">
            <p class="flex items-center gap-1.5">
                <svg class="w-4 h-4 shrink-0 inline -mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                {{ $fechaFormateada }}
            </p>
            <p class="flex items-center gap-1.5">
                <svg class="w-4 h-4 shrink-0 inline -mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                {{ $horaFormateada }}
            </p>
        </div>

        <hr class="border-complementary-light/30">

        {{-- Estado --}}
        <div class="flex flex-col items-center gap-1">
            <p class="flex items-center gap-1 text-complementary-light text-xs uppercase tracking-wide">
                <svg class="w-3.5 h-3.5 shrink-0 inline -mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                Estado
            </p>
            <p class="font-bold text-base">{{ $estado }}</p>
        </div>

    </div>

</li>
