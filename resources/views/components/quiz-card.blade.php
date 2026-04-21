@props(['quiz'])

@php
    $hasPlayed = !is_null($quiz->last_attempt_number ?? null) || ($quiz->next_attempt_number ?? 1) > 1;
    $canRetry = !empty($quiz->retry);
@endphp

<li class="bg-complementary-primary border border-secondary rounded-2xl p-5 text-light flex flex-col">
    <span class="w-max bg-green-600 ms-auto text-light text-sm px-3 py-1 rounded-md mb-2">
        +{{ $quiz->points }} puntos
    </span>

    <div class="flex items-center gap-4 mb-4">
        <span class="icon-[fa-solid--brain] w-12 h-12 text-light shrink-0"></span>
        <div class="min-w-0">
            <h2 class="text-xl font-bold truncate">{{ $quiz->name }}</h2>
            @if ($hasPlayed)
                <p class="text-sm text-complementary-light">
                    Próximo intento: {{ $quiz->next_attempt_number }} de {{ $quiz->attempts }}
                </p>
                <p class="text-sm text-complementary-light">
                    Puntos ganados: {{ $quiz->current_score ?? 0 }}
                </p>
            @else
                <p class="text-sm text-complementary-light">Aún no has jugado</p>
            @endif
        </div>
    </div>

    @if ($hasPlayed)
        <div class="grid grid-cols-2 gap-3">
            <a
                href="{{ route('web.inicio.trivias.last-attempt', $quiz->id) }}"
                class="flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 transition-colors text-light font-semibold py-2.5 rounded-full text-sm lg:text-base"
            >
                <span class="icon-[material-symbols--visibility-outline] w-5 h-5"></span>
                Ver resultado
            </a>            
            <a
                href="{{ route('web.inicio.trivias.show', $quiz->id) }}"
                class="flex items-center justify-center gap-2 bg-green-700 hover:bg-green-600 transition-colors text-light font-semibold py-2.5 rounded-full text-sm lg:text-base @if (!$canRetry) pointer-events-none opacity-80 @endif"
                @if (!$canRetry) aria-disabled="true" @endif
                @if (!$canRetry) tabindex="-1" @endif
            >   
                <span class="icon-[material-symbols--refresh] w-5 h-5"></span>
                Reintentar
            </a>
        </div>
    @else
        <a
            href="{{ route('web.inicio.trivias.show', $quiz->id) }}"
            class="flex items-center justify-center gap-2 w-full bg-green-700 hover:bg-green-600 transition-colors text-light font-semibold py-2.5 rounded-full text-sm lg:text-base"
        >
            <span class="icon-[material-symbols--play-arrow] w-5 h-5"></span>
            Jugar
        </a>
    @endif
</li>
