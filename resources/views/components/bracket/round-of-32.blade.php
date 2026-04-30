@props(['partidos', 'jornada' => null])

<div class="flex flex-col items-center gap-2">
    <h2 @if($jornada) id="jornada-{{ $jornada->id }}" @endif
        data-active="{{ $jornada?->is_current ? '1' : '0' }}"
        class="text-sm font-bold uppercase tracking-wider text-light mb-2">
        16avos
    </h2>

    <div class="flex flex-col justify-around h-full" style="gap: 0.75rem;">
        @foreach ($partidos as $partido)
            <x-bracket.match-card :partido="$partido" />
        @endforeach
    </div>
</div>

{{-- Conectores hacia Octavos (8 pares, height brazo 3rem) --}}
<div class="flex flex-col justify-around h-full pt-20 gap-23.5">
    @for ($i = 0; $i < 8; $i++)
        @php
            $partidoTop = $partidos->firstWhere('bracket_position', $i * 2 + 1);
            $partidoBottom = $partidos->firstWhere('bracket_position', $i * 2 + 2);

            $topFinished = $partidoTop?->status === 2;
            $botFinished = $partidoBottom?->status === 2;
            $anyFinished = $topFinished || $botFinished;
        @endphp
        <div class="flex items-center">
            <div class="flex flex-col shadow-lg">
                <div class="w-6 border-t-2 border-r-2 rounded-tr {{ $topFinished ? 'border-light/80' : 'border-complementary-light/40' }}"
                     style="height: 3rem;"></div>
                <div class="w-6 border-b-2 border-r-2 rounded-br {{ $botFinished ? 'border-light/80' : 'border-complementary-light/40' }}"
                     style="height: 3rem;"></div>
            </div>
            <div class="w-6 border-t-2 {{ $anyFinished ? 'border-light/80' : 'border-complementary-light/40' }}"></div>
        </div>
    @endfor
</div>
