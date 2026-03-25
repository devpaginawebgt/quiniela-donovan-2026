<?php

namespace App\Http\Requests\Quiz;

use App\Models\QuizOption;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'quiz_id' => ['required', 'integer', 'exists:quizzes,id'],

            'answers' => ['required', 'array', 'min:1'],

            'answers.*.question_id' => [
                'required', 
                'integer', 
                // 'exists:quiz_questions,id'
            ],

            'answers.*.selected_value' => [
                'required',
                'integer',
                // 'exists:quiz_options,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // QUIZ ID
            'quiz_id.required' => 'El identificador de la trivia es obligatorio.',
            'quiz_id.integer'  => 'El identificador de la trivia debe ser un número válido.',
            'quiz_id.exists'   => 'La trivia seleccionada no existe en nuestros registros.',

            // ANSWERS
            'answers.required' => 'Las respuestas son obligatorias.',
            'answers.array'    => 'Las respuestas deben ser una lista válida.',
            'answers.min'      => 'Debe enviar al menos una respuesta.',

            // QUESTION ID
            'answers.*.question_id.required' => 'El identificador de la pregunta es obligatorio.',
            'answers.*.question_id.integer'  => 'El identificador de la pregunta debe ser un número válido.',
            // 'answers.*.question_id.exists'   => 'El identificador de la pregunta no existe en nuestros registros.',

            // SELECTED VALUE
            'answers.*.selected_value.required' => 'La opción seleccionada es obligatoria.',
            'answers.*.selected_value.integer'  => 'La opción seleccionada debe ser un número válido.',
            // 'answers.*.selected_value.exists'   => 'La opción seleccionada no existe en nuestros registros.',
        ];
    }
}
