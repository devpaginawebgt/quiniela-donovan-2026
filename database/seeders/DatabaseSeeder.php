<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CodigoSeeder::class,
            CountrySeeder::class,
            CompanySeeder::class,
            VisitorSeeder::class,
            BranchSeeder::class,
            UserTypeSeeder::class,
            UserSeeder::class,
            GrupoSeeder::class,
            EquipoSeeder::class,
            EstadioSeeder::class,
            JornadaSeeder::class,
            PartidoSeeder::class,
            EquipoPartidoSeeder::class,
            ResultadoPartidoSeeder::class,
            PremioSeeder::class,
            // PrediccionSeeder::class
        ]);
    }
}
