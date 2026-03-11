<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            // Banners App
            [
                'name'      => 'app-proximos-partidos-compleben',
                'url'       => '/images/banners/BANNER_1080x660px_COMPLEBEN_FEB_2026.jpg',
                'module_id' => 1,
            ],
            [
                'name'      => 'app-proximos-partidos-donotos',
                'url'       => '/images/banners/BANNER_1080x660px_DONOTOS_FEB_2026.jpg',
                'module_id' => 1,
            ],
            [
                'name'      => 'app-proximos-partidos-florabasil',
                'url'       => '/images/banners/BANNER_1080x660px_FLORABASIL_FEB_2026.jpg',
                'module_id' => 1,
            ],
            [
                'name'      => 'app-proximos-partidos-glifoglu',
                'url'       => '/images/banners/BANNER_1080x660px_GLIFOGLU_FEB_2026.jpg',
                'module_id' => 1,
            ],
            [
                'name'      => 'app-proximos-partidos-principal-feb',
                'url'       => '/images/banners/BANNER_1080x660px_PRINCIPAL_FEB_2026.jpg',
                'module_id' => 1,
            ],
            [
                'name'      => 'app-proximos-partidos-tetravit-feb',
                'url'       => '/images/banners/BANNER_1080x660px_TETRAVIT_FEB_2026.jpg',
                'module_id' => 1,
            ],
            [
                'name'      => 'app-proximos-partidos-viridon-hpb-feb',
                'url'       => '/images/banners/BANNER_1080x660px_VIRIDON_HPB_FEB_2026.jpg',
                'module_id' => 1,
            ],
            [
                'name'      => 'app-mis-pronosticos-florabasil-gif',
                'url'       => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'module_id' => 2,
            ],
            [
                'name'      => 'app-calendario-florabasil-gif',
                'url'       => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'module_id' => 3,
            ],
            [
                'name'      => 'app-selecciones-florabasil-gif',
                'url'       => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'module_id' => 4,
            ],
            [
                'name'      => 'app-grupos-florabasil-gif',
                'url'       => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'module_id' => 5,
            ],
            [
                'name'      => 'app-sedes-florabasil-gif',
                'url'       => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'module_id' => 6,
            ],

            // Banners Web
            [
                'name'      => 'web-proximos-partidos-compleben',
                'url'       => '/images/banners/BANNER_1080x660px_COMPLEBEN_FEB_2026.jpg',
                'url_web'   => '/images/banners/BANNER_1080x660px_COMPLEBEN_FEB_2026.jpg',
                'module_id' => 7,
            ],
            [
                'name'      => 'web-proximos-partidos-donotos',
                'url'       => '/images/banners/BANNER_1080x660px_DONOTOS_FEB_2026.jpg',
                'url_web'   => '/images/banners/BANNER_1080x660px_DONOTOS_FEB_2026.jpg',
                'module_id' => 7,
            ],
            [
                'name'      => 'web-proximos-partidos-florabasil',
                'url'       => '/images/banners/BANNER_1080x660px_FLORABASIL_FEB_2026.jpg',
                'url_web'   => '/images/banners/BANNER_1080x660px_FLORABASIL_FEB_2026.jpg',
                'module_id' => 7,
            ],
            [
                'name'      => 'web-proximos-partidos-glifoglu',
                'url'       => '/images/banners/BANNER_1080x660px_GLIFOGLU_FEB_2026.jpg',
                'url_web'   => '/images/banners/BANNER_1080x660px_GLIFOGLU_FEB_2026.jpg',
                'module_id' => 7,
            ],
            [
                'name'      => 'web-proximos-partidos-principal-feb',
                'url'       => '/images/banners/BANNER_1080x660px_PRINCIPAL_FEB_2026.jpg',
                'url_web'   => '/images/banners/BANNER_1920x700px_PRINCIPAL_FEB_2026.jpg',
                'module_id' => 7,
            ],
            [
                'name'      => 'web-proximos-partidos-tetravit-feb',
                'url'       => '/images/banners/BANNER_1080x660px_TETRAVIT_FEB_2026.jpg',
                'url_web'   => '/images/banners/BANNER_1080x660px_TETRAVIT_FEB_2026.jpg',
                'module_id' => 7,
            ],
            [
                'name'      => 'web-proximos-partidos-viridon-hpb-feb',
                'url'       => '/images/banners/BANNER_1080x660px_VIRIDON_HPB_FEB_2026.jpg',
                'url_web'   => '/images/banners/BANNER_1080x660px_VIRIDON_HPB_FEB_2026.jpg',
                'module_id' => 7,
            ],
            [
                'name'      => 'web-mis-pronosticos-florabasil-gif',
                'url'       => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'url_web'   => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'module_id' => 8,
            ],
            [
                'name'      => 'web-calendario-florabasil-gif',
                'url'       => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'url_web'   => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'module_id' => 9,
            ],
            [
                'name'      => 'web-selecciones-florabasil-gif',
                'url'       => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'url_web'   => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'module_id' => 10,
            ],
            [
                'name'      => 'web-grupos-florabasil-gif',
                'url'       => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'url_web'   => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'module_id' => 11,
            ],
            [
                'name'      => 'web-sedes-florabasil-gif',
                'url'       => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'url_web'   => '/images/banners/BANNER_ANIMADO_1080x480px_FLORABASIL_FEB_2026-ezgif.com-video-to-gif-converter.gif',
                'module_id' => 12,
            ],


        ];

        foreach($banners as $banner) {
            Banner::create($banner);
        }
    }
}
