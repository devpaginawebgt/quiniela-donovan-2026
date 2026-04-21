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
            TermSeeder::class,
            ModuleSeeder::class,
            CountrySeeder::class,
            BannerSeeder::class,
            BrandSeeder::class,
            BrandPositionSeeder::class,
            CompanySeeder::class,
            BranchSeeder::class,
            VisitorSeeder::class,
            CodigoSeeder::class,
            UserTypeSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            GrupoSeeder::class,
            EquipoSeeder::class,
            EstadioSeeder::class,
            JornadaSeeder::class,

            // Scaffolding requerido por los listeners de MatchCreated.
            SystemSettingSeeder::class,
            PushNotificationTypeSeeder::class,

            PartidoSeeder::class,
            EquipoPartidoSeeder::class,
            BracketGameSeeder::class,
            // PrediccionSeeder::class,
            // ResultadoPartidoSeeder::class,
            PremioSeeder::class,

            QuizSeeder::class,
            QuizQuestionSeeder::class,
            QuizOptionSeeder::class,
            BonusSeeder::class,
        ]);
    }
}
