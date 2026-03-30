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
            'is_correct'       => $this->is_correct,
            'points_received'  => $this->points_received,
            
            'question'         => !empty($this->question) 
                                    ? new QuizResponseQuestionResource($this->question) 
                                    : null,
            'selected_option'  => !empty($this->option) 
                                    ? new QuizOptionResource($this->option) 
                                    : null,
        ];
    }
}
