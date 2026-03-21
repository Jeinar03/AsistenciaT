<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use App\Models\Asistencia;
use App\Models\Calificacion;
use App\Models\CriterioEvaluacion;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $alumno = Auth::user();

        $grupos = Grupo::with(['materia', 'semestre', 'maestro'])
                       ->whereHas('alumnos', fn($q) => $q->where('alumno_id', $alumno->id))
                       ->where('activo', true)
                       ->get();

        $resumen = $grupos->map(function($grupo) use ($alumno) {
            $totalSesiones = $grupo->sesiones()->where('estado', 'realizada')->count();
            $presentes = Asistencia::whereHas('sesion', fn($q) => $q->where('grupo_id', $grupo->id))
                                   ->where('alumno_id', $alumno->id)
                                   ->whereIn('estado', ['presente', 'retardo'])
                                   ->count();

            $porcentaje = $totalSesiones > 0
                ? round(($presentes / $totalSesiones) * 100, 1)
                : 0;

            $criterios = CriterioEvaluacion::where('grupo_id', $grupo->id)->get();
            $promedio = null;

            if ($criterios->count() > 0) {
                $total = 0;
                foreach ($criterios as $criterio) {
                    $cal = Calificacion::where('criterio_id', $criterio->id)
                                       ->where('alumno_id', $alumno->id)
                                       ->first();
                    if ($cal) {
                        $total += $cal->calificacion * ($criterio->peso / 100);
                    }
                }
                $promedio = round($total, 1);
            }

            return [
                'grupo'          => $grupo,
                'totalSesiones'  => $totalSesiones,
                'presentes'      => $presentes,
                'porcentaje'     => $porcentaje,
                'aprobado'       => $porcentaje >= $grupo->porcentaje_asistencia_minima,
                'promedio'       => $promedio,
            ];
        });

        return view('alumno.dashboard', compact('alumno', 'resumen'));
    }
}