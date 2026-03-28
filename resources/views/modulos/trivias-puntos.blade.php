<x-app-layout>
    <x-inicio-header :activeTab="'trivia'" />

    <div class="px-4 py-6 max-w-2xl mx-auto">
        {{-- Header: título, icono, puntos, intento --}}
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-light">{{ $quizLA->quiz->name }}</h1>

            <div class="flex justify-center my-4">
                <span class="icon-[material-symbols--trophy] w-16 h-16 text-light"></span>
            </div>

            <p class="text-3xl font-bold text-secondary">+{{ $quizLA->response_points }} puntos</p>
            <p class="text-lg font-semibold text-light mt-1">
                Intento {{ $quizLA->attempt_number }} de {{ $quizLA->quiz->attempts }}
            </p>
        </div>

        {{-- Stats: Correctas / Incorrectas --}}
        @php
            $correctas = $quizLA->responses->where('is_correct', true)->count();
            $incorrectas = $quizLA->responses->where('is_correct', false)->count();
        @endphp

        <div class="flex justify-center items-center gap-8 mb-8">
            <div class="text-center">
                <span class="icon-[material-symbols--check-circle] w-10 h-10 text-green-500"></span>
                <p class="text-3xl font-bold text-light">{{ $correctas }}</p>
                <p class="text-sm text-complementary-light">Correctas</p>
            </div>
            <div class="w-px h-16 bg-complementary-light"></div>
            <div class="text-center">
                <span class="icon-[material-symbols--cancel] w-10 h-10 text-red-500"></span>
                <p class="text-3xl font-bold text-light">{{ $incorrectas }}</p>
                <p class="text-sm text-complementary-light">Incorrectas</p>
            </div>
        </div>

        {{-- Mis Respuestas --}}
        <h2 class="text-2xl text-center| font-bold text-light mb-4">Mis Respuestas</h2>

        <div class="space-y-0">
            @foreach ($quizLA->responses as $response)
                <div class="py-4 border-b border-secondary/40">
                    <div class="flex items-start gap-3">
                        {{-- Número de pregunta --}}
                        <span class="text-2xl font-bold text-light shrink-0">#{{ $response->question->order }}</span>

                        {{-- Contenido --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-lg font-bold text-light mb-2">{{ $response->question->question }}</p>

                            @if ($response->is_correct)
                                {{-- Respuesta correcta --}}
                                <div class="flex items-center gap-2">
                                    <span class="icon-[material-symbols--check-small] w-5 h-5 text-green-500 shrink-0"></span>
                                    <span class="text-sm text-light">{{ $response->option->option_text }}</span>
                                </div>
                            @else
                                {{-- Respuesta incorrecta del usuario --}}
                                @if ($response->option)
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="icon-[fa-solid--times] w-4 h-4 text-red-500 shrink-0"></span>
                                        <span class="text-sm text-light">{{ $response->option->option_text }}</span>
                                    </div>
                                @endif
                                {{-- Respuesta correcta --}}
                                @if ($response->question->correct_option)
                                    <div class="flex items-center gap-2">
                                        <span class="icon-[material-symbols--check-small] w-5 h-5 text-green-500 shrink-0"></span>
                                        <span class="text-sm text-light">{{ $response->question->correct_option->option_text }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>

                        {{-- Icono resultado --}}
                        <div class="shrink-0">
                            @if ($response->is_correct)
                                <span class="icon-[material-symbols--check-circle] w-8 h-8 text-green-500"></span>
                            @else
                                <span class="icon-[material-symbols--cancel] w-8 h-8 text-red-500"></span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Botón volver a intentar --}}
        @if ($quizLA->retry)
            <div class="mt-8 mb-4">
                <a href="{{ route('web.inicio.trivia') }}"
                   class="flex items-center justify-center gap-2 w-full py-3 rounded-full bg-red-600 hover:bg-red-500 text-light font-semibold text-lg transition-colors">
                    <span class="icon-[material-symbols--refresh] w-5 h-5"></span>
                    Volver a intentar
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
