<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonusUser extends Model
{
    use SoftDeletes;

    protected $table = 'user_bonuses';

    protected $fillable = [
        'bonus_id',
        'user_id',
        'puntos',
        'is_active',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'puntos'    => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function bonus(): BelongsTo
    {
        return $this->belongsTo(Bonus::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
