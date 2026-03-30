<?php

namespace App\Http\Requests\Prediccion;

use App\Http\Services\HelperService;
use Illuminate\Foundation\Http\FormRequest;

class PrediccionRequest extends FormRequest
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
            'predicciones' => ['required', 'array', 'min:1', 'max:25'],

            'predicciones.*.idPartido' => [
                'required',
                'integer',
                'exists:partidos,id',
                'distinct'
            ],

            'predicciones.*.prediccionEquipoUno' => [
                'nullable',
                'integer',
                'min:0',
                'max:25',
            ],

            'predicciones.*.prediccionEquipoDos' => [
                'nullable',
                'integer',
                'min:0',
                'max:25',
            ],
        ];
    }

    public function messages()
    {
        return [            
            'predicciones.required' => 'Debe ingresar al menos una predicción.',
            'predicciones.array' => 'El formato de las predicciones no es válido.',
            'predicciones.min' => 'Debe ingresar al menos una predicción.',
            'predicciones.max' => 'No se puede guardar más de 25 predicciones.',

            'predicciones.*.idPartido.required' => 'Error al identificar el número de partido.',
            'predicciones.*.idPartido.integer' => 'El número de partido debe ser un valor numérico.',
            'predicciones.*.idPartido.exists' => 'El número de partido seleccionado no existe.',
            'predicciones.*.idPartido.distinct' => 'El número de partido no puede repetirse en sus predicciones.',

            'predicciones.*.prediccionEquipoUno.required' => 'Ingrese la predicción para el equipo uno.',
            'predicciones.*.prediccionEquipoUno.integer' => 'Ingresa un número entero para la predicción de goles del equipo uno.',
            'predicciones.*.prediccionEquipoUno.min' => 'Ingresa un número positivo para la predicción de goles del equipo uno.',
            'predicciones.*.prediccionEquipoUno.max' => 'La predicción del equipo uno no puede superar los 25 goles.',

            'predicciones.*.prediccionEquipoDos.required' => 'Ingrese la predicción para el equipo dos.',
            'predicciones.*.prediccionEquipoDos.integer' => 'Ingresa un número entero para la predicción de goles del equipo dos.',
            'predicciones.*.prediccionEquipoDos.min' => 'Ingresa un número positivo para la predicción de goles del equipo dos.',
            'predicciones.*.prediccionEquipoDos.max' => 'La predicción del equipo dos no puede superar los 25 goles.',
        ];
    }


    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        if ($key !== null) {
            return $validated;
        }

        $data = [];

        foreach($validated['predicciones'] as $record) {
            $data[] = HelperService::CamelCaseToSnake($record);
        }

        $validated['predicciones'] = $data;

        return $validated;
    }
}
