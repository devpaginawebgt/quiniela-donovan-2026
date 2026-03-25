<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizLAQuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->quiz_question_id,
            'question' => $this->question->question,
            'points' => $this->question->points,
            'correct_option' => $this->question->correct_option->option_text ?? null,
            'selected_option' => $this->option->option_text,
            'points_received' => $this->points_received,
            'correct' => $this->is_correct,
        ];
    }
}
