<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrera extends Model
{
    use SoftDeletes;

    protected $fillable = ['clave', 'nombre', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function materias()
    {
        return $this->hasMany(Materia::class);
    }
}
