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
                'name'          => 'Principal',
                'background'    => '#d2d4da', // Mostaza pálida
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-principal.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Florabasil',
                'background'    => '#63697d', // Verde bosque
                'on_background' => '#FFFFFF',
                'image'         => '/images/brands/logo-florabasil.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Momemist',
                'background'    => '#d2d4da', // Durazno suave
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-momemist.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Compleben',
                'background'    => '#d2d4da', // Menta clara
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-compleben.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Dexidian',
                'background'    => '#d2d4da', // Rosa polvo
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-dexidian.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Glifoglu',
                'background'    => '#d2d4da', // Pistache
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-glifoglu.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Viridon HPb',
                'background'    => '#d2d4da', // Durazno cálido
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-viridon-hpb.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Nebralgia',
                'background'    => '#d2d4da', // Lavanda clara
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-nebralgia.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Dexilopram',
                'background'    => '#d2d4da', // Amarillo crema
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-dexilopram.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Foly Hierro',
                'background'    => '#d2d4da', // Terracota claro
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-foly-hierro.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Gripetin',
                'background'    => '#d2d4da', // Melocotón pálido
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-gripetin.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Sitavan M XR',
                'background'    => '#d2d4da', // Sage
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-sitavan-mxr.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Donofosfo',
                'background'    => '#d2d4da', // Salmón claro
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-donofosfo.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Betax',
                'background'    => '#d2d4da', // Lila polvo
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-betax.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Degravan',
                'background'    => '#d2d4da', // Lino
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-degravan.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Donoflat',
                'background'    => '#d2d4da', // Adobe suave
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-donoflat.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Tetravit',
                'background'    => '#d2d4da', // Champaña
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-tetravit.png',
                'url'           => 'https://donovanwerke.com/'
            ],
            [
                'name'          => 'Donoepoc',
                'background'    => '#d2d4da', // Coral pastel
                'on_background' => '#101820',
                'image'         => '/images/brands/logo-donoepoc.png',
                'url'           => 'https://donovanwerke.com/'
            ],
        ];

        foreach($brands as $brand) {
            Brand::create($brand);
        }
    }
}
