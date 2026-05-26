<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            [ 'name' => 'App - Próximos Partidos', 'code' => 'app-proximos-partidos', 'permission_name' => 'read pools' ],
            [ 'name' => 'App - Mis Pronósticos',   'code' => 'app-mis-pronosticos',   'permission_name' => 'read pools results' ],
            [ 'name' => 'App - Trivias',           'code' => 'app-trivias',           'permission_name' => 'read quizzes' ],
            [ 'name' => 'App - Calendario',        'code' => 'app-calendario',        'permission_name' => 'read calendar' ],
            [ 'name' => 'App - Estadios',          'code' => 'app-estadios',          'permission_name' => 'read stadiums' ],
            [ 'name' => 'App - Grupos',            'code' => 'app-grupos',            'permission_name' => 'read groups' ],
            [ 'name' => 'App - Equipos',           'code' => 'app-equipos',           'permission_name' => 'read teams' ],
            [ 'name' => 'App - Clasificación',     'code' => 'app-clasificacion',     'permission_name' => 'read ranking' ],
            [ 'name' => 'App - Recompensas',       'code' => 'app-recompensas',       'permission_name' => 'read prizes' ],

            [ 'name' => 'Web - Próximos Partidos', 'code' => 'web-proximos-partidos', 'permission_name' => 'read pools' ],
            [ 'name' => 'Web - Mis Pronósticos',   'code' => 'web-mis-pronosticos',   'permission_name' => 'read pools results' ],
            [ 'name' => 'Web - Trivias',           'code' => 'web-trivias',           'permission_name' => 'read quizzes' ],
            [ 'name' => 'Web - Calendario',        'code' => 'web-calendario',        'permission_name' => 'read calendar' ],
            [ 'name' => 'Web - Estadios',          'code' => 'web-estadios',          'permission_name' => 'read stadiums' ],
            [ 'name' => 'Web - Grupos',            'code' => 'web-grupos',            'permission_name' => 'read groups' ],
            [ 'name' => 'Web - Equipos',           'code' => 'web-equipos',           'permission_name' => 'read teams' ],
            [ 'name' => 'Web - Clasificación',     'code' => 'web-clasificacion',     'permission_name' => 'read ranking' ],
            [ 'name' => 'Web - Recompensas',       'code' => 'web-recompensas',       'permission_name' => 'read prizes' ],
            [ 'name' => 'Web - Admin',             'code' => 'web-admin',             'permission_name' => 'read admin' ],
        ];

        foreach($modules as $module) {
            Module::create($module);
        }
    }
}
