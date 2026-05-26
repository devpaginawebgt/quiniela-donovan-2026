<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'attempts',
        'points',
        'ranking_tab_id',
        'is_visible',
        'expires_at',
    ];

    protected $casts = [
        'attempts' => 'integer',
        'expires_at' => 'datetime',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order')->orderBy('id');
    }

    public function rankingTab(): BelongsTo
    {
        return $this->belongsTo(RankingTab::class);
    }
}
