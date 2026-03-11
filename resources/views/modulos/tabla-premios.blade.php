<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Mundial 2026 México | Estados Unidos | Canadá') }}
        </h2>
    </x-slot>

    <div class="max-w-screen-2xl my-6 mx-auto px-0 sm:px-6 lg:px-8" id="selecciones-container">
        <div class="overflow-hidden shadow-sm sm:rounded-lg pb-11 md:px-10">
            <div class="mt-4 mb-8">
                <h5 class="text-3xl text-center font-bold">Premios ganadores</h5>
                {{-- <p class="text-xl text-center font-semibold">(Disponible proximamente)</p> --}}
            </div>

            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mx-auto max-w-screen-lg">
                <table class="w-full text-left">
                    <thead class="text-xs uppercase bg-dark">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Posicion
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Premio
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Descripcion
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Imagen ilustrativa
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($premios as $premio)

                            @php
                                $positionText = '';
                                $positionStyle = '';

                                $position = $premio->posicion;

                                switch ($position) {
                                    case 1:
                                        $positionText = '1°. <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V7q0-.825.588-1.412T5 5h2V3h10v2h2q.825 0 1.413.588T21 7v1q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"/></svg>';
                                        $positionStyle = 'color: #EFBF04';
                                        break;
                                    case 2:
                                        $positionText = '2°. <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V7q0-.825.588-1.412T5 5h2V3h10v2h2q.825 0 1.413.588T21 7v1q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"/></svg>';
                                        $positionStyle = 'color: #C4C4C4';
                                        break;
                                    case 3:
                                        $positionText = '3°. <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V7q0-.825.588-1.412T5 5h2V3h10v2h2q.825 0 1.413.588T21 7v1q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"/></svg>';
                                        $positionStyle = 'color: #CE8946';
                                        break;
                                    default:                                        
                                        $positionText = "{$position}°.";
                                        break;
                                }                                
                            @endphp

                            <tr class="bg-complementary-primary border-b border-zinc-400">
                                <th scope="row" class="py-4 px-6 font-medium whitespace-nowrap text-xl">
                                    <span class="flex gap-2 items-center justify-center h-full" style="{{ $positionStyle }}">
                                        {!! $positionText !!}
                                    </span>
                                </th>
                                <td class="py-4 px-6">
                                    {{$premio->nombre}}
                                </td>
                                <td class="py-4 px-6">
                                    {{$premio->descripcion}}
                                </td>
                                <td class="py-4 px-6">
                                    <img src="{{ asset($premio->imagen) }}" class="w-20 h-16 rounded">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <img src="{{asset('images/perrito_espana.png')}}" alt="PORTADA-2022" style="width: 20%; position: absolute; z-index: 10000; right: 0px; bottom: 0;" class=""> --}}
    </div>
</x-app-layout>
