<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'sesion_id', 'alumno_id', 'estado',
        'justificacion', 'registrado_por'
    ];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class);
    }

    public function alumno()
    {
        return $this->belongsTo(User::class, 'alumno_id');
    }

    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
