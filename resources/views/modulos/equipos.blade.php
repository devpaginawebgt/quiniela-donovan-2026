<x-app-layout>
    <x-inicio-header :activeTab="'equipos'" />

    <x-carousel-section-banners :banners="$banners" />

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
            <div class="px-6 pb-6">

                <h5 class="text-3xl 2xl:text-4xl text-center font-bold mt-8 mb-4">Selecciones Clasificadas</h5>

                <x-user-stats :user="$user" />

                <div class="w-full max-w-lg mx-auto mb-6">
                    <x-search-input id="buscar-selecciones" name="buscar_selecciones" placeholder="Buscar Selecciones" />
                </div>

                <div id="selecciones-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 2xl:gap-8 max-w-6xl mx-auto min-h-60">
                    @foreach($equipos as $equipo)
                        <x-team-card :equipo="$equipo" />
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    {{-- Modal / Drawer Selección --}}
    <x-team-modal />

</x-app-layout>
