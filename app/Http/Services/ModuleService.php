<?php

namespace App\Http\Services;

use App\Models\Banner;
use App\Models\Line;
use App\Models\Module;

class ModuleService {

    public function getModules(string $prefix)
    {
        return Module::where('code', 'LIKE', $prefix . '-%')
            ->orderBy('id')
            ->get();
    }

    public function getModule(string $module_code)
    {
        return Module::where('code', $module_code)->first();
    }

    public function getBanners(string|int $module_id)
    {
        return Banner::where('module_id', $module_id)->where('is_active', true)->get();
    }

}