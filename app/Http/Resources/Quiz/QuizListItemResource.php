<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizListItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->name,
            'retry'          => $this->retry,
            'attempts'       => $this->attempts,
            'attempt'        => $this->attempt,
            'current_points' => $this->current_points ?? 0,
            'hasAnsweredCorrectly' => $this->hasAnsweredCorrectly ?? false,
        ];
    }
}
