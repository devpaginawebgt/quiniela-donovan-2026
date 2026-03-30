<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preccion extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'partido_id',
        'goles_equipo_1',
        'goles_equipo_2',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partido()
    {
        return $this->belongsTo(Partido::class);
    }

    public function resultado()
    {
        return $this->hasOne(ResultadoPartido::class, 'partido_id', 'partido_id');
    }
}
