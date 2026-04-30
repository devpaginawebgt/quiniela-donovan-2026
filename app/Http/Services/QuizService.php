<?php

namespace App\Http\Services;

use App\Models\Quiz;

class QuizService {

    public function getQuizzes()
    {
        return Quiz::where('is_visible', true)->get();
    }

    public function getQuizById(string|int $id)
    {
        return Quiz::find($id);
    }

}