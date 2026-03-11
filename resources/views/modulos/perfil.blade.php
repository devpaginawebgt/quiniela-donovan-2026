<x-app-layout>
    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-6">
        <div class="bg-complementary-primary border border-complementary-light rounded-2xl p-10 max-w-sm w-full">
            <svg class="mx-auto mb-4 w-16 h-16 text-secondary opacity-70" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <h2 class="text-2xl font-bold text-light mb-2">Perfil</h2>
            <p class="text-complementary-light text-sm mb-6">Esta sección está en desarrollo.</p>

            <form method="POST" action="{{ route('web.logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-xl transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
