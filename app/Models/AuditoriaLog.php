<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaLog extends Model
{
    protected $fillable = [
        'user_id', 'accion', 'modelo', 'modelo_id',
        'datos_anteriores', 'datos_nuevos', 'ip', 'user_agent'
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
