<?php

namespace Database\Seeders;

use App\Models\BrandPosition;
use Illuminate\Database\Seeder;

class BrandPositionSeeder extends Seeder
{
    public function run(): void
    {
        BrandPosition::create([
            'position' => 1,
            'brand_id' => 1,
            'country_id' => 1,
        ]);

        BrandPosition::create([
            'position' => 1,
            'brand_id' => 1,
            'country_id' => 2,
        ]);
    }
}
