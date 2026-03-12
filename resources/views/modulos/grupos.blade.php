<x-app-layout>
    <x-inicio-header :activeTab="'grupos'" />

    {{-- Banner Carousel --}}
    @if($banners->isNotEmpty())
    <div id="banners-carousel" class="relative w-full bg-complementary-primary" data-carousel="slide" data-carousel-interval="4000">
        <div class="relative overflow-hidden w-full max-w-480 mx-auto aspect-1080/480 lg:aspect-1920/500">
            @foreach($banners as $index => $banner)
            <div class="hidden duration-700 ease-in-out" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                <picture class="block w-full h-full">
                    <source media="(min-width: 1024px)" srcset="{{ asset($banner->url_web) }}">
                    <img src="{{ asset($banner->url) }}" class="block w-full h-full object-cover object-center pointer-events-none" alt="{{ $banner->name }}">
                </picture>
            </div>
            @endforeach
        </div>
        <div class="absolute z-30 flex -translate-x-1/2 bottom-3 left-1/2 gap-2">
            @foreach($banners as $index => $banner)
            <button
                type="button"
                class="w-2.5 h-2.5 rounded-full bg-white/50 hover:bg-white"
                aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                aria-label="Slide {{ $index + 1 }}"
                data-carousel-slide-to="{{ $index }}"
            ></button>
            @endforeach
        </div>
    </div>
    @endif

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-4 pb-6">

                <h5 class="text-3xl 2xl:text-4xl text-center font-bold mt-8 mb-4">Grupos conformados</h5>

                <x-user-stats :user="$user" />

                {{-- Search --}}
                <div class="w-full max-w-lg mx-auto mb-4">
                    <x-search-input id="buscar-equipos" name="buscar_equipos" placeholder="Buscar Equipo" />
                </div>

                {{-- Group selector --}}
                <div class="max-w-lg mx-auto mb-6">
                    <x-form-select id="selector-grupo" name="selector_grupo" label="Grupo:">
                        @foreach($grupos as $grupo)
                        <option
                            value="{{ $grupo->id }}"
                            class="bg-complementary-primary"
                            {{ $grupo->is_current === true ? 'selected' : '' }}
                        >
                            {{ $grupo->name }}
                        </option>
                        @endforeach
                    </x-form-select>
                </div>

                {{-- Group title --}}
                <h6 id="titulo-grupo" class="text-2xl font-bold text-center mb-4">
                    Grupo {{ ($grupos->firstWhere('is_current', true))->name }}
                </h6>

                {{-- Loading spinner --}}
                <div id="grupos-spinner" class="hidden">
                    <div class="flex justify-center py-8">
                        <svg class="animate-spin w-8 h-8 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Team cards grid --}}
                <div id="equipos-grupo-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-6xl mx-auto items-start">
                    @foreach($equipos_grupo as $equipo)
                        <x-team-card :equipo="$equipo" />
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    {{-- Floating "Ver Jornadas" button --}}
    <div class="fixed bottom-20 right-4 z-30">
        <button
            id="btn-ver-jornadas"
            type="button"
            class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold text-sm px-4 py-2.5 rounded-full shadow-lg transition-colors"
        >
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
            Ver Jornadas
        </button>
    </div>

    {{-- Jornadas section (collapsible) --}}
    <div id="jornadas-section" class="hidden max-w-screen-2xl mx-auto px-4 pb-24 sm:px-6 lg:px-8">

        <h5 class="text-2xl font-bold text-center my-6">Jornadas</h5>

        <p class="text-xl font-semibold mb-3">Jornada 1</p>
        <div class="shadow-md mx-auto w-full lg:w-3/4 bg-complementary-primary rounded-2xl overflow-hidden p-4 mb-8">
            <ul>
                @if(!empty($jornada_uno))
                    @foreach($jornada_uno['partidos'] as $equipos_partido)
                        @php
                            $fecha_utc  = $equipos_partido->partido->fecha_partido;
                            $timezone   = auth()->user()->country->timezone;
                            $fecha_local = $fecha_utc->copy()->timezone($timezone)->locale('es');
                            $fecha_partido = $fecha_local->isoFormat('dddd, D [de] MMMM [de] YYYY');
                            $hora_partido  = $fecha_local->translatedFormat('h:i a');
                        @endphp
                        <li class="flex justify-around py-6 lg:py-4 border-b border-zinc-400 items-center mb-4">
                            <div class="w-1/2 flex-col lg:flex-row xl:w-1/4 flex items-center justify-between">
                                <img src="{{ $equipos_partido->equipoUno->imagen }}" alt="SELECCION" class="h-10 w-14 object-cover mx-4 border rounded-md shadow-md">
                                <p class="font-semibold">{{ $equipos_partido->equipoUno->nombre }}</p>
                            </div>
                            <div class="w-full xl:w-1/3 absolute lg:relative">
                                <p class="text-center">{{ $fecha_partido }}</p>
                                <p class="text-center">{{ $hora_partido }}</p>
                            </div>
                            <div class="w-1/2 flex-col lg:flex-row xl:w-1/4 flex items-center justify-between">
                                <img src="{{ $equipos_partido->equipoDos->imagen }}" alt="SELECCION" class="h-10 w-14 mx-4 object-cover border rounded-md shadow-md">
                                <p class="font-semibold">{{ $equipos_partido->equipoDos->nombre }}</p>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <p class="text-xl font-semibold mb-3">Jornada 2</p>
        <div class="shadow-md mx-auto w-full lg:w-3/4 bg-complementary-primary rounded-2xl overflow-hidden p-4 mb-8">
            <ul>
                @if(!empty($jornada_dos))
                    @foreach($jornada_dos['partidos'] as $equipos_partido)
                        @php
                            $fecha_utc  = $equipos_partido->partido->fecha_partido;
                            $timezone   = auth()->user()->country->timezone;
                            $fecha_local = $fecha_utc->copy()->timezone($timezone)->locale('es');
                            $fecha_partido = $fecha_local->isoFormat('dddd, D [de] MMMM [de] YYYY');
                            $hora_partido  = $fecha_local->translatedFormat('h:i a');
                        @endphp
                        <li class="flex justify-around py-6 lg:py-4 border-b border-zinc-400 items-center mb-4">
                            <div class="w-1/2 flex-col lg:flex-row xl:w-1/4 flex items-center justify-between">
                                <img src="{{ $equipos_partido->equipoUno->imagen }}" alt="SELECCION" class="h-10 w-14 object-cover mx-4 border rounded-md shadow-md">
                                <p class="font-semibold">{{ $equipos_partido->equipoUno->nombre }}</p>
                            </div>
                            <div class="w-full xl:w-1/3 absolute lg:relative">
                                <p class="text-center">{{ $fecha_partido }}</p>
                                <p class="text-center">{{ $hora_partido }}</p>
                            </div>
                            <div class="w-1/2 flex-col lg:flex-row xl:w-1/4 flex items-center justify-between">
                                <img src="{{ $equipos_partido->equipoDos->imagen }}" alt="SELECCION" class="h-10 w-14 mx-4 object-cover border rounded-md shadow-md">
                                <p class="font-semibold">{{ $equipos_partido->equipoDos->nombre }}</p>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <p class="text-xl font-semibold mb-3">Jornada 3</p>
        <div class="shadow-md mx-auto w-full lg:w-3/4 bg-complementary-primary rounded-2xl overflow-hidden p-4">
            <ul>
                @if(!empty($jornada_tres))
                    @foreach($jornada_tres['partidos'] as $equipos_partido)
                        @php
                            $fecha_utc  = $equipos_partido->partido->fecha_partido;
                            $timezone   = auth()->user()->country->timezone ?? 'GMT-6';
                            $fecha_local = $fecha_utc->copy()->timezone($timezone)->locale('es');
                            $fecha_partido = $fecha_local->isoFormat('dddd, D [de] MMMM [de] YYYY');
                            $hora_partido  = $fecha_local->translatedFormat('h:i a');
                        @endphp
                        <li class="flex justify-around py-6 lg:py-4 border-b border-zinc-400 items-center mb-4">
                            <div class="w-1/2 flex-col lg:flex-row xl:w-1/4 flex items-center justify-between">
                                <img src="{{ $equipos_partido->equipoUno->imagen }}" alt="SELECCION" class="h-10 w-14 object-cover mx-4 border rounded-md shadow-md">
                                <p class="font-semibold">{{ $equipos_partido->equipoUno->nombre }}</p>
                            </div>
                            <div class="w-full xl:w-1/3 absolute lg:relative">
                                <p class="text-center">{{ $fecha_partido }}</p>
                                <p class="text-center">{{ $hora_partido }}</p>
                            </div>
                            <div class="w-1/2 flex-col lg:flex-row xl:w-1/4 flex items-center justify-between">
                                <img src="{{ $equipos_partido->equipoDos->imagen }}" alt="SELECCION" class="h-10 w-14 mx-4 object-cover border rounded-md shadow-md">
                                <p class="font-semibold">{{ $equipos_partido->equipoDos->nombre }}</p>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

    </div>

</x-app-layout>
