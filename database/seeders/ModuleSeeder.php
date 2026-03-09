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
            [ 'name' => 'App - Próximos Partidos', 'code' => 'app-proximos-partidos' ],
            [ 'name' => 'App - Mis Pronósticos',   'code' => 'app-mis-pronosticos' ],
            [ 'name' => 'App - Calendario',        'code' => 'app-calendario' ],
            [ 'name' => 'App - Selecciones',       'code' => 'app-selecciones' ],
            [ 'name' => 'App - Grupos',            'code' => 'app-grupos' ],
            [ 'name' => 'App - Sedes',             'code' => 'app-sedes' ],
        ]; 

        foreach($modules as $module) {
            Module::create($module);
        }
    }
}
