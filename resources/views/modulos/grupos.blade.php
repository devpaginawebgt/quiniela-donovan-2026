<x-app-layout>
    <x-inicio-header :activeTab="'grupos'" />

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8" id="selecciones-container">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 pb-6 mb-8">
                <h5 class="text-3xl text-center font-bold my-8">Grupos conformados</h5>
                <div class="flex flex-col">
                    <div class="xl:w-1/6 w-1/2 mx-auto mb-4">
                        <label for="grupos" class="block mb-2 text-sm font-medium text-light text-center">Seleccione: </label>
                        <div class="flex items-center justify-center">
                            <select
                                id="grupos"
                                class="bg-complementary-primary border border-complementary-light text-light font-semibold text-center cursor-pointer rounded-lg block w-1/2 p-2.5"
                                {{-- onchange="verEquiposGrupo(this)" --}}
                            >
                                @foreach($grupos as $grupo)

                                    <option value="{{ $grupo->id }}" {{ $grupo->is_current === true ? 'selected' : ''; }}>
                                        {{ $grupo->name }}
                                    </option>

                                @endforeach
                            </select>
                            <svg class="animate-spin spinner-load" viewBox="0 0 24 24"></svg>
                        </div>
                    </div>

                    <div class="w-full lg:w-3/4 overflow-x-auto relative shadow-md sm:rounded-lg mx-auto mb-12">
                        <table class="xl:w-full text-sm text-left">
                            <thead class="text-xs bg-dark uppercase">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Equipo</th>
                                    <th scope="col" class="py-3 px-6">PJ</th>
                                    <th scope="col" class="py-3 px-6">PG</th>
                                    <th scope="col" class="py-3 px-6">PE</th>
                                    <th scope="col" class="py-3 px-6">PP</th>
                                    <th scope="col" class="py-3 px-6">GF</th>
                                    <th scope="col" class="py-3 px-6">GC</th>
                                    <th scope="col" class="py-3 px-6">Puntos</th>
                                </tr>
                            </thead>
                            <tbody id="body-equipos-grupo">
                                @if (!empty($equipos_grupo))
                                    @foreach($equipos_grupo as $equipo)
                                        <tr class="bg-complementary-primary border-b border-zinc-400 text-light">
                                            <th scope="row" class="py-4 px-6 font-medium whitespace-nowrap flex items-center justify-between w-full">
                                                <img
                                                    src="{{ $equipo->imagen }}"
                                                    alt="SELECCION"
                                                    class="h-10 w-14 object-cover mx-4 rounded-md shadow-md"
                                                >
                                                {{ $equipo->nombre }}

                                                <td class="py-4 px-6">
                                                    {{ $equipo->partidos_jugados }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $equipo->partidos_ganados }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $equipo->partidos_empatados }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $equipo->partidos_perdidos }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $equipo->goles_favor }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $equipo->goles_contra }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $equipo->puntos }}
                                                </td>
                                            </th>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <p class="text-xl font-semibold text-center mb-4">
                        Jornada 1
                    </p>

                    <div class="shadow-md mx-auto w-full lg:w-3/4 bg-complementary-primary rounded-2xl overflow-hidden p-4 mb-12">
                        <ul id="partidos-jornada-1">

                            @if(!empty($jornada_uno))

                                @foreach($jornada_uno['partidos'] as $index => $equipos_partido)

                                    @php
                                        $fecha_utc = $equipos_partido->partido->fecha_partido;
                                        $timezone = auth()->user()->country->timezone;

                                        $fecha_local = $fecha_utc
                                            ->copy()
                                            ->timezone($timezone)
                                            ->locale('es');

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

                    <p class="text-xl font-semibold text-center mb-4">
                        Jornada 2
                    </p>

                    <div class="shadow-md mx-auto w-full lg:w-3/4 bg-complementary-primary rounded-2xl overflow-hidden p-4 mb-12">
                        <ul id="partidos-jornada-2">

                            @if(!empty($jornada_dos))

                                @foreach($jornada_dos['partidos'] as $equipos_partido)

                                    @php
                                        $fecha_utc = $equipos_partido->partido->fecha_partido;
                                        $timezone = auth()->user()->country->timezone;

                                        $fecha_local = $fecha_utc
                                            ->copy()
                                            ->timezone($timezone)
                                            ->locale('es');

                                        $fecha_partido = $fecha_local->isoFormat('dddd, D [de] MMMM [de] YYYY');
                                        $hora_partido  = $fecha_local->format('H:i A');

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

                                            <img src="{{ $equipos_partido->equipoDos->imagen }}" alt="SELECCION" class="h-10 w-14 object-cover mx-4 border rounded-md shadow-md">

                                            <p class="font-semibold">{{ $equipos_partido->equipoDos->nombre }}</p>

                                        </div>

                                    </li>
                                
                                @endforeach

                            @endif

                        </ul>   
                    </div>

                    <p class="text-xl font-semibold text-center mb-4">
                        Jornada 3
                    </p>

                    <div class="shadow-md mx-auto w-full lg:w-3/4 bg-complementary-primary rounded-2xl overflow-hidden p-4">
                        <ul id="partidos-jornada-3">

                            @if(!empty($jornada_tres))

                                @foreach($jornada_tres['partidos'] as $equipos_partido)

                                    @php
                                        $fecha_utc = $equipos_partido->partido->fecha_partido;
                                        $timezone = auth()->user()->country->timezone ?? 'GMT-6';

                                        $fecha_local = $fecha_utc
                                            ->copy()
                                            ->timezone($timezone)
                                            ->locale('es');

                                        $fecha_partido = $fecha_local->isoFormat('dddd, D [de] MMMM [de] YYYY');
                                        $hora_partido  = $fecha_local->format('H:i A');

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

                                            <img src="{{ $equipos_partido->equipoDos->imagen }}" alt="SELECCION" class="h-10 w-14 object-cover mx-4 border rounded-md shadow-md">

                                            <p class="font-semibold">{{ $equipos_partido->equipoDos->nombre }}</p>

                                        </div>

                                    </li>
                                
                                @endforeach

                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>