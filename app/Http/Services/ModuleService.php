<?php

namespace App\Http\Services;

use App\Models\Banner;
use App\Models\Line;
use App\Models\Module;

class ModuleService {

    public function getModule($module_code)
    {
        return Module::where('code', $module_code)->first();
    }

    public function getBanners($module_id)
    {
        return Banner::where('module_id', $module_id)->where('is_active', true)->get();
    }

}