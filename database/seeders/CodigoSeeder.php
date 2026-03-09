<?php

namespace Database\Seeders;

use App\Models\Codigo;
use Illuminate\Database\Seeder;

class CodigoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Codigo::factory(2)->state(['estado' => 1])->create();
        Codigo::factory(10)->create();

        Codigo::factory(3)->state(['estado' => 1])->create();
    }
}
