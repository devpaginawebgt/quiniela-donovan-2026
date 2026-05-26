<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ApiLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'numero_documento' => ['required', 'regex:/^\d+$/', 'digits:13'],
        ];
    }

    public function messages()
    {

        return [
            'numero_documento.required' => 'Por favor ingrese su número de documento.',
            'numero_documento.regex'    => 'Ingresa un número de documento válido (solo números).',
            'numero_documento.digits'   => 'Ingresa un número de documento válido (debe contener 13 dígitos).',
        ];

    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 10)) {

            $seconds = RateLimiter::availableIn($this->throttleKey());

            $minutes = ceil($seconds / 60);

            throw ValidationException::withMessages([
                'numero_documento' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => $minutes,
                ]),
            ]);

        }
    }

    /**
     * Increment the rate limiter hits.
     *
     * @return void
     */
    public function hitRateLimiter()
    {
        RateLimiter::hit($this->throttleKey());
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('numero_documento')).'|'.$this->ip();
    }
}
