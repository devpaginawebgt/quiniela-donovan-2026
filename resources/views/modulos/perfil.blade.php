<x-app-layout>
    <x-inicio-header :activeTab="''" />

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden sm:rounded-lg">
            <div class="px-6 pb-6">

                <h1 class="text-2xl lg:text-3xl text-center font-bold mb-4">Usuario</h1>

                {{-- Avatar --}}
                <div class="flex justify-center mb-3">
                    <div class="w-20 h-20 rounded-full bg-blue-500 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-light" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                </div>

                {{-- User Name --}}
                <p class="text-xl font-bold text-light text-center mb-2">{{ $user->nombres }} {{ $user->apellidos }}</p>

                {{-- Stats --}}
                <x-user-stats :user="$user" />

                {{-- Preferencias --}}
                <div class="w-full max-w-lg mx-auto">
                    <h2 class="text-xl font-bold text-light mb-4">Preferencias</h2>

                    {{-- País --}}
                    <div class="w-full flex items-center justify-between border-b border-complementary-light pb-2 mb-2 text-zinc-200/60 pointer-events-none">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset($user->country->image) }}" alt="{{ $user->country->name }}" class="w-8 aspect-6/3 object-cover">
                            <span class="lg:text-lg font-bold tracking-wide">{{ $user->country->name }}</span>
                        </div>

                        <div>
                            <span>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="28"
                                    height="28"
                                    viewBox="0 0 24 24"><path
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 5v14m7-7l-7 7l-7-7"
                                /></svg>
                            </span>
                        </div>
                    </div>

                    {{-- Cerrar sesión --}}
                    <button
                        type="button"
                        id="btn-logout"
                        class="w-full flex items-center gap-2 py-3 text-light font-semibold hover:text-red-400 transition-colors duration-150 cursor-pointer">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24"><path fill="currentColor" d="m17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5M4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4z"/></svg>
                        </span>
                        Salir
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- Modal Cerrar Sesión --}}
    <div id="modal-logout" class="pointer-events-none fixed inset-0 z-50 flex items-center justify-center p-4">

        {{-- Backdrop --}}
        <div id="modal-logout-backdrop" class="absolute inset-0 bg-black/70 opacity-0 transition-opacity duration-200"></div>

        {{-- Panel --}}
        <div id="modal-logout-panel" class="relative bg-complementary-primary rounded-2xl shadow-xl border border-complementary-light/20 w-full max-w-md scale-90 opacity-0 transition-[transform,opacity] duration-200 ease-out">
            <div class="p-6">
                <h3 class="text-xl font-bold text-light text-left mb-2">Cerrar sesión</h3>
                <p class="text-complementary-light text-left mb-6">¿Deseas cerrar tu sesión actual?</p>

                <div class="flex items-center justify-end gap-4">
                    <button
                        type="button"
                        id="modal-logout-cancel"
                        class="text-complementary-light font-semibold hover:text-light transition-colors cursor-pointer">
                        Cancelar
                    </button>

                    <form method="POST" action="{{ route('web.logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="text-red-500 font-semibold hover:text-red-400 transition-colors cursor-pointer">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal    = document.getElementById('modal-logout');
            const backdrop = document.getElementById('modal-logout-backdrop');
            const panel    = document.getElementById('modal-logout-panel');
            const trigger  = document.getElementById('btn-logout');
            const cancel   = document.getElementById('modal-logout-cancel');

            const open = () => {
                modal.classList.remove('pointer-events-none');
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('scale-90', 'opacity-0');
                document.body.style.overflow = 'hidden';
            };

            const close = () => {
                backdrop.classList.add('opacity-0');
                panel.classList.add('scale-90', 'opacity-0');
                document.body.style.overflow = '';
                panel.addEventListener('transitionend', () => {
                    modal.classList.add('pointer-events-none');
                }, { once: true });
            };

            trigger.addEventListener('click', open);
            cancel.addEventListener('click', close);
            backdrop.addEventListener('click', close);

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('pointer-events-none')) close();
            });
        });
    </script>
</x-app-layout>
