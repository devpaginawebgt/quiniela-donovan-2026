<?php

namespace App\Http\Services;

use App\Models\EquipoPartido;
use App\Models\Partido;
use App\Models\ResultadoPartido;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Http;

class TestService
{

    public static function jornadaUno()
    {
        return array(
            0 =>
            array(
                'id' => 1,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-11 19:00:00',
                'estadio_id' => 3,
                'equipo_1' => 1,
                'goles_equipo_1' => 3,
                'equipo_2' => 1,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 1,
            ),
            1 =>
            array(
                'id' => 2,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-12 02:00:00',
                'estadio_id' => 4,
                'equipo_1' => 3,
                'goles_equipo_1' => 1,
                'equipo_2' => 3,
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => NULL,
            ),
            2 =>
            array(
                'id' => 7,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-12 19:00:00',
                'estadio_id' => 1,
                'equipo_1' => 5,
                'goles_equipo_1' => 1,
                'equipo_2' => 5,
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => NULL,
            ),
            3 =>
            array(
                'id' => 8,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-13 19:00:00',
                'estadio_id' => 15,
                'equipo_1' => 7,
                'goles_equipo_1' => 0,
                'equipo_2' => 7,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 8,
            ),
            4 =>
            array(
                'id' => 13,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-13 22:00:00',
                'estadio_id' => 13,
                'equipo_1' => 9,
                'goles_equipo_1' => 2,
                'equipo_2' => 9,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 9,
            ),
            5 =>
            array(
                'id' => 14,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-14 01:00:00',
                'estadio_id' => 7,
                'equipo_1' => 11,
                'goles_equipo_1' => 1,
                'equipo_2' => 11,
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 12,
            ),
            6 =>
            array(
                'id' => 19,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-13 01:00:00',
                'estadio_id' => 11,
                'equipo_1' => 13,
                'goles_equipo_1' => 3,
                'equipo_2' => 13,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => NULL,
            ),
            7 =>
            array(
                'id' => 20,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-13 04:00:00',
                'estadio_id' => 2,
                'equipo_1' => 15,
                'goles_equipo_1' => 2,
                'equipo_2' => 15,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => NULL,
            ),
            8 =>
            array(
                'id' => 25,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-14 17:00:00',
                'estadio_id' => 9,
                'equipo_1' => 17,
                'goles_equipo_1' => 4,
                'equipo_2' => 17,
                'goles_equipo_2' => 4,
                'equipo_ganador_id' => 17,
            ),
            9 =>
            array(
                'id' => 26,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-14 23:00:00',
                'estadio_id' => 14,
                'equipo_1' => 19,
                'goles_equipo_1' => 2,
                'equipo_2' => 19,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 19,
            ),
            10 =>
            array(
                'id' => 31,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-14 20:00:00',
                'estadio_id' => 8,
                'equipo_1' => 21,
                'goles_equipo_1' => 1,
                'equipo_2' => 21,
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 22,
            ),
            11 =>
            array(
                'id' => 32,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-15 02:00:00',
                'estadio_id' => 5,
                'equipo_1' => 23,
                'goles_equipo_1' => 4,
                'equipo_2' => 23,
                'goles_equipo_2' => 4,
                'equipo_ganador_id' => 23,
            ),
            12 =>
            array(
                'id' => 37,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-15 19:00:00',
                'estadio_id' => 16,
                'equipo_1' => 25,
                'goles_equipo_1' => 0,
                'equipo_2' => 25,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 26,
            ),
            13 =>
            array(
                'id' => 38,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-16 01:00:00',
                'estadio_id' => 11,
                'equipo_1' => 27,
                'goles_equipo_1' => 4,
                'equipo_2' => 27,
                'goles_equipo_2' => 4,
                'equipo_ganador_id' => 27,
            ),
            14 =>
            array(
                'id' => 43,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-15 16:00:00',
                'estadio_id' => 6,
                'equipo_1' => 29,
                'goles_equipo_1' => 2,
                'equipo_2' => 29,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => NULL,
            ),
            15 =>
            array(
                'id' => 44,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-15 22:00:00',
                'estadio_id' => 12,
                'equipo_1' => 31,
                'goles_equipo_1' => 4,
                'equipo_2' => 31,
                'goles_equipo_2' => 4,
                'equipo_ganador_id' => 31,
            ),
            16 =>
            array(
                'id' => 49,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-16 19:00:00',
                'estadio_id' => 13,
                'equipo_1' => 33,
                'goles_equipo_1' => 2,
                'equipo_2' => 33,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => NULL,
            ),
            17 =>
            array(
                'id' => 50,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-16 22:00:00',
                'estadio_id' => 7,
                'equipo_1' => 35,
                'goles_equipo_1' => 0,
                'equipo_2' => 35,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 36,
            ),
            18 =>
            array(
                'id' => 55,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-17 01:00:00',
                'estadio_id' => 10,
                'equipo_1' => 37,
                'goles_equipo_1' => 2,
                'equipo_2' => 37,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 37,
            ),
            19 =>
            array(
                'id' => 56,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-17 04:00:00',
                'estadio_id' => 15,
                'equipo_1' => 39,
                'goles_equipo_1' => 0,
                'equipo_2' => 39,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 40,
            ),
            20 =>
            array(
                'id' => 61,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-17 17:00:00',
                'estadio_id' => 9,
                'equipo_1' => 41,
                'goles_equipo_1' => 3,
                'equipo_2' => 41,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 41,
            ),
            21 =>
            array(
                'id' => 62,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-18 02:00:00',
                'estadio_id' => 3,
                'equipo_1' => 43,
                'goles_equipo_1' => 3,
                'equipo_2' => 43,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => NULL,
            ),
            22 =>
            array(
                'id' => 67,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-17 20:00:00',
                'estadio_id' => 8,
                'equipo_1' => 45,
                'goles_equipo_1' => 2,
                'equipo_2' => 45,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 45,
            ),
            23 =>
            array(
                'id' => 68,
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => '2026-06-17 23:00:00',
                'estadio_id' => 1,
                'equipo_1' => 47,
                'goles_equipo_1' => 2,
                'equipo_2' => 47,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 47,
            ),
        );
    }

