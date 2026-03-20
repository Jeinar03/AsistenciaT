<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asignacion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'grupo_id', 'criterio_id', 'titulo',
        'descripcion', 'fecha_publicacion', 'fecha_entrega', 'visible'
    ];

    protected $casts = [
        'fecha_publicacion' => 'date',
        'fecha_entrega'     => 'date',
        'visible'           => 'boolean',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function criterio()
    {
        return $this->belongsTo(CriterioEvaluacion::class, 'criterio_id');
    }
}
