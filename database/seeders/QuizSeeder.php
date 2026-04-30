<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quizzes = [
            [ 
                'name'           => 'GastroQuiz',
                'attempts'       => 3, 
                'points'         => 3,                 
                'ranking_tab_id' => 1,
            ],
        ];

        foreach($quizzes as $quizz) {
            Quiz::create($quizz);
        }
    }
}
