<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grupo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'materia_id', 'semestre_id', 'maestro_id',
        'clave', 'max_alumnos', 'porcentaje_asistencia_minima', 'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'porcentaje_asistencia_minima' => 'decimal:2',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function maestro()
    {
        return $this->belongsTo(User::class, 'maestro_id');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function sesiones()
    {
        return $this->hasMany(Sesion::class);
    }

    public function criteriosEvaluacion()
    {
        return $this->hasMany(CriterioEvaluacion::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }

    // Alumnos inscritos (relación muchos a muchos con users)
    public function alumnos()
    {
        return $this->belongsToMany(User::class, 'grupo_alumno', 'grupo_id', 'alumno_id')
                    ->withTimestamps();
    }
}
