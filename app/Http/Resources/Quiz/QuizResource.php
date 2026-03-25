<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'retry' => $this->retry,
            'attempt' => $this->attempt,

            'lastAttempt' => !empty($this->last_attempt) ? new QuizLAResource($this->last_attempt) : null,

            'questions' => !empty($this->questions) ? QuizQuestionResource::collection($this->questions) : [],

        ];
    }
}
