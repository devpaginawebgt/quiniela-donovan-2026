<?php

namespace Database\Seeders;

use App\Models\RankingTab;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankingTabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RankingTab::create([
            'name' => 'Fase de Grupos',
            'code' => 'grupos',
            'is_active' => true,
            'is_visible' => true,
            'app_route_name' => 'api.ranking.grupos',
            'web_route_name' => 'web.ranking.grupos',
        ]);

        RankingTab::create([
            'name' => 'Fase Eliminatoria',
            'code' => 'elminatoria',
            'is_active' => false,
            'is_visible' => false,
            'app_route_name' => 'api.ranking.eliminatorias',
            'web_route_name' => 'web.ranking.eliminatorias',
        ]);
    }
}
