<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            ['name' => 'Farmacias Cruz Verde',    'country_id' => 1],
            ['name' => 'Farmacias Galeno',        'country_id' => 1],
            ['name' => 'Farmacias Batres',        'country_id' => 1],
            ['name' => 'Farmacia Independiente',  'country_id' => 1],

            ['name' => 'Farmacia Independiente', 'country_id' => 2],
        ];

        foreach($companies as $company) {
            Company::create($company);
        }
    }
}
