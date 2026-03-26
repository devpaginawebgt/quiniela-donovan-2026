<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizLAResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'quiz_id'   => $this->quiz->id,
            'title'     => $this->quiz->name,
            'retry'     => $this->retry,
            'attempts'  => $this->quiz->attempts,
            'attempt'   => $this->attempt_number,

            'score'       => $this->response_points,
            'all_correct' => $this->responses->every(fn ($response) => $response->is_correct),

            'answers'  => !empty($this->responses) ? QuizResponseResource::collection($this->responses) : [],
        ];
    }
}
