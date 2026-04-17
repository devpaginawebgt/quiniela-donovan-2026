@props(['partidos'])

<div class="flex flex-col items-center gap-2 pt-84">
    <h2 class="text-sm font-bold uppercase tracking-wider text-light mb-2">
        Semis
    </h2>

    <div class="flex flex-col justify-around h-full gap-168">
        @foreach ($partidos as $partido)
            <x-bracket.match-card :partido="$partido" />
        @endforeach
    </div>
</div>

{{-- Conector hacia Final (1 par, height brazo 13rem) --}}
<div class="flex flex-col justify-around h-full py-8 pt-103">
    <div class="flex items-center">
        <div class="flex flex-col">
            <div class="w-6 border-t-2 border-r-2 border-complementary-light/40 rounded-tr" style="height: 23.7rem;"></div>
            <div class="w-6 border-b-2 border-r-2 border-complementary-light/40 rounded-br" style="height: 23.7rem;"></div>
        </div>
        <div class="w-6 border-t-2 border-complementary-light/40"></div>
    </div>
</div>
