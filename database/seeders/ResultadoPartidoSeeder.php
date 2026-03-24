<?php

namespace Database\Seeders;

use App\Models\EquipoPartido;
use App\Models\ResultadoPartido;
use Illuminate\Database\Seeder;

class ResultadoPartidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equiposPartidos = EquipoPartido::whereHas('partido')->get();

        if ($equiposPartidos->isEmpty()) {
            $this->command->warn('No hay partidos en la base de datos. Se omite la creación de resultados.');
            return;
        }

        foreach ($equiposPartidos as $ep) {
            $golesEquipo1 = fake()->numberBetween(0, 6);
            $golesEquipo2 = fake()->numberBetween(0, 6);

            // Determinar ganador (null si empate)
            $ganadorId = null;
            if ($golesEquipo1 > $golesEquipo2) {
                $ganadorId = $ep->equipo_1;
            } elseif ($golesEquipo2 > $golesEquipo1) {
                $ganadorId = $ep->equipo_2;
            }

            ResultadoPartido::create([
                'partido_id'     => $ep->partido_id,
                'goles_equipo_1' => $golesEquipo1,
                'goles_equipo_2' => $golesEquipo2,
                'equipo_ganador_id' => $ganadorId,
            ]);
        }
    }
}
