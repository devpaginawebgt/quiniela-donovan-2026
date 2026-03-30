<?php

namespace Database\Seeders;

use App\Models\Premio;
use Illuminate\Database\Seeder;

class PremioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $premios = [
            [
                'posicion' => 1,
                'titulo_posicion' => 'Primeros 3 lugares',
                'nombre' => 'Televisión 55" 4K UHD',
                'descripcion' => 'Televisor de alta definición con conectividad inteligente y control por voz.',
                'imagen' => '/images/premios/tv.png',
                'pais_id' => 1,
            ],
            [
                'posicion' => 2,
                'titulo_posicion' => 'Siguientes 3 lugares',
                'nombre' => 'Teléfono Xiaomi 5G',
                'descripcion' => 'Smartphone Xiaomi con conectividad 5G, pantalla AMOLED y cámara de alta resolución.',
                'imagen' => '/images/premios/phone.png',
                'pais_id' => 1,
            ],
            [
                'posicion' => 3,
                'titulo_posicion' => 'Siguientes 2 lugares',
                'nombre' => 'Smartwatch deportivo',
                'descripcion' => 'Reloj inteligente con monitor de ritmo cardíaco y seguimiento de actividad física.',
                'imagen' => '/images/premios/smartwatch.png',
                'pais_id' => 1,
            ],

            [
                'posicion' => 1,
                'titulo_posicion' => 'Primeros 3 lugares',
                'nombre' => 'Consola PlayStation 5',
                'descripcion' => 'Consola de videojuegos de última generación con gráficos 4K, almacenamiento SSD ultrarrápido y experiencia de juego inmersiva.',
                'imagen' => '/images/premios/ps5.png',
                'pais_id' => 2,
            ],
            [
                'posicion' => 2,
                'titulo_posicion' => 'Siguientes 3 lugares',
                'nombre' => 'Apple AirPods inalámbricos',
                'descripcion' => 'Audífonos inalámbricos con sonido de alta calidad, conexión automática y estuche de carga portátil.',
                'imagen' => '/images/premios/airpods.png',
                'pais_id' => 2,
            ],
            [
                'posicion' => 3,
                'titulo_posicion' => 'Siguientes 2 lugares',
                'nombre' => 'Audífonos Bluetooth con cancelación de ruido',
                'descripcion' => 'Auriculares inalámbricos con tecnología de cancelación de ruido, batería de larga duración y sonido envolvente de alta fidelidad.',
                'imagen' => '/images/premios/headphones.png',
                'pais_id' => 2,
            ],
        ];

        foreach($premios as $premio) {
            Premio::create($premio);
        }
    }
}
