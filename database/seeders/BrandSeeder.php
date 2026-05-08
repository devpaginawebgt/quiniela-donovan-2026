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
                'name'       => 'Principal',
                'background' => '#E6CB7A',
                'image'      => 'images/brands/logo-principal.png',
                'url'        => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Florabasil',
                'background' => '#008236',
                'image' => 'images/brands/logo-florabasil.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Momemist',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-momemist.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Compleben',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-compleben.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Dexidian',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-dexidian.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Glifoglu',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-glifoglu.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Viridon HPb',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-viridon-hpb.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Nebralgia',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-nebralgia.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Dexilopram',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-dexilopram.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Foly Hierro',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-foly-hierro.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Gripetin',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-gripetin.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Sitavan M XR',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-sitavan-mxr.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Donofosfo',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-donofosfo.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Betax',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-betax.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Degravan',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-degravan.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Donoflat',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-donoflat.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Tetravit',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-tetravit.png',
                'url'  => 'https://donovanwerke.com/'
            ],
            [
                'name' => 'Donoepoc',
                'background' => '#E6CB7A',
                'image' => 'images/brands/logo-donoepoc.png',
                'url'  => 'https://donovanwerke.com/'
            ],
        ];

        foreach($brands as $brand) {
            Brand::create($brand);
        }
    }
}
