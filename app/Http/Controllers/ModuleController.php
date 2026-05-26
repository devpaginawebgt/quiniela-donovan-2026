<?php

namespace App\Http\Controllers;

use App\Http\Resources\Banner\BannerResource;
use App\Http\Resources\Module\ModuleResource;
use App\Http\Services\ModuleService;
use App\Models\Module;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly ModuleService $moduleService
    ) {}

    public function getModules(Request $request, string $prefix)
    {
        $modules = $this->moduleService->getModules('app');

        $modules = ModuleResource::collection($modules);

        return $this->successResponse($modules);
    }

    /**
     * Display a listing of the resource.
     */
    public function banners(Request $request, string $module_code)
    {
        $module = $this->moduleService->getModule($module_code);

        if (empty($module)) {
            return $this->errorResponse('No se encontró el módulo', 422);
        }

        $banners = $module->banners->where('is_active', true);

        $banners = BannerResource::collection($banners);

        return $this->successResponse($banners);
    }

}
