<?php

namespace App\Http\Resources\Term;

use Illuminate\Http\Resources\Json\JsonResource;

class TermResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'version' => $this->version,
            'content' => $this->content,
        ];
    }
}
