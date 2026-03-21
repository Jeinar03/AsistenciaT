<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use App\Models\User;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    public function index(Grupo $grupo)
    {
        $grupo->load('materia', 'semestre', 'maestro', 'alumnos');
        $alumnosDisponibles = User::where('tipo', 'alumno')
                                  ->where('activo', true)
                                  ->whereNotIn('id', $grupo->alumnos->pluck('id'))
                                  ->orderBy('name')
                                  ->get();

        return view('admin.inscripciones.index', compact('grupo', 'alumnosDisponibles'));
    }

    public function inscribir(Request $request, Grupo $grupo)
    {
        $request->validate([
            'alumno_id' => 'required|exists:users,id',
        ]);

        $alumno = User::findOrFail($request->alumno_id);

        if ($grupo->alumnos()->where('alumno_id', $alumno->id)->exists()) {
            return back()->with('error', 'El alumno ya está inscrito en este grupo.');
        }

        if ($grupo->alumnos->count() >= $grupo->max_alumnos) {
            return back()->with('error', 'El grupo ya alcanzó el máximo de alumnos.');
        }

        $grupo->alumnos()->attach($alumno->id);

        return back()->with('success', "Alumno {$alumno->name} inscrito exitosamente.");
    }

    public function desinscribir(Grupo $grupo, User $alumno)
    {
        $grupo->alumnos()->detach($alumno->id);
        return back()->with('success', "Alumno {$alumno->name} removido del grupo.");
    }
}