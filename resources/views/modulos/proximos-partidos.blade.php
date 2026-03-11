<x-app-layout>
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
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 pb-6">

                <h5 class="text-3xl 2xl:text-4xl text-center font-bold mt-8 mb-4">Próximos Partidos</h5>
                
                <x-user-stats :user="$user" />

                <div class="w-full max-w-lg mx-auto mb-4">
                    <x-search-input id="buscar-partidos" name="buscar_partidos" placeholder="Buscar Partidos" />
                </div>

                <div class="w-full max-w-lg mx-auto mb-4">
                    <x-form-select id="jornadas" name="jornadas" label="Jornada:">
                        @foreach($jornadas as $jornada)
                            <option value="{{ $jornada->id }}" {{ $jornada->is_current === true ? 'selected' : '' }}>
                                {{ $jornada->name }}
                            </option>
                        @endforeach
                    </x-form-select>
                </div>

                <div class="flex flex-col gap-4">

                    <div class="shadow-md rounded-md mx-auto w-full lg:w-3/4 my-4">
                        <div class="flex items-center justify-center">
                            <p class="p-4 text-xl">Partidos Programados</p>
                            <svg class="animate-spin spinner-load" viewBox="0 0 24 24"></svg>
                        </div>

                        <ul id="partidos-jornada-general" class="bg-complementary-primary p-4 rounded-xl">

                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
