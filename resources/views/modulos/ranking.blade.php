<x-app-layout>
    <x-inicio-header :activeTab="''" />

    {{-- Pill tabs: ranking / premios --}}
    <div class="px-4 mt-8 mb-4 max-w-lg w-full mx-auto">
        <ul
            class="flex text-sm font-semibold text-center bg-red-600/30 backdrop-blur-sm rounded-full p-1"
            id="navegacion-tabs"
            data-tabs-toggle="#navegacion-tabs-content"
            data-tabs-type="pills"
            data-tabs-active-classes="bg-red-500/80 text-light shadow"
            data-tabs-inactive-classes="text-light/80 hover:text-light"
            role="tablist"
        >
            @php
                $activeTab   = $tabs->firstWhere('is_active', true) ?? $tabs->first();
            @endphp
            @foreach($tabs as $tab)
                <li class="flex-1" role="presentation">
                    <button
                        class="w-full inline-flex items-center justify-center gap-2 p-3 rounded-full transition-colors"
                        id="tab-{{ $tab->code }}-btn"
                        data-tabs-target="#tab-{{ $tab->code }}"
                        type="button"
                        role="tab"
                        aria-controls="tab-{{ $tab->code }}"
                        aria-selected="{{ $activeTab && $tab->id === $activeTab->id ? 'true' : 'false' }}"
                    >
                        {{-- <span class="icon-[material-symbols--leaderboard] w-5 h-5"></span> --}}
                        {{ $tab->name }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Tab content --}}
    <div id="navegacion-tabs-content" class="flex-1 flex flex-col">
        @php
            $tabGrupos         = $tabs->where('id', 1)->first();
            $tabEliminatorias  = $tabs->where('id', 2)->first();
        @endphp

        @php
            $isGruposActive        = $activeTab && $tabGrupos && $activeTab->id === $tabGrupos->id;
            $isEliminatoriasActive = $activeTab && $tabEliminatorias && $activeTab->id === $tabEliminatorias->id;
        @endphp

        @if($tabGrupos && $tabGrupos->is_visible === true)
            <div
                id="tab-{{ $tabGrupos->code }}"
                role="tabpanel"
                aria-labelledby="tab-{{ $tabGrupos->code }}-btn"
                class="{{ $isGruposActive ? 'flex flex-col' : 'hidden flex-col' }} flex-1">
                @include('components.ranking-grupos')
            </div>
        @endif

        @if($tabEliminatorias && $tabEliminatorias->is_visible === true)
            <div
                id="tab-{{ $tabEliminatorias->code }}"
                role="tabpanel"
                aria-labelledby="tab-{{ $tabEliminatorias->code }}-btn"
                class="{{ $isEliminatoriasActive ? 'flex flex-col' : 'hidden flex-col' }} flex-1">
                @include('components.ranking-eliminatorias')
            </div>
        @endif
    </div>
</x-app-layout>
