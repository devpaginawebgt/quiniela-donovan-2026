<x-app-layout>
    <x-inicio-header :activeTab="'estadios'" />

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
            <div class="px-6 pb-6">

                <h5 class="text-3xl 2xl:text-4xl text-center font-bold mt-8 mb-4">Estadios de la Copa Mundial</h5>

                <x-user-stats :user="$user" />

                <div class="w-full max-w-lg mx-auto mb-6">
                    <x-search-input id="buscar-estadios" name="buscar_estadios" placeholder="Buscar Estadios" />
                </div>

                <div id="estadios-grid" class="grid grid-cols-1 md:grid-cols-2 2xl:gap-12 max-w-6xl mx-auto gap-4 lg:gap-8 items-start">
                    @foreach($estadios as $estadio)
                        <x-estadio-card :estadio="$estadio" />
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    {{-- Modal Estadio --}}
    <div id="modal-estadio" class="pointer-events-none fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4">

        {{-- Backdrop --}}
        <div id="modal-estadio-backdrop" class="absolute inset-0 bg-black/70 opacity-0 transition-opacity duration-300"></div>

        {{-- Panel --}}
        <div id="modal-estadio-panel" class="relative bg-complementary-primary rounded-t-3xl sm:rounded-3xl overflow-hidden w-full sm:max-w-xl max-h-[90dvh] flex flex-col translate-y-full opacity-0 transition-[transform,opacity] duration-300 ease-out">

            {{-- Header --}}
            <div class="flex items-center justify-end px-4 pt-3 pb-2 shrink-0">
                {{-- <div class="w-8 sm:hidden"></div> --}}
                {{-- <div class="flex-1 flex justify-center sm:hidden">
                    <div class="w-10 h-1 rounded-full bg-complementary-light/40"></div>
                </div> --}}
                <div class="hidden sm:flex flex-1"></div>
                <button
                    id="modal-estadio-close"
                    type="button"
                    class="shrink-0 bg-complementary-light/10 hover:bg-complementary-light/20 text-light rounded-full p-1.5 transition-colors"
                    aria-label="Cerrar"
                >
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Scrollable content --}}
            <div class="overflow-y-auto">
                <div class="px-6">
                    <img
                        id="modal-estadio-img"
                        src=""
                        alt=""
                        class="w-full aspect-video object-cover"
                    >
                </div>
                <div class="p-6 flex flex-col gap-3">
                    <h3 id="modal-estadio-nombre" class="font-bold text-2xl text-center"></h3>
                    <p id="modal-estadio-descripcion" class="text-complementary-light text-sm leading-relaxed text-justify"></p>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