    public static function jornadaDos()
    {
        return array(
            0 =>
            array(
                'id' => 3,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-18 16:00:00',
                'estadio_id' => 6,
                'equipo_1' => 4,
                'goles_equipo_1' => 2,
                'equipo_2' => 4,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 2,
            ),
            1 =>
            array(
                'id' => 4,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-19 01:00:00',
                'estadio_id' => 4,
                'equipo_1' => 1,
                'goles_equipo_1' => 0,
                'equipo_2' => 1,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 3,
            ),
            2 =>
            array(
                'id' => 9,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-18 19:00:00',
                'estadio_id' => 11,
                'equipo_1' => 8,
                'goles_equipo_1' => 3,
                'equipo_2' => 8,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 8,
            ),
            3 =>
            array(
                'id' => 10,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-18 22:00:00',
                'estadio_id' => 2,
                'equipo_1' => 5,
                'goles_equipo_1' => 3,
                'equipo_2' => 5,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 5,
            ),
            4 =>
            array(
                'id' => 15,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-19 22:00:00',
                'estadio_id' => 7,
                'equipo_1' => 12,
                'goles_equipo_1' => 0,
                'equipo_2' => 12,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 10,
            ),
            5 =>
            array(
                'id' => 16,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-20 01:00:00',
                'estadio_id' => 14,
                'equipo_1' => 9,
                'goles_equipo_1' => 1,
                'equipo_2' => 9,
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 11,
            ),
            6 =>
            array(
                'id' => 21,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-19 19:00:00',
                'estadio_id' => 16,
                'equipo_1' => 13,
                'goles_equipo_1' => 2,
                'equipo_2' => 13,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 15,
            ),
            7 =>
            array(
                'id' => 22,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-19 04:00:00',
                'estadio_id' => 15,
                'equipo_1' => 16,
                'goles_equipo_1' => 0,
                'equipo_2' => 16,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => NULL,
            ),
            8 =>
            array(
                'id' => 27,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-20 20:00:00',
                'estadio_id' => 1,
                'equipo_1' => 17,
                'goles_equipo_1' => 0,
                'equipo_2' => 17,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 19,
            ),
            9 =>
            array(
                'id' => 28,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-21 02:00:00',
                'estadio_id' => 10,
                'equipo_1' => 20,
                'goles_equipo_1' => 0,
                'equipo_2' => 20,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 18,
            ),
            10 =>
            array(
                'id' => 33,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-20 17:00:00',
                'estadio_id' => 9,
                'equipo_1' => 21,
                'goles_equipo_1' => 3,
                'equipo_2' => 21,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 21,
            ),
            11 =>
            array(
                'id' => 34,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-20 04:00:00',
                'estadio_id' => 5,
                'equipo_1' => 24,
                'goles_equipo_1' => 2,
                'equipo_2' => 24,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 22,
            ),
            12 =>
            array(
                'id' => 39,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-21 19:00:00',
                'estadio_id' => 11,
                'equipo_1' => 25,
                'goles_equipo_1' => 2,
                'equipo_2' => 25,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 27,
            ),
            13 =>
            array(
                'id' => 40,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-22 01:00:00',
                'estadio_id' => 2,
                'equipo_1' => 28,
                'goles_equipo_1' => 3,
                'equipo_2' => 28,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 28,
            ),
            14 =>
            array(
                'id' => 45,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-21 16:00:00',
                'estadio_id' => 6,
                'equipo_1' => 29,
                'goles_equipo_1' => 3,
                'equipo_2' => 29,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 29,
            ),
            15 =>
            array(
                'id' => 46,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-21 22:00:00',
                'estadio_id' => 12,
                'equipo_1' => 32,
                'goles_equipo_1' => 1,
                'equipo_2' => 32,
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 30,
            ),
            16 =>
            array(
                'id' => 51,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-22 21:00:00',
                'estadio_id' => 14,
                'equipo_1' => 33,
                'goles_equipo_1' => 3,
                'equipo_2' => 33,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => NULL,
            ),
            17 =>
            array(
                'id' => 52,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-23 00:00:00',
                'estadio_id' => 13,
                'equipo_1' => 36,
                'goles_equipo_1' => 0,
                'equipo_2' => 36,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => NULL,
            ),
            18 =>
            array(
                'id' => 57,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-22 17:00:00',
                'estadio_id' => 8,
                'equipo_1' => 37,
                'goles_equipo_1' => 4,
                'equipo_2' => 37,
                'goles_equipo_2' => 4,
                'equipo_ganador_id' => 37,
            ),
            19 =>
            array(
                'id' => 58,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-23 03:00:00',
                'estadio_id' => 15,
                'equipo_1' => 40,
                'goles_equipo_1' => 1,
                'equipo_2' => 40,
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 40,
            ),
            20 =>
            array(
                'id' => 63,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-23 17:00:00',
                'estadio_id' => 9,
                'equipo_1' => 41,
                'goles_equipo_1' => 3,
                'equipo_2' => 41,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 41,
            ),
            21 =>
            array(
                'id' => 64,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-24 02:00:00',
                'estadio_id' => 4,
                'equipo_1' => 44,
                'goles_equipo_1' => 4,
                'equipo_2' => 44,
                'goles_equipo_2' => 4,
                'equipo_ganador_id' => 44,
            ),
            22 =>
            array(
                'id' => 69,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-23 20:00:00',
                'estadio_id' => 7,
                'equipo_1' => 45,
                'goles_equipo_1' => 3,
                'equipo_2' => 45,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 45,
            ),
            23 =>
            array(
                'id' => 70,
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => '2026-06-23 23:00:00',
                'estadio_id' => 1,
                'equipo_1' => 48,
                'goles_equipo_1' => 1,
                'equipo_2' => 48,
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 46,
            ),
        );
    }

