<?php

namespace App\Http\Controllers\Maestro;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use App\Models\Sesion;
use App\Models\Asistencia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $maestro = Auth::user();

        $grupos = Grupo::with(['materia', 'semestre', 'alumnos'])
                       ->where('maestro_id', $maestro->id)
                       ->where('activo', true)
                       ->get();

        $totalAlumnos = $grupos->sum(fn($g) => $g->alumnos->count());

        $proximasSesiones = Sesion::whereIn('grupo_id', $grupos->pluck('id'))
                                  ->where('fecha', '>=', now()->toDateString())
                                  ->where('estado', 'programada')
                                  ->orderBy('fecha')
                                  ->take(5)
                                  ->with('grupo.materia')
                                  ->get();

        return view('maestro.dashboard', compact(
            'maestro', 'grupos', 'totalAlumnos', 'proximasSesiones'
        ));
    }
}