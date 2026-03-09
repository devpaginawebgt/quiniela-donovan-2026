<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterDoctorRequest extends FormRequest
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
            // 'codigo_id'        => ['required', 'string', 'exists:codigos,name'],
            'nombres'          => ['required', 'string', 'max:60'],
            'apellidos'        => ['required', 'string', 'max:60'],
            'numero_documento' => ['required', 'integer', 'digits:13', 'unique:users,numero_documento'],
            'telefono'         => ['required', 'string', 'max:20'],
            'email'            => ['required', 'email', 'max:255', 'unique:users'],
            'direccion'        => ['required', 'string', 'max:255'],
            'pais_id'          => ['required', 'integer', 'exists:countries,id'],
            'user_type_id'     => ['required', 'integer', 'exists:user_types,id'],

            'region'           => ['required', 'string', 'min:2', 'max:100'],
            'capital'          => ['required', 'string', 'min:2', 'max:100'],
            'visitor_id'       => ['required', 'integer', 'exists:visitors,id'],
        ];
    }

    public function messages(): array
    {
        return [
            // NOMBRES
            'nombres.required' => 'Por favor, ingrese su nombre.',
            'nombres.string'   => 'El campo nombres debe contener texto.',
            'nombres.max'      => 'El campo nombres no debe superar los 60 caracteres.',

            // APELLIDOS
            'apellidos.required' => 'Por favor, ingrese su apellido.',
            'apellidos.string'   => 'El campo apellidos debe contener texto.',
            'apellidos.max'      => 'El campo apellidos no debe superar los 60 caracteres.',

            // NUMERO DOCUMENTO
            'numero_documento.required' => 'Por favor, ingrese su Número de Documento.',
            'numero_documento.integer'  => 'El campo número de documento solo debe contener números.',
            'numero_documento.digits'   => 'El número de documento debe contener 13 dígitos.',
            // 'numero_documento.max'      => 'El Número de Documento no debe superar los 13 caracteres.',
            'numero_documento.unique'   => 'Ya existe un usuario registrado con este Número de Documento.',

            // TELEFONO
            'telefono.required' => 'Por favor, ingrese su número de teléfono.',
            'telefono.string'   => 'El teléfono debe contener texto.',
            'telefono.max'      => 'El teléfono no debe superar los 20 caracteres.',

            // EMAIL
            'email.required' => 'Por favor, ingrese su correo electrónico.',
            'email.email'    => 'Por favor ingrese un correo electrónico válido.',
            'email.max'      => 'El correo electrónico no debe superar los 255 caracteres.',
            'email.unique'   => 'Ya existe un usuario registrado con este correo electrónico.',

            // DIRECCION
            'direccion.required' => 'Por favor, ingrese su dirección.',
            'direccion.string'   => 'La dirección debe contener texto.',
            'direccion.max'      => 'La dirección no debe superar los 255 caracteres.',

            // PAIS
            'pais_id.required' => 'Por favor seleccione su país.',
            'pais_id.integer'  => 'El país seleccionado no es válido.',
            'pais_id.exists'   => 'El país seleccionado no existe en nuestros registros.',

            // REGION
            'region.required' => 'Por favor, llene el campo región.',
            'region.string'   => 'El campo región debe contener texto.',
            'region.min'      => 'El campo región debe tener al menos 2 caracteres.',
            'region.max'      => 'El campo región no debe superar los 100 caracteres.',

            // CAPITAL
            'capital.required' => 'Por favor llene el campo capital.',
            'capital.string'   => 'El campo capital debe contener texto.',
            'capital.min'      => 'El campo capital debe tener al menos 2 caracteres.',
            'capital.max'      => 'El campo capital no debe superar los 100 caracteres.',

            // CAPITAL
            'visitor_id.required' => 'Por favor seleccione el visitador médico que inscribe.',
            'visitor_id.integer'  => 'Selecciona un visitador médico del listado.',
            'visitor_id.exists'   => 'No se encontró el visitador médico seleccionado.',
        ];
    }
}
