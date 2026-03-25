<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\StoreQuizRequest;
use App\Http\Resources\Quiz\QuizResource;
use App\Http\Services\QuizService;
use App\Http\Services\QuizUserService;
use App\Models\Quiz;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly QuizService $quizService,
        private readonly QuizUserService $quizUserService,
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $quiz = $this->quizService->getCurrentQuiz();

        if (empty($quiz)) {
            return $this->errorResponse('No se ha encontrado una trivia activa.', 404);
        }

        $last_attempt = $this->quizUserService->getLastAttempt($quiz->id);

        $current_attempts = $last_attempt ? $last_attempt->attempt_number : 0;

        $quiz->retry = $current_attempts < $quiz->attempts;

        $quiz->attempt = $current_attempts + 1;
        
        $quiz->last_attempt = $last_attempt;

        $quiz = new QuizResource($quiz);
        
        return $this->successResponse($quiz);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request)
    {
        $data = $request->validated();

        $quiz = $this->quizService->getCurrentQuiz();

        if (empty($quiz)) {
            return $this->errorResponse('No se ha encontrado una trivia activa.', 404);
        }

        if ($quiz->id !== $data['quiz_id']) {
            return $this->errorResponse('Esta trivia no se encuentra activa.', 422);
        }

        $lastAttempt = $this->quizUserService->getLastAttempt($quiz->id);

        $currentAttempts = !empty($lastAttempt) ? $lastAttempt->attempt_number : 0;

        if ($currentAttempts >= $quiz->attempts) {
            return $this->errorResponse('Haz alcanzado el límite de intentos disponibles para esta trivia.', 422);
        }

        $result = $this->quizUserService->validateAttempt($quiz, $data);

        if (isset($result['error']) && $result['error'] === true) {

            $error_message = !empty($result['message']) 
                ? $result['message'] 
                : 'Ocurrió un error al validar esta trivia.';

            return $this->errorResponse($error_message, 422);

        }

        $current_attempt = $currentAttempts + 1;

        $this->quizUserService->createAttempt($quiz, $data['answers'], $current_attempt);

        // Formar respuesta API

        $last_attempt = $this->quizUserService->getLastAttempt($quiz->id);

        $current_attempts = $last_attempt ? $last_attempt->attempt_number : 0;

        $quiz->retry = $current_attempts < $quiz->attempts;

        $quiz->attempt = $current_attempts + 1;
        
        $quiz->last_attempt = $last_attempt;

        $quiz = new QuizResource($quiz);

        return $this->successResponse($quiz);
    }
}
