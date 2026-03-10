<?php

namespace App\Http\Services;

class TermsService
{

    public function getTerms()
    {
        return [
            'version' => '1.0',

            'ultima_actualizacion' => '2026-03-10',

            'titulo' => 'Términos y Condiciones de Participación',

            'subtitulo' => 'Sistema de Quiniela',

            'introduccion' => 'La participación en el Sistema de Quiniela implica el conocimiento, comprensión y aceptación expresa de los presentes Términos y Condiciones. Toda persona que decida participar declara haber leído y aceptado íntegramente las disposiciones aquí establecidas. En caso de desacuerdo con cualquiera de los términos, deberá abstenerse de participar. La participación voluntaria constituye aceptación plena y total de las normas que regulan esta actividad.',

            'secciones' => [

                [
                    'numero' => 1,
                    'titulo' => 'Descripción General',
                    'contenido' => 'El Sistema de Quiniela es una dinámica recreativa dirigida exclusivamente a médicos invitados, que consiste en realizar pronósticos sobre los resultados oficiales de los partidos correspondientes a la Copa Mundial de la FIFA 2026. Los participantes podrán acceder a la plataforma oficial a través del sitio web: https://quiniela.placeholder.com Asimismo, el Sistema de Quiniela contará con una aplicación móvil disponible en App Store y Play Store, desde donde podrá consultarse la misma información, registrar pronósticos y verificar resultados. Tanto la página web como la aplicación reflejarán datos sincronizados. El objetivo de la actividad es fomentar un espacio de entretenimiento y sana competencia durante el desarrollo del torneo. El Sistema de Quiniela estará habilitado para participantes en: - Guatemala - Honduras La vigencia de la actividad comprenderá del 11 de junio de 2026 al 19 de julio de 2026, período oficial de la Copa Mundial de la FIFA 2026. La inscripción y participación estarán disponibles a partir del 11 de junio de 2026.',
                    'subsecciones' => null
                ],

                [
                    'numero' => 2,
                    'titulo' => 'Mecánica del Sistema',
                    'contenido' => null,
                    'subsecciones' => [

                        [
                            'letra' => 'a',
                            'titulo' => 'Alcance territorial',
                            'contenido' => 'El Sistema de Quiniela se desarrollará de manera virtual y estará dirigido a un público seleccionado. La premiación se realizará por Departamento dentro de cada país, de conformidad con la división territorial administrativa correspondiente. Cada participante competirá dentro del departamento en el cual se encuentre registrado.',
                        ],

                        [
                            'letra' => 'b',
                            'titulo' => 'Participantes',
                            'contenido' => 'La participación está limitada exclusivamente a profesionales médicos invitados que ejerzan en Guatemala y Honduras. No está abierta al público en general.',
                        ],

                        [
                            'letra' => 'c',
                            'titulo' => 'Inscripción y participación',
                            'contenido' => 'Los participantes podrán registrarse a partir del 11 de junio de 2026. Cada usuario podrá ingresar una predicción por partido. Los pronósticos podrán registrarse o modificarse hasta diez minutos antes del inicio de cada encuentro. Una vez que falten menos de diez (10) minutos para el inicio del partido, el sistema bloqueará automáticamente la opción de ingreso o modificación de pronósticos. Si el participante no registra una predicción para un partido determinado dentro del plazo establecido, no acumulará puntos en dicho encuentro.',
                        ],

                        [
                            'letra' => 'd',
                            'titulo' => 'Costo de participación',
                            'contenido' => 'La participación es totalmente gratuita y no requiere pago.',
                        ],

                        [
                            'letra' => 'e',
                            'titulo' => 'Disponibilidad',
                            'contenido' => 'El sistema estará disponible las 24 horas del día a través del sitio web y la aplicación móvil, sujeto a los plazos de cierre establecidos para cada partido.',
                        ],

                        [
                            'letra' => 'f',
                            'titulo' => 'Protección de datos',
                            'contenido' => 'La información proporcionada por los participantes será tratada de forma confidencial y utilizada exclusivamente para la administración, gestión y correcta ejecución del Sistema de Quiniela, conforme a la normativa aplicable en materia de protección de datos personales.',
                        ],

                        [
                            'letra' => 'g',
                            'titulo' => 'Sistema de puntuación',
                            'contenido' => 'La asignación de puntos se basará en el resultado oficial del partido al finalizar los 90 minutos reglamentarios, incluyendo el tiempo añadido por el árbitro. No se considerarán tiempos extra ni tandas de penales.',
                            'puntos' => [
                                ['condicion' => 'Acertó ambos marcadores exactos', 'valor' => '5 puntos'],
                                ['condicion' => 'Acertó equipo ganador y un marcador', 'valor' => '4 puntos'],
                                ['condicion' => 'Predijo equipo ganador sin acertar marcadores', 'valor' => '2 puntos'],
                                ['condicion' => 'Predijo empate sin acertar marcadores', 'valor' => '2 puntos'],
                                ['condicion' => 'Acertó uno de los marcadores', 'valor' => '1 punto'],
                            ],
                        ]

                    ]
                ],

                [
                    'numero' => 3,
                    'titulo' => 'Determinación de Ganadores',
                    'contenido' => null,
                    'subsecciones' => [

                        [
                            'letra' => 'a',
                            'titulo' => 'Ganadores',
                            'contenido' => 'Se otorgará premio a los primeros tres lugares por Departamento en cada país. Los ganadores serán los participantes que acumulen la mayor cantidad de puntos dentro de su respectivo departamento al finalizar todas las fases del torneo.',                            
                        ],

                        [
                            'letra' => 'b',
                            'titulo' => 'Publicación de resultados',
                            'contenido' => 'Cada participante podrá consultar su puntaje y posición ingresando a la plataforma web o aplicación móvil. La clasificación final será determinada al concluir el torneo.'
                        ],

                        [
                            'letra' => 'c',
                            'titulo' => 'Condiciones de los premios',
                            'contenido' => 'Los premios son personales e intransferibles. No podrán ser canjeados por dinero en efectivo ni sustituidos por otros bienes o servicios.'
                        ],

                        [
                            'letra' => 'd',
                            'titulo' => 'Notificación',
                            'contenido' => 'Los ganadores serán contactados a través del correo electrónico registrado durante la inscripción. En dicha comunicación se indicarán las instrucciones para la aceptación y coordinación de la entrega del premio. En caso de no recibir respuesta dentro del plazo indicado, se entenderá que el participante renuncia al premio, el cual podrá declararse desierto.'
                        ],

                        [
                            'letra' => 'e',
                            'titulo' => 'Empates',
                            'contenido' => 'En caso de empate en cualquiera de las posiciones premiadas, el comité organizador podrá establecer un mecanismo de desempate, el cual será informado oportunamente a los participantes involucrados.'
                        ],

                        [
                            'letra' => 'f',
                            'titulo' => 'Descalificación',
                            'contenido' => 'Podrá ser descalificado cualquier participante que incumpla los presentes Términos y Condiciones o que realice acciones que comprometan la transparencia, integridad o correcto funcionamiento del Sistema de Quiniela.'
                        ]

                    ]
                ],

                [
                    'numero' => 4,
                    'titulo' => 'Disposiciones Finales',
                    'contenido' => 'Cualquier situación no prevista en el presente documento será resuelta por el comité organizador, cuya decisión será definitiva e inapelable. La participación en el Sistema de Quiniela implica la aceptación total e incondicional de estos Términos y Condiciones, los cuales constituyen un acuerdo vinculante entre el participante y la organización responsable de la actividad.',
                    'subsecciones' => null
                ]

            ]
        ];
    }
}
