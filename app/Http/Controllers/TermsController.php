<?php

namespace App\Http\Controllers;

use App\Http\Resources\Term\TermResource;
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
        $terms = $this->termsService->getTerms();
        $terms = new TermResource($terms);

        return $this->successResponse($terms);
    }
}
