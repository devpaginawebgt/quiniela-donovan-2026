<?php

namespace App\Http\Services;

use App\Models\Quiz;

class QuizService {

    public function getQuizzes(?int $country_id = null)
    {
        return Quiz::where('is_visible', true)
            ->when($country_id !== null, fn ($q) => $q->where('country_id', $country_id))
            ->get();
    }

    public function getQuizById(string|int $id, ?int $country_id = null)
    {
        return Quiz::when($country_id !== null, fn ($q) => $q->where('country_id', $country_id))
            ->find($id);
    }

}
