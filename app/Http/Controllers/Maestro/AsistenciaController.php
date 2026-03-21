<?php

namespace App\Http\Controllers\Maestro;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use App\Models\Sesion;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    // Lista de grupos del maestro
    public function index()
    {
        $maestro = Auth::user();
        $grupos = Grupo::with(['materia', 'semestre', 'alumnos'])
                       ->where('maestro_id', $maestro->id)
                       ->where('activo', true)
                       ->get();

        return view('maestro.asistencia.index', compact('grupos'));
    }

    // Sesiones de un grupo
    public function sesiones(Grupo $grupo)
    {
        if ($grupo->maestro_id !== Auth::id()) {
            abort(403);
        }

        $sesiones = Sesion::where('grupo_id', $grupo->id)
                          ->orderBy('fecha', 'desc')
                          ->paginate(20);

        return view('maestro.asistencia.sesiones', compact('grupo', 'sesiones'));
    }

    // Formulario de toma de asistencia
    public function tomar(Sesion $sesion)
    {
        if ($sesion->grupo->maestro_id !== Auth::id()) {
            abort(403);
        }

        $sesion->load('grupo.materia', 'grupo.alumnos');
        $asistencias = Asistencia::where('sesion_id', $sesion->id)
                                  ->pluck('estado', 'alumno_id');

        return view('maestro.asistencia.tomar', compact('sesion', 'asistencias'));
    }

    // Guardar asistencia
    public function guardar(Request $request, Sesion $sesion)
    {
        if ($sesion->grupo->maestro_id !== Auth::id()) {
            abort(403);
        }

        $alumnos = $sesion->grupo->alumnos;

        foreach ($alumnos as $alumno) {
            $estado = $request->input("asistencia.{$alumno->id}", 'falta');

            Asistencia::updateOrCreate(
                [
                    'sesion_id' => $sesion->id,
                    'alumno_id' => $alumno->id,
                ],
                [
                    'estado'          => $estado,
                    'registrado_por'  => Auth::id(),
                ]
            );
        }

        // Marcar sesión como realizada
        $sesion->update(['estado' => 'realizada']);

        return redirect()->route('maestro.asistencia.sesiones', $sesion->grupo_id)
                         ->with('success', 'Asistencia guardada exitosamente.');
    }

    // Reporte de asistencia por grupo
    public function reporte(Grupo $grupo)
    {
        if ($grupo->maestro_id !== Auth::id()) {
            abort(403);
        }

        $grupo->load('materia', 'semestre', 'alumnos');
        $sesionesRealizadas = Sesion::where('grupo_id', $grupo->id)
                                    ->where('estado', 'realizada')
                                    ->count();

        $reporteAlumnos = $grupo->alumnos->map(function($alumno) use ($grupo, $sesionesRealizadas) {
            $presentes = Asistencia::whereHas('sesion', fn($q) => $q->where('grupo_id', $grupo->id))
                                   ->where('alumno_id', $alumno->id)
                                   ->whereIn('estado', ['presente', 'retardo'])
                                   ->count();

            $porcentaje = $sesionesRealizadas > 0
                ? round(($presentes / $sesionesRealizadas) * 100, 2)
                : 0;

            return [
                'alumno'     => $alumno,
                'presentes'  => $presentes,
                'faltas'     => $sesionesRealizadas - $presentes,
                'porcentaje' => $porcentaje,
                'aprobado'   => $porcentaje >= $grupo->porcentaje_asistencia_minima,
            ];
        });

        return view('maestro.asistencia.reporte', compact('grupo', 'sesionesRealizadas', 'reporteAlumnos'));
    }
}