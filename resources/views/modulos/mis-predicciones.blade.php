<x-app-layout>
    <x-inicio-header :activeTab="'pronosticos'" />

    <x-carousel-section-banners :banners="$banners" />

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
            <div class="px-6 pb-6">

                <h5 class="text-3xl 2xl:text-4xl text-center font-bold mt-8 mb-4">Mis Pronósticos</h5>

                <x-user-stats :user="$user" />

                <div class="w-full max-w-lg mx-auto mb-4">
                    <x-search-input id="buscar-partidos" name="buscar_partidos" placeholder="Buscar partido" />
                </div>

                <form id="form-mis-predicciones" action="{{ route('web.inicio.mis-predicciones') }}" method="GET" class="w-full max-w-lg mx-auto mb-6">
                    <x-form-select id="select-mis-predicciones" name="jornada" label="Jornada:">
                        @foreach($jornadas as $jornada)
                            <option value="{{ $jornada->id }}" {{ $jornada->id === $jornada_activa ? 'selected' : '' }}>
                                {{ $jornada->name }}
                            </option>
                        @endforeach
                    </x-form-select>
                </form>

                @if(isset($resultados) && $resultados->isNotEmpty())

                    <ul id="partidos-jornada-general" class="grid grid-cols-1 md:grid-cols-2 2xl:gap-12 max-w-6xl mx-auto gap-4 lg:gap-8 items-start min-h-80">
                        @foreach($resultados as $registro)
                            <x-result-card :registro="$registro" />
                        @endforeach
                    </ul>

                @else

                    <p class="text-2xl text-complementary-light w-full text-center py-12">
                        No hay partidos finalizados en esta jornada
                    </p>

                @endif

            </div>
        </div>
    </div>
</x-app-layout>
