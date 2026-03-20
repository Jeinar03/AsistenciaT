<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CriterioEvaluacion extends Model
{
    protected $fillable = [
        'grupo_id', 'nombre', 'peso',
        'tipo', 'fecha_entrega', 'orden'
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
        'peso'          => 'decimal:2',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'criterio_id');
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'criterio_id');
    }
}
