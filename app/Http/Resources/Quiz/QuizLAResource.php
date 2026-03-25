<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizLAResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'number' => $this->attempt_number,
            'score' => $this->response_points,
            'all_correct' => $this->responses->every(fn ($response) => $response->is_correct),
            'results' => QuizLAQuestionResource::collection($this->responses),
        ];
    }
}
