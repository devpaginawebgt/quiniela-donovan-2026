<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $correct_option = $this->options->first(function($option) {
            return (int)$option->is_correct === 1;
        });        

        return [
            'id' => $this->id,
            'question' => $this->question,
            'points' => $this->points,
            'order' => $this->order,
            'correct_value' => $correct_option?->id,

            'options' => !empty($this->options) ? QuizOptionResource::collection($this->options) : [],

            'success_message' => $this->success_message,
            'fail_message' => $this->fail_message,
        ];
    }
}
