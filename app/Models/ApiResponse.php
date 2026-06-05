<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiResponse extends Model
{
    protected $fillable = [
        'endpoint',
        'parameters',
        'errors',
        'results',
        'paging',
        'response',
        'status_code',
        'success',
    ];

    protected $casts = [
        'parameters' => 'array',
        'errors'     => 'array',
        'paging'     => 'array',
        'response'   => 'array',
        'success'    => 'boolean',
    ];
}
