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
            [
                'name'      => 'test',
                'url'       => '/images/banners/test.png',
                'module_id' => 1,
            ],
        ];

        foreach($banners as $banner) {
            Banner::create($banner);
        }
    }
}
