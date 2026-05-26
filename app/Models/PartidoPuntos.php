<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartidoPuntos extends Model
{
    protected $fillable = [
        'partido_id',
        'acerto_marcadores',
        'acerto_ganador',
        'acerto_empate',
        'default',
    ];

    protected function casts() 
    {
        return [
            'acerto_marcadores'          => 'integer',
            'acerto_ganador'             => 'integer',
            'acerto_empate'              => 'integer',
            'default'                    => 'integer',
        ];
    }

    public function partido(): BelongsTo
    {
        return $this->belongsTo(Partido::class, 'partido_id');
    }
}
