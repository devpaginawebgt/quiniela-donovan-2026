@props(['quiz'])

@php
    $hasPlayed = !is_null($quiz->last_attempt_number ?? null) || ($quiz->next_attempt_number ?? 1) > 1;
    $expired  = $quiz->expires_at && $quiz->expires_at->isPast();
    $canRetry = (bool) ($quiz->retry ?? false);

    $expiresFormatted = null;
    if ($quiz->expires_at) {
        $timezone = auth()->user()?->country?->timezone ?? config('app.timezone');
        $expiresFormatted = $quiz->expires_at->copy()->timezone($timezone)->locale('es')->translatedFormat('d/m/Y h:i a');
    }
@endphp

<li class="bg-complementary-primary border border-secondary rounded-2xl p-5 text-light flex flex-col">
    <span class="w-max bg-green-600 ms-auto text-light text-sm px-3 py-1 rounded-md mb-2">
        +{{ $quiz->points }} puntos
    </span>

    <div class="flex items-start gap-4 mb-4">
        <span class="icon-[fa-solid--brain] w-12 h-12 text-light shrink-0"></span>
        <div class="min-w-0 flex-1">
            <h2 class="text-xl font-bold truncate">{{ $quiz->name }}</h2>
            @if ($hasPlayed)
                <p class="text-sm text-complementary-light">
                    @if ($expired || !$canRetry)
                        Intento {{ $quiz->last_attempt_number }} de {{ $quiz->attempts }}
                    @else
                        Próximo intento: {{ $quiz->next_attempt_number }} de {{ $quiz->attempts }}
                    @endif
                </p>
                <div class="border-t border-secondary/40 mt-2 pt-2">
                    <p class="font-bold text-light">
                        +{{ $quiz->current_score ?? 0 }} puntos ganados
                    </p>
                </div>
            @else
                <p class="text-sm text-complementary-light">Aún no has jugado</p>
            @endif
        </div>
    </div>

    @if ($expired)
        <p class="flex items-center gap-2 text-sm text-complementary-light mb-4">
            <span class="icon-[fa-solid--lock] w-4 h-4 shrink-0"></span>
            Venció: {{ $expiresFormatted }}
        </p>
    @endif

    @if ($hasPlayed)
        <div class="grid {{ !$canRetry ? 'grid-cols-1' : 'grid-cols-2' }} gap-3">
            <a
                href="{{ route('web.inicio.trivias.last-attempt', $quiz->id) }}"
                class="flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 transition-colors text-light font-semibold py-2.5 rounded-full text-sm lg:text-base"
            >
                <span class="icon-[material-symbols--visibility-outline] w-5 h-5"></span>
                Ver resultado
            </a>
            @if ($canRetry)
                <a
                    href="{{ route('web.inicio.trivias.show', $quiz->id) }}"
                    class="flex items-center justify-center gap-2 bg-green-700 hover:bg-green-600 transition-colors text-light font-semibold py-2.5 rounded-full text-sm lg:text-base"
                >
                    <span class="icon-[material-symbols--refresh] w-5 h-5"></span>
                    Reintentar
                </a>
            @endif
        </div>
    @elseif (!$expired)
        <a
            href="{{ route('web.inicio.trivias.show', $quiz->id) }}"
            class="flex items-center justify-center gap-2 w-full bg-green-700 hover:bg-green-600 transition-colors text-light font-semibold py-2.5 rounded-full text-sm lg:text-base"
        >
            <span class="icon-[material-symbols--play-arrow] w-5 h-5"></span>
            Jugar
        </a>
    @endif

    @if ($hasPlayed && ($quiz->has_answered_correctly ?? false))
        <div class="mt-3 flex items-center gap-2 bg-green-600/10 border border-green-600/40 text-green-500 rounded-xl px-4 py-3">
            <span class="icon-[material-symbols--check-circle] w-5 h-5 shrink-0"></span>
            <p class="text-sm font-semibold">¡Felicidades! Obtuviste el puntaje perfecto.</p>
        </div>
    @endif
</li>
