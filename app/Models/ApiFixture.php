<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiFixture extends Model
{
    protected $fillable = [
        'api_fixture_id',
        'league_id',
        'season',
        'round',
        'api_home_team_id',
        'api_away_team_id',
        'date',
        'timezone',
        'status_short',
        'status_long',
        'goals_home',
        'goals_away',
        'ft_goals_home',
        'ft_goals_away',
        'et_goals_home',
        'et_goals_away',
        'pt_goals_home',
        'pt_goals_away',
        'last_synced_at',
    ];

    protected $casts = [
        'date'           => 'datetime',
        'last_synced_at' => 'datetime',
        'goals_home'     => 'integer',
        'goals_away'     => 'integer',
        'ft_goals_home'  => 'integer',
        'ft_goals_away'  => 'integer',
        'et_goals_home'  => 'integer',
        'et_goals_away'  => 'integer',
        'pt_goals_home'  => 'integer',
        'pt_goals_away'  => 'integer',
    ];

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(ApiTeam::class, 'api_home_team_id', 'api_team_id');
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(ApiTeam::class, 'api_away_team_id', 'api_team_id');
    }
}
