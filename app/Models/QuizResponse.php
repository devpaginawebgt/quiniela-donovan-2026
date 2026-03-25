<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizResponse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quiz_user_id',
        'quiz_question_id',
        'quiz_option_id',
        'points_received',
        'is_correct',
    ];

    protected $casts = [
        'points_received' => 'integer',
        'is_correct'      => 'boolean',
    ];

    public function quizUser(): BelongsTo
    {
        return $this->belongsTo(QuizUser::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(QuizOption::class, 'quiz_option_id');
    }
}
