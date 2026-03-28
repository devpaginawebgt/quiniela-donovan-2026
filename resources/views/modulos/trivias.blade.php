<x-app-layout>
    <x-inicio-header :activeTab="'trivia'" />

    @if (!$quiz)
        <div class="px-4 py-12 text-center">
            <p class="text-lg text-complementary-light">No hay una trivia activa en este momento.</p>
        </div>
    @else
        <div class="px-4 py-4 max-w-2xl mx-auto"
             id="trivia-container"
             data-quiz-id="{{ $quiz['id'] }}"
             data-total="{{ count($quiz['questions']) }}"
             data-store-url="{{ route('web.inicio.trivias.store') }}"
             data-results-url="{{ route('web.inicio.trivia-puntos') }}">

            {{-- Top badges --}}
            <div class="flex justify-between items-center mb-3">
                <span class="bg-red-600/70 text-light text-sm font-bold px-3 py-1 rounded-lg">
                    Intento {{ $quiz['attempt'] }}
                </span>
                <span id="points-badge" class="bg-red-600/70 text-light text-sm font-bold px-3 py-1 rounded-lg">
                    0 puntos
                </span>
            </div>

            {{-- Progress --}}
            <div class="flex justify-between items-center text-sm text-complementary-light mb-1">
                <span id="progress-label">Pregunta 1 de {{ count($quiz['questions']) }}</span>
                <span id="progress-percent">0%</span>
            </div>
            <div class="w-full h-1.5 bg-complementary-light/30 rounded-full mb-6">
                <div id="progress-bar" class="h-full bg-secondary rounded-full transition-all duration-300" style="width: 0%"></div>
            </div>

            {{-- Questions (rendered via Blade, only first visible) --}}
            @foreach ($quiz['questions'] as $index => $question)
                <x-quiz-question
                    :question="$question"
                    :index="$index"
                    :total="count($quiz['questions'])"
                    :hidden="$index !== 0"
                />
            @endforeach

            {{-- Action button --}}
            <button id="btn-next"
                class="w-full py-3.5 rounded-full font-bold text-lg flex items-center justify-center gap-2 transition-all duration-200 bg-secondary/30 text-light/40 cursor-not-allowed"
                disabled>
                <span class="icon-[material-symbols--arrow-forward] w-5 h-5"></span>
                <span id="btn-next-text">Siguiente pregunta</span>
            </button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                // Contenedor
                const container = document.getElementById('trivia-container');

                // Información de la quiz
                const quizId = parseInt(container.dataset.quizId);
                const total = parseInt(container.dataset.total);
                const storeUrl = container.dataset.storeUrl;
                const resultsUrl = container.dataset.resultsUrl;

                // Preguntas
                const questionEls = container.querySelectorAll('.quiz-question');

                // Badge de puntos
                const pointsBadge = document.getElementById('points-badge');

                // Barra de progreso
                const progressLabel = document.getElementById('progress-label');
                const progressPercent = document.getElementById('progress-percent');
                const progressBar = document.getElementById('progress-bar');

                // Botón de acción
                const btnNext = document.getElementById('btn-next');
                const btnNextText = document.getElementById('btn-next-text');

                let currentIndex = 0;
                let totalPoints = 0;
                const answers = [];

                // Update percentage bar
                function updateProgress() {
                    const pct = Math.round((currentIndex / total) * 100);
                    progressLabel.textContent = `Pregunta ${currentIndex + 1} de ${total}`;
                    progressPercent.textContent = `${pct}%`;
                    progressBar.style.width = `${pct}%`;
                }

                // Reset action button
                function resetButton() {
                    btnNext.disabled = true;
                    btnNext.className = 'w-full py-3.5 rounded-full font-bold text-lg flex items-center justify-center gap-2 transition-all duration-200 bg-secondary/30 text-light/40 cursor-not-allowed';
                    btnNextText.textContent = currentIndex < total - 1 ? 'Siguiente pregunta' : 'Ver resultados';
                }

                // Show feedback
                function showFeedback(questionEl, isCorrect) {
                    const feedback = questionEl.querySelector('.quiz-feedback');
                    const icon = questionEl.querySelector('.quiz-feedback-icon');
                    const text = questionEl.querySelector('.quiz-feedback-text');

                    const message = isCorrect
                        ? questionEl.dataset.successMessage
                        : questionEl.dataset.failMessage;

                    feedback.classList.remove('hidden');
                    feedback.classList.add('flex');

                    if (isCorrect) {
                        feedback.classList.add('bg-green-500/15', 'border-green-500/40');
                        icon.className = 'quiz-feedback-icon icon-[material-symbols--check-circle] w-6 h-6 text-green-500 shrink-0';
                        text.className = 'quiz-feedback-text font-semibold text-sm text-green-400';
                    } else {
                        feedback.classList.add('bg-red-500/15', 'border-red-500/40');
                        icon.className = 'quiz-feedback-icon icon-[material-symbols--cancel] w-6 h-6 text-red-500 shrink-0';
                        text.className = 'quiz-feedback-text font-semibold text-sm text-red-400';
                    }

                    text.textContent = message;
                }

                // Option click handler (delegated)
                container.addEventListener('click', function (e) {
                    const optionBtn = e.target.closest('.quiz-option');
                    if (!optionBtn) return;

                    const questionEl = optionBtn.closest('.quiz-question');
                    if (questionEl.dataset.answered === '1') return;

                    questionEl.dataset.answered = '1';

                    const questionId = parseInt(optionBtn.dataset.questionId);
                    const optionId = parseInt(optionBtn.dataset.optionId);
                    const correctOptionId = parseInt(questionEl.dataset.correctOptionId);
                    const isCorrect = optionId === correctOptionId;
                    const points = parseInt(questionEl.dataset.points);

                    // Save answer
                    answers.push({ question_id: questionId, selected_value: optionId });

                    // Disable all options in this question
                    const allOptions = questionEl.querySelectorAll('.quiz-option');

                    allOptions.forEach(function (btn) {
                        btn.classList.remove('hover:border-secondary', 'hover:bg-secondary/5', 'group');
                        btn.style.pointerEvents = 'none';

                        const icon = btn.querySelector('.quiz-option-icon');
                        const letter = btn.querySelector('.quiz-option-letter');
                        icon.classList.remove('group-hover:opacity-100');
                        icon.classList.add('opacity-0');

                        // Mark the correct option green (border, bg, icon, letter)
                        if (parseInt(btn.dataset.optionId) === correctOptionId) {
                            btn.classList.remove('border-complementary-light/30', 'bg-white/5');
                            btn.classList.add('border-green-500', 'bg-green-500/10');
                            icon.className = 'quiz-option-icon icon-[material-symbols--check-circle] w-6 h-6 text-green-500 opacity-100 shrink-0';
                            letter.classList.remove('bg-complementary-light/20');
                            letter.classList.add('bg-green-600/50', 'text-dark');
                        }
                    });

                    if (isCorrect) {
                        totalPoints += points;
                        pointsBadge.textContent = `${totalPoints} punto${totalPoints !== 1 ? 's' : ''}`;
                        pointsBadge.classList.remove('bg-red-600/70');
                        pointsBadge.classList.add('bg-secondary', 'text-dark');

                        btnNext.disabled = false;
                        btnNext.className = 'w-full py-3.5 rounded-full font-bold text-lg flex items-center justify-center gap-2 transition-all duration-200 bg-secondary text-dark hover:bg-secondary/90';
                    } else {
                        // Mark selected as red (border, bg, icon, letter)
                        optionBtn.classList.remove('border-complementary-light/30', 'bg-white/5', 'border-green-500', 'bg-green-500/10');
                        optionBtn.classList.add('border-red-500', 'bg-red-500/10');
                        const selectedIcon = optionBtn.querySelector('.quiz-option-icon');
                        selectedIcon.className = 'quiz-option-icon icon-[material-symbols--cancel] w-6 h-6 text-red-500 opacity-100 shrink-0';
                        const selectedLetter = optionBtn.querySelector('.quiz-option-letter');
                        selectedLetter.classList.remove('bg-complementary-light/20', 'bg-green-600/70');
                        selectedLetter.classList.add('bg-red-600/50', 'text-dark');

                        btnNext.disabled = false;
                        btnNext.className = 'w-full py-3.5 rounded-full font-bold text-lg flex items-center justify-center gap-2 transition-all duration-200 bg-red-600 text-light hover:bg-red-500';
                        btnNextText.textContent = currentIndex < total - 1 ? 'Continuar' : 'Ver resultados';
                    }

                    showFeedback(questionEl, isCorrect);
                });

                // Next button
                btnNext.addEventListener('click', function () {
                    if (btnNext.disabled) return;

                    currentIndex++;

                    if (currentIndex < total) {
                        // Hide current, show next
                        questionEls.forEach(function (el, i) {
                            el.classList.toggle('hidden', i !== currentIndex);
                        });
                        updateProgress();
                        resetButton();
                    } else {
                        submitQuiz();
                    }
                });

                function submitQuiz() {
                    btnNext.disabled = true;
                    btnNext.className = 'w-full py-3.5 rounded-full font-bold text-lg flex items-center justify-center gap-2 transition-all duration-200 bg-secondary/30 text-light/40 cursor-not-allowed';
                    btnNextText.textContent = 'Guardando predicción...';

                    window.axios.post(storeUrl, {
                        quiz_id: quizId,
                        answers: answers
                    }).then(function () {
                        window.location.href = resultsUrl;
                    }).catch(function (err) {
                        const msg = err.response?.data?.message || 'Ocurrió un error al enviar la trivia.';
                        const currentQ = questionEls[currentIndex - 1];
                        const feedback = currentQ.querySelector('.quiz-feedback');
                        const icon = currentQ.querySelector('.quiz-feedback-icon');
                        const text = currentQ.querySelector('.quiz-feedback-text');

                        feedback.classList.remove('hidden', 'bg-green-500/15', 'border-green-500/40');
                        feedback.classList.add('flex', 'bg-red-500/15', 'border-red-500/40');
                        icon.className = 'quiz-feedback-icon icon-[material-symbols--cancel] w-6 h-6 text-red-500 shrink-0';
                        text.className = 'quiz-feedback-text font-semibold text-sm text-red-400';
                        text.textContent = msg;

                        btnNext.disabled = false;
                        btnNext.className = 'w-full py-3.5 rounded-full font-bold text-lg flex items-center justify-center gap-2 transition-all duration-200 bg-secondary text-dark hover:bg-secondary/90';
                        btnNextText.textContent = 'Reintentar envío';
                    });
                }

                // Init
                updateProgress();
            });
        </script>
    @endif
</x-app-layout>
