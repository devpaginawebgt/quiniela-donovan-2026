<x-embed-layout>
    <div class="min-h-screen p-4 overflow-x-auto">
        {{-- Bracket principal --}}
        <div class="flex items-start gap-6" style="min-width: max-content;">
            <x-bracket.group-standings :grupos="$grupos" />
            <x-bracket.round-of-32   :partidos="$rondas[4] ?? collect()" />
            <x-bracket.round-of-16   :partidos="$rondas[5] ?? collect()" />
            <x-bracket.quarterfinals :partidos="$rondas[6] ?? collect()" />
            <x-bracket.semifinals    :partidos="$rondas[7] ?? collect()" />
            <x-bracket.final
                :tercer="($rondas[8] ?? collect())->first()"
                :partido="($rondas[9] ?? collect())->first()"
            />
        </div>
    </div>
</x-embed-layout>
