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
            [ 
                'name'  => 'Kralfato',
                'image' => '/images/brands/kralfato.png',
                'url'   => 'https://donovanwerke.com/'
            ],
            [ 
                'name'  => 'Heprakal',
                'image' => '/images/brands/heprakal.png',
                'url'   => 'https://donovanwerke.com/'
            ],
            [ 
                'name'  => 'Enterovid',
                'image' => '/images/brands/enterovid.png',
                'url'   => 'https://donovanwerke.com/'
            ],
        ];

        foreach($brands as $brand) {
            Brand::create($brand);
        }
    }
}
