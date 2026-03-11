<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Mundial 2026 México | Estados Unidos | Canadá') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="flex justify-center">
            <img
                src="{{asset('images/portadas/portada_2.jpg')}}"
                alt="PORTADA-2022"
                style="max-width: 100rem"
            >
        </div>
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 bg-complementary-primary">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 ">
                    <p class="text-center text-2xl font-bold">
                        Bienvenido {{ Auth::user()->nombres . " " . Auth::user()->apellidos}}
                    </p>
                    <p class="text-center text-4xl mt-2">
                         Estamos listos para el Mundial 2026
                    </p>
                </div>
                <div class="flex w-full py-8" style="justify-content: center;align-items: center;">
                    <img src="{{asset('images/grupos.jpg')}}" alt="PORTADA-2022" style="width: 60%;height: auto;" class="">
                    <img src="{{asset('images/adorno_1.jpg')}}" alt="PORTADA-2022" style="width: 20%;height: 1%;margin-left: 15px;" class="">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

