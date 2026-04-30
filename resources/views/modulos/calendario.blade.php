<x-app-layout>
    <x-inicio-header :activeTab="'calendario'" />

    <x-carousel-section-banners :banners="$banners" />

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden">
            <div class="px-6 pb-6">

                <h5 class="text-3xl 2xl:text-4xl text-center font-bold mt-8 mb-4">Calendario de Partidos</h5>

                <x-user-stats :user="$user" />

                <div class="w-full max-w-lg mx-auto mb-4">
                    <x-search-input id="buscar-partidos" name="buscar_partidos" placeholder="Buscar Partidos" />
                </div>

                <div class="w-full max-w-lg mx-auto mb-6">
                    <x-form-select id="jornadas" name="jornada" label="Jornada:">
                        @foreach($jornadas as $jornada)
                            <option value="{{ $jornada->id }}" {{ $jornada->is_current === true ? 'selected' : '' }}>
                                {{ $jornada->name }}
                            </option>
                        @endforeach
                    </x-form-select>
                </div>

                <ul id="partidos-jornada-general" class="grid grid-cols-1 md:grid-cols-2 2xl:gap-12 max-w-6xl mx-auto gap-4 lg:gap-8 items-center min-h-96">
                    <li class="col-span-2 flex justify-center py-8">
                        <svg class="animate-spin w-8 h-8 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </li>
                </ul>

            </div>
        </div>
    </div>


    <a
        href="{{ route('web.inicio.bracket') }}"
        class="focus:outline-none hover:brightness-[1.2] focus:ring-4 focus:ring-primary rounded-full fixed bottom-20 right-4 shadow-lg shadow-dark bg-green-700 text-light text-md lg:text-lg py-2 lg:py-3 px-4 lg:px-6 font-semibold gap-2 flex justify-center items-center z-50"
    >
        <span class="icon-[material-symbols--account-tree-rounded] w-5 h-5"></span>
        Eliminatoria
    </a>
</x-app-layout>
