<x-app-layout>
    <x-inicio-header :activeTab="'proximos'" />

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8" id="selecciones-container">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 pb-6 ">
                <h5 class="text-3xl text-center font-bold my-8">Calendario de partidos</h5>
                <div class="flex flex-col">
                    <div class="w-36 mx-auto mb-4">
                        <label for="grupos"
                            class="block mb-2 text-sm font-medium text-center">Jornada: </label>
                        <select
                            id="jornadas"
                            class="bg-complementary-primary border border-complementary-light text-light font-semibold text-center cursor-pointer rounded-lg block p-2.5 w-full"
                            {{-- onchange="verPartidosJornada(this)" --}}
                        >
                            @foreach($jornadas as $jornada)

                                <option value="{{ $jornada->id }}" {{ $jornada->is_current === true ? 'selected' : ''; }}>
                                    {{ $jornada->name }}
                                </option>

                            @endforeach
                        </select>
                    </div>

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