    public static function jornadaTres()
    {
        return array(
            0 =>
            array(
                'id' => 5,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-25 01:00:00',
                'estadio_id' => 3,
                'equipo_1' => 4,
                'goles_equipo_1' => 3,
                'equipo_2' => 4,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 4,
            ),
            1 =>
            array(
                'id' => 6,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-25 01:00:00',
                'estadio_id' => 5,
                'equipo_1' => 2,
                'goles_equipo_1' => 2,
                'equipo_2' => 2,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 3,
            ),
            2 =>
            array(
                'id' => 11,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-24 19:00:00',
                'estadio_id' => 2,
                'equipo_1' => 8,
                'goles_equipo_1' => 2,
                'equipo_2' => 8,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 8,
            ),
            3 =>
            array(
                'id' => 12,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-24 19:00:00',
                'estadio_id' => 16,
                'equipo_1' => 6,
                'goles_equipo_1' => 0,
                'equipo_2' => 6,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => NULL,
            ),
            4 =>
            array(
                'id' => 17,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-24 22:00:00',
                'estadio_id' => 12,
                'equipo_1' => 9,
                'goles_equipo_1' => 1,
                'equipo_2' => 9,
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => NULL,
            ),
            5 =>
            array(
                'id' => 18,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-24 22:00:00',
                'estadio_id' => 6,
                'equipo_1' => 10,
                'goles_equipo_1' => 4,
                'equipo_2' => 10,
                'goles_equipo_2' => 4,
                'equipo_ganador_id' => NULL,
            ),
            6 =>
            array(
                'id' => 23,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-26 02:00:00',
                'estadio_id' => 11,
                'equipo_1' => 16,
                'goles_equipo_1' => 0,
                'equipo_2' => 16,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 13,
            ),
            7 =>
            array(
                'id' => 24,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-26 02:00:00',
                'estadio_id' => 15,
                'equipo_1' => 14,
                'goles_equipo_1' => 0,
                'equipo_2' => 14,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 15,
            ),
            8 =>
            array(
                'id' => 29,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-25 20:00:00',
                'estadio_id' => 14,
                'equipo_1' => 18,
                'goles_equipo_1' => 4,
                'equipo_2' => 18,
                'goles_equipo_2' => 4,
                'equipo_ganador_id' => 18,
            ),
            9 =>
            array(
                'id' => 30,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-25 20:00:00',
                'estadio_id' => 13,
                'equipo_1' => 20,
                'goles_equipo_1' => 2,
                'equipo_2' => 20,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => NULL,
            ),
            10 =>
            array(
                'id' => 35,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-25 23:00:00',
                'estadio_id' => 8,
                'equipo_1' => 22,
                'goles_equipo_1' => 0,
                'equipo_2' => 22,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 23,
            ),
            11 =>
            array(
                'id' => 36,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-25 23:00:00',
                'estadio_id' => 10,
                'equipo_1' => 24,
                'goles_equipo_1' => 1,
                'equipo_2' => 24,
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 21,
            ),
            12 =>
            array(
                'id' => 41,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-27 03:00:00',
                'estadio_id' => 16,
                'equipo_1' => 26,
                'goles_equipo_1' => 4,
                'equipo_2' => 26,
                'goles_equipo_2' => 4,
                'equipo_ganador_id' => 26,
            ),
            13 =>
            array(
                'id' => 42,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-27 03:00:00',
                'estadio_id' => 2,
                'equipo_1' => 28,
                'goles_equipo_1' => 0,
                'equipo_2' => 28,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 25,
            ),
            14 =>
            array(
                'id' => 47,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-27 00:00:00',
                'estadio_id' => 9,
                'equipo_1' => 30,
                'goles_equipo_1' => 0,
                'equipo_2' => 30,
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 31,
            ),
            15 =>
            array(
                'id' => 48,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-27 00:00:00',
                'estadio_id' => 4,
                'equipo_1' => 32,
                'goles_equipo_1' => 2,
                'equipo_2' => 32,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 29,
            ),
            16 =>
            array(
                'id' => 53,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-26 19:00:00',
                'estadio_id' => 7,
                'equipo_1' => 36,
                'goles_equipo_1' => 2,
                'equipo_2' => 36,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => NULL,
            ),
            17 =>
            array(
                'id' => 54,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-26 19:00:00',
                'estadio_id' => 1,
                'equipo_1' => 34,
                'goles_equipo_1' => 2,
                'equipo_2' => 34,
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 35,
            ),
            18 =>
            array(
                'id' => 59,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-28 02:00:00',
                'estadio_id' => 10,
                'equipo_1' => 38,
                'goles_equipo_1' => 3,
                'equipo_2' => 38,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 38,
            ),
            19 =>
            array(
                'id' => 60,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-28 02:00:00',
                'estadio_id' => 8,
                'equipo_1' => 40,
                'goles_equipo_1' => 3,
                'equipo_2' => 40,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => NULL,
            ),
            20 =>
            array(
                'id' => 65,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-27 23:30:00',
                'estadio_id' => 12,
                'equipo_1' => 44,
                'goles_equipo_1' => 4,
                'equipo_2' => 44,
                'goles_equipo_2' => 4,
                'equipo_ganador_id' => 44,
            ),
            21 =>
            array(
                'id' => 66,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-27 23:30:00',
                'estadio_id' => 6,
                'equipo_1' => 42,
                'goles_equipo_1' => 3,
                'equipo_2' => 42,
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 42,
            ),
            22 =>
            array(
                'id' => 71,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-27 21:00:00',
                'estadio_id' => 13,
                'equipo_1' => 48,
                'goles_equipo_1' => 1,
                'equipo_2' => 48,
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 45,
            ),
            23 =>
            array(
                'id' => 72,
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => '2026-06-27 21:00:00',
                'estadio_id' => 14,
                'equipo_1' => 46,
                'goles_equipo_1' => 1,
                'equipo_2' => 46,
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => NULL,
            ),
        );
    }

    public static function dieciseisavos()
    {
        $fecha_inicial = Carbon::create(2026, 6, 1, 0, 0, 0, 'UTC');

        return [
            // DIECISEISAVOS — Jornada 4
            // Día 1: 1A vs 2B | 1B vs 2A
            [
                'id' => 73,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(36)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 3,   // 1A — gana
                'goles_equipo_1' => 2,
                'equipo_2' => 5,   // 2B
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 3,
            ],
            [
                'id' => 74,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(36)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 8,   // 1B
                'goles_equipo_1' => 1,
                'equipo_2' => 4,   // 2A — gana
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 4,
            ],
            // Día 1: 1C vs 3F | 1D vs 2C
            [
                'id' => 75,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(36)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 12,  // 1C — gana
                'goles_equipo_1' => 3,
                'equipo_2' => 22,  // 3F
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 12,
            ],
            [
                'id' => 76,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(36)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 15,  // 1D
                'goles_equipo_1' => 0,
                'equipo_2' => 10,  // 2C — gana
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 10,
            ],

            // Día 2: 1E vs 2F | 1F vs 2E
            [
                'id' => 77,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(37)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 18,  // 1E — gana
                'goles_equipo_1' => 1,
                'equipo_2' => 23,  // 2F
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 18,
            ],
            [
                'id' => 78,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(37)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 21,  // 1F
                'goles_equipo_1' => 1,
                'equipo_2' => 19,  // 2E — gana
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 19,
            ],
            // Día 2: 1G vs 3E | 1H vs 3G
            [
                'id' => 79,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(37)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 26,  // 1G — gana
                'goles_equipo_1' => 4,
                'equipo_2' => 17,  // 3E
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 26,
            ],
            [
                'id' => 80,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(37)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 29,  // 1H
                'goles_equipo_1' => 1,
                'equipo_2' => 25,  // 3G — gana
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 25,
            ],

            // Día 3: 1I vs 2J | 1J vs 2I
            [
                'id' => 81,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(38)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 36,  // 1I
                'goles_equipo_1' => 2,
                'equipo_2' => 37,  // 2J — gana
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 37,
            ],
            [
                'id' => 82,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(38)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 40,  // 1J — gana
                'goles_equipo_1' => 3,
                'equipo_2' => 35,  // 2I
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 40,
            ],
            // Día 3: 1K vs 3I | 1L vs 3J
            [
                'id' => 83,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(38)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 44,  // 1K
                'goles_equipo_1' => 1,
                'equipo_2' => 33,  // 3I — gana
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 33,
            ],
            [
                'id' => 84,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(38)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 45,  // 1L — gana
                'goles_equipo_1' => 2,
                'equipo_2' => 38,  // 3J
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 45,
            ],

            // Día 4: 2D vs 3C | 2G vs 3H
            [
                'id' => 85,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(39)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 13,  // 2D
                'goles_equipo_1' => 0,
                'equipo_2' => 9,   // 3C — gana
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 9,
            ],
            [
                'id' => 86,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(39)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 27,  // 2G — gana
                'goles_equipo_1' => 3,
                'equipo_2' => 30,  // 3H
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 27,
            ],
            // Día 4: 2H vs 3L | 2K vs 2L
            [
                'id' => 87,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(39)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 31,  // 2H — gana
                'goles_equipo_1' => 1,
                'equipo_2' => 46,  // 3L
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 31,
            ],
            [
                'id' => 88,
                'fase' => 'DIECISEISAVOS',
                'jornada_id' => 4,
                'fecha_partido' => $fecha_inicial->copy()->addDays(39)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 41,  // 2K
                'goles_equipo_1' => 2,
                'equipo_2' => 47,  // 2L
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 41,
            ],
        ];
    }

    public static function octavos()
    {
        $fecha_inicial = Carbon::create(2026, 6, 1, 0, 0, 0, 'UTC');

        return [
            // OCTAVOS DE FINAL — Jornada 5
            // Día 1: w73 vs w74 | w75 vs w76
            [
                'id' => 89,
                'fase' => 'OCTAVOS',
                'jornada_id' => 5,
                'fecha_partido' => $fecha_inicial->copy()->addDays(42)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 3,   // w73 — gana
                'goles_equipo_1' => 2,
                'equipo_2' => 4,   // w74
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 3,
            ],
            [
                'id' => 90,
                'fase' => 'OCTAVOS',
                'jornada_id' => 5,
                'fecha_partido' => $fecha_inicial->copy()->addDays(42)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 12,  // w75
                'goles_equipo_1' => 0,
                'equipo_2' => 10,  // w76 — gana
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 10,
            ],
            // Día 1: w77 vs w78 | w79 vs w80
            [
                'id' => 91,
                'fase' => 'OCTAVOS',
                'jornada_id' => 5,
                'fecha_partido' => $fecha_inicial->copy()->addDays(42)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 18,  // w77
                'goles_equipo_1' => 1,
                'equipo_2' => 19,  // w78 — gana
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 19,
            ],
            [
                'id' => 92,
                'fase' => 'OCTAVOS',
                'jornada_id' => 5,
                'fecha_partido' => $fecha_inicial->copy()->addDays(42)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 26,  // w79 — gana
                'goles_equipo_1' => 3,
                'equipo_2' => 25,  // w80
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 26,
            ],

            // Día 2: w81 vs w82 | w83 vs w84
            [
                'id' => 93,
                'fase' => 'OCTAVOS',
                'jornada_id' => 5,
                'fecha_partido' => $fecha_inicial->copy()->addDays(43)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 37,  // w81
                'goles_equipo_1' => 0,
                'equipo_2' => 40,  // w82 — gana
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 40,
            ],
            [
                'id' => 94,
                'fase' => 'OCTAVOS',
                'jornada_id' => 5,
                'fecha_partido' => $fecha_inicial->copy()->addDays(43)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 33,  // w83
                'goles_equipo_1' => 1,
                'equipo_2' => 45,  // w84 — gana
                'goles_equipo_2' => 3,
                'equipo_ganador_id' => 45,
            ],
            // Día 2: w85 vs w86 | w87 vs w88
            [
                'id' => 95,
                'fase' => 'OCTAVOS',
                'jornada_id' => 5,
                'fecha_partido' => $fecha_inicial->copy()->addDays(43)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 9,   // w85 — gana
                'goles_equipo_1' => 2,
                'equipo_2' => 27,  // w86
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 9,
            ],
            [
                'id' => 96,
                'fase' => 'OCTAVOS',
                'jornada_id' => 5,
                'fecha_partido' => $fecha_inicial->copy()->addDays(43)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 31,  // w87 — gana
                'goles_equipo_1' => 1,
                'equipo_2' => 41,  // w88
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 31,
            ],
        ];
    }

