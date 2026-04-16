<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\StoreQuizRequest;
use App\Http\Resources\Quiz\QuizLAResource;
use App\Http\Resources\Quiz\QuizListItemResource;
use App\Http\Resources\Quiz\QuizResource;
use App\Http\Services\QuizService;
use App\Http\Services\QuizUserService;
use App\Http\Services\UserService;
use App\Models\Quiz;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly QuizService $quizService,
        private readonly UserService $userService,
        private readonly QuizUserService $quizUserService,
    ) {}

    public function index() 
    {
        $quizzes = $this->quizService->getQuizzes();

        if (empty($quizzes)) {
            return $this->successResponse([]);
        }

        $quizzes = $this->quizUserService->showQuizzes($quizzes);

        $quizzes = QuizListItemResource::collection($quizzes);

        return $this->successResponse($quizzes);
    }

    /**
     * Display a listing of the resource.
     */
    public function show(Request $request, string $id)
    {
        $quiz_id = (int)$id;

        $quiz = $this->quizService->getQuizById($quiz_id);

        if (empty($quiz)) {
            return $this->errorResponse('No se ha encontrado la información trivia.', 404);
        }

        $quiz = $this->quizUserService->showQuiz($quiz);

        $quiz = new QuizResource($quiz);

        return $this->successResponse($quiz);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request)
    {
        $data = $request->validated();

        $quiz = $this->quizService->getQuizById($data['quiz_id']);

        $lastAttempt = $this->quizUserService->getLastAttempt($quiz->id);

        $current_attempt = $lastAttempt ? $lastAttempt->attempt_number + 1 : 1;

        if ($current_attempt > $quiz->attempts) {
            return $this->errorResponse('Has alcanzado el límite de intentos disponibles para esta trivia.', 422);
        }

        if ($lastAttempt && $lastAttempt->all_correct === true) {
            return $this->errorResponse('Ya has respondido correctamente todas las preguntas de esta trivia.', 422);
        }

        $result = $this->quizUserService->validateAttempt($quiz, $data);

        if (isset($result['error']) && $result['error'] === true) {

            $error_message = !empty($result['message']) 
                ? $result['message'] 
                : 'Ocurrió un error al validar esta trivia.';

            return $this->errorResponse($error_message, 422);

        }

        $this->quizUserService->createAttempt($quiz, $data['answers'], $current_attempt);

        // Formar respuesta API

        $last_attempt = $this->quizUserService->getLastAttempt($quiz->id);

        $best_attempt = $this->quizUserService->getBestAttempt($quiz->id);

        $next_attempt_number = $last_attempt ? $last_attempt->attempt_number + 1 : 1;

        $hasAnsweredCorrectly = $best_attempt ? $best_attempt->all_correct : false;

        $last_attempt->retry = $next_attempt_number <= $quiz->attempts && !$hasAnsweredCorrectly;

        $last_attempt->current_score = $best_attempt ? $best_attempt->response_points : 0;

        $last_attempt->next_attempt_number = $next_attempt_number;

        $last_attempt->has_answered_correctly = $hasAnsweredCorrectly;

        $last_attempt = new QuizLAResource($last_attempt);

        return $this->successResponse($last_attempt);
    }

    /**
     * Display a listing of the resource.
     */
    public function lastAttempt(Request $request, string $id)
    {
        $quiz_id = (int)$id;

        $quiz = $this->quizService->getQuizById($quiz_id);

        if (empty($quiz)) {
            return $this->errorResponse('No se ha encontrado la información de la trivia.', 404);
        }

        $last_attempt = $this->quizUserService->getLastAttempt($quiz->id);

        if (empty($last_attempt)) {
            return $this->successResponse(null, 200);
        }

        $best_attempt = $this->quizUserService->getBestAttempt($quiz->id);

        $next_attempt_number = $last_attempt ? $last_attempt->attempt_number + 1 : 1;

        $hasAnsweredCorrectly = $best_attempt ? $best_attempt->all_correct : false;

        $last_attempt->retry = $next_attempt_number < $quiz->attempts && !$hasAnsweredCorrectly;

        $last_attempt->current_score = $best_attempt ? $best_attempt->response_points : 0;

        $last_attempt->next_attempt_number = $next_attempt_number;

        $last_attempt->has_answered_correctly = $hasAnsweredCorrectly;

        $last_attempt = new QuizLAResource($last_attempt);

        return $this->successResponse($last_attempt);
    }

    /**
     * Show trivia view with active quiz data.
    */
    public function lastAttemptWeb(Request $request)
    {
        $quiz = $this->quizService->getCurrentQuiz();

        if (empty($quiz)) {
            return redirect()->route('web.inicio.trivia');
        }

        $last_attempt = $this->quizUserService->getLastAttempt($quiz->id);

        if (empty($last_attempt)) {
            return redirect()->route('web.inicio.trivia');
        }

        $current_attempts = $last_attempt ? $last_attempt->attempt_number : 0;
        
        $all_correct = $last_attempt && $last_attempt->responses->every(fn ($r) => $r->is_correct);

        $last_attempt->retry = $current_attempts < $quiz->attempts && !$all_correct;

        $quizLA = $last_attempt;

        return view('modulos.trivias-puntos', compact('quizLA'));
    }

    /**
     * Show trivia view with active quiz data.
     */
    public function indexWeb(Request $request)
    {
        $quiz_db = $this->quizService->getCurrentQuiz();

        $quiz = null;

        if ($quiz_db) {
            $last_attempt = $this->quizUserService->getLastAttempt($quiz_db->id);

            $current_attempts = $last_attempt ? $last_attempt->attempt_number : 0;
            $all_correct = $last_attempt && $last_attempt->responses->every(fn ($r) => $r->is_correct);

            $quiz_db->retry = $current_attempts < $quiz_db->attempts && !$all_correct;

            if ($quiz_db->retry === false) {
                return redirect()->route('web.inicio.trivia-puntos');
            }

            $quiz_db->attempt = $current_attempts + 1;

            $quiz = (new QuizResource($quiz_db))->resolve();
        }

        return view('modulos.trivias', compact('quiz'));
    }
}
