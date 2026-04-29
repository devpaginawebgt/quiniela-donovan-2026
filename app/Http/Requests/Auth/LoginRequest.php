<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'numero_documento' => ['required', 'integer', 'digits:13'],
        ];
    }

    public function messages()
    {

        return [
            'numero_documento.required' => 'Por favor ingrese su número de documento.',
            'numero_documento.integer'  => 'Ingresa un número de documento válido (solo números).',
            'numero_documento.digits'   => 'Ingresa un número de documento válido (debe contener 13 dígitos).',
        ];

    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        $data = $this->validated();

        $user = User::where('numero_documento', $data['numero_documento'])->first();

        if (empty($user)) {
            $this->hitRateLimiter();

            throw ValidationException::withMessages([
                'numero_documento' => 'El número de documento ingresado no está registrado en el sistema.',
            ]);
        }

        $credentials = ['email' => $user->email, 'password' => config('quiniela.default_pass')];

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'numero_documento' => 'Ha ocurrido un error al iniciar la sesión, contacta a Soporte.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
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
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 10)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'numero_documento' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
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
