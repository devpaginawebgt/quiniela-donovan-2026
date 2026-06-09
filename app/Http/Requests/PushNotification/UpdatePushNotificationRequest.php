<?php

namespace App\Http\Requests\PushNotification;

use App\Models\PushNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Throwable;

class UpdatePushNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (! $this->user()?->can('create admin notifications')) {
            return false;
        }

        $notification = $this->route('notification');

        return $notification instanceof PushNotification
            && $notification->status === PushNotification::STATUS_PENDING;
    }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'max:100'],
            'description'      => ['required', 'string', 'max:240'],
            'user_type_id'     => ['nullable', 'integer', 'exists:user_types,id'],
            'country_id'       => ['nullable', 'integer', 'exists:countries,id'],
            'image'            => ['nullable', 'image', 'max:500'], // 500 KB
            'remove_image'     => ['nullable', 'in:0,1'],
            'schedule_enabled' => ['nullable', 'in:0,1'],
            'send_at_date'     => ['required_if:schedule_enabled,1', 'nullable', 'date_format:Y-m-d'],
            'send_at_time'     => ['required_if:schedule_enabled,1', 'nullable', 'date_format:H:i'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            if ((string) $this->input('schedule_enabled') !== '1') {
                return;
            }

            $date = $this->input('send_at_date');
            $time = $this->input('send_at_time');

            if (! $date || ! $time) {
                return;
            }

            $userTimezone = $this->user()?->country?->timezone ?? config('app.timezone');

            try {
                $scheduledAt = Carbon::createFromFormat('Y-m-d H:i', "$date $time", $userTimezone);
            } catch (Throwable $e) {
                $v->errors()->add('send_at_date', 'Fecha y hora de envío inválidas.');
                return;
            }

            if (! $scheduledAt || $scheduledAt->lessThan(now()->addMinutes(5))) {
                $v->errors()->add('send_at_date', 'La hora de envío debe ser al menos 5 minutos en el futuro.');
            }
        });
    }

    public function attributes(): array
    {
        return [
            'send_at_date' => 'fecha de envío',
            'send_at_time' => 'hora de envío',
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

            'send_at_date.required_if'    => 'La fecha de envío es obligatoria al programar.',
            'send_at_date.date_format'    => 'La fecha de envío no es válida.',
            'send_at_time.required_if'    => 'La hora de envío es obligatoria al programar.',
            'send_at_time.date_format'    => 'La hora de envío no es válida.',
        ];
    }
}
