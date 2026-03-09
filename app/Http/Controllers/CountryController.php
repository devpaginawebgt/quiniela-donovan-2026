<?php

namespace App\Http\Controllers;

use App\Http\Resources\Country\CountryResource;
use App\Http\Services\CountryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly CountryService $countryService,
    ) {}

    public function index(Request $request)
    {   
        $country_code = $request->input('country_code');

        if (!empty($country_code)) {

            $country = $this->countryService->getCountryByCode($country_code);

            if (empty($country)) {

                return $this->errorResponse('No se encontró el código de país', 422);

            }

            if ($country->is_active === false) {

                return $this->errorResponse('El código de país está inactivo en la plataforma', 422);

            }

            $country = new CountryResource($country);

            return $this->successResponse($country);

        }

        $countries = $this->countryService->getCountries();

        $countries = CountryResource::collection($countries);

        return $this->successResponse($countries);
    }
}
