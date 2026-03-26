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
            'id'        => $this->id,
            'title'     => $this->name,
            'retry'     => $this->retry,
            'attempts'  => $this->attempts,
            'attempt'   => $this->attempt,
            'questions' => !empty($this->questions) ? QuizQuestionResource::collection($this->questions) : [],

        ];
    }
}
