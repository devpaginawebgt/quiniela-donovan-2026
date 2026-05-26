<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankingTab extends Model
{
    protected $fillable = [
        'name',
        'code',
        'route_name',
        'is_current',
        'is_active',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'is_current' => 'boolean',
            'is_active' => 'boolean',
            'is_visible' => 'boolean',
        ];
    }
}
