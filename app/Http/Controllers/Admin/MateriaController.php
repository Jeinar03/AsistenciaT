<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMateriaRequest;
use App\Models\Materia;
use App\Models\Carrera;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::with('carrera')
                           ->orderBy('created_at', 'desc')
                           ->paginate(15);
        return view('admin.materias.index', compact('materias'));
    }

    public function create()
    {
        $carreras = Carrera::where('activo', true)->orderBy('nombre')->get();
        return view('admin.materias.create', compact('carreras'));
    }

    public function store(StoreMateriaRequest $request)
    {
        Materia::create([
            'carrera_id' => $request->carrera_id,
            'clave'      => strtoupper($request->clave),
            'nombre'     => $request->nombre,
            'creditos'   => $request->creditos,
            'activo'     => true,
        ]);

        return redirect()->route('admin.materias.index')
                         ->with('success', 'Materia creada exitosamente.');
    }

    public function edit(Materia $materia)
    {
        $carreras = Carrera::where('activo', true)->orderBy('nombre')->get();
        return view('admin.materias.edit', compact('materia', 'carreras'));
    }

    public function update(StoreMateriaRequest $request, Materia $materia)
    {
        $materia->update([
            'carrera_id' => $request->carrera_id,
            'clave'      => strtoupper($request->clave),
            'nombre'     => $request->nombre,
            'creditos'   => $request->creditos,
            'activo'     => $request->boolean('activo'),
        ]);

        return redirect()->route('admin.materias.index')
                         ->with('success', 'Materia actualizada exitosamente.');
    }

    public function destroy(Materia $materia)
    {
        $materia->delete();
        return redirect()->route('admin.materias.index')
                         ->with('success', 'Materia eliminada exitosamente.');
    }
}