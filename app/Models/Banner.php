<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banner extends Model
{
    protected $fillable = [
        'name',
        'url',
        'url_web',
        'module_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [ 'is_active' => 'boolean' ];
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}
