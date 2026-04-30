<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\StoreQuizRequest;
use App\Http\Resources\Quiz\QuizLAResource;
use App\Http\Resources\Quiz\QuizListItemResource;
use App\Http\Resources\Quiz\QuizResource;
use App\Http\Services\ModuleService;
use App\Http\Services\QuizService;
use App\Http\Services\QuizUserService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly QuizService $quizService,
        private readonly UserService $userService,
        private readonly QuizUserService $quizUserService,
        private readonly ModuleService $moduleService,        
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

        $is_active = empty($quiz->expires_at) || $quiz->expires_at->isFuture();

        if ($is_active === false) {
            return $this->errorResponse('La vigencia de esta trivia ha terminado, ya no se aceptan respuestas.', 422);
        }

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

        $last_attempt = $this->quizUserService->getQuizLastAttemptInfo($quiz, $last_attempt, $best_attempt);

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

        $last_attempt = $this->quizUserService->getQuizLastAttemptInfo($quiz, $last_attempt, $best_attempt);

        $last_attempt = new QuizLAResource($last_attempt);

        return $this->successResponse($last_attempt);
    }

    /**
     * Show trivia view with active quiz data.
     */
    public function triviasWeb(Request $request)
    {
        // Banners

        $banners = $this->moduleService->getBanners(10);

        // User Info

        $user = Auth::user();
        
        $user = $this->userService->getUserRank($user);

        $user = $this->userService->getUserPredictionsCount($user);

        $quizzes = $this->quizService->getQuizzes();

        if (empty($quizzes)) {
            return $this->successResponse([]);
        }

        $quizzes = $this->quizUserService->showQuizzes($quizzes);

        return view('modulos.trivias', compact('banners', 'user', 'quizzes'));

    }

    public function triviaWeb(Request $request, string $quiz_id)
    {
        $quiz = $this->quizService->getQuizById((int)$quiz_id);

        if (empty($quiz)) {
            return redirect()->route('web.inicio.trivias.index');
        }

        $last_attempt = $this->quizUserService->getLastAttemptSimple($quiz->id);

        $best_attempt = $this->quizUserService->getBestAttempt($quiz->id);

        $quiz = $this->quizUserService->showQuiz($quiz);

        if ($quiz->retry === false) {
            return redirect()->route('web.inicio.trivias.last-attempt', $quiz_id);
        }

        $quiz = (new QuizResource($quiz))->resolve();

        return view('modulos.trivia', compact('quiz'));
    }

    /**
     * Show trivia view with active quiz data.
    */
    public function lastAttemptWeb(Request $request, string $quiz_id)
    {
        $quiz = $this->quizService->getQuizById((int)$quiz_id);

        if (empty($quiz)) {
            return redirect()->route('web.inicio.trivias.index');
        }

        $last_attempt = $this->quizUserService->getLastAttempt($quiz->id);

        if (empty($last_attempt)) {
            return redirect()->route('web.inicio.trivias.show', $quiz_id);
        }

        $best_attempt = $this->quizUserService->getBestAttempt($quiz->id);

        $current_attempts = $last_attempt ? $last_attempt->attempt_number : 0;
        
        $quizLA = $this->quizUserService->getQuizLastAttemptInfo($quiz, $last_attempt, $best_attempt);

        return view('modulos.trivia-last-attempt', compact('quizLA'));
    }
}
