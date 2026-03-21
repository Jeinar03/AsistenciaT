<?php

namespace App\Http\Controllers\Maestro;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use App\Models\CriterioEvaluacion;
use App\Models\Calificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    public function index(Grupo $grupo)
    {
        if ($grupo->maestro_id !== Auth::id()) abort(403);

        $grupo->load('materia', 'semestre', 'alumnos');
        $criterios = CriterioEvaluacion::where('grupo_id', $grupo->id)
                                        ->orderBy('orden')->get();

        $calificaciones = [];
        foreach ($grupo->alumnos as $alumno) {
            foreach ($criterios as $criterio) {
                $cal = Calificacion::where('criterio_id', $criterio->id)
                                   ->where('alumno_id', $alumno->id)
                                   ->first();
                $calificaciones[$alumno->id][$criterio->id] = $cal?->calificacion;
            }
        }

        return view('maestro.calificaciones.index', compact('grupo', 'criterios', 'calificaciones'));
    }

    public function guardar(Request $request, Grupo $grupo)
    {
        if ($grupo->maestro_id !== Auth::id()) abort(403);

        $request->validate([
            'calificaciones'         => 'required|array',
            'calificaciones.*.*'     => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->calificaciones as $alumnoId => $criterios) {
            foreach ($criterios as $criterioId => $valor) {
                if ($valor !== null && $valor !== '') {
                    Calificacion::updateOrCreate(
                        ['criterio_id' => $criterioId, 'alumno_id' => $alumnoId],
                        ['calificacion' => $valor, 'registrado_por' => Auth::id()]
                    );
                }
            }
        }

        return back()->with('success', 'Calificaciones guardadas exitosamente.');
    }
}