    public static function cuartos()
    {
        $fecha_inicial = Carbon::create(2026, 6, 1, 0, 0, 0, 'UTC');

        return [
            // CUARTOS DE FINAL — Jornada 6
            // Día 1: w89(3) vs w90(10) | w91(19) vs w92(26)
            [
                'id' => 97,
                'fase' => 'CUARTOS',
                'jornada_id' => 6,
                'fecha_partido' => $fecha_inicial->copy()->addDays(46)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 3,   // w89 — gana
                'goles_equipo_1' => 2,
                'equipo_2' => 10,  // w90
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 3,
            ],
            [
                'id' => 98,
                'fase' => 'CUARTOS',
                'jornada_id' => 6,
                'fecha_partido' => $fecha_inicial->copy()->addDays(46)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 19,  // w91
                'goles_equipo_1' => 1,
                'equipo_2' => 26,  // w92 — gana
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 26,
            ],
            // Día 2: w93(40) vs w94(45) | w95(9) vs w96(31)
            [
                'id' => 99,
                'fase' => 'CUARTOS',
                'jornada_id' => 6,
                'fecha_partido' => $fecha_inicial->copy()->addDays(47)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 40,  // w93
                'goles_equipo_1' => 0,
                'equipo_2' => 45,  // w94 — gana
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 45,
            ],
            [
                'id' => 100,
                'fase' => 'CUARTOS',
                'jornada_id' => 6,
                'fecha_partido' => $fecha_inicial->copy()->addDays(47)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 9,   // w95 — gana
                'goles_equipo_1' => 3,
                'equipo_2' => 31,  // w96
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 9,
            ],
        ];
    }

