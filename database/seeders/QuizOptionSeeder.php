<?php

namespace Database\Seeders;

use App\Models\QuizOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [

            // Question 1: ¿Qué medicamento protege el estómago...?
            [
                'quiz_question_id' => 1,
                'option_text' => 'Citrato de mosaprida',
                'is_correct' => false,
                'order' => 1,
            ],
            [
                'quiz_question_id' => 1,
                'option_text' => 'Kralfato - Sucralfato',
                'is_correct' => true,
                'order' => 2,
            ],
            [
                'quiz_question_id' => 1,
                'option_text' => 'Bacillus clausii',
                'is_correct' => false,
                'order' => 3,
            ],

            // Question 2: ¿Cuál ayuda a mejorar el movimiento del sistema digestivo?
            [
                'quiz_question_id' => 2,
                'option_text' => 'Bacillus clausii',
                'is_correct' => false,
                'order' => 1,
            ],
            [
                'quiz_question_id' => 2,
                'option_text' => 'Sucralfato',
                'is_correct' => false,
                'order' => 2,
            ],
            [
                'quiz_question_id' => 2,
                'option_text' => 'Perivan - Citrato de mosaprida',
                'is_correct' => true,
                'order' => 3,
            ],
            
            // Question 3: ¿Cuál ayuda a equilibrar la microbiota intestinal?
            [
                'quiz_question_id' => 3,
                'option_text' => 'Florabasil - Bacillus clausii + Zinc + FOS',
                'is_correct' => true,
                'order' => 1,
            ],
            [
                'quiz_question_id' => 3,
                'option_text' => 'Sucralfato',
                'is_correct' => false,
                'order' => 2,
            ],
            [
                'quiz_question_id' => 3,
                'option_text' => 'Citrato de mosaprida',
                'is_correct' => false,
                'order' => 3,
            ],
        ];

        foreach ($options as $option) {
            QuizOption::create($option);
        }
    }
}
