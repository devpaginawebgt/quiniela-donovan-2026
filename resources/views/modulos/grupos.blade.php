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
        <div class="overflow-hidden sm:rounded-lg">
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
                <div id="equipos-grupo-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-6xl mx-auto items-start min-h-60">
                    @foreach($equipos_grupo as $equipo)
                        <x-team-group-card :equipo="$equipo" />
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

        <h5 id="titulo-jornadas-grupo" class="text-2xl font-bold text-center mt-6 mb-4">
            Jornadas de Partidos del Grupo {{ ($grupos->firstWhere('is_current', true))->name }}
        </h5>

        {{-- Buscador de partidos --}}
        <div class="w-full max-w-lg mx-auto mb-6">
            <x-search-input id="buscar-partidos-grupo" name="buscar_partidos_grupo" placeholder="Buscar Partidos" />
        </div>

        {{-- Spinner jornadas --}}
        <div id="jornadas-spinner" class="hidden">
            <div class="flex justify-center py-8">
                <svg class="animate-spin w-8 h-8 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </div>
        </div>

        {{-- Contenedor de jornadas con partidos --}}
        <div id="jornadas-partidos-list"></div>

    </div>

</x-app-layout>
