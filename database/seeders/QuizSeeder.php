<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $quizzes = [
        //     [ 
        //         'name'           => 'GastroQuiz',
        //         'attempts'       => 3, 
        //         'points'         => 3,                 
        //         'ranking_tab_id' => 1,
        //     ],
        // ];

        $quizzes = [
            // [
            //     'name'            => 'Semana #1',
            //     'attempts'        => 3,
            //     'points'          => 6,
            //     'ranking_tab_id'  => 1,
            //     'is_visible'      => true,
            //     'expires_at'      => null,
            //     'questions'       => [
            //         [
            //             'question'        => '¿Cuál es el beneficio de utilizar una metformina de liberación prolongada como METAVAN XR?',
            //             'points'          => 1,
            //             'order'           => 1,
            //             'success_message' => '¡Correcto! METAVAN XR libera el principio activo de forma gradual y constante, reduciendo los efectos secundarios.',
            //             'fail_message'    => 'Incorrecto. La ventaja principal de METAVAN XR es su liberación prolongada.',
            //             'options'         => [
            //                 [
            //                     'option_text' => 'Es más barata que una normal.',
            //                     'is_correct'  => false,
            //                     'order'       => 1,
            //                 ],
            //                 [
            //                     'option_text' => 'Permite la liberación de manera gradual, constante y con menores efectos secundarios.',
            //                     'is_correct'  => true,
            //                     'order'       => 2,
            //                 ],
            //                 [
            //                     'option_text' => 'Ninguno, solo el nombre es más técnico.',
            //                     'is_correct'  => false,
            //                     'order'       => 3,
            //                 ],
            //             ],
            //         ],
            //         [
            //             'question'        => '¿Cuál es el principio activo de Momemist?',
            //             'points'          => 1,
            //             'order'           => 2,
            //             'success_message' => '¡Correcto! El principio activo de Momemist es la Mometasona.',
            //             'fail_message'    => 'Incorrecto. El principio activo de Momemist es la Mometasona.',
            //             'options'         => [
            //                 [
            //                     'option_text' => 'Loratadina',
            //                     'is_correct'  => false,
            //                     'order'       => 1,
            //                 ],
            //                 [
            //                     'option_text' => 'Guaifenesina',
            //                     'is_correct'  => false,
            //                     'order'       => 2,
            //                 ],
            //                 [
            //                     'option_text' => 'Sucralfato',
            //                     'is_correct'  => false,
            //                     'order'       => 3,
            //                 ],
            //                 [
            //                     'option_text' => 'Mometasona',
            //                     'is_correct'  => true,
            //                     'order'       => 4,
            //                 ],
            //                 [
            //                     'option_text' => 'Esomeprazol',
            //                     'is_correct'  => false,
            //                     'order'       => 5,
            //                 ],
            //             ],
            //         ],
            //         [
            //             'question'        => '¿Cuál es la función de Lakit en el organismo?',
            //             'points'          => 1,
            //             'order'           => 3,
            //             'success_message' => '¡Correcto! Lakit bloquea la enzima que produce ácido úrico en la sangre.',
            //             'fail_message'    => 'Incorrecto. Lakit bloquea la enzima que produce ácido úrico en la sangre.',
            //             'options'         => [
            //                 [
            //                     'option_text' => 'Aumenta la eliminación de calcio',
            //                     'is_correct'  => false,
            //                     'order'       => 1,
            //                 ],
            //                 [
            //                     'option_text' => 'Bloquea la enzima que produce ácido úrico en la sangre',
            //                     'is_correct'  => true,
            //                     'order'       => 2,
            //                 ],
            //                 [
            //                     'option_text' => 'Estimula la producción de orina',
            //                     'is_correct'  => false,
            //                     'order'       => 3,
            //                 ],
            //                 [
            //                     'option_text' => 'Disminuye la presión arterial',
            //                     'is_correct'  => false,
            //                     'order'       => 4,
            //                 ],
            //             ],
            //         ],
            //         [
            //             'question'        => 'En el "equipo" de tu cuerpo, ¿qué función cumple Compleben para mantenerte en tu mejor rendimiento?',
            //             'points'          => 1,
            //             'order'           => 4,
            //             'success_message' => '¡Correcto! Compleben mejora la energía y el funcionamiento del sistema nervioso.',
            //             'fail_message'    => 'Incorrecto. Compleben mejora la energía y el funcionamiento del sistema nervioso.',
            //             'options'         => [
            //                 [
            //                     'option_text' => 'Aumentar la masa muscular',
            //                     'is_correct'  => false,
            //                     'order'       => 1,
            //                 ],
            //                 [
            //                     'option_text' => 'Mejorar la energía y el funcionamiento del sistema nervioso',
            //                     'is_correct'  => true,
            //                     'order'       => 2,
            //                 ],
            //                 [
            //                     'option_text' => 'Hidratar el cuerpo durante el partido',
            //                     'is_correct'  => false,
            //                     'order'       => 3,
            //                 ],
            //                 [
            //                     'option_text' => 'Reducir la grasa corporal',
            //                     'is_correct'  => false,
            //                     'order'       => 4,
            //                 ],
            //             ],
            //         ],
            //         [
            //             'question'        => '¿Cuáles son los 3 componentes que tiene Florabasil?',
            //             'points'          => 1,
            //             'order'           => 5,
            //             'success_message' => '¡Correcto! Florabasil contiene Bacillus Clausii, Fructooligosacáridos (FOS) y Zinc.',
            //             'fail_message'    => 'Incorrecto. Florabasil contiene Bacillus Clausii, Fructooligosacáridos (FOS) y Zinc.',
            //             'options'         => [
            //                 [
            //                     'option_text' => 'Bacillus Clausii, Fructooligosacáridos (FOS), Zinc',
            //                     'is_correct'  => true,
            //                     'order'       => 1,
            //                 ],
            //                 [
            //                     'option_text' => 'Bacillus Clausii, esomeprazol, nifuroxazida',
            //                     'is_correct'  => false,
            //                     'order'       => 2,
            //                 ],
            //                 [
            //                     'option_text' => 'Bacillus Clausii, Bromuro, dexlanzoprazol',
            //                     'is_correct'  => false,
            //                     'order'       => 3,
            //                 ],
            //                 [
            //                     'option_text' => 'Bacillus Clausii, Zinc, esomeprazol',
            //                     'is_correct'  => false,
            //                     'order'       => 4,
            //                 ],
            //             ],
            //         ],
            //         [
            //             'question'        => 'Principal Forte te ayuda en la protección de:',
            //             'points'          => 1,
            //             'order'           => 6,
            //             'success_message' => '¡Correcto! Principal Forte ayuda en la protección del hígado.',
            //             'fail_message'    => 'Incorrecto. Principal Forte ayuda en la protección del hígado.',
            //             'options'         => [
            //                 [
            //                     'option_text' => 'Riñones',
            //                     'is_correct'  => false,
            //                     'order'       => 1,
            //                 ],
            //                 [
            //                     'option_text' => 'Hígado',
            //                     'is_correct'  => true,
            //                     'order'       => 2,
            //                 ],
            //                 [
            //                     'option_text' => 'Estómago',
            //                     'is_correct'  => false,
            //                     'order'       => 3,
            //                 ],
            //                 [
            //                     'option_text' => 'Corazón',
            //                     'is_correct'  => false,
            //                     'order'       => 4,
            //                 ],
            //             ],
            //         ],
            //     ],
            // ]

            [
                'name'            => 'Semana #1',
                'attempts'        => 3,
                'points'          => 5,
                'ranking_tab_id'  => 1,
                'country_id'      => 2,
                'is_visible'      => false,
                'expires_at'      => null,
                'questions'       => [
                    [
                        'question'        => '¿Cuál es el beneficio de utilizar una metformina de liberación prolongada como METAVAN XR?',
                        'points'          => 1,
                        'order'           => 1,
                        'success_message' => '¡Correcto! METAVAN XR libera el principio activo de forma gradual y constante, reduciendo los efectos secundarios.',
                        'fail_message'    => 'Incorrecto. La ventaja principal de METAVAN XR es su liberación prolongada.',
                        'options'         => [
                            [
                                'option_text' => 'Es más barata que una normal.',
                                'is_correct'  => false,
                                'order'       => 1,
                            ],
                            [
                                'option_text' => 'Permite la liberación de manera gradual, constante y con menores efectos secundarios.',
                                'is_correct'  => true,
                                'order'       => 2,
                            ],
                            [
                                'option_text' => 'Ninguno, solo el nombre es más técnico.',
                                'is_correct'  => false,
                                'order'       => 3,
                            ],
                        ],
                    ],
                    [
                        'question'        => '¿Cuál es la función de Lakit en el organismo?',
                        'points'          => 1,
                        'order'           => 2,
                        'success_message' => '¡Correcto! Lakit bloquea la enzima que produce ácido úrico en la sangre.',
                        'fail_message'    => 'Incorrecto. Lakit bloquea la enzima que produce ácido úrico en la sangre.',
                        'options'         => [
                            [
                                'option_text' => 'Aumenta la eliminación de calcio',
                                'is_correct'  => false,
                                'order'       => 1,
                            ],
                            [
                                'option_text' => 'Bloquea la enzima que produce ácido úrico en la sangre',
                                'is_correct'  => true,
                                'order'       => 2,
                            ],
                            [
                                'option_text' => 'Estimula la producción de orina',
                                'is_correct'  => false,
                                'order'       => 3,
                            ],
                            [
                                'option_text' => 'Disminuye la presión arterial',
                                'is_correct'  => false,
                                'order'       => 4,
                            ],
                        ],
                    ],
                    [
                        'question'        => '¿Cuántos son los picos de liberación de Dexidian?',
                        'points'          => 1,
                        'order'           => 3,
                        'success_message' => '¡Correcto! Dexidian tiene dos picos de liberación: el primero a 1 hora y el segundo a las 4 horas.',
                        'fail_message'    => 'Incorrecto. Dexidian tiene dos picos de liberación: el primero a 1 hora y el segundo a las 4 horas.',
                        'options'         => [
                            [
                                'option_text' => 'Primera a 1 hora, segunda a las 4 horas',
                                'is_correct'  => true,
                                'order'       => 1,
                            ],
                            [
                                'option_text' => 'Solo tiene una liberación',
                                'is_correct'  => false,
                                'order'       => 2,
                            ],
                            [
                                'option_text' => 'Primera 4 horas, segunda a las 6 horas',
                                'is_correct'  => false,
                                'order'       => 3,
                            ],
                            [
                                'option_text' => 'Liberación constante',
                                'is_correct'  => false,
                                'order'       => 4,
                            ],
                        ],
                    ],
                    [
                        'question'        => '¿Qué tipo de cálculos ayuda a disolver Urdex?',
                        'points'          => 1,
                        'order'           => 4,
                        'success_message' => '¡Correcto! Urdex ayuda a disolver los cálculos de colesterol en la vesícula.',
                        'fail_message'    => 'Incorrecto. Urdex ayuda a disolver los cálculos de colesterol en la vesícula.',
                        'options'         => [
                            [
                                'option_text' => 'Cálculos renales',
                                'is_correct'  => false,
                                'order'       => 1,
                            ],
                            [
                                'option_text' => 'Cálculos de calcio',
                                'is_correct'  => false,
                                'order'       => 2,
                            ],
                            [
                                'option_text' => 'Cálculos de colesterol en la vesícula',
                                'is_correct'  => true,
                                'order'       => 3,
                            ],
                            [
                                'option_text' => 'Cálculos pulmonares',
                                'is_correct'  => false,
                                'order'       => 4,
                            ],
                        ],
                    ],
                    [
                        'question'        => 'Principal Forte te ayuda en la protección de:',
                        'points'          => 1,
                        'order'           => 5,
                        'success_message' => '¡Correcto! Principal Forte ayuda en la protección del hígado.',
                        'fail_message'    => 'Incorrecto. Principal Forte ayuda en la protección del hígado.',
                        'options'         => [
                            [
                                'option_text' => 'Riñones',
                                'is_correct'  => false,
                                'order'       => 1,
                            ],
                            [
                                'option_text' => 'Hígado',
                                'is_correct'  => true,
                                'order'       => 2,
                            ],
                            [
                                'option_text' => 'Estómago',
                                'is_correct'  => false,
                                'order'       => 3,
                            ],
                            [
                                'option_text' => 'Corazón',
                                'is_correct'  => false,
                                'order'       => 4,
                            ],
                        ],
                    ],
                ],
            ],
        ];


        foreach($quizzes as $quiz) {

            // Create quizz base

            $questions = $quiz['questions'];
            unset($quiz['questions']);

            $db_quiz = Quiz::create($quiz);

            // Add questions

            foreach($questions as $question) {
                $options = $question['options'];

                unset($question['options']);
                $question['quiz_id'] = $db_quiz->id;

                $db_question = QuizQuestion::create($question);

                foreach($options as $option) {
                    $option['quiz_question_id'] = $db_question->id;
                    QuizOption::create($option);
                }
            }
        }
    }
}
