<x-app-layout>
    <x-inicio-header :activeTab="'pronosticos'" />

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8" id="selecciones-container">

        <div class="overflow-hidden shadow-sm sm:rounded-lg">

            <div class="lg:px-6 pb-6">

                <h5 class="text-2xl text-center font-bold mt-4">Pronostica los próximos partidos</h5>
                
                <div class="w-44 mx-auto mb-4">

                    <form action="{{ route('web.ver-quiniela') }}" method="GET" id="verPartidosQuinielaSelect">

                        <label for="grupos" class="block mb-2 text-xl font-bold text-center text-complementary-light mt-4">Jornada:

                        </label>

                        <select
                            id="quiniela"
                            class="bg-complementary-primary border border-light text-light text-lg text-center font-bold hover:border-secondary hover:cursor-pointer rounded-lg focus:ring-secondary focus:border-secondary block w-full p-2.5"
                            {{-- onchange="verPartidosJornadaQuiniela(this)" --}}
                        >

                            @foreach($jornadas as $jornada)

                                <option value="{{ $jornada->id }}" {{ $jornada->id === $jornada_activa ? 'selected' : ''; }}>
                                    {{ $jornada->name }}
                                </option>

                            @endforeach

                        </select>

                    </form>

                </div>

                <div class="status-message flex w-full">

                    @if ($message == '1OK')

                        <div
                            class="w-2/3 mx-auto p-4 text-center text-xl text-gray-800 rounded-md shadow-sm bg-green-200 animate-pulse">

                            Listo, tus marcadores fueron guardados!

                        </div>
                    @else
                        @if ($message == '2OK')

                            <div
                                class="w-2/3 mx-auto p-4 text-center text-xl text-gray-800 rounded-md shadow-sm bg-yellow-200 animate-pulse">

                                Oh, algunos marcadores no fueron guardados, solo puedes guardar marcadores 10 minutos antes de
                                iniciar el partido.

                            </div>
                        @else
                            @if ($message != '0OK')
                                <div
                                    class="w-2/3 mx-auto p-4 text-center text-xl text-gray-800 rounded-md shadow-sm bg-red-200 animate-pulse">

                                    Umm, ocurrio un problema al guardar tus marcadores, por favor intentalo mas tarde.

                                </div>
                            @endif

                        @endif

                    @endif

                </div>

                <form action="{{ route('web.guardar-predicciones-form') }}" method="POST">

                    <div class="flex flex-col">

                        <div class="mx-auto w-full">

                            <div class="flex items-center justify-center p-4">

                                <p class="text-xl font-bold mb-4">Partidos Programados</p>

                                <svg class="animate-spin spinner-load" viewBox="0 0 24 24"></svg>

                                <input
                                    type="number"
                                    name="jornada"
                                    value="{{ $jornada_activa ?? 1 }}"
                                    hidden
                                    class="hidden"
                                >

                                @csrf

                                <button
                                    type="submit"
                                    class="border-2 border-dark focus:outline-none hover:brightness-[1.2] focus:ring-4 focus:ring-primary rounded-full py-2 px-4 fixed bottom-5 right-5 shadow-xl bg-secondary text-dark text-sm font-semibold gap-1 flex justify-center items-center z-30"
                                >
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-2 .85L16.15 5H5v14h14zm-4.875 9.275Q15 16.25 15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18t2.125-.875M6 10h9V6H6zM5 7.85V19V5z"/></svg>
                                    </span>
                                    Pronosticar
                                </button>

                            </div>

                            <ul id="partidos-jornada-quiniela" class="grid grid-cols-1 md:grid-cols-2 2xl:gap-12 max-w-[72rem] mx-auto gap-4 lg:gap-8 items-center">

                                @foreach ($partidosJornada as $registro)

                                <li class="bg-complementary-primary p-8 rounded-3xl flex flex-col relative">

                                    @php          
                                        $partido    = $registro->partido;
                                        $equipoUno  = $registro->equipoUno;
                                        $equipoDos  = $registro->equipoDos;
                                        $prediccion = $registro->prediccion;
                                        $resultado  = $registro->resultado;

                                        $pronosticado = !empty($prediccion);
                                        $prediccion_equipo_uno = empty($prediccion) ? '' : $prediccion->goles_equipo_1;
                                        $prediccion_equipo_dos = empty($prediccion) ? '' : $prediccion->goles_equipo_2;                                        
                                    @endphp

                                    @if($pronosticado)
                                        <div class="absolute rounded-full py-1 px-4 top-4 -right-4 bg-secondary text-sm text-dark font-semibold">
                                            Pronosticado
                                        </div>
                                    @endif

                                    <div class="w-full flex flex-col justify-center items-center">
                                        <p class="resultadoPartido flex justify-between items-center text-xl font-bold mb-2">
                                            @if ($partido->estado === 0)
                                                Por jugar
                                            @elseif ($partido->estado === 2)
                                                ¡En juego!
                                            @else
                                                Partido Finalizado
                                            @endif
                                        </p>

                                        <p class="text-center flex gap-2 text-complementary-light">

                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 14q-.425 0-.712-.288T11 13t.288-.712T12 12t.713.288T13 13t-.288.713T12 14m-4.712-.288Q7 13.426 7 13t.288-.712T8 12t.713.288T9 13t-.288.713T8 14t-.712-.288M16 14q-.425 0-.712-.288T15 13t.288-.712T16 12t.713.288T17 13t-.288.713T16 14m-4 4q-.425 0-.712-.288T11 17t.288-.712T12 16t.713.288T13 17t-.288.713T12 18m-4.712-.288Q7 17.426 7 17t.288-.712T8 16t.713.288T9 17t-.288.713T8 18t-.712-.288M16 18q-.425 0-.712-.288T15 17t.288-.712T16 16t.713.288T17 17t-.288.713T16 18M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v14q0 .825-.587 1.413T19 22zm0-2h14V10H5z"/></svg>
                                            </span>

                                            @php
                                                $fecha_utc = $partido->fecha_partido;
                                                $timezone = auth()->user()->country->timezone;

                                                $fecha_local = $fecha_utc
                                                    ->copy()
                                                    ->timezone($timezone)
                                                    ->locale('es');

                                                $fecha_partido = $fecha_local->isoFormat('dddd, D [de] MMMM [de] YYYY');
                                                $hora_partido  = $fecha_local->translatedFormat('h:i a');
                                            @endphp

                                            <span>{{ $fecha_partido }},</span>
                                            <span>{{ $hora_partido }}</span>

                                        </p>
                                    </div>

                                    <div class="flex justify-between items-center {{ $partido->estado == 0 ? 'partido-modulo-pronosticos' : '' }} partido-{{ $partido->id }} border-y border-complementary-light py-8 my-8">

                                        <div class="flex flex-col items-center w-full max-w-60 gap-4">

                                            <div class="flex flex-col justify-center items-center gap-4">

                                                <img
                                                    src="{{ asset($equipoUno->imagen) }}"
                                                    alt="SELECCION"
                                                    class="w-20 h-14 object-cover rounded-xl shadow-md"
                                                >

                                                <p class="font-semibold text-xs xs:text-md lg:text-base">

                                                    {{ $equipoUno->nombre }}</p>

                                            </div>

                                        </div>

                                        <div class="px-18">

                                            <span class="font-semibold text-2xl">VS</span>                                            

                                        </div>

                                        <div class="flex flex-col items-center w-full max-w-60 gap-4">

                                            <div class="flex flex-col justify-center items-center gap-4">

                                                <img
                                                    src="{{ asset($equipoDos->imagen) }}"
                                                    alt="SELECCION"
                                                    class="w-20 h-14 object-cover rounded-xl shadow-md"
                                                >

                                                <p class="font-semibold text-xs xs:text-md lg:text-base">{{ $equipoDos->nombre }}</p>                                                

                                            </div>

                                        </div>
                                        
                                    </div>


                                    {{-- Card Footer --}}

                                    <div class="flex flex-col">

                                        @if ($partido->estado === 1)
                                            <div class="mb-6">
                                                <p class="text-center mb-2">Resultado del partido:</p>
    
                                                <div class="resultadoPartido flex justify-center gap-8 items-center text-3xl font-bold">
                                                    <p> {{ $resultado->goles_equipo_1 }} </p> 
                                                    - 
                                                    <p> {{ $resultado->goles_equipo_2 }} </p>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <p class="text-center text-sm text-complementary-light mb-3">
                                            Tu pronóstico
                                        </p>

                                        <div class="flex items-center justify-center gap-8"> 
                                            
                                            <div>
                                                @if ($partido->estado === 0)
        
                                                    <input type="number" name="partidos[]"
                                                        value="{{ $registro->partido_id }}" hidden
                                                        class="hidden partido-jornada-quiniela">
        
                                                    <div class="flex justify-center items-center w-auto gap-4">
        
                                                        <button type="button" onclick="decreaseBookmar(this)" class="">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32"><path fill="currentColor" d="M28 16c0-6.627-5.373-12-12-12S4 9.373 4 16s5.373 12 12 12s12-5.373 12-12m2 0c0 7.732-6.268 14-14 14S2 23.732 2 16S8.268 2 16 2s14 6.268 14 14m-20-1a1 1 0 1 0 0 2h12a1 1 0 1 0 0-2z"/></svg>
                                                            </span>
                                                        </button>
        
                                                        <div>
        
                                                            <input
                                                                type="number"
                                                                name="prediccion_equipo1_{{ $registro->partido_id }}"
                                                                min="0"
                                                                max="25"
                                                                value="{{ $prediccion_equipo_uno }}"
                                                                class="marcador-equipo-1 marcador-equipo border border-light text-light bg-transparent text-center rounded-md hide-input-arrows px-0 py-1"
                                                            >
        
                                                        </div>
        
                                                        <button type="button" onclick="increaseBookmar(this)">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32"><path fill="currentColor" d="M15 10a1 1 0 1 1 2 0v5h5a1 1 0 1 1 0 2h-5v5a1 1 0 1 1-2 0v-5h-5a1 1 0 1 1 0-2h5zm15 6c0 7.732-6.268 14-14 14S2 23.732 2 16S8.268 2 16 2s14 6.268 14 14m-2 0c0-6.627-5.373-12-12-12S4 9.373 4 16s5.373 12 12 12s12-5.373 12-12"/></svg>
                                                            </span>
                                                        </button>
        
                                                    </div>
                                                @elseif ($partido->estado === 2)
                                                    <div class="flex flex-col justify-items-center">
                                                        <span class="text-2xl text-light">
                                                            {{ $prediccion_equipo_uno }}
                                                        </span>
                                                    </div>
                                                @elseif ($partido->estado === 1)
                                                    <div class="flex flex-col justify-items-center">
                                                        <span class="text-xl text-complementary-light">
                                                            {{ $prediccion_equipo_uno }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
    
                                            <div>
                                                @if($partido->estado === 0 || $pronosticado)
                                                    <span class="text-2xl">
                                                        -
                                                    </span>
                                                @else
                                                    <span class="text-lg text-zinc-400">
                                                        No has ingresado una predicción
                                                    </span>
                                                @endif
                                            </div>
    
                                            <div>
                                                @if ($partido->estado === 0)
                                                    <div class="flex justify-center items-center w-auto gap-4">
        
                                                        <button type="button" onclick="decreaseBookmar(this)" class="">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32"><path fill="currentColor" d="M28 16c0-6.627-5.373-12-12-12S4 9.373 4 16s5.373 12 12 12s12-5.373 12-12m2 0c0 7.732-6.268 14-14 14S2 23.732 2 16S8.268 2 16 2s14 6.268 14 14m-20-1a1 1 0 1 0 0 2h12a1 1 0 1 0 0-2z"/></svg>
                                                            </span>
                                                        </button>
        
                                                        <div>
        
                                                            <input type="number"
                                                                name="prediccion_equipo2_{{ $registro->partido_id }}"
                                                                min="0" 
                                                                max="10"
                                                                value="{{ $prediccion_equipo_dos }}"
                                                                class="marcador-equipo-1 marcador-equipo border border-light text-light bg-transparent text-center rounded-md hide-input-arrows px-0 py-1">
        
                                                        </div>
        
                                                        <button type="button" onclick="increaseBookmar(this)">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32"><path fill="currentColor" d="M15 10a1 1 0 1 1 2 0v5h5a1 1 0 1 1 0 2h-5v5a1 1 0 1 1-2 0v-5h-5a1 1 0 1 1 0-2h5zm15 6c0 7.732-6.268 14-14 14S2 23.732 2 16S8.268 2 16 2s14 6.268 14 14m-2 0c0-6.627-5.373-12-12-12S4 9.373 4 16s5.373 12 12 12s12-5.373 12-12"/></svg>
                                                            </span>
                                                        </button>
        
                                                    </div>
                                                @elseif ($partido->estado === 2)
                                                    <div class="flex flex-col justify-items-center">
                                                        <span class="text-2xl text-light">
                                                            {{ $prediccion_equipo_dos }}
                                                        </span>
                                                    </div>
                                                @elseif ($partido->estado === 1)
                                                    <div class="flex flex-col justify-items-center">
                                                        <span class="text-xl text-complementary-light">
                                                            {{ $prediccion_equipo_dos }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>


                                        </div>                                      

                                        @if ($partido->estado === 1)
                                            <div class="puntosGenerados font-semibold text-center mt-4 text-xl">
                                                Ganaste: {{ $partido->puntos ?? '0' }} puntos.
                                            </div>
                                        @endif
                                    </div>




                                    {{-- @if($registro->estado === 2)
                                        <div class="text-xl w-full flex items-center justify-center mt-8 text-complementary-light">
                                            @php
                                                $random_id = rand(0, 2);
                                                $messages = [
                                                    '¡No te pierdas el partido!',
                                                    '¿Quién ganará?',
                                                    'Sintoniza el partido'
                                                ];
                                                $message = $messages[$random_id];
                                            @endphp

                                            {{ $message }}
                                        </div>
                                    @endif --}}
                                </li>
                                @endforeach

                            </ul>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>

        setTimeout(() => {

            document.querySelector(".status-message").classList.toggle('hidden');

        }, 6500);

    </script>

</x-app-layout>

