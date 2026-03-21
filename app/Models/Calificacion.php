<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones'; // ← agregar esta línea

    protected $fillable = [
        'criterio_id', 'alumno_id',
        'calificacion', 'comentario', 'registrado_por'
    ];

    protected $casts = ['calificacion' => 'decimal:2'];

    public function criterio()
    {
        return $this->belongsTo(CriterioEvaluacion::class, 'criterio_id');
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