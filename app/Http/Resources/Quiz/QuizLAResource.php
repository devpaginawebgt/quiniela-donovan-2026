<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizLAResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user_timezone = $request->user()->country->timezone;
        $expires_at    = $this->quiz->expires_at?->copy()->setTimezone($user_timezone);

        return [
            'id'                   => $this->id,
            'quiz_id'              => $this->quiz->id,
            'title'                => $this->quiz->name,
            'attempts'             => $this->quiz->attempts,
            'availableScore'       => $this->quiz->points,
            'currentScore'         => $this->current_score,
            'expiresAt'            => $expires_at?->format('Y-m-d H:i:s'),
            'expired'              => $expires_at?->isPast() ?? false,

            'retry'                => $this->retry,
            'nextAttemptNumber'    => $this->next_attempt_number,
            'hasAnsweredCorrectly' => $this->has_answered_correctly,

            'lastAttemptNumber'    => $this->attempt_number,
            'lastAttemptScore'     => $this->response_points,
            'all_correct'          => $this->all_correct,

            'answers'  => !empty($this->responses) ? QuizResponseResource::collection($this->responses) : [],
        ];
    }
}
