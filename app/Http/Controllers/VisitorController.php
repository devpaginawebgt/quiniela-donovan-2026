<?php

namespace App\Http\Controllers;

use App\Http\Resources\Visitor\VisitorResource;
use App\Http\Services\VisitorService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly VisitorService $visitorService,
    ) {}

    public function index(Request $request)
    {   
        $country_id = $request->input('country_id');

        $visitors = $this->visitorService->getVisitorsByCountry($country_id);

        $visitors = VisitorResource::collection($visitors);

        return $this->successResponse($visitors);
    }
}
