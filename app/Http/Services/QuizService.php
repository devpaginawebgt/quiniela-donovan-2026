<?php

namespace App\Http\Services;

use App\Models\Quiz;

class QuizService {

    public function getCurrentQuiz()
    {
        return Quiz::with('questions.options')
            ->where('is_active', true)
            ->firstOrFail();
    }

}