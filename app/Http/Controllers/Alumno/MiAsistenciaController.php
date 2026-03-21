<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use App\Models\Asistencia;
use App\Models\Sesion;
use Illuminate\Support\Facades\Auth;

class MiAsistenciaController extends Controller
{
    public function index(Grupo $grupo)
    {
        $alumno = Auth::user();

        // Verificar que el alumno pertenece al grupo
        if (!$grupo->alumnos()->where('alumno_id', $alumno->id)->exists()) {
            abort(403);
        }

        $grupo->load('materia', 'semestre', 'maestro');

        $sesiones = Sesion::where('grupo_id', $grupo->id)
                          ->where('estado', 'realizada')
                          ->orderBy('fecha', 'desc')
                          ->get();

        $asistencias = Asistencia::whereIn('sesion_id', $sesiones->pluck('id'))
                                  ->where('alumno_id', $alumno->id)
                                  ->pluck('estado', 'sesion_id');

        $totalSesiones = $sesiones->count();
        $presentes = $asistencias->whereIn(null, ['presente', 'retardo'])->count();
        $presentes = $sesiones->filter(fn($s) =>
            in_array($asistencias[$s->id] ?? 'falta', ['presente', 'retardo'])
        )->count();

        $porcentaje = $totalSesiones > 0
            ? round(($presentes / $totalSesiones) * 100, 1)
            : 0;

        return view('alumno.asistencia', compact(
            'grupo', 'sesiones', 'asistencias', 'totalSesiones', 'presentes', 'porcentaje'
        ));
    }
}