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
        // user_type_id: 1 = Dependiente, 2 = Doctor
        // pais_id: 1, 2

        $base = [
            [
                'posicion' => 1,
                'titulo_posicion' => 'Primer Lugar',
                'nombre' => 'Televisión 65Q6QV 65" QLED TV Ultra HD-4K',
                'descripcion' => 'Televisor QLED de 65" con resolución Ultra HD 4K, colores vibrantes y tecnología inteligente.',
                'imagen' => '/images/premios/television-65.png',
            ],
            [
                'posicion' => 2,
                'titulo_posicion' => 'Segundo Lugar',
                'nombre' => 'Televisión 50A4NV 50" Smart TV LED Full HD',
                'descripcion' => 'Smart TV LED de 50" con resolución Full HD, conectividad inteligente y aplicaciones integradas.',
                'imagen' => '/images/premios/television-50.png',
            ],
            [
                'posicion' => 3,
                'titulo_posicion' => 'Tercer Lugar  ',
                'nombre' => 'Televisión 43Q6QV 43" QLED TV Ultra HD-4K',
                'descripcion' => 'Televisor QLED de 43" con resolución Ultra HD 4K, colores vibrantes y tecnología inteligente.',
                'imagen' => '/images/premios/television-43.png',
            ],
        ];

        $paises = [1, 2];
        $userTypes = [1, 2];

        foreach ($paises as $paisId) {
            foreach ($userTypes as $userTypeId) {
                foreach ($base as $premio) {
                    Premio::create(array_merge($premio, [
                        'pais_id' => $paisId,
                        'user_type_id' => $userTypeId,
                    ]));
                }
            }
        }
    }
}
