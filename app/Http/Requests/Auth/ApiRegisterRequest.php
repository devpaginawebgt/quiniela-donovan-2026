<?php

namespace App\Http\Requests\Auth;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ApiRegisterRequest extends FormRequest
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
            'nombres'          => ['required', 'string', 'min:2', 'max:60'],
            'apellidos'        => ['required', 'string', 'min:2', 'max:60'],
            'numero_documento' => ['required', 'string', 'min:6', 'max:20', 'unique:users,numero_documento'],
            'telefono'         => ['required', 'integer', 'digits:8'],
            'email'            => ['required', 'email', 'min:5', 'max:255', 'unique:users'],
            'direccion'        => ['required', 'string', 'min:5', 'max:255'],
            'pais_id'          => ['required', 'integer', 'exists:countries,id'],
            'user_type_id'     => ['required', 'integer', 'exists:user_types,id'],

            'colegiado' => [
                'nullable',
                'required_if:user_type_id,2',
                'prohibited_unless:user_type_id,2',
                'string',
                'min:2',
                'max:20',
                'unique:users'
            ],
            'region' => [
                'nullable',
                'required_if:user_type_id,2',
                'prohibited_unless:user_type_id,2',
                'string',
                'min:2',
                'max:100',
            ],
            'visitor_id' => [
                'nullable',
                'prohibited_unless:user_type_id,2',
                'integer',
                'exists:visitors,id',
            ],

            'company_id' => [
                'nullable',
                'required_if:user_type_id,1',
                'prohibited_unless:user_type_id,1',
                'integer',
                'exists:companies,id',
            ],
            'branch' => [
                'nullable',
                'required_if:user_type_id,1',
                'prohibited_unless:user_type_id,1',
                'string',
                'min:3',
                'max:255',
            ],

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
            // NOMBRES
            'nombres.required' => 'Por favor, ingrese su nombre.',
            'nombres.string'   => 'El campo nombre debe contener texto.',
            'nombres.min'      => 'El campo nombre debe contener al menos 2 caracteres.',
            'nombres.max'      => 'El campo nombre no debe superar los 60 caracteres.',

            // APELLIDOS
            'apellidos.required' => 'Por favor, ingrese su apellido.',
            'apellidos.string'   => 'El campo apellido debe contener texto.',
            'apellidos.min'      => 'El campo apellido debe contener al menos 2 caracteres.',
            'apellidos.max'      => 'El campo apellido no debe superar los 60 caracteres.',

            // NUMERO DOCUMENTO
            'numero_documento.required' => 'Por favor, ingrese su número de documento.',
            'numero_documento.string'   => 'El número de documento debe ser un texto válido.',
            'numero_documento.min'      => 'El número de documento debe tener al menos 6 caracteres.',
            'numero_documento.max'      => 'El número de documento no puede tener más de 20 caracteres.',
            'numero_documento.unique'   => 'Ya existe un usuario registrado con este número de documento.',

            // TELEFONO
            'telefono.required' => 'Por favor, ingrese su número de teléfono.',
            'telefono.integer'  => 'El campo teléfono debe ser un número válido.',
            'telefono.digits'   => 'El campo teléfono debe tener 8 dígitos.',

            // EMAIL
            'email.required' => 'Por favor, ingrese su correo electrónico.',
            'email.email'    => 'Por favor ingrese un correo electrónico válido.',
            'email.min'      => 'El correo electrónico debe contener al menos 5 caracteres.',
            'email.max'      => 'El correo electrónico no debe superar los 255 caracteres.',
            'email.unique'   => 'Ya existe un usuario registrado con este correo electrónico.',

            // DIRECCION
            'direccion.required' => 'Por favor, ingrese su dirección.',
            'direccion.string'   => 'El campo dirección debe contener texto.',
            'direccion.min'      => 'El campo dirección debe contener al menos 5 caracteres.',
            'direccion.max'      => 'El campo dirección no debe superar los 255 caracteres.',

            // PAIS
            'pais_id.required' => 'Por favor seleccione su país.',
            'pais_id.integer'  => 'El país seleccionado no es válido.',
            'pais_id.exists'   => 'El país seleccionado no existe en nuestros registros.',

            // LINEA
            'line_id.required' => 'Por favor seleccione la línea de medicamentos en la que participará.',
            'line_id.integer'  => 'La línea seleccionada no es válida.',
            'line_id.exists'   => 'La línea seleccionada no existe en nuestros registros.',

            'user_type_id.required' => 'El tipo de usuario es incorrecto.',
            'user_type_id.integer'  => 'El tipo de usuario es incorrecto.',
            'user_type_id.exists'   => 'No se encontró el tipo de usuario.',

            // COLEGIADO
            'colegiado.required_if'       => 'Por favor, ingrese su número de colegiado.',
            'colegiado.prohibited_unless' => 'El número de colegiado solo aplica para usuarios tipo doctor.',
            'colegiado.string'            => 'El número de colegiado debe ser un texto válido.',
            'colegiado.min'               => 'El número de colegiado debe tener al menos 2 caracteres.',
            'colegiado.max'               => 'El número de colegiado no puede tener más de 20 caracteres.',
            'colegiado.unique'            => 'Ya existe un usuario registrado con este número de colegiado.',

            // REGION
            'region.required_if'       => 'Por favor, ingrese su región.',
            'region.prohibited_unless' => 'El campo región solo aplica para usuarios tipo doctor.',
            'region.string'            => 'El campo región debe ser un texto válido.',
            'region.min'               => 'El campo región debe tener al menos 2 caracteres.',
            'region.max'               => 'El campo región no puede tener más de 100 caracteres.',

            // VISITOR
            'visitor_id.prohibited_unless' => 'El campo visitador no aplica para usuarios tipo dependiente.',
            'visitor_id.integer'           => 'El visitador seleccionado no es válido.',
            'visitor_id.exists'            => 'El visitador seleccionado no existe en nuestros registros.',

            // COMPANY
            'company_id.required_if'       => 'Por favor, seleccione la cadena de farmacias para la cuál labora.',
            'company_id.prohibited_unless' => 'El campo cadena solo aplica para usuarios tipo dependiente.',
            'company_id.integer'           => 'La cadena seleccionada no es válida.',
            'company_id.exists'            => 'La cadena seleccionada no existe en nuestros registros.',

            // BRANCH
            'branch.required_if'       => 'Por favor, ingrese su sucursal.',
            'branch.prohibited_unless' => 'La sucursal solo aplica para usuarios tipo dependiente.',
            'branch.string'            => 'El campo sucursal debe ser un texto válido.',
            'branch.min'               => 'El campo sucursal debe tener al menos 3 caracteres.',
            'branch.max'               => 'El campo sucursal no puede tener más de 255 caracteres.',

            // ACCEPTED TERMS VERSION
            'accepted_terms_version.required' => 'Debe aceptar los términos y condiciones.',
            'accepted_terms_version.string'   => 'La versión de términos aceptados debe ser un texto válido.',
            'accepted_terms_version.max'      => 'La versión de términos aceptados no puede tener más de 20 caracteres.',
        ];
    }
}
