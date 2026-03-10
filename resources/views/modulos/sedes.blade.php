<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Mundial 2026 México | Estados Unidos | Canadá') }}
        </h2>
    </x-slot>

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8" id="selecciones-container">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 pb-6 ">
                <h5 class="text-3xl text-center font-bold my-8">Estadios del Mundial 2026</h5>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 justify-center items-start gap-8 transition-all">

                    @foreach($estadios as $estadio)
                        <div class="max-w-md bg-complementary-primary rounded-lg transform ease-in duration-150 hover:scale-105 overflow-hidden shadow-lg">
                            <div class="flex">
                                <img
                                    class="rounded-t-lg hover:cursor-pointer btn-bandera w-full object-cover"
                                    style="aspect-ratio: 6/3"
                                    src="{{ asset($estadio->imagen) }}"
                                    alt=""
                                    id="{{ $estadio->id }}"
                                    onclick="slideToggle({{ $estadio->id }})"
                                />
                            </div>
                            <div class="p-5 rounded-lg">
                                <div class="mb-2 xl:text-xl font-semibold tracking-tight flex gap-4 justify-center items-center">
                                    {{ $estadio->nombre }}
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 16 16"><path fill="currentColor" d="M3.2 5.74a.75.75 0 0 1 1.06-.04L8 9.227L11.74 5.7a.75.75 0 1 1 1.02 1.1l-4.25 4a.75.75 0 0 1-1.02 0l-4.25-4a.75.75 0 0 1-.04-1.06"/></svg>
                                    </span>
                                </div>
                                <div class="container-{{ $estadio->id }} hidden">
                                    <p class="mb-3 font-normal text-center">
                                        {{ $estadio->descripcion }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
</x-app-layout>