<?php

namespace App\Http\Controllers;

use App\Http\Services\TermsService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly TermsService $termsService
    ) {}

    public function index()
    {
        return $this->successResponse($this->termsService->getTerms());
    }
}
