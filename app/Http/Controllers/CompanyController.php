<?php

namespace App\Http\Controllers;

use App\Http\Resources\Company\CompanyResource;
use App\Http\Services\CompanyService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly CompanyService $companyService,
    ) {}

    public function index(Request $request)
    {   
        $companies = $this->companyService->getCompanies($request);

        $companies = CompanyResource::collection($companies);

        return $this->successResponse($companies);
    }
}
