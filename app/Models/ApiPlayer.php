<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiPlayer extends Model
{
    protected $fillable = [
        'api_player_id',
        'api_team_id',
        'name',
        'age',
        'number',
        'position',
        'photo',
        'is_active',
        'last_synced_at',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'last_synced_at' => 'datetime',
    ];
}
