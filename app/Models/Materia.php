<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materia extends Model
{
    use SoftDeletes;

    protected $fillable = ['carrera_id', 'clave', 'nombre', 'creditos', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function grupos()
    {
        return $this->hasMany(Grupo::class);
    }
}
