<x-app-layout>
    <x-inicio-header :activeTab="''" />

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8" id="selecciones-container">

        <div class="overflow-hidden shadow-sm sm:rounded-lg xl:px-10 px-2 pb-11">

            <div class="px-6 pb-6 flex items-center justify-center">

                <h5 class="text-3xl text-center font-bold mt-4 mb-4">Ranking de participantes</h5>

                <svg class="animate-spin spinner-load" viewBox="0 0 24 24"></svg>

            </div>

            

            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mx-auto">

                <table class="w-full text-sm text-left bg-complementary-primary" id="ranking-table">

                    <thead class="text-xs uppercase bg-dark">

                        <tr>

                            <th scope="col" class="py-3 px-6">

                                Posicion

                            </th>

                            <th scope="col" class="py-3 px-6">

                                Nombre

                            </th>

                            <th scope="col" class="py-3 px-6">

                                Apellido

                            </th>
                            <th scope="col" class="py-3 px-6">

                                Número de documento

                            </th>
                            <th scope="col" class="py-3 px-6">

                                Correo

                            </th>
                            <th scope="col" class="py-3 px-6">

                                Teléfono

                            </th>
                            
                            <th scope="col" class="py-3 px-6">

                                Puntos

                            </th>

                            {{-- <th scope="col" class="py-3 px-6">

                                Fecha de registro

                            </th> --}}

                        </tr>

                    </thead>

                    <tbody id="body-participantes-quiniela">
                        @if(!empty($participantes))

                            @foreach($participantes as $participante)

                                @php
                                    switch($participante->posicion) {
                                        case 1:
                                            $decoration = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V7q0-.825.588-1.412T5 5h2V3h10v2h2q.825 0 1.413.588T21 7v1q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"/></svg>';
                                            $positionStyle = 'color: #EFBF04';
                                            break;
                                        case 2:
                                            $decoration = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V7q0-.825.588-1.412T5 5h2V3h10v2h2q.825 0 1.413.588T21 7v1q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"/></svg>';
                                            $positionStyle = 'color: #C4C4C4';
                                            break;
                                        case 3:
                                            $decoration = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V7q0-.825.588-1.412T5 5h2V3h10v2h2q.825 0 1.413.588T21 7v1q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"/></svg>';
                                            $positionStyle = 'color: #CE8946';
                                            break;
                                        default:
                                            $decoration = '';
                                            $positionStyle = 'color: #FFFFFF';
                                            break;
                                    }
                                @endphp

                                <tr class="border-b border-zinc-400">

                                    <th scope="row" class="py-4 px-6 font-bold text-lg whitespace-nowrap">
                                        <span style="{{ $positionStyle }}" class="flex gap-2 items-center">
                                            {{ $participante->posicion }}°. {!! $decoration !!}
                                        </span>
                                    </th>
                                    <td class="py-4 px-6">{{ $participante->nombres }}</td>
                                    <td class="py-4 px-6">{{ $participante->apellidos }}</td>
                                    <td class="py-4 px-6">{{ $participante->numero_documento }}</td>
                                    <td class="py-4 px-6">{{ $participante->email }}</td>
                                    <td class="py-4 px-6">{{ $participante->telefono }}</td>
                                    <td class="py-4 px-6">{{ $participante->puntos }}</td>
                                </tr>
                            
                            @endforeach
                        
                        @else

                            <tr>
                                <td colspan="8" class="py-4 text-center">
                                    No hay participantes para mostrar
                                </td>
                            </tr>

                        @endif
                    </tbody>

                </table>

            </div>

        </div>

        {{-- <img src="{{asset('images/panda_argentina.png')}}" alt="PORTADA-2022" class="img_ani"> --}}

    </div>

</x-app-layout>

