<?php

namespace App\Http\Services;

use App\Models\Quiz;
use App\Models\QuizUser;
use Illuminate\Database\Eloquent\Collection;

class QuizUserService {

    public function getLastAttempts() {

        $user = request()->user();

        return $user->quizzes()
            ->latest()
            ->get()
            ->unique('quiz_id');
    }

    public function getLastAttemptSimple(string|int $quiz_id)
    {
        $user = request()->user();

        return $user->quizzes()
            ->with('responses.question', 'responses.option')
            ->where('quiz_id', $quiz_id)
            ->latest()
            ->first();
    }

    public function getLastAttempt(string|int $quiz_id)
    {
        $user = request()->user();

        return $user->quizzes()
            ->where('quiz_id', $quiz_id)
            ->latest()
            ->first();
    }

    public function getBestAttempts()
    {
        $user = request()->user();

        return $user->quizzes()
            ->orderBy('response_points', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('quiz_id');
    }

    public function getBestAttempt(string|int $quiz_id)
    {
        $user = request()->user();

        return $user->quizzes()
            ->where('quiz_id', $quiz_id)
            ->orderBy('response_points', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function getQuizUserInfo(Quiz $quiz, QuizUser|null $last_attempt, QuizUser|null $best_attempt)
    {
        $is_active = empty($quiz->expires_at) || $quiz->expires_at->isFuture();

        $next_attempt_number = $last_attempt ? $last_attempt->attempt_number + 1 : 1;

        $hasAnsweredCorrectly = $best_attempt ? $best_attempt->all_correct : false;

        $quiz->retry = $next_attempt_number <= $quiz->attempts && !$hasAnsweredCorrectly && $is_active;

        $quiz->current_score = $best_attempt ? $best_attempt->response_points : 0;

        $quiz->next_attempt_number = $next_attempt_number;

        $quiz->has_answered_correctly = $hasAnsweredCorrectly;

        $quiz->last_attempt_number = $last_attempt?->attempt_number;

        return $quiz;
    }

    public function getQuizLastAttemptInfo(Quiz $quiz, QuizUser|null $last_attempt, QuizUser|null $best_attempt)
    {
        $is_active = empty($quiz->expires_at) || $quiz->expires_at->isFuture();

        $next_attempt_number = $last_attempt ? $last_attempt->attempt_number + 1 : 1;

        $hasAnsweredCorrectly = $best_attempt ? $best_attempt->all_correct : false;

        $last_attempt->retry = $next_attempt_number <= $quiz->attempts && !$hasAnsweredCorrectly && $is_active;

        $last_attempt->current_score = $best_attempt ? $best_attempt->response_points : 0;

        $last_attempt->next_attempt_number = $next_attempt_number;

        $last_attempt->has_answered_correctly = $hasAnsweredCorrectly;

        return $last_attempt;
    }

    public function showQuizzes(Collection $quizzes)
    {
        $last_attempts = $this->getLastAttempts();

        $best_attempts = $this->getBestAttempts();

        return $quizzes->map(function($quiz) use($last_attempts, $best_attempts) {

            $last_attempt = $last_attempts->firstWhere('quiz_id', $quiz->id);

            $best_attempt = $best_attempts->firstWhere('quiz_id', $quiz->id);

            return $this->getQuizUserInfo($quiz, $last_attempt, $best_attempt);

        });
    }

    public function showQuiz(Quiz $quiz)
    {
        $last_attempt = $this->getLastAttemptSimple($quiz->id);

        $best_attempt = $this->getBestAttempt($quiz->id);

        return $this->getQuizUserInfo($quiz, $last_attempt, $best_attempt);
    }

    public function validateAttempt(Quiz $quiz, array $data): array
    {
        $quizQuestionIds = $quiz->questions->pluck('id');

        $answerQuestionIds = collect($data['answers'])->pluck('question_id');

        // No deben haber questions repetidas en answers
        if ($answerQuestionIds->count() !== $answerQuestionIds->unique()->count()) {
            return ['error' => true, 'message' => 'No puedes enviar respuestas duplicadas para la misma pregunta.'];
        }

        // Todas las questions de la trivia deben venir en answers
        $missing = $quizQuestionIds->diff($answerQuestionIds);

        if ($missing->isNotEmpty()) {
            return ['error' => true, 'message' => 'Debes responder todas las preguntas de la trivia.'];
        }

        // Todas las questions en answers deben pertenecer a la trivia
        $extra = $answerQuestionIds->diff($quizQuestionIds);

        if ($extra->isNotEmpty()) {
            return ['error' => true, 'message' => 'Una o más preguntas no pertenecen a esta trivia.'];
        }

        // selected_value debe ser una option válida de la question
        $questionsById = $quiz->questions->keyBy('id');

        foreach ($data['answers'] as $answer) {

            $question = $questionsById->get($answer['question_id']);

            $validOptionIds = $question->options->pluck('id');

            if (!$validOptionIds->contains($answer['selected_value'])) {
                return ['error' => true, 'message' => 'Una opción seleccionada no pertenece a la pregunta de la trivia.'];
            }
        }

        return ['error' => false, 'message' => ''];
    }

    public function createAttempt(Quiz $quiz, array $answers, int $attemptNumber): QuizUSer
    {
        $user = request()->user();

        // Creamos las quiz user y preparamos la suma de puntos

        $quizUser = QuizUser::create([
            'quiz_id'         => $quiz->id,
            'user_id'         => $user->id,
            'attempt_number'  => $attemptNumber,
            'response_points' => 0,
        ]);

        $totalPoints = 0;

        // Obtenemos mapeamos la collection para que el index sea el id

        $questionsById = $quiz->questions->keyBy('id');

        foreach ($answers as $answer) {

            $question = $questionsById->get($answer['question_id']);

            $option = $question->options->firstWhere('id', $answer['selected_value']);

            // Validamos que la option seleccionada sea la correcta

            $pointsReceived = $option->is_correct ? $question->points : 0;

            $quizUser->responses()->create([
                'quiz_question_id' => $answer['question_id'],
                'quiz_option_id'   => $answer['selected_value'],
                'is_correct'       => $option->is_correct,
                'points_received'  => $pointsReceived,
            ]);

            $totalPoints += $pointsReceived;
        }

        $all_correct = $quizUser->responses->every(fn ($r) => $r->is_correct);

        $quizUser->update([
            'all_correct' => $all_correct,
            'response_points' => $totalPoints,
        ]);

        $this->updateUserQuizPoints();

        return $quizUser;

    }

    public function updateUserQuizPoints()
    {
        $user = request()->user();

        $quizzes = $user->quizzes()
            ->with('quiz')
            ->orderBy('response_points', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('quiz_id');

        $user->puntos_trivias_grupos = $quizzes->where('quiz.ranking_tab_id', 1)->sum('response_points');
        $user->puntos_trivias        = $quizzes->where('quiz.ranking_tab_id', 2)->sum('response_points');

        $user->puntos_grupos = $user->puntos_bonus_grupos + $user->puntos_trivias_grupos + $user->puntos_predicciones_grupos;
        $user->puntos        = $user->puntos_bonus + $user->puntos_trivias + $user->puntos_predicciones;

        $user->save();
    }

}