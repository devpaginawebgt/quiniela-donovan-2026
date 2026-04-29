<?php

namespace App\Http\Resources\Ranking;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RankingTabResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'        => $this->name,
            'code'        => $this->code,
            'is_active'   => $this->is_active,
            'is_visible'  => $this->is_visible,
            'api_url'     => route($this->app_route_name),
        ];
    }
}
