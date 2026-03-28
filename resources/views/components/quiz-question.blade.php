@props(['question', 'index', 'total', 'hidden' => false])

@php
    $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
@endphp

<div class="quiz-question {{ $hidden ? 'hidden' : '' }}"
     data-id="{{ $question['id'] }}"
     data-correct-option-id="{{ $question['correct_option']['id'] }}"
     data-points="{{ $question['points'] }}"
     data-success-message="{{ $question['success_message'] ?? '¡Correcto!' }}"
     data-fail-message="{{ $question['fail_message'] ?? 'Incorrecto. Intenta la siguiente.' }}">

    {{-- Pregunta --}}
    <div class="flex items-start gap-3 mb-6">
        <span class="icon-[fa-solid--quote-left] w-8 h-8 text-secondary shrink-0 mt-1"></span>
        <h2 class="text-xl font-bold text-light">{{ $question['question'] }}</h2>
    </div>

    {{-- Opciones --}}
    <div class="space-y-3 mb-6">
        @foreach ($question['options'] as $i => $option)
            <button type="button"
                    class="quiz-option w-full flex items-center gap-3 px-4 py-3.5 rounded-xl border-2 border-complementary-light/30 bg-white/5 text-light transition-all duration-200 hover:border-secondary hover:bg-secondary/5 group"
                    data-question-id="{{ $question['id'] }}"
                    data-option-id="{{ $option['id'] }}">
                <span class="quiz-option-letter w-8 h-8 rounded-full bg-complementary-light/20 flex items-center justify-center text-sm font-bold text-light shrink-0 transition-colors duration-200">
                    {{ $letters[$i] ?? '' }}
                </span>
                <span class="flex-1 text-left font-medium">{{ $option['option_text'] }}</span>
                <span class="quiz-option-icon icon-[material-symbols--check-circle] w-6 h-6 text-secondary opacity-0 group-hover:opacity-100 transition-opacity shrink-0"></span>
            </button>
        @endforeach
    </div>

    {{-- Feedback --}}
    <div class="quiz-feedback hidden rounded-lg border px-4 py-3 mb-4 items-center gap-3">
        <span class="quiz-feedback-icon w-6 h-6 shrink-0"></span>
        <span class="quiz-feedback-text font-semibold text-sm"></span>
    </div>
</div>
