<?php

namespace App\Http\Requests\MatchScoreRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatchScoreRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage match polling') ?? false;
    }

    public function rules(): array
    {
        return [
            'partido_ids'   => ['required', 'array', 'min:1'],
            'partido_ids.*' => ['integer', 'exists:partidos,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'partido_ids.required' => 'Selecciona al menos un partido.',
            'partido_ids.array'    => 'El formato de la selección no es válido.',
            'partido_ids.min'      => 'Selecciona al menos un partido.',
            'partido_ids.*.integer' => 'Alguno de los partidos seleccionados no es válido.',
            'partido_ids.*.exists'  => 'Alguno de los partidos seleccionados no existe.',
        ];
    }
}
