<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [ 'name'  => 'Kralfato',  'image' => '/images/brands/kralfato.png' ],
            [ 'name'  => 'Heprakal',  'image' => '/images/brands/heprakal.png' ],
            [ 'name'  => 'Enterovid', 'image' => '/images/brands/enterovid.png' ],
        ];

        foreach($brands as $brand) {
            Brand::create($brand);
        }
    }
}
