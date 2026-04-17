@props(['partido', 'tercer'])

<div class="flex flex-col items-center gap-28 pt-175">    
    <div class="flex flex-col items-center">
        <h2 class="text-sm font-bold uppercase tracking-wider text-secondary mb-2">
            Final
        </h2>
    
        <div class="flex flex-col justify-around h-full">
            @if ($partido)
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
                <div class="bg-complementary-primary border border-secondary rounded-3xl overflow-hidden w-64 shadow-lg">
                    <div class="flex items-center gap-2 px-6 py-4">
                        @if ($partido->teamOne)
                            <img src="{{ asset($partido->teamOne->imagen) }}"
                                alt="{{ $partido->teamOne->codigo_iso }}"
                                class="w-10 h-7 object-cover rounded-sm shadow-sm">
                            <span class="flex-1 text-base truncate {{ $localGana ? 'text-light font-semibold' : 'text-complementary-light' }}">
                                {{ $partido->teamOne->nombre }}
                            </span>
                        @else
                            <span class="w-10 h-7 bg-complementary-light/10 rounded-sm"></span>
                            <span class="flex-1 text-sm italic text-complementary-light/70 truncate">
                                {{ $localLabel }}
                            </span>
                        @endif
                        <span class="text-base font-bold {{ $localGana ? 'text-secondary' : 'text-complementary-light' }}">
                            {{ $tieneResultado ? $golesLocal : '—' }}
                        </span>
                    </div>
                    <hr class="border-complementary-light/30">
                    <div class="flex items-center gap-2 px-6 py-4">
                        @if ($partido->teamTwo)
                            <img src="{{ asset($partido->teamTwo->imagen) }}"
                                alt="{{ $partido->teamTwo->codigo_iso }}"
                                class="w-10 h-7 object-cover rounded-sm shadow-sm">
                            <span class="flex-1 text-base truncate {{ $visitanteGana ? 'text-light font-semibold' : 'text-complementary-light' }}">
                                {{ $partido->teamTwo->nombre }}
                            </span>
                        @else
                            <span class="w-10 h-7 bg-complementary-light/10 rounded-sm"></span>
                            <span class="flex-1 text-sm italic text-complementary-light/70 truncate">
                                {{ $visitanteLabel }}
                            </span>
                        @endif
                        <span class="text-base font-bold {{ $visitanteGana ? 'text-secondary' : 'text-complementary-light' }}">
                            {{ $tieneResultado ? $golesVisitante : '—' }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="flex flex-col items-center gap-2">
        <h2 class="text-sm font-bold uppercase tracking-wider text-light mb-2">
            3er lugar
        </h2>
    
        @if ($tercer)
            <x-bracket.match-card :partido="$tercer" />
        @endif
    </div>
</div>

