@props(['partido'])

@php
    $tieneResultado = $partido->result !== null;
    $golesLocal = $tieneResultado ? (int) $partido->result->goles_equipo_1 : null;
    $golesVisitante = $tieneResultado ? (int) $partido->result->goles_equipo_2 : null;
    $localGana = $tieneResultado && $golesLocal > $golesVisitante;
    $visitanteGana = $tieneResultado && $golesVisitante > $golesLocal;

    $localLabel = $partido->local_slot_label
        ?? ($partido->localFeeder ? 'Ganador M' . $partido->localFeeder->bracket_position : 'Por definir');
    $visitanteLabel = $partido->visitor_slot_label
        ?? ($partido->visitorFeeder ? 'Ganador M' . $partido->visitorFeeder->bracket_position : 'Por definir');
@endphp

<div class="bg-complementary-primary border border-secondary rounded-3xl overflow-hidden w-52 shadow-lg shadow-zinc-950">
    <div class="flex items-center gap-2 px-4 py-2.5">
        @if ($partido->teamOne)
            <img src="{{ asset($partido->teamOne->imagen) }}"
                 alt="{{ $partido->teamOne->codigo_iso }}"
                 class="w-7 h-5 object-cover rounded-sm shadow-sm">
            <span class="flex-1 text-sm truncate {{ $localGana ? 'text-light font-semibold' : 'text-slate-300' }}">
                {{ $partido->teamOne->codigo_iso }}
            </span>
        @else
            <span class="w-7 h-5 bg-complementary-light/10 rounded-sm"></span>
            <span class="flex-1 text-xs italic text-complementary-light/70 truncate">
                {{ $localLabel }}
            </span>
        @endif
        <span class="text-sm font-bold {{ $localGana ? 'text-secondary' : 'text-slate-300' }}">
            {{ $tieneResultado ? $golesLocal : '—' }}
        </span>
    </div>
    <hr class="border-complementary-light/30">
    <div class="flex items-center gap-2 px-4 py-2.5">
        @if ($partido->teamTwo)
            <img src="{{ asset($partido->teamTwo->imagen) }}"
                 alt="{{ $partido->teamTwo->codigo_iso }}"
                 class="w-7 h-5 object-cover rounded-sm shadow-sm">
            <span class="flex-1 text-sm truncate {{ $visitanteGana ? 'text-light font-semibold' : 'text-slate-300' }}">
                {{ $partido->teamTwo->codigo_iso }}
            </span>
        @else
            <span class="w-7 h-5 bg-complementary-light/10 rounded-sm"></span>
            <span class="flex-1 text-xs italic text-complementary-light/70 truncate">
                {{ $visitanteLabel }}
            </span>
        @endif
        <span class="text-sm font-bold {{ $visitanteGana ? 'text-secondary' : 'text-slate-300' }}">
            {{ $tieneResultado ? $golesVisitante : '—' }}
        </span>
    </div>
</div>
