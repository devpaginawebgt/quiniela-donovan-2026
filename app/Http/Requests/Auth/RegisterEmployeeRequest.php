<?php

namespace App\Http\Requests\Auth;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;

class RegisterEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id'            => ['required', 'integer', 'exists:users,id'],
            'numero_documento'       => ['required', 'string', 'size:13', 'unique:users,numero_documento'],
            'accepted_terms_version' => ['required', 'string', 'max:20'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->has('pais_id') || $validator->errors()->has('numero_documento')) {
                return;
            }

            $country = Country::find($this->pais_id);

            if ($country && $country->document_regex && !preg_match("/{$country->document_regex}/", $this->numero_documento)) {
                $validator->errors()->add(
                    'numero_documento',
                    $country->document_regex_message ?? 'El formato del documento no es válido.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            // EMPLOYEE
            'employee_id.required' => 'El colaborador seleccionado es incorrecto.',
            'employee_id.integer'  => 'El colaborador seleccionado es incorrecto.',
            'employee_id.exists'   => 'No se encontró el colaborador en el listado.',

            // NUMERO DOCUMENTO
            'numero_documento.required' => 'Por favor, ingrese su número de documento.',
            'numero_documento.string'   => 'El número de documento debe ser un texto válido.',
            'numero_documento.size'     => 'El número de documento debe contener 16 digitos.',
            'numero_documento.unique'   => 'Ya existe un usuario registrado con este número de documento.',

            // ACCEPTED TERMS VERSION
            'accepted_terms_version.required' => 'Debe aceptar los términos y condiciones.',
            'accepted_terms_version.string'   => 'La versión de términos aceptados debe ser un texto válido.',
            'accepted_terms_version.max'      => 'La versión de términos aceptados no puede tener más de 20 caracteres.',
        ];
    }
}
