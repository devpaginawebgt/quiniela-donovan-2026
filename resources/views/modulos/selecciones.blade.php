<x-app-layout>
    <x-inicio-header :activeTab="'equipos'" />

    <div class="max-w-screen-2xl mb-6 mx-auto sm:px-6 lg:px-8" id="selecciones-container">
        <div class= overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 pb-6 border-b">
                <h5 class="text-3xl text-center font-bold my-8">Selecciones clasificadas</h5>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 justify-center items-start gap-8 transition-all">
                    @foreach ($equipos as $equipo)
                    <div class="w-full max-w-sm bg-complementary-primary text-white transform ease-in duration-150 hover:scale-105 rounded-lg px-2 py-6 mx-auto shadow-lg">
                        <div class="flex">
                            <img
                                class="rounded-lg mx-auto hover:cursor-pointer btn-bandera w-32 h-20 cursor-pointer"
                                src="{{ asset( $equipo->imagen ) }}"
                                alt="{{$equipo->nombre}}"
                                id="{{str_replace(' ', '', $equipo->id)}}"
                                onclick="slideToggle(this.id)"
                            />
                        </div>
                        <div class="pt-2">
                            <div
                                class="mb-2 text-center text-2xl font-bold tracking-tight cursor-pointer flex gap-4 justify-center items-center"
                                id="{{str_replace(' ', '', $equipo->id)}}"
                                onclick="slideToggle(this.id)"
                            >
                                {{ $equipo->nombre }}
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 16 16"><path fill="currentColor" d="M3.2 5.74a.75.75 0 0 1 1.06-.04L8 9.227L11.74 5.7a.75.75 0 1 1 1.02 1.1l-4.25 4a.75.75 0 0 1-1.02 0l-4.25-4a.75.75 0 0 1-.04-1.06"/></svg>
                                </span>
                            </div>
                            <div class="container-{{str_replace(' ', '', $equipo->id)}} hidden rounded-lg p-3">
                                <p class="mb-3 font-normal text-center">{{$equipo->descripcion}}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
