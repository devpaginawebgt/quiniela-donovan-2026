<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultadoPartido extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'partido_id',
        'goles_equipo_1',
        'goles_equipo_2',
        'equipo_ganador_id',
    ];

    public function equiposPartido(): BelongsTo
    {
        return $this->belongsTo(EquipoPartido::class, 'partido_id', 'partido_id');
    }

    public function partido(): BelongsTo
    {
        return $this->belongsTo(Partido::class, 'partido_id');
    }
}
