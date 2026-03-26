<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResponseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'question'         => !empty($this->question) 
                                    ? new QuizResponseQuestionResource($this->question) 
                                    : null,
            'correct_option'   => !empty($this->question->correct_option) 
                                    ? new QuizOptionResource($this->question->correct_option) 
                                    : null,
            'selected_option'  => !empty($this->option) 
                                    ? new QuizOptionResource($this->option) 
                                    : null,
            'is_correct'       => $this->is_correct,
            'points_received'  => $this->points_received,
        ];
    }
}
