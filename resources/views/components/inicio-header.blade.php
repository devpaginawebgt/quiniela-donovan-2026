@props(['activeTab' => 'proximos'])

@php
    $user = Auth::user();

    $tabs = [
        [
            'key'   => 'proximos',
            'route' => 'web.inicio.proximos-partidos',
            'icon'  => 'icon-[material-symbols--schedule-rounded]',
            'label' => 'Partidos Próximos',
            'show'  => $user->can('read pools'),
        ],
        [
            'key'   => 'pronosticos',
            'route' => 'web.inicio.mis-predicciones',
            'icon'  => 'icon-[material-symbols--assignment-rounded]',
            'label' => 'Mis Pronósticos',
            'show'  => $user->can('read pools results'),
        ],
        [
            'key'   => 'trivia',
            'route' => 'web.inicio.trivias.index',
            'icon'  => 'icon-[fa-solid--brain]',
            'label' => 'Trivias',
            'show'  => $user->can('read quizzes'),
        ],
        [
            'key'   => 'calendario',
            'route' => 'web.inicio.calendario',
            'icon'  => 'icon-[material-symbols--calendar-month-rounded]',
            'label' => 'Calendario',
            'show'  => $user->can('read calendar'),
        ],
        [
            'key'   => 'estadios',
            'route' => 'web.inicio.estadios',
            'icon'  => 'icon-[material-symbols--stadium-rounded]',
            'label' => 'Estadios',
            'show'  => $user->can('read stadiums'),
        ],
        [
            'key'   => 'grupos',
            'route' => 'web.inicio.grupos',
            'icon'  => 'icon-[material-symbols--grid-view-rounded]',
            'label' => 'Grupos',
            'show'  => $user->can('read groups'),
        ],
        [
            'key'   => 'equipos',
            'route' => 'web.inicio.equipos',
            'icon'  => 'icon-[material-symbols--groups-rounded]',
            'label' => 'Equipos',
            'show'  => $user->can('read teams'),
        ],
    ];
@endphp

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

                @foreach($tabs as $tab)
                    @continue(! $tab['show'])

                    @php $active = $activeTab === $tab['key']; @endphp

                    <li role="presentation">
                        <a href="{{ route($tab['route']) }}"
                           role="tab"
                           aria-selected="{{ $active ? 'true' : 'false' }}"
                           @if($active) aria-current="page" @endif
                           @class([
                               'inline-flex items-center gap-1.5 lg:gap-1 xl:gap-1.5 px-4 lg:px-3 xl:px-4 py-2 lg:py-1.5 xl:py-2 rounded-full transition-colors',
                               'bg-secondary text-dark font-semibold' => $active,
                               'text-complementary-light hover:bg-white/10 hover:text-light' => ! $active,
                           ])
                        >
                            <span class="{{ $tab['icon'] }} w-4 h-4 lg:w-3.5 lg:h-3.5 xl:w-4 xl:h-4 shrink-0"></span>
                            {{ $tab['label'] }}
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>

    </div>
</header>
