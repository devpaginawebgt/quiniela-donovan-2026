<input type="hidden" id="user_id" value="{{ Auth::user()->id }}">

@php
    $items = [
        [
            'route' => 'web.inicio.proximos-partidos',
            'match' => 'web.inicio.*',
            'icon'  => 'icon-[material-symbols--home-rounded]',
            'label' => 'Inicio',
            'show'  => true,
        ],
        [
            'route' => 'web.ranking.grupos',
            'match' => 'web.ranking.grupos',
            'icon'  => 'icon-[material-symbols--leaderboard-rounded]',
            'label' => 'Clasificación',
            'show'  => true,
        ],
        [
            'route' => 'web.recompensas',
            'match' => 'web.recompensas',
            'icon'  => 'icon-[material-symbols--trophy-rounded]',
            'label' => 'Recompensas',
            'show'  => true,
        ],
        [
            'route' => 'web.admin.reports.users.index',
            'match' => 'web.admin.*',
            'icon'  => 'icon-[material-symbols--shield-person-rounded]',
            'label' => 'Administrador',
            'show'  => Auth::user()->hasRole('admin'),
        ],
        [
            'route' => 'web.users.perfil',
            'match' => 'web.users.perfil',
            'icon'  => 'icon-[material-symbols--manage-accounts-rounded]',
            'label' => 'Perfil',
            'show'  => true,
        ],
    ];
@endphp

{{-- Bottom Navigation Bar --}}
<nav class="fixed bottom-0 left-0 right-0 z-40 bg-complementary-primary border-t border-secondary">
    <div class="flex justify-around items-center h-16 max-w-lg mx-auto px-4">

        @foreach($items as $item)
            @continue(! $item['show'])

            @php $active = request()->routeIs($item['match']); @endphp

            <a href="{{ route($item['route']) }}"
               class="flex flex-col items-center gap-1 text-xs font-medium transition-colors duration-150 text-complementary-light hover:text-secondary">
                <span @class([
                    'flex items-center rounded-full transition-colors',
                    'bg-secondary text-complementary-primary px-3 py-1' => $active,
                ])>
                    <span class="{{ $item['icon'] }} w-5 h-5 lg:w-6 lg:h-6"></span>
                </span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach

    </div>
</nav>
