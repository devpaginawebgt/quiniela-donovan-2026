@props(['activeTab' => 'proximos'])

<header class="bg-complementary-primary border-b border-secondary sticky top-0 z-40">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-center lg:gap-4 lg:px-6 py-3">

    {{-- Logo --}}
    <div class="flex items-center justify-center px-4 py-3 lg:p-0 lg:shrink-0">
        <img
            src="{{ asset('images/logos/logo-liga.png') }}"
            alt="{{ config('app.name', 'Quiniela') }}"
            class="w-full max-w-28 lg:max-w-18"
        >
    </div>

    {{-- Flowbite scrollable pill tabs --}}
    <div class="overflow-x-auto pb-3 lg:pb-0 px-4">

        <ul class="flex lg:justify-center gap-2 whitespace-nowrap text-sm lg:text-xs xl:text-sm font-medium" role="tablist">

            <li role="presentation">
                <a href="{{ route('web.inicio.proximos-partidos') }}"
                   role="tab"
                   aria-selected="{{ $activeTab === 'proximos' ? 'true' : 'false' }}"
                   @if($activeTab === 'proximos') aria-current="page" @endif
                   class="inline-flex items-center gap-1.5 lg:gap-1 xl:gap-1.5 px-4 lg:px-3 xl:px-4 py-2 lg:py-1.5 xl:py-2 rounded-full transition-colors
                       {{ $activeTab === 'proximos'
                           ? 'bg-secondary text-dark font-semibold'
                           : 'text-complementary-light hover:bg-white/10 hover:text-light' }}"
                >
                    <svg class="w-4 h-4 lg:w-3.5 lg:h-3.5 xl:w-4 xl:h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Partidos Próximos
                </a>
            </li>

            <li role="presentation">
                <a href="{{ route('web.inicio.mis-predicciones') }}"
                   role="tab"
                   aria-selected="{{ $activeTab === 'pronosticos' ? 'true' : 'false' }}"
                   @if($activeTab === 'pronosticos') aria-current="page" @endif
                   class="inline-flex items-center gap-1.5 lg:gap-1 xl:gap-1.5 px-4 lg:px-3 xl:px-4 py-2 lg:py-1.5 xl:py-2 rounded-full transition-colors
                       {{ $activeTab === 'pronosticos'
                           ? 'bg-secondary text-dark font-semibold'
                           : 'text-complementary-light hover:bg-white/10 hover:text-light' }}"
                >
                    <svg class="w-4 h-4 lg:w-3.5 lg:h-3.5 xl:w-4 xl:h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                    Mis Pronósticos
                </a>
            </li>

            <li role="presentation">
                <a href="{{ route('web.inicio.trivias.index') }}"
                   role="tab"
                   aria-selected="{{ $activeTab === 'trivia' ? 'true' : 'false' }}"
                   @if($activeTab === 'trivia') aria-current="page" @endif
                   class="inline-flex items-center gap-1.5 lg:gap-1 xl:gap-1.5 px-4 lg:px-3 xl:px-4 py-2 lg:py-1.5 xl:py-2 rounded-full transition-colors
                       {{ $activeTab === 'trivia'
                           ? 'bg-secondary text-dark font-semibold'
                           : 'text-complementary-light hover:bg-white/10 hover:text-light' }}"
                >
                    <span class="icon-[fa-solid--brain] w-4 h-4 lg:w-3.5 lg:h-3.5 xl:w-4 xl:h-4 shrink-0"></span>
                    Trivias
                </a>
            </li>

            <li role="presentation">
                <a href="{{ route('web.inicio.calendario') }}"
                   role="tab"
                   aria-selected="{{ $activeTab === 'calendario' ? 'true' : 'false' }}"
                   @if($activeTab === 'calendario') aria-current="page" @endif
                   class="inline-flex items-center gap-1.5 lg:gap-1 xl:gap-1.5 px-4 lg:px-3 xl:px-4 py-2 lg:py-1.5 xl:py-2 rounded-full transition-colors
                       {{ $activeTab === 'calendario'
                           ? 'bg-secondary text-dark font-semibold'
                           : 'text-complementary-light hover:bg-white/10 hover:text-light' }}"
                >
                    <svg class="w-4 h-4 lg:w-3.5 lg:h-3.5 xl:w-4 xl:h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    Calendario
                </a>
            </li>

            <li role="presentation">
                <a href="{{ route('web.inicio.estadios') }}"
                   role="tab"
                   aria-selected="{{ $activeTab === 'estadios' ? 'true' : 'false' }}"
                   @if($activeTab === 'estadios') aria-current="page" @endif
                   class="inline-flex items-center gap-1.5 lg:gap-1 xl:gap-1.5 px-4 lg:px-3 xl:px-4 py-2 lg:py-1.5 xl:py-2 rounded-full transition-colors
                       {{ $activeTab === 'estadios'
                           ? 'bg-secondary text-dark font-semibold'
                           : 'text-complementary-light hover:bg-white/10 hover:text-light' }}"
                >
                    <svg class="w-4 h-4 lg:w-3.5 lg:h-3.5 xl:w-4 xl:h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    Estadios
                </a>
            </li>

            <li role="presentation">
                <a href="{{ route('web.inicio.grupos') }}"
                   role="tab"
                   aria-selected="{{ $activeTab === 'grupos' ? 'true' : 'false' }}"
                   @if($activeTab === 'grupos') aria-current="page" @endif
                   class="inline-flex items-center gap-1.5 lg:gap-1 xl:gap-1.5 px-4 lg:px-3 xl:px-4 py-2 lg:py-1.5 xl:py-2 rounded-full transition-colors
                       {{ $activeTab === 'grupos'
                           ? 'bg-secondary text-dark font-semibold'
                           : 'text-complementary-light hover:bg-white/10 hover:text-light' }}"
                >
                    <svg class="w-4 h-4 lg:w-3.5 lg:h-3.5 xl:w-4 xl:h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    Grupos
                </a>
            </li>

            <li role="presentation">
                <a href="{{ route('web.inicio.equipos') }}"
                   role="tab"
                   aria-selected="{{ $activeTab === 'equipos' ? 'true' : 'false' }}"
                   @if($activeTab === 'equipos') aria-current="page" @endif
                   class="inline-flex items-center gap-1.5 lg:gap-1 xl:gap-1.5 px-4 lg:px-3 xl:px-4 py-2 lg:py-1.5 xl:py-2 rounded-full transition-colors
                       {{ $activeTab === 'equipos'
                           ? 'bg-secondary text-dark font-semibold'
                           : 'text-complementary-light hover:bg-white/10 hover:text-light' }}"
                >
                    <svg class="w-4 h-4 lg:w-3.5 lg:h-3.5 xl:w-4 xl:h-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                    Equipos
                </a>
            </li>

        </ul>
    </div>

    </div>
</header>
