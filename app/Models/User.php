<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'name', 'email', 'password',
        'matricula', 'telefono', 'tipo', 'activo'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'ultimo_acceso'     => 'datetime',
            'password'          => 'hashed',
            'activo'            => 'boolean',
        ];
    }

    // Relaciones
    public function gruposComoMaestro()
    {
        return $this->hasMany(Grupo::class, 'maestro_id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'alumno_id');
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'alumno_id');
    }

    public function auditoriaLogs()
    {
        return $this->hasMany(AuditoriaLog::class, 'user_id');
    }

    // Scopes útiles
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeMaestros($query)
    {
        return $query->where('tipo', 'maestro');
    }

    public function scopeAlumnos($query)
    {
        return $query->where('tipo', 'alumno');
    }
}
