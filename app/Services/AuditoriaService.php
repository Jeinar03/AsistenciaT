<?php

namespace App\Services;

use App\Models\AuditoriaLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditoriaService
{
    public static function registrar(
        string $accion,
        string $modulo,
        string $descripcion,
        array $datosAnteriores = [],
        array $datosNuevos = []
    ): void {
        try {
            AuditoriaLog::create([
                'user_id'          => Auth::id(),
                'accion'           => $accion,
                'modulo'           => $modulo,
                'descripcion'      => $descripcion,
                'ip'               => Request::ip(),
                'user_agent'       => Request::userAgent(),
                'datos_anteriores' => $datosAnteriores ?: null,
                'datos_nuevos'     => $datosNuevos ?: null,
            ]);
        } catch (\Exception $e) {
            // No interrumpir el flujo si falla la auditoría
        }
    }
}