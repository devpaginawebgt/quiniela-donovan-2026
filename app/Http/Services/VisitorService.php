<?php

namespace App\Http\Services;

use App\Models\Visitor;

class VisitorService {

    public function getVisitors()
    {
        return Visitor::where('is_active', true)
            ->get();
    }

    public function getVisitor(string|int $visitor_id)
    {   
        return Visitor::find($visitor_id);
    }

}