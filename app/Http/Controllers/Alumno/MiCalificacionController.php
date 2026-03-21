<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use App\Models\CriterioEvaluacion;
use App\Models\Calificacion;
use Illuminate\Support\Facades\Auth;

class MiCalificacionController extends Controller
{
    public function index(Grupo $grupo)
    {
        $alumno = Auth::user();

        if (!$grupo->alumnos()->where('alumno_id', $alumno->id)->exists()) {
            abort(403);
        }

        $grupo->load('materia', 'semestre', 'maestro');

        $criterios = CriterioEvaluacion::where('grupo_id', $grupo->id)
                                        ->orderBy('orden')->get();

        $calificaciones = Calificacion::whereIn('criterio_id', $criterios->pluck('id'))
                                       ->where('alumno_id', $alumno->id)
                                       ->pluck('calificacion', 'criterio_id');

        $promedio = 0;
        $pesoTotal = 0;
        foreach ($criterios as $criterio) {
            if (isset($calificaciones[$criterio->id])) {
                $promedio += $calificaciones[$criterio->id] * ($criterio->peso / 100);
                $pesoTotal += $criterio->peso;
            }
        }
        $promedio = $pesoTotal > 0 ? round($promedio, 1) : null;

        return view('alumno.calificaciones', compact(
            'grupo', 'criterios', 'calificaciones', 'promedio'
        ));
    }
}