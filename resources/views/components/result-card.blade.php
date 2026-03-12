@props(['registro'])

@php
    $partido    = $registro->partido;
    $equipoUno  = $registro->equipoUno;
    $equipoDos  = $registro->equipoDos;
    $resultado  = $registro->resultado;
    $prediccion = $registro->prediccion;
    $puntos     = $registro->puntos ?? 0;
    $mensaje    = $registro->mensaje ?? 'No has realizado una predicción.';

    $tienePrediccion = !empty($prediccion);
    $tieneResultado  = !empty($resultado);
@endphp

<li class="bg-complementary-primary border border-secondary rounded-3xl flex flex-col overflow-hidden"
    data-equipos="{{ strtolower($equipoUno->nombre . ' ' . $equipoDos->nombre) }}">

    {{-- Header: Brand --}}
    @if(!empty($partido->brand))
        <div class="flex">
            <div class="bg-red-700/80 flex items-center py-2 px-3">
                <span class="text-light text-sm font-medium whitespace-nowrap">Patrocinado por</span>
            </div>
            <div class="flex-1 flex items-center justify-center p-2 bg-green-700">
                <img
                    src="{{ asset($partido->brand->image) }}"
                    alt="{{ $partido->brand->name }}"
                    class="w-full max-w-28 object-contain"
                >
            </div>
        </div>
    @endif

    <div class="flex flex-col flex-1 pt-6 px-6 gap-6">

        {{-- Equipos VS --}}
        <div class="flex items-center justify-between w-full gap-2">

            <div class="flex flex-col items-center gap-2 flex-1">
                <img
                    src="{{ asset($equipoUno->imagen) }}"
                    alt="{{ $equipoUno->nombre }}"
                    class="w-full max-w-20 lg:max-w-24 aspect-6/4 object-cover rounded-xl shadow-md"
                >
                <p class="font-semibold text-sm text-center leading-tight">{{ $equipoUno->nombre }}</p>
            </div>

            <span class="font-bold text-2xl shrink-0">VS</span>

            <div class="flex flex-col items-center gap-2 flex-1">
                <img
                    src="{{ asset($equipoDos->imagen) }}"
                    alt="{{ $equipoDos->nombre }}"
                    class="w-full max-w-20 lg:max-w-24 aspect-6/4 object-cover rounded-xl shadow-md"
                >
                <p class="font-semibold text-sm text-center leading-tight">{{ $equipoDos->nombre }}</p>
            </div>

        </div>

        {{-- Badge puntos --}}
        <div class="flex justify-center">
            <span class="w-full text-center font-bold text-base py-2 px-6 rounded-full bg-secondary text-dark">
                {{ $mensaje }}
            </span>
        </div>

        {{-- Mostrar Detalles --}}
        <div>
            <button
                type="button"
                onclick="toggleDetalles(this)"
                aria-expanded="false"
                class="flex items-center justify-between w-full text-light font-semibold text-sm pt-4 pb-6 cursor-pointer"
            >
                <span>Mostrar Detalles</span>
                <svg class="w-4 h-4 shrink-0 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <div class="result-card-details overflow-hidden max-h-0 transition-[max-height] duration-500 ease-in-out mt-0">
                <hr class="border-complementary-light/30 mb-4">

                <div class="flex flex-col gap-4 text-center pb-6">

                    {{-- Resultado Final --}}
                    <div class="flex flex-col gap-2">
                        <p class="text-light font-bold text-base">Resultado Final</p>
                        @if($tieneResultado)
                            <div class="flex items-center justify-center gap-8">
                                <span class="text-light font-bold text-3xl">{{ $resultado->goles_equipo_1 }}</span>
                                <span class="text-complementary-light font-bold text-2xl">-</span>
                                <span class="text-light font-bold text-3xl">{{ $resultado->goles_equipo_2 }}</span>
                            </div>
                        @else
                            <p class="text-complementary-light text-sm">Sin resultado</p>
                        @endif
                    </div>

                    <hr class="border-complementary-light/30">

                    {{-- Tu Pronóstico --}}
                    <div class="flex flex-col gap-2">
                        <p class="text-light font-bold text-base">Tu Pronóstico</p>
                        @if($tienePrediccion)
                            <div class="flex items-center justify-center gap-8">
                                <span class="text-light font-bold text-3xl">{{ $prediccion->goles_equipo_1 }}</span>
                                <span class="text-complementary-light font-bold text-2xl">-</span>
                                <span class="text-light font-bold text-3xl">{{ $prediccion->goles_equipo_2 }}</span>
                            </div>
                        @else
                            <p class="text-complementary-light text-sm">Sin pronóstico</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>

</li>
