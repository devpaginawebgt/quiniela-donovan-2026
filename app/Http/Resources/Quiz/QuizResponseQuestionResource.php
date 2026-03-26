<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResponseQuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'question'        => $this->question,
            'points'          => $this->points,
            'order'           => $this->order,
            'success_message' => $this->success_message,
            'fail_message'    => $this->fail_message,
        ];
    }
}
