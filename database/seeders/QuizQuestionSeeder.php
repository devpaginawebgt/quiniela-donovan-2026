<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'quiz_id' => 1,
                'question' => '¿Qué medicamento protege el estómago formando una barrera contra la acidez?',
                'points' => 1,
                'order' => 1,
                'success_message' => '¡Correcto! Sucralfato actúa como defensa del estómago.',
                'fail_message' => 'Incorrecto. Intenta la siguiente.',
            ],
            [
                'quiz_id' => 1,
                'question' => '¿Cuál ayuda a mejorar el movimiento del sistema digestivo?',
                'points' => 1,
                'order' => 2,
                'success_message' => '¡Bien jugado! Mejora la motilidad digestiva.',
                'fail_message' => 'Casi... Vamos a la siguiente.',
            ],
            [
                'quiz_id' => 1,
                'question' => '¿Cuál ayuda a equilibrar la microbiota intestinal?',
                'points' => 1,
                'order' => 3,
                'success_message' => '¡Gol! Ayuda a restaurar la microbiota intestinal.',
                'fail_message' => 'No pasa nada, sigue jugando.',
            ],
        ];

        foreach ($questions as $question) {
            QuizQuestion::create($question);
        }
    }
}
