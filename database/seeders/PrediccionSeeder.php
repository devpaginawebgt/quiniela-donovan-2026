<?php

namespace Database\Seeders;

use App\Models\Partido;
use App\Models\Preccion;
use App\Models\User;
use Illuminate\Database\Seeder;

class PrediccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // -- Lógica original comentada --
        // $predicciones = [
        //     ['user_id' => 1, 'partido_id' => 1, 'goles_equipo_1' => 2, 'goles_equipo_2' => 2],
        //     ['user_id' => 1, 'partido_id' => 2, 'goles_equipo_1' => 2, 'goles_equipo_2' => 2],
        // ];
        // foreach($predicciones as $prediccion) {
        //     Preccion::create($prediccion);
        // }
        // $predicciones_user_1 = 12;
        // for ($i = 0; $i < $predicciones_user_1; $i++) {
        //     Preccion::factory()->create([
        //         'user_id' => 1,
        //         'partido_id' => $i + 3,
        //     ]);
        // }
        // $predicciones_revisor = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 13];
        // foreach($predicciones_revisor as $id_partido) {
        //     Preccion::factory()->create(['user_id' => 2, 'partido_id' => $id_partido]);
        //     Preccion::factory()->create(['user_id' => 3, 'partido_id' => $id_partido]);
        //     Preccion::factory()->create(['user_id' => 4, 'partido_id' => $id_partido]);
        // }

        $users = User::where('status_user', 1)->get();
        $partidoIds = Partido::pluck('id');

        if ($partidoIds->isEmpty()) {
            $this->command->warn('No hay partidos en la base de datos. Se omite la creación de predicciones.');
            return;
        }

        // ~5% de usuarios no generan predicciones (para testear filtro en ranking)
        $skipRate = 0.05;

        $records = [];

        foreach ($users as $user) {
            if (fake()->boolean($skipRate * 100)) {
                continue;
            }

            foreach ($partidoIds as $partidoId) {
                $records[] = [
                    'user_id'        => $user->id,
                    'partido_id'     => $partidoId,
                    'goles_equipo_1' => fake()->numberBetween(0, 6),
                    'goles_equipo_2' => fake()->numberBetween(0, 6),
                    'status'         => 0,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }

            // Insertar en lotes de 1000 para no saturar memoria
            if (count($records) >= 1000) {
                Preccion::insert($records);
                $records = [];
            }
        }

        // Insertar registros restantes
        if (count($records) > 0) {
            Preccion::insert($records);
        }
    }
}
