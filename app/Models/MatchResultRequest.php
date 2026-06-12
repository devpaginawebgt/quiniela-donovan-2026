<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchResultRequest extends Model
{
    public const STATUS_PENDING   = 'pending';
    public const STATUS_FETCHING  = 'fetching';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED    = 'failed';
    public const STATUS_CANCELED  = 'canceled';

    public const OFFSET_MINUTES         = 104;
    public const RETRY_INTERVAL_MINUTES = 2;
    public const MAX_ATTEMPTS           = 90;

    protected $fillable = [
        'partido_id',
        'api_fixture_id',
        'status',
        'scheduled_at',
        'attempts',
        'last_attempted_at',
        'last_status_short',
        'last_status_long',
        'last_goals_home',
        'last_goals_away',
        'last_error',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'partido_id'        => 'integer',
            'api_fixture_id'    => 'integer',
            'attempts'          => 'integer',
            'scheduled_at'      => 'datetime',
            'last_attempted_at' => 'datetime',
            'last_goals_home'   => 'integer',
            'last_goals_away'   => 'integer',
            'completed_at'      => 'datetime',
        ];
    }

    public function partido(): BelongsTo
    {
        return $this->belongsTo(Partido::class);
    }

    public function apiFixture(): BelongsTo
    {
        return $this->belongsTo(ApiFixture::class, 'api_fixture_id', 'api_fixture_id');
    }
}
