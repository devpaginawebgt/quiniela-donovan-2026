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
        $visitors = $this->visitorService->getVisitors($request);

        $visitors = VisitorResource::collection($visitors);

        return $this->successResponse($visitors);
    }
}
