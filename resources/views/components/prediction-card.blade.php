@props(['registro'])

@php
    $partido    = $registro->partido;
    $equipoUno  = $registro->equipoUno;
    $equipoDos  = $registro->equipoDos;
    $prediccion = $registro->prediccion;

    $pronosticado = !empty($prediccion);
    $prediccion_equipo_uno = empty($prediccion) ? '' : $prediccion->goles_equipo_1;
    $prediccion_equipo_dos = empty($prediccion) ? '' : $prediccion->goles_equipo_2;

    $fecha_utc   = $partido->fecha_partido;
    $timezone    = auth()->user()->country->timezone;
    $fecha_local = $fecha_utc->copy()->timezone($timezone)->locale('es');
    $fecha_fmt   = $fecha_local->isoFormat('dddd, D [de] MMMM [de] YYYY');
    $hora_fmt    = $fecha_local->translatedFormat('h:i a');
@endphp

<li class="bg-complementary-primary border border-secondary rounded-3xl flex flex-col overflow-hidden">

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

    <div class="flex flex-col flex-1 p-6 gap-6">

        {{-- Sección 2: Estado + badge pronosticado --}}
        <div class="flex items-start justify-between gap-2">
            <div class="flex flex-col gap-1">
                <p class="text-complementary-light text-sm flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m1 15h-2v-6h2zm0-8h-2V7h2z"/></svg>
                    Estado
                </p>
                <p class="text-light font-bold text-lg leading-tight">
                    @if ($partido->estado === 0)
                        Por jugar
                    @elseif ($partido->estado === 2)
                        ¡En juego!
                    @else
                        Finalizado
                    @endif
                </p>
            </div>

            @if($pronosticado)
                <span class="flex items-center gap-1 bg-green-600 text-white text-xs font-semibold px-3 py-1.5 rounded-full shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="m9.55 18l-5.7-5.7l1.425-1.425L9.55 15.15l9.175-9.175L20.15 7.4z"/></svg>
                    Pronosticado
                </span>
            @else
                <span class="flex items-center gap-1 bg-red-600/80 text-white text-xs font-semibold px-3 py-1.5 rounded-full shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z"/></svg>
                    Pendiente
                </span>
            @endif
        </div>

        {{-- Separador --}}
        <hr class="border-complementary-light/30">

        {{-- Sección 2b: Fecha + equipos VS --}}
        <div class="flex flex-col items-center gap-4">

            <div class="flex flex-col items-center gap-1 text-complementary-light text-sm">
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M12 14q-.425 0-.712-.288T11 13t.288-.712T12 12t.713.288T13 13t-.288.713T12 14m-4.712-.288Q7 13.426 7 13t.288-.712T8 12t.713.288T9 13t-.288.713T8 14t-.712-.288M16 14q-.425 0-.712-.288T15 13t.288-.712T16 12t.713.288T17 13t-.288.713T16 14m-4 4q-.425 0-.712-.288T11 17t.288-.712T12 16t.713.288T13 17t-.288.713T12 18m-4.712-.288Q7 17.426 7 17t.288-.712T8 16t.713.288T9 17t-.288.713T8 18t-.712-.288M16 18q-.425 0-.712-.288T15 17t.288-.712T16 16t.713.288T17 17t-.288.713T16 18M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v14q0 .825-.587 1.413T19 22zm0-2h14V10H5z"/></svg>
                    {{ $fecha_fmt }}
                </span>
                <span class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10S22 17.52 22 12S17.52 2 12 2m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8m.5-13H11v6l5.25 3.15l.75-1.23l-4.5-2.67z"/></svg>
                    {{ $hora_fmt }}
                </span>
            </div>

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
        </div>

        {{-- Separador --}}
        <hr class="border-complementary-light/30">

        {{-- Footer: Inputs o predicción quemada --}}
        <div class="flex flex-col gap-3">

            <p class="text-center text-sm text-complementary-light">Tu pronóstico</p>

            <div class="flex items-center justify-center gap-4 lg:gap-8">

                @if ($partido->estado === 0)
                    {{-- Equipo 1 input --}}
                    <input type="number" name="partidos[]"
                        value="{{ $registro->partido_id }}" hidden
                        class="hidden partido-jornada-quiniela">

                    <div class="flex items-center gap-2 lg:gap-4">

                        <button type="button" onclick="decreaseBookmar(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 lg:w-6 lg:h-6" viewBox="0 0 32 32"><path fill="currentColor" d="M28 16c0-6.627-5.373-12-12-12S4 9.373 4 16s5.373 12 12 12s12-5.373 12-12m2 0c0 7.732-6.268 14-14 14S2 23.732 2 16S8.268 2 16 2s14 6.268 14 14m-20-1a1 1 0 1 0 0 2h12a1 1 0 1 0 0-2z"/></svg>
                        </button>

                        <input
                            type="number"
                            name="prediccion_equipo1_{{ $registro->partido_id }}"
                            min="0" max="25"
                            value="{{ $prediccion_equipo_uno }}"
                            class="marcador-equipo-1 marcador-equipo border border-light text-light bg-complementary-primary/50 text-center rounded-lg hide-input-arrows w-10 h-9 lg:w-12 lg:h-12 text-base lg:text-xl font-bold"
                        >

                        <button type="button" onclick="increaseBookmar(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 lg:w-6 lg:h-6" viewBox="0 0 32 32"><path fill="currentColor" d="M15 10a1 1 0 1 1 2 0v5h5a1 1 0 1 1 0 2h-5v5a1 1 0 1 1-2 0v-5h-5a1 1 0 1 1 0-2h5zm15 6c0 7.732-6.268 14-14 14S2 23.732 2 16S8.268 2 16 2s14 6.268 14 14m-2 0c0-6.627-5.373-12-12-12S4 9.373 4 16s5.373 12 12 12s12-5.373 12-12"/></svg>
                        </button>

                    </div>

                    <span class="text-xl lg:text-2xl font-bold">:</span>

                    {{-- Equipo 2 input --}}
                    <div class="flex items-center gap-2 lg:gap-4">

                        <button type="button" onclick="decreaseBookmar(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 lg:w-6 lg:h-6" viewBox="0 0 32 32"><path fill="currentColor" d="M28 16c0-6.627-5.373-12-12-12S4 9.373 4 16s5.373 12 12 12s12-5.373 12-12m2 0c0 7.732-6.268 14-14 14S2 23.732 2 16S8.268 2 16 2s14 6.268 14 14m-20-1a1 1 0 1 0 0 2h12a1 1 0 1 0 0-2z"/></svg>
                        </button>

                        <input
                            type="number"
                            name="prediccion_equipo2_{{ $registro->partido_id }}"
                            min="0" max="25"
                            value="{{ $prediccion_equipo_dos }}"
                            class="marcador-equipo-2 marcador-equipo border border-light text-light bg-complementary-primary/50 text-center rounded-lg hide-input-arrows w-10 h-9 lg:w-12 lg:h-12 text-base lg:text-xl font-bold"
                        >

                        <button type="button" onclick="increaseBookmar(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 lg:w-6 lg:h-6" viewBox="0 0 32 32"><path fill="currentColor" d="M15 10a1 1 0 1 1 2 0v5h5a1 1 0 1 1 0 2h-5v5a1 1 0 1 1-2 0v-5h-5a1 1 0 1 1 0-2h5zm15 6c0 7.732-6.268 14-14 14S2 23.732 2 16S8.268 2 16 2s14 6.268 14 14m-2 0c0-6.627-5.373-12-12-12S4 9.373 4 16s5.373 12 12 12s12-5.373 12-12"/></svg>
                        </button>

                    </div>

                @elseif ($partido->estado === 2)
                    @if($pronosticado)
                        <span class="text-3xl font-bold text-light">{{ $prediccion_equipo_uno }}</span>
                        <span class="text-2xl font-bold"> : </span>
                        <span class="text-3xl font-bold text-light">{{ $prediccion_equipo_dos }}</span>
                    @else
                        <span class="text-sm text-zinc-400">No has ingresado una predicción</span>
                    @endif
                @endif

            </div>
        </div>

    </div>

</li>
