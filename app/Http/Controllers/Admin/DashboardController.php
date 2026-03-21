<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Grupo;
use App\Models\Semestre;
use App\Models\Carrera;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_maestros'  => User::where('tipo', 'maestro')->count(),
            'total_alumnos'   => User::where('tipo', 'alumno')->count(),
            'total_grupos'    => Grupo::count(),
            'semestre_activo' => Semestre::where('activo', true)->first(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}