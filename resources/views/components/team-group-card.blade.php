@props(['equipo'])

<div
    class="team-group-card bg-complementary-primary border border-secondary rounded-3xl overflow-hidden cursor-pointer"
    data-nombre="{{ $equipo->nombre }}"
    aria-expanded="false"
>
    {{-- Top: flag + name --}}
    <div class="flex items-center gap-4 p-4 pb-3">
        <img
            src="{{ $equipo->imagen }}"
            alt="{{ $equipo->nombre }}"
            class="h-16 w-24 object-cover rounded-2xl shrink-0 shadow-md"
        >
        <span class="flex-1 font-bold text-right leading-tight text-light">{{ $equipo->nombre }}</span>
    </div>

    {{-- Always visible: "Estadísticas" + chevron --}}
    <div class="flex items-center justify-between px-4 pb-3">
        <span class="font-semibold text-light text-sm">Estadísticas</span>
        <svg
            class="team-group-card-chevron w-4 h-4 text-complementary-light shrink-0 transition-transform duration-300"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="2.5" stroke="currentColor"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </div>

    {{-- Collapsible stats panel --}}
    <div class="team-group-card-panel max-h-0 overflow-hidden transition-[max-height] duration-300 ease-in-out">
        <div class="px-4 pb-4">
            <div class="border-t border-complementary-light/20 pt-3">
                <div class="flex flex-col">
                    @foreach([
                        ['PJ', $equipo->partidos_jugados],
                        ['PG', $equipo->partidos_ganados],
                        ['PE', $equipo->partidos_empatados],
                        ['PP', $equipo->partidos_perdidos],
                        ['GF', $equipo->goles_favor],
                        ['GC', $equipo->goles_contra],
                    ] as [$label, $value])
                    <div class="flex justify-between items-center py-2 border-b border-complementary-light/10">
                        <span class="font-semibold text-sm text-light">{{ $label }}</span>
                        <span class="text-sm text-light">{{ $value }}</span>
                    </div>
                    @endforeach
                    <div class="flex justify-between items-center py-2">
                        <span class="font-bold text-light">Puntos</span>
                        <span class="font-bold text-light">{{ $equipo->puntos }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