    public static function semifinales()
    {
        $fecha_inicial = Carbon::create(2026, 6, 1, 0, 0, 0, 'UTC');

        return [
            // SEMIFINALES — Jornada 7
            // w97(3) vs w98(26) | w99(45) vs w100(9)
            [
                'id' => 101,
                'fase' => 'SEMIFINALES',
                'jornada_id' => 7,
                'fecha_partido' => $fecha_inicial->copy()->addDays(52)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 3,   // w97 — gana
                'goles_equipo_1' => 2,
                'equipo_2' => 26,  // w98
                'goles_equipo_2' => 0,
                'equipo_ganador_id' => 3,
            ],
            [
                'id' => 102,
                'fase' => 'SEMIFINALES',
                'jornada_id' => 7,
                'fecha_partido' => $fecha_inicial->copy()->addDays(53)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 45,  // w99
                'goles_equipo_1' => 1,
                'equipo_2' => 9,   // w100 — gana
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 9,
            ],
        ];
    }

    public static function tercerLugar()
    {
        $fecha_inicial = Carbon::create(2026, 6, 1, 0, 0, 0, 'UTC');

        return [
            // TERCER LUGAR — Jornada 8
            // Perdedor semi101(26) vs Perdedor semi102(45)
            [
                'id' => 103,
                'fase' => 'TERCER LUGAR',
                'jornada_id' => 8,
                'fecha_partido' => $fecha_inicial->copy()->addDays(56)->addHours(8)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 26,  // perdedor semi101 — gana
                'goles_equipo_1' => 2,
                'equipo_2' => 45,  // perdedor semi102
                'goles_equipo_2' => 1,
                'equipo_ganador_id' => 26,
            ],
        ];
    }

