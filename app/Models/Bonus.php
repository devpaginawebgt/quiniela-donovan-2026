<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bonus extends Model
{
    protected $fillable = [
        'name',
        'code',
        'puntos',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'puntos' => 'integer',
        ];
    }

    public function bonusUsers(): HasMany
    {
        return $this->hasMany(BonusUser::class);
    }
}
