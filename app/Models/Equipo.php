<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'imagen',
        'codigo_iso',
        'code',
        'descripcion',
        'grupo',
        'api_team_id',
        'goles_favor',
        'goles_contra',
        'partidos_jugados',
        'partidos_ganados',
        'partidos_perdidos',
        'partidos_empatados',
        'puntos',
    ];

    public function partidos($jornada)
    {
        return $this->belongsToMany(Partido::class,'equipo_partidos');
    }

    public function apiTeam()
    {
        return $this->belongsTo(ApiTeam::class, 'api_team_id', 'api_team_id');
    }

    public function players()
    {
        return $this->hasMany(ApiPlayer::class, 'api_team_id', 'api_team_id');
    }
}
