@props(['partidos'])

<div class="flex flex-col items-center gap-2 pt-36">
    <h2 class="text-sm font-bold uppercase tracking-wider text-light mb-2">
        Cuartos
    </h2>

    <div class="flex flex-col justify-around h-full gap-74">
        @foreach ($partidos as $partido)
            <x-bracket.match-card :partido="$partido" />
        @endforeach
    </div>
</div>

{{-- Conectores hacia Semis (2 pares, height brazo 7rem) --}}
<div class="flex flex-col justify-around h-full pt-56 gap-94">
    @for ($i = 0; $i < 2; $i++)
        <div class="flex items-center">
            <div class="flex flex-col">
                <div class="w-6 border-t-2 border-r-2 border-complementary-light/40 rounded-tr" style="height: 11.8rem;"></div>
                <div class="w-6 border-b-2 border-r-2 border-complementary-light/40 rounded-br" style="height: 11.8rem;"></div>
            </div>
            <div class="w-6 border-t-2 border-complementary-light/40"></div>
        </div>
    @endfor
</div>
