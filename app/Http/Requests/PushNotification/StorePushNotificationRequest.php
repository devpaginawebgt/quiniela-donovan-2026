<?php

namespace App\Http\Requests\PushNotification;

use Illuminate\Foundation\Http\FormRequest;

class StorePushNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('admin.enviar-notificaciones-push') ?? false;
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:100'],
            'description'  => ['required', 'string', 'max:240'],
            'user_type_id' => ['nullable', 'integer', 'exists:user_types,id'],
            'country_id'   => ['nullable', 'integer', 'exists:countries,id'],
            'image'        => ['nullable', 'image', 'max:500'], // 500 KB
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'El título es obligatorio.',
            'title.string'         => 'El título debe ser texto.',
            'title.max'            => 'El título no puede superar los 100 caracteres.',

            'description.required' => 'El mensaje es obligatorio.',
            'description.string'   => 'El mensaje debe ser texto.',
            'description.max'      => 'El mensaje no puede superar los 240 caracteres.',

            'user_type_id.integer' => 'La audiencia seleccionada no es válida.',
            'user_type_id.exists'  => 'La audiencia seleccionada no existe.',

            'country_id.integer'   => 'El país seleccionado no es válido.',
            'country_id.exists'    => 'El país seleccionado no existe.',

            'image.image'          => 'El archivo debe ser una imagen.',
            'image.max'            => 'La imagen no puede superar los 500 KB.',
        ];
    }
}