    public static function finales()
    {
        $fecha_inicial = Carbon::create(2026, 6, 1, 0, 0, 0, 'UTC');

        return [
            // FINAL — Jornada 9
            // Ganador semi101(3) vs Ganador semi102(9)
            [
                'id' => 104,
                'fase' => 'FINALES',
                'jornada_id' => 9,
                'fecha_partido' => $fecha_inicial->copy()->addDays(56)->addHours(16)->toDateTimeString(),
                'estadio_id' => rand(1, 16),
                'equipo_1' => 3,   // ganador semi101
                'goles_equipo_1' => 1,
                'equipo_2' => 9,   // ganador semi102 — CAMPEÓN
                'goles_equipo_2' => 2,
                'equipo_ganador_id' => 9,
            ],
        ];
    }

    public static function guardarResultadoPartido(int $id_partido)
    {
        $partido_db = Partido::find($id_partido);

        if (empty($partido_db)) return ['error' => 'Error al encontrar el partido en base de datos.'];

        $partido_test = null;

        $jornada_test = [];

        switch ($partido_db->jornada) {
            case 1:
                $jornada_test = TestService::jornadaUno();
                break;
            case 2:
                $jornada_test = TestService::jornadaDos();
                break;
            case 3:
                $jornada_test = TestService::jornadaTres();
                break;
            case 4:
                $jornada_test = TestService::dieciseisavos();
                break;
            case 5:
                $jornada_test = TestService::octavos();
                break;
            case 6:
                $jornada_test = TestService::cuartos();
                break;
            case 7:
                $jornada_test = TestService::semifinales();
                break;
            case 8:
                $jornada_test = TestService::tercerLugar();
                break;
            case 9:
                $jornada_test = TestService::finales();
                break;
            default:
                $jornada_test = [];
        }

        if (empty($jornada_test)) return ['error' => 'Error al encontrar la jornada del partido.'];

        $partido_test = array_find($jornada_test, function ($partido) use ($id_partido) {
            return (int)$partido['id'] === (int)$id_partido;
        });

        if (empty($partido_test)) return ['error' => 'Error al encontrar el partido en listado.'];

        $resultado_db = ResultadoPartido::find($id_partido);

        if (! empty($resultado_db)) return ['error' => 'Este partido ya tiene un resultado ingresado.'];

        $resultado = ResultadoPartido::create([
            'partido_id' => $id_partido,
            'goles_equipo_1' => $partido_test['goles_equipo_1'],
            'goles_equipo_2' => $partido_test['goles_equipo_2'],
            'equipo_ganador_id' => $partido_test['equipo_ganador_id'],
        ]);

        if (empty($resultado)) return ['error' => 'Error al guardar resultado del partido.'];

        return [
            'message' => 'Se ha procesado el partido con éxito.',
            'resultado' => $resultado
        ];
    }
}
