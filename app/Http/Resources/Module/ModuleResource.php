<?php

namespace App\Http\Resources\Module;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = request()->user();

        return [
            'name'      => $this->name,
            'code'      => $this->code,
            'canAccess' => $user->can($this->permission_name),
        ];
    }
}
