<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizQuestion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quiz_id',
        'question',
        'points',
        'order',
        'success_message',
        'fail_message',
    ];

    protected $casts = [
        'points' => 'integer',
        'order' => 'integer',
    ];    

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuizOption::class)->orderBy('order')->orderBy('id');
    }

    public function correct_option(): HasOne
    {
        return $this->hasOne(QuizOption::class, 'quiz_question_id')->where('is_correct', true);
    }
    
}
