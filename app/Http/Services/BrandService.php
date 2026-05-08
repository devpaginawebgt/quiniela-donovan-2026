<?php

namespace App\Http\Services;

use App\Models\Brand;
use App\Models\Partido;
use Illuminate\Support\Collection;

class BrandService {

    private static ?Collection $matchBrandsMap = null;

    public function getBrands()
    {
        return Brand::all();
    }

    public function matchBrands(): Collection
    {
        return self::$matchBrandsMap ??= collect([
            ['partido_id' => 1,   'brand_id' => 1],  // Principal
            ['partido_id' => 2,   'brand_id' => 2],  // Florabasil
            ['partido_id' => 3,   'brand_id' => 3],  // Momemist
            ['partido_id' => 4,   'brand_id' => 4],  // Compleben
            ['partido_id' => 5,   'brand_id' => 5],  // Dexidian
            ['partido_id' => 6,   'brand_id' => 6],  // Glifoglu
            ['partido_id' => 7,   'brand_id' => 7],  // Viridon HPb
            ['partido_id' => 8,   'brand_id' => 8],  // Nebralgia
            ['partido_id' => 9,   'brand_id' => 9],  // Dexilopram
            ['partido_id' => 10,  'brand_id' => 10], // Foly Hierro
            ['partido_id' => 11,  'brand_id' => 11], // Gripetin
            ['partido_id' => 12,  'brand_id' => 12], // Sitavan M XR
            ['partido_id' => 13,  'brand_id' => 13], // Donofosfo
            ['partido_id' => 14,  'brand_id' => 14], // Betax
            ['partido_id' => 15,  'brand_id' => 15], // Degravan
            ['partido_id' => 16,  'brand_id' => 16], // Donoflat
            ['partido_id' => 17,  'brand_id' => 17], // Tetravit
            ['partido_id' => 18,  'brand_id' => 18], // Donoepoc
            ['partido_id' => 19,  'brand_id' => 1],  // Principal
            ['partido_id' => 20,  'brand_id' => 2],  // Florabasil
            ['partido_id' => 21,  'brand_id' => 3],  // Momemist
            ['partido_id' => 22,  'brand_id' => 4],  // Compleben
            ['partido_id' => 23,  'brand_id' => 5],  // Dexidian
            ['partido_id' => 24,  'brand_id' => 6],  // Glifoglu
            ['partido_id' => 25,  'brand_id' => 7],  // Viridon HPb
            ['partido_id' => 26,  'brand_id' => 8],  // Nebralgia
            ['partido_id' => 27,  'brand_id' => 9],  // Dexilopram
            ['partido_id' => 28,  'brand_id' => 10], // Foly Hierro
            ['partido_id' => 29,  'brand_id' => 11], // Gripetin
            ['partido_id' => 30,  'brand_id' => 12], // Sitavan M XR
            ['partido_id' => 31,  'brand_id' => 13], // Donofosfo
            ['partido_id' => 32,  'brand_id' => 14], // Betax
            ['partido_id' => 33,  'brand_id' => 15], // Degravan
            ['partido_id' => 34,  'brand_id' => 16], // Donoflat
            ['partido_id' => 35,  'brand_id' => 17], // Tetravit
            ['partido_id' => 36,  'brand_id' => 18], // Donoepoc
            ['partido_id' => 37,  'brand_id' => 1],  // Principal
            ['partido_id' => 38,  'brand_id' => 2],  // Florabasil
            ['partido_id' => 39,  'brand_id' => 3],  // Momemist
            ['partido_id' => 40,  'brand_id' => 4],  // Compleben
            ['partido_id' => 41,  'brand_id' => 5],  // Dexidian
            ['partido_id' => 42,  'brand_id' => 6],  // Glifoglu
            ['partido_id' => 43,  'brand_id' => 7],  // Viridon HPb
            ['partido_id' => 44,  'brand_id' => 8],  // Nebralgia
            ['partido_id' => 45,  'brand_id' => 9],  // Dexilopram
            ['partido_id' => 46,  'brand_id' => 10], // Foly Hierro
            ['partido_id' => 47,  'brand_id' => 11], // Gripetin
            ['partido_id' => 48,  'brand_id' => 12], // Sitavan M XR
            ['partido_id' => 49,  'brand_id' => 13], // Donofosfo
            ['partido_id' => 50,  'brand_id' => 14], // Betax
            ['partido_id' => 51,  'brand_id' => 15], // Degravan
            ['partido_id' => 52,  'brand_id' => 16], // Donoflat
            ['partido_id' => 53,  'brand_id' => 17], // Tetravit
            ['partido_id' => 54,  'brand_id' => 18], // Donoepoc
            ['partido_id' => 55,  'brand_id' => 1],  // Principal
            ['partido_id' => 56,  'brand_id' => 2],  // Florabasil
            ['partido_id' => 57,  'brand_id' => 3],  // Momemist
            ['partido_id' => 58,  'brand_id' => 4],  // Compleben
            ['partido_id' => 59,  'brand_id' => 5],  // Dexidian
            ['partido_id' => 60,  'brand_id' => 6],  // Glifoglu
            ['partido_id' => 61,  'brand_id' => 7],  // Viridon HPb
            ['partido_id' => 62,  'brand_id' => 8],  // Nebralgia
            ['partido_id' => 63,  'brand_id' => 9],  // Dexilopram
            ['partido_id' => 64,  'brand_id' => 10], // Foly Hierro
            ['partido_id' => 65,  'brand_id' => 11], // Gripetin
            ['partido_id' => 66,  'brand_id' => 12], // Sitavan M XR
            ['partido_id' => 67,  'brand_id' => 13], // Donofosfo
            ['partido_id' => 68,  'brand_id' => 14], // Betax
            ['partido_id' => 69,  'brand_id' => 15], // Degravan
            ['partido_id' => 70,  'brand_id' => 16], // Donoflat
            ['partido_id' => 71,  'brand_id' => 17], // Tetravit
            ['partido_id' => 72,  'brand_id' => 18], // Donoepoc
            ['partido_id' => 73,  'brand_id' => 1],  // Principal
            ['partido_id' => 74,  'brand_id' => 2],  // Florabasil
            ['partido_id' => 75,  'brand_id' => 3],  // Momemist
            ['partido_id' => 76,  'brand_id' => 4],  // Compleben
            ['partido_id' => 77,  'brand_id' => 5],  // Dexidian
            ['partido_id' => 78,  'brand_id' => 6],  // Glifoglu
            ['partido_id' => 79,  'brand_id' => 7],  // Viridon HPb
            ['partido_id' => 80,  'brand_id' => 8],  // Nebralgia
            ['partido_id' => 81,  'brand_id' => 9],  // Dexilopram
            ['partido_id' => 82,  'brand_id' => 10], // Foly Hierro
            ['partido_id' => 83,  'brand_id' => 11], // Gripetin
            ['partido_id' => 84,  'brand_id' => 12], // Sitavan M XR
            ['partido_id' => 85,  'brand_id' => 13], // Donofosfo
            ['partido_id' => 86,  'brand_id' => 14], // Betax
            ['partido_id' => 87,  'brand_id' => 15], // Degravan
            ['partido_id' => 88,  'brand_id' => 16], // Donoflat
            ['partido_id' => 89,  'brand_id' => 17], // Tetravit
            ['partido_id' => 90,  'brand_id' => 18], // Donoepoc
            ['partido_id' => 91,  'brand_id' => 4],  // Compleben
            ['partido_id' => 92,  'brand_id' => 5],  // Dexidian
            ['partido_id' => 93,  'brand_id' => 6],  // Glifoglu
            ['partido_id' => 94,  'brand_id' => 7],  // Viridon HPb
            ['partido_id' => 95,  'brand_id' => 8],  // Nebralgia
            ['partido_id' => 96,  'brand_id' => 9],  // Dexilopram
            ['partido_id' => 97,  'brand_id' => 10], // Foly Hierro
            ['partido_id' => 98,  'brand_id' => 11], // Gripetin
            ['partido_id' => 99,  'brand_id' => 12], // Sitavan M XR
            ['partido_id' => 100, 'brand_id' => 13], // Donofosfo
            ['partido_id' => 101, 'brand_id' => 14], // Betax
            ['partido_id' => 102, 'brand_id' => 3],  // Momemist
            ['partido_id' => 103, 'brand_id' => 2],  // Florabasil
            ['partido_id' => 104, 'brand_id' => 1],  // Principal
        ])->keyBy('partido_id');
    }

    public function addMatchBrand(Partido $partido): void
    {
        if (!empty($partido->brand_id)) return;

        $brandId = $this->matchBrands()->get($partido->id)['brand_id'] ?? null;

        if (empty($brandId)) return;

        $partido->update(['brand_id' => $brandId]);
    }

}