<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizUser extends Pivot
{
    use SoftDeletes;

    protected $table = 'quiz_user';

    public $incrementing = true;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'attempt_number',
        'response_points',
    ];

    protected $casts = [
        'attempt_number' => 'integer',
        'response_points' => 'integer',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(QuizResponse::class, 'quiz_user_id');
    }
}
