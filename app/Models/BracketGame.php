<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BracketGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'journey_id',
        'bracket_position',
        'team_one_id',
        'team_two_id',
        'result_id',
        'status',
        'local_game_id',
        'visitor_game_id',
        'local_slot_label',
        'visitor_slot_label',
        'local_source',
        'visitor_source',
    ];

    public function journey(): BelongsTo
    {
        return $this->belongsTo(Jornada::class, 'journey_id');
    }

    public function teamOne(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'team_one_id');
    }

    public function teamTwo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'team_two_id');
    }

    public function result(): BelongsTo
    {
        return $this->belongsTo(ResultadoPartido::class, 'result_id');
    }

    public function localFeeder(): BelongsTo
    {
        return $this->belongsTo(BracketGame::class, 'local_game_id');
    }

    public function visitorFeeder(): BelongsTo
    {
        return $this->belongsTo(BracketGame::class, 'visitor_game_id');
    }
}
