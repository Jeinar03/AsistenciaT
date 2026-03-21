<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditoriaLog;

class AuditoriaController extends Controller
{
    public function index()
    {
        $logs = AuditoriaLog::with('user')
                            ->orderBy('created_at', 'desc')
                            ->paginate(20);

        $modulos = AuditoriaLog::distinct()->pluck('modulo');
        $acciones = AuditoriaLog::distinct()->pluck('accion');

        return view('admin.auditoria.index', compact('logs', 'modulos', 'acciones'));
    }
}