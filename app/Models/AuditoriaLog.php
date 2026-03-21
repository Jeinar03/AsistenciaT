<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaLog extends Model
{
    protected $table = 'auditoria_logs';

    protected $fillable = [
        'user_id', 'accion', 'modulo',
        'descripcion', 'ip', 'user_agent', 'datos_anteriores', 'datos_nuevos'
    ];

    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos'     => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}