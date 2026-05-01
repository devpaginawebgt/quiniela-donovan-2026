<?php

namespace Database\Seeders;

use App\Events\MatchCreated;
use App\Models\EquipoPartido;
use App\Models\Partido;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fecha_inicial = Carbon::create(2026, 3, 1, 0, 0, 0, 'UTC');

        $partidos = [

            /* ======================
            GRUPO A - JORNADA 1
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 11, 15, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 19:00 UTC
                'estadio_id' => 3,
                'equipo_1' => 1, // México
                'equipo_2' => 2, // Sudáfrica
                'brand_id' => 1,
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 11, 22, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 02:00 UTC (12 junio)
                'estadio_id' => 4,
                'equipo_1' => 3, // República de Corea
                'equipo_2' => 4, // Dinamarca
                'brand_id' => 2,
            ],

            /* ======================
            GRUPO A - JORNADA 2
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 18, 12, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 16:00 UTC
                'estadio_id' => 6,
                'equipo_1' => 4, // Dinamarca
                'equipo_2' => 2, // Sudáfrica
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 18, 21, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 01:00 UTC (19 junio)
                'estadio_id' => 4,
                'equipo_1' => 1, // México
                'equipo_2' => 3, // República de Corea
            ],

            /* ======================
            GRUPO A - JORNADA 3
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 24, 21, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 01:00 UTC (25 junio)
                'estadio_id' => 3,
                'equipo_1' => 4, // Dinamarca
                'equipo_2' => 1, // México
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 24, 21, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 01:00 UTC (25 junio)
                'estadio_id' => 5,
                'equipo_1' => 2, // Sudáfrica
                'equipo_2' => 3, // República de Corea
            ],

            /* ======================
            GRUPO B - JORNADA 1
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 12, 15, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 19:00 UTC
                'estadio_id' => 1, // Toronto Stadium
                'equipo_1' => 5, // Canadá
                'equipo_2' => 6, // Italia placeholder
                'brand_id' => 3,
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 13, 15, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 19:00 UTC
                'estadio_id' => 15, // San Francisco Bay Area Stadium
                'equipo_1' => 7, // Catar
                'equipo_2' => 8, // Suiza
                'brand_id' => 1,
            ],

            /* ======================
            GRUPO B - JORNADA 2
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 18, 15, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 19:00 UTC
                'estadio_id' => 11, // Los Angeles Stadium
                'equipo_1' => 8, // Suiza
                'equipo_2' => 6, // Italia placeholder
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 18, 18, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 22:00 UTC
                'estadio_id' => 2, // BC Place Vancouver
                'equipo_1' => 5, // Canadá
                'equipo_2' => 7, // Catar
            ],

            /* ======================
            GRUPO B - JORNADA 3
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 24, 15, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 19:00 UTC
                'estadio_id' => 2, // BC Place Vancouver
                'equipo_1' => 8, // Suiza
                'equipo_2' => 5, // Canadá
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 24, 15, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 19:00 UTC
                'estadio_id' => 16, // Seattle Stadium
                'equipo_1' => 6, // Italia placeholder
                'equipo_2' => 7, // Catar
            ],

            /* ======================
            GRUPO C - JORNADA 1
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 13, 18, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 22:00 UTC
                'estadio_id' => 13, // New York/New Jersey Stadium
                'equipo_1' => 9,  // Brasil
                'equipo_2' => 10, // Marruecos
                'brand_id' => 2,
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 13, 21, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 01:00 UTC (14 junio)
                'estadio_id' => 7, // Boston Stadium
                'equipo_1' => 11, // Haití
                'equipo_2' => 12, // Escocia
                'brand_id' => 3,
            ],

            /* ======================
            GRUPO C - JORNADA 2
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 19, 18, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 22:00 UTC
                'estadio_id' => 7, // Boston Stadium
                'equipo_1' => 12, // Escocia
                'equipo_2' => 10, // Marruecos
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 19, 20, 30, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 01:00 UTC (20 junio)
                'estadio_id' => 14, // Philadelphia Stadium
                'equipo_1' => 9,  // Brasil
                'equipo_2' => 11, // Haití
            ],

            /* ======================
            GRUPO C - JORNADA 3
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 24, 18, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 22:00 UTC
                'estadio_id' => 12, // Miami Stadium
                'equipo_1' => 12, // Escocia
                'equipo_2' => 9,  // Brasil
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 24, 18, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 22:00 UTC
                'estadio_id' => 6, // Atlanta Stadium
                'equipo_1' => 10, // Marruecos
                'equipo_2' => 11, // Haití
            ],

            /* ======================
            GRUPO D - JORNADA 1
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 12, 21, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 01:00 UTC (13 junio)
                'estadio_id' => 11, // Los Angeles Stadium
                'equipo_1' => 13, // Estados Unidos
                'equipo_2' => 14, // Paraguay
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 14, 0, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 04:00 UTC
                'estadio_id' => 2, // BC Place Vancouver
                'equipo_1' => 15, // Australia
                'equipo_2' => 16, // Turquía placeholder
            ],

            /* ======================
            GRUPO D - JORNADA 2
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 19, 15, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 19:00 UTC
                'estadio_id' => 16, // Seattle Stadium
                'equipo_1' => 13, // Estados Unidos
                'equipo_2' => 15, // Australia
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 19, 23, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 04:00 UTC
                'estadio_id' => 15, // San Francisco Bay Area Stadium
                'equipo_1' => 16, // Turquía placeholder
                'equipo_2' => 14, // Paraguay
            ],

            /* ======================
            GRUPO D - JORNADA 3
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 25, 22, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 02:00 UTC (26 junio)
                'estadio_id' => 11, // Los Angeles Stadium
                'equipo_1' => 16, // Turquía placeholder
                'equipo_2' => 13, // Estados Unidos
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 25, 22, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 02:00 UTC (26 junio)
                'estadio_id' => 15, // San Francisco Bay Area Stadium
                'equipo_1' => 14, // Paraguay
                'equipo_2' => 15, // Australia
            ],

            /* ======================
            GRUPO E - JORNADA 1
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 14, 13, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 17:00 UTC
                'estadio_id' => 9, // Houston Stadium
                'equipo_1' => 17, // Alemania
                'equipo_2' => 18, // Curazao
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 14, 19, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 23:00 UTC
                'estadio_id' => 14, // Philadelphia Stadium
                'equipo_1' => 19, // Costa de Marfil
                'equipo_2' => 20, // Ecuador
            ],

            /* ======================
            GRUPO E - JORNADA 2
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 20, 16, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 20:00 UTC
                'estadio_id' => 1, // Toronto Stadium
                'equipo_1' => 17, // Alemania
                'equipo_2' => 19, // Costa de Marfil
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 20, 20, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 02:00 UTC (21 junio)
                'estadio_id' => 10, // Kansas City Stadium
                'equipo_1' => 20, // Ecuador
                'equipo_2' => 18, // Curazao
            ],

            /* ======================
            GRUPO E - JORNADA 3
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 25, 16, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 20:00 UTC
                'estadio_id' => 14, // Philadelphia Stadium
                'equipo_1' => 18, // Curazao
                'equipo_2' => 19, // Costa de Marfil
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 25, 16, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 20:00 UTC
                'estadio_id' => 13, // New York/New Jersey Stadium
                'equipo_1' => 20, // Ecuador
                'equipo_2' => 17, // Alemania
            ],

            /* ======================
            GRUPO F - JORNADA 1
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 14, 16, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 20:00 UTC
                'estadio_id' => 8, // Dallas Stadium
                'equipo_1' => 21, // Países Bajos
                'equipo_2' => 22, // Japón
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 14, 22, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 02:00 UTC (15 junio)
                'estadio_id' => 5, // Estadio Monterrey
                'equipo_1' => 23, // Placeholder
                'equipo_2' => 24, // Túnez
            ],

            /* ======================
            GRUPO F - JORNADA 2
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 20, 13, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 17:00 UTC
                'estadio_id' => 9, // Houston Stadium
                'equipo_1' => 21, // Países Bajos
                'equipo_2' => 23, // Placeholder
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 21, 0, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 04:00 UTC
                'estadio_id' => 5, // Estadio Monterrey
                'equipo_1' => 24, // Túnez
                'equipo_2' => 22, // Japón
            ],

            /* ======================
            GRUPO F - JORNADA 3
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 25, 19, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 23:00 UTC
                'estadio_id' => 8, // Dallas Stadium
                'equipo_1' => 22, // Japón
                'equipo_2' => 23, // Placeholder
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 25, 19, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 23:00 UTC
                'estadio_id' => 10, // Kansas City Stadium
                'equipo_1' => 24, // Túnez
                'equipo_2' => 21, // Países Bajos
            ],

            /* ======================
            GRUPO G - JORNADA 1
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 15, 15, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 19:00 UTC
                'estadio_id' => 16, // Seattle Stadium
                'equipo_1' => 25, // Bélgica
                'equipo_2' => 26, // Egipto
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 15, 21, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 01:00 UTC (16 junio)
                'estadio_id' => 11, // Los Angeles Stadium
                'equipo_1' => 27, // Irán
                'equipo_2' => 28, // Nueva Zelanda
            ],

            /* ======================
            GRUPO G - JORNADA 2
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 21, 15, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 19:00 UTC
                'estadio_id' => 11, // Los Angeles Stadium
                'equipo_1' => 25, // Bélgica
                'equipo_2' => 27, // Irán
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 21, 21, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 01:00 UTC (22 junio)
                'estadio_id' => 2, // BC Place Vancouver
                'equipo_1' => 28, // Nueva Zelanda
                'equipo_2' => 26, // Egipto
            ],

            /* ======================
            GRUPO G - JORNADA 3
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 26, 23, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 03:00 UTC (27 junio)
                'estadio_id' => 16, // Seattle Stadium
                'equipo_1' => 26, // Egipto
                'equipo_2' => 27, // Irán
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 26, 23, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 03:00 UTC (27 junio)
                'estadio_id' => 2, // BC Place Vancouver
                'equipo_1' => 28, // Nueva Zelanda
                'equipo_2' => 25, // Bélgica
            ],


            /* ======================
            GRUPO H - JORNADA 1
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 15, 12, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 16:00 UTC
                'estadio_id' => 6, // Atlanta Stadium
                'equipo_1' => 29, // España
                'equipo_2' => 30, // Cabo Verde
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 15, 18, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 22:00 UTC
                'estadio_id' => 12, // Miami Stadium
                'equipo_1' => 31, // Arabia Saudí
                'equipo_2' => 32, // Uruguay
            ],

            /* ======================
            GRUPO H - JORNADA 2
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 21, 12, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 16:00 UTC
                'estadio_id' => 6, // Atlanta Stadium
                'equipo_1' => 29, // España
                'equipo_2' => 31, // Arabia Saudí
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 21, 18, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 22:00 UTC
                'estadio_id' => 12, // Miami Stadium
                'equipo_1' => 32, // Uruguay
                'equipo_2' => 30, // Cabo Verde
            ],

            /* ======================
            GRUPO H - JORNADA 3
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 26, 20, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 00:00 UTC (27 junio)
                'estadio_id' => 9, // Houston Stadium
                'equipo_1' => 30, // Cabo Verde
                'equipo_2' => 31, // Arabia Saudí
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 26, 20, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 00:00 UTC (27 junio)
                'estadio_id' => 4, // Estadio Guadalajara
                'equipo_1' => 32, // Uruguay
                'equipo_2' => 29, // España
            ],


            /* ======================
            GRUPO I - JORNADA 1
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 16, 15, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 19:00 UTC
                'estadio_id' => 13, // New York/New Jersey Stadium
                'equipo_1' => 33, // Francia
                'equipo_2' => 34, // Senegal
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 16, 18, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 22:00 UTC
                'estadio_id' => 7, // Boston Stadium
                'equipo_1' => 35, // Placeholder Bolivia
                'equipo_2' => 36, // Noruega
            ],

            /* ======================
            GRUPO I - JORNADA 2
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 22, 17, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 21:00 UTC
                'estadio_id' => 14, // Philadelphia Stadium
                'equipo_1' => 33, // Francia
                'equipo_2' => 35, // Placeholder Bolivia
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 22, 20, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 00:00 UTC (23 junio)
                'estadio_id' => 13, // New York/New Jersey Stadium
                'equipo_1' => 36, // Noruega
                'equipo_2' => 34, // Senegal
            ],

            /* ======================
            GRUPO I - JORNADA 3
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 26, 15, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 19:00 UTC
                'estadio_id' => 7, // Boston Stadium
                'equipo_1' => 36, // Noruega
                'equipo_2' => 33, // Francia
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 26, 15, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 19:00 UTC
                'estadio_id' => 1, // Toronto Stadium
                'equipo_1' => 34, // Senegal
                'equipo_2' => 35, // Placeholder Bolivia
            ],


            /* ======================
            GRUPO J - JORNADA 1
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 16, 21, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 01:00 UTC (17 junio)
                'estadio_id' => 10, // Kansas City Stadium
                'equipo_1' => 37, // Argentina
                'equipo_2' => 38, // Argelia
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 17, 0, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 04:00 UTC
                'estadio_id' => 15, // San Francisco Bay Area Stadium
                'equipo_1' => 39, // Austria
                'equipo_2' => 40, // Jordania
            ],

            /* ======================
            GRUPO J - JORNADA 2
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 22, 13, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 17:00 UTC
                'estadio_id' => 8, // Dallas Stadium
                'equipo_1' => 37, // Argentina
                'equipo_2' => 39, // Austria
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 22, 23, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 03:00 UTC (23 junio)
                'estadio_id' => 15, // San Francisco Bay Area Stadium
                'equipo_1' => 40, // Jordania
                'equipo_2' => 38, // Argelia
            ],

            /* ======================
            GRUPO J - JORNADA 3
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 27, 22, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 02:00 UTC (28 junio)
                'estadio_id' => 10, // Kansas City Stadium
                'equipo_1' => 38, // Argelia
                'equipo_2' => 39, // Austria
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 27, 22, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 02:00 UTC (28 junio)
                'estadio_id' => 8, // Dallas Stadium
                'equipo_1' => 40, // Jordania
                'equipo_2' => 37, // Argentina
            ],

            /* ======================
            GRUPO K - JORNADA 1
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 17, 13, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 17:00 UTC
                'estadio_id' => 9, // Houston Stadium
                'equipo_1' => 41, // Portugal
                'equipo_2' => 42, // Placeholder Jamaica
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 17, 22, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 02:00 UTC (18 junio)
                'estadio_id' => 3, // Estadio Ciudad de México
                'equipo_1' => 43, // Uzbekistán
                'equipo_2' => 44, // Colombia
            ],

            /* ======================
            GRUPO K - JORNADA 2
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 23, 13, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 17:00 UTC
                'estadio_id' => 9, // Houston Stadium
                'equipo_1' => 41, // Portugal
                'equipo_2' => 43, // Uzbekistán
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 23, 22, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 02:00 UTC (24 junio)
                'estadio_id' => 4, // Estadio Guadalajara
                'equipo_1' => 44, // Colombia
                'equipo_2' => 42, // Placeholder Jamaica
            ],

            /* ======================
            GRUPO K - JORNADA 3
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 27, 19, 30, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 23:30 UTC
                'estadio_id' => 12, // Miami Stadium
                'equipo_1' => 44, // Colombia
                'equipo_2' => 41, // Portugal
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 27, 19, 30, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 23:30 UTC
                'estadio_id' => 6, // Atlanta Stadium
                'equipo_1' => 42, // Placeholder Jamaica
                'equipo_2' => 43, // Uzbekistán
            ],


            /* ======================
            GRUPO L - JORNADA 1
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 17, 16, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 20:00 UTC
                'estadio_id' => 8, // Dallas Stadium
                'equipo_1' => 45, // Inglaterra
                'equipo_2' => 46, // Croacia
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 1,
                'fecha_partido' => Carbon::create(2026, 6, 17, 19, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 23:00 UTC
                'estadio_id' => 1, // Toronto Stadium
                'equipo_1' => 47, // Ghana
                'equipo_2' => 48, // Panamá
            ],

            /* ======================
            GRUPO L - JORNADA 2
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 23, 16, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 20:00 UTC
                'estadio_id' => 7, // Boston Stadium
                'equipo_1' => 45, // Inglaterra
                'equipo_2' => 47, // Ghana
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 2,
                'fecha_partido' => Carbon::create(2026, 6, 23, 19, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 23:00 UTC
                'estadio_id' => 1, // Toronto Stadium
                'equipo_1' => 48, // Panamá
                'equipo_2' => 46, // Croacia
            ],

            /* ======================
            GRUPO L - JORNADA 3
            ====================== */

            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 27, 17, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 21:00 UTC
                'estadio_id' => 13, // New York/New Jersey Stadium
                'equipo_1' => 48, // Panamá
                'equipo_2' => 45, // Inglaterra
            ],
            [
                'fase' => 'GRUPOS',
                'jornada_id' => 3,
                'fecha_partido' => Carbon::create(2026, 6, 27, 17, 0, 0, 'America/New_York')
                    ->setTimezone('UTC')
                    ->toDateTimeString(), // 21:00 UTC
                'estadio_id' => 14, // Philadelphia Stadium
                'equipo_1' => 46, // Croacia
                'equipo_2' => 47, // Ghana
            ],

        ]; 

        foreach($partidos as $partido) {

            $equipo_1 = $partido['equipo_1'];

            unset($partido['equipo_1']);

            $equipo_2 = $partido['equipo_2'];

            unset($partido['equipo_2']);

            $partido_db = Partido::create($partido);

            $equipo_partido = EquipoPartido::create([
                'partido_id' => $partido_db->id,
                'equipo_1' => $equipo_1,
                'equipo_2' => $equipo_2
            ]);

            // Carga la relación para que los listeners (AddBracketGame,
            // ScheduleMatchPushNotification) puedan acceder a $partido->equipos.
            $partido_db->load('equipos');

            MatchCreated::dispatch($partido_db);
        }
    }
}
