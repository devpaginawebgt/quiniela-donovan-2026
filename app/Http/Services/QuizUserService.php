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

    public function getLastAttempt(string|int $quiz_id)
    {
        $user = request()->user();

        return $user->quizzes()
            ->with('responses.question', 'responses.option')
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

    public function showQuizzes(Collection $quizzes)
    {
        $last_attempts = $this->getLastAttempts();

        $best_attempts = $this->getBestAttempts();

        return $quizzes->map(function($quiz) use($last_attempts, $best_attempts) {

            $last_attempt = $last_attempts->firstWhere('quiz_id', $quiz->id);

            $best_attempt = $best_attempts->firstWhere('quiz_id', $quiz->id);

            $current_attempts = $last_attempt ? $last_attempt->attempt_number : 0;

            $hasAnsweredCorrectly = $best_attempt ? $best_attempt->all_correct : false;

            $quiz->retry = $current_attempts < $quiz->attempts && !$hasAnsweredCorrectly;

            $quiz->attempt = $current_attempts + 1;

            $quiz->current_points = $best_attempt ? $best_attempt->response_points : 0;

            $quiz->hasAnsweredCorrectly = $hasAnsweredCorrectly;

            return $quiz;

        });
    }

    public function showQuiz(Quiz $quiz)
    {
        $last_attempt = $this->getLastAttempt($quiz->id);

        $best_attempt = $this->getBestAttempt($quiz->id);

        $current_attempts = $last_attempt ? $last_attempt->attempt_number : 0;
        
        $hasAnsweredCorrectly = $best_attempt ? $best_attempt->all_correct : false;

        $quiz->retry = $current_attempts < $quiz->attempts && !$hasAnsweredCorrectly;

        $quiz->attempt = $current_attempts + 1;

        $quiz->current_points = $best_attempt ? $best_attempt->response_points : 0;

        $quiz->hasAnsweredCorrectly = $hasAnsweredCorrectly;

        return $quiz;
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
            ->orderBy('response_points', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('quiz_id');

        $puntos_trivias = $quizzes->sum('response_points');

        $user->puntos_trivias = $puntos_trivias;

        $user->puntos = $puntos_trivias + ($user->puntos_predicciones ?? 0);

        $user->save();
    }

}