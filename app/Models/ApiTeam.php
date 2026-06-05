<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiTeam extends Model
{
    protected $fillable = [
        'api_team_id',
        'name',
        'code',
        'country',
        'founded',
        'national',
        'logo',
    ];

    protected $casts = [
        'founded'  => 'integer',
        'national' => 'boolean',
    ];
}
