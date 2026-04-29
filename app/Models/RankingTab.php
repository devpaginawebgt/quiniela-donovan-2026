<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankingTab extends Model
{
    protected $fillable = [
        'name',
        'code',
        'route_name',
        'is_active',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_visible' => 'boolean',
        ];
    }
}
