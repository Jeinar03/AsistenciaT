<?php

namespace App\Http\Controllers\Maestro;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use App\Models\Sesion;
use App\Models\Asistencia;
use App\Models\CriterioEvaluacion;
use App\Models\Calificacion;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function asistenciaPdf(Grupo $grupo)
    {
        if ($grupo->maestro_id !== Auth::id()) abort(403);

        $grupo->load('materia', 'semestre', 'maestro', 'alumnos');
        $sesionesRealizadas = Sesion::where('grupo_id', $grupo->id)
                                    ->where('estado', 'realizada')
                                    ->count();

        $reporteAlumnos = $grupo->alumnos->map(function($alumno) use ($grupo, $sesionesRealizadas) {
            $presentes = Asistencia::whereHas('sesion', fn($q) => $q->where('grupo_id', $grupo->id))
                                   ->where('alumno_id', $alumno->id)
                                   ->whereIn('estado', ['presente', 'retardo'])
                                   ->count();
            $faltas = Asistencia::whereHas('sesion', fn($q) => $q->where('grupo_id', $grupo->id))
                                ->where('alumno_id', $alumno->id)
                                ->where('estado', 'falta')
                                ->count();
            $porcentaje = $sesionesRealizadas > 0
                ? round(($presentes / $sesionesRealizadas) * 100, 1)
                : 0;
            return [
                'alumno'     => $alumno,
                'presentes'  => $presentes,
                'faltas'     => $faltas,
                'porcentaje' => $porcentaje,
                'aprobado'   => $porcentaje >= $grupo->porcentaje_asistencia_minima,
            ];
        });

        $pdf = Pdf::loadView('pdf.reporte-asistencia', compact(
            'grupo', 'sesionesRealizadas', 'reporteAlumnos'
        ))->setPaper('a4', 'portrait');

        return $pdf->download("reporte-asistencia-{$grupo->clave}.pdf");
    }

    public function calificacionesPdf(Grupo $grupo)
    {
        if ($grupo->maestro_id !== Auth::id()) abort(403);

        $grupo->load('materia', 'semestre', 'maestro', 'alumnos');
        $criterios = CriterioEvaluacion::where('grupo_id', $grupo->id)
                                        ->orderBy('orden')->get();

        $reporteAlumnos = $grupo->alumnos->map(function($alumno) use ($criterios) {
            $cals = [];
            $promedio = 0;
            $pesoTotal = 0;
            foreach ($criterios as $criterio) {
                $cal = Calificacion::where('criterio_id', $criterio->id)
                                   ->where('alumno_id', $alumno->id)
                                   ->first();
                $cals[$criterio->id] = $cal?->calificacion;
                if ($cal) {
                    $promedio += $cal->calificacion * ($criterio->peso / 100);
                    $pesoTotal += $criterio->peso;
                }
            }
            return [
                'alumno'         => $alumno,
                'calificaciones' => $cals,
                'promedio'       => $pesoTotal > 0 ? round($promedio, 1) : null,
            ];
        });

        $pdf = Pdf::loadView('pdf.reporte-calificaciones', compact(
            'grupo', 'criterios', 'reporteAlumnos'
        ))->setPaper('a4', 'landscape');

        return $pdf->download("reporte-calificaciones-{$grupo->clave}.pdf");
    }
}
