<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    protected $table = 'sesiones'; // ← agregar esta línea

    protected $fillable = [
        'grupo_id', 'horario_id', 'fecha',
        'hora_inicio', 'hora_fin', 'estado', 'tema', 'observaciones'
    ];

    protected $casts = ['fecha' => 'date'];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}