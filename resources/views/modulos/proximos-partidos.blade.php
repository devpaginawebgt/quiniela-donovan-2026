<x-app-layout>
    <div id="toast-container"
         class="fixed top-4 left-1/2 -translate-x-1/2 z-50 flex-col items-center gap-3 w-full max-w-sm px-4"
         style="display: none;"
         aria-live="polite">
    </div>

    <x-inicio-header :activeTab="'proximos'" />

    {{-- Banner Carousel --}}
    @if($banners->isNotEmpty())
    <div id="banners-carousel" class="relative w-full bg-complementary-primary" data-carousel="slide" data-carousel-interval="4000">
        {{-- Slides --}}
        <div class="relative overflow-hidden w-full max-w-480 mx-auto aspect-1080/660 lg:aspect-1920/700">
            @foreach($banners as $index => $banner)
            <div class="hidden duration-700 ease-in-out" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                <picture class="block w-full h-full">
                    <source media="(min-width: 1024px)" srcset="{{ asset($banner->url_web) }}">
                    <img src="{{ asset($banner->url) }}" class="block w-full h-full object-cover pointer-events-none" alt="{{ $banner->name }}">
                </picture>
            </div>
            @endforeach
        </div>
        {{-- Indicators --}}
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

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8" id="selecciones-container">
        <div class="overflow-hidden">
            <div class="px-6 pb-6">

                <h5 class="text-3xl 2xl:text-4xl text-center font-bold mt-8 mb-4">Próximos Partidos</h5>
                
                <x-user-stats :user="$user" />

                <div class="w-full max-w-lg mx-auto mb-4">
                    <x-search-input id="buscar-partidos" name="buscar_partidos" placeholder="Buscar Partidos" />
                </div>

                <form id="form-proximos-partidos" action="{{ route('web.inicio.proximos-partidos') }}" method="GET" class="w-full max-w-lg mx-auto mb-4">
                    <x-form-select id="select-proximos-partidos" name="jornada" label="Jornada:">
                        @foreach($jornadas as $jornada)
                            <option value="{{ $jornada->id }}" {{ $jornada->id === $jornada_activa ? 'selected' : '' }}>
                                {{ $jornada->name }}
                            </option>
                        @endforeach
                    </x-form-select>
                </form>

                <form
                    id="formPredicionesWeb"
                    action="{{ route('web.inicio.save-predicciones') }}"
                    method="POST"
                    data-url-predicciones="{{ route('web.inicio.save-predicciones') }}"
                >

                    @csrf

                    <input type="number" name="jornada" value="{{ $jornada_activa }}" hidden class="hidden">

                    <div class="flex">
                        <button
                            type="submit"
                            class="focus:outline-none hover:brightness-[1.2] focus:ring-4 focus:ring-primary rounded-full fixed bottom-20 right-4 shadow-lg shadow-dark bg-green-700 text-light text-md lg:text-xl py-2 lg:py-3 px-4 lg:px-6 font-semibold gap-1 flex justify-center items-center z-50"
                        >
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-2 .85L16.15 5H5v14h14zm-4.875 9.275Q15 16.25 15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18t2.125-.875M6 10h9V6H6zM5 7.85V19V5z"/></svg>
                            </span>
                            Pronosticar
                        </button>
                    </div>

                    @if (isset($partidosJornada) && $partidosJornada->isNotEmpty())

                        <ul id="partidos-jornada-general" class="grid grid-cols-1 md:grid-cols-2 2xl:gap-12 max-w-6xl mx-auto gap-4 lg:gap-8 items-center min-h-96">

                            @foreach ($partidosJornada as $registro)
                                <x-prediction-card :registro="$registro" />
                            @endforeach

                        </ul>

                    @else

                        <p class="text-2xl text-complementary-light w-full text-center py-12">
                            No hay predicciones disponibles para esta jornada
                        </p>

                    @endif

                </form>
            </div>

        </div>
    </div>

    {{-- Modal Resultado de Predicciones --}}
    <div id="modal-resultado-predicciones" class="pointer-events-none fixed inset-0 z-50 flex items-end lg:items-center justify-center p-0 lg:p-4" style="display: none;">

        {{-- Backdrop --}}
        <div id="modal-resultado-backdrop" class="absolute inset-0 bg-black/70 opacity-0 transition-opacity duration-300"></div>

        {{-- Panel --}}
        <div id="modal-resultado-panel" class="relative bg-complementary-primary lg:rounded-3xl overflow-hidden w-full lg:max-w-4xl h-full lg:h-auto lg:max-h-[90dvh] flex flex-col opacity-0 transition-opacity duration-300 ease-out">

            {{-- Header --}}
            <div class="shrink-0 pt-6 pb-4 px-6 flex items-start justify-between gap-4">
                <h2 class="text-xl lg:text-2xl font-bold text-light leading-tight">Resultado del registro de predicciones</h2>
                <button type="button" id="modal-resultado-close" class="shrink-0 text-complementary-light hover:text-light transition-colors mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z"/></svg>
                </button>
            </div>

            {{-- Scrollable cards container --}}
            <div class="overflow-y-auto flex-1 px-6 py-4 pb-6">
                <div id="modal-resultado-cards" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
            </div>

        </div>
    </div>
</x-app-layout>
