    <x-app-layout>
    <x-inicio-header :activeTab="''" />

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg">
            <div class="px-6 pb-6">

                <h1 class="text-2xl lg:text-3xl text-center font-bold mb-4">Premios Ganadores</h1>

                <x-user-stats :user="$user" />

                <div class="w-full max-w-lg mx-auto mb-6">
                    <x-search-input id="buscar-premios" name="buscar_premios" placeholder="Buscar Premios" />
                </div>

                {{-- Brands Slider --}}
                <div class="w-full max-w-lg mx-auto mb-8">
                    <x-brands-slider :brands="$brands" />
                </div>

                {{-- Prize Cards --}}
                <div class="w-full max-w-lg mx-auto flex flex-col gap-3 pb-4" id="premios-list">
                    @foreach($premios as $premio)
                        <x-prize-card :premio="$premio" />
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    {{-- Modal / Drawer Premio --}}
    <x-prize-modal />

</x-app-layout>
