<?php

namespace App\Http\Services;

use App\Models\Quiz;

class QuizService {

    public function getQuizzes()
    {
        return Quiz::all();
    }

    public function getCurrentQuiz()
    {
        return Quiz::with('questions.options')
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function getQuizById($id)
    {
        return Quiz::find($id);
    }

}