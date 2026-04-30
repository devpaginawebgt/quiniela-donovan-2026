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
            'id'                   => $this->id,
            'title'                => $this->name,
            'attempts'             => $this->attempts,
            'availableScore'       => $this->points,
            'currentScore'         => $this->current_score,
            'expiresAt'            => $this->expires_at?->toDateTimeString(),

            'retry'                => $this->retry,
            'nextAttemptNumber'    => $this->next_attempt_number,
            'hasAnsweredCorrectly' => $this->has_answered_correctly,

            'lastAttemptNumber'    => $this->last_attempt_number,
        ];
    }
}
