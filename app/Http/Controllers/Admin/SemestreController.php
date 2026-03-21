<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSemestreRequest;
use App\Models\Semestre;

class SemestreController extends Controller
{
    public function index()
    {
        $semestres = Semestre::orderBy('fecha_inicio', 'desc')->paginate(10);
        return view('admin.semestres.index', compact('semestres'));
    }

    public function create()
    {
        return view('admin.semestres.create');
    }

    public function store(StoreSemestreRequest $request)
    {
        // Si se marca como activo, desactivar los demás
        if ($request->boolean('activo')) {
            Semestre::where('activo', true)->update(['activo' => false]);
        }

        Semestre::create([
            'nombre'       => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'activo'       => $request->boolean('activo'),
        ]);

        return redirect()->route('admin.semestres.index')
                         ->with('success', 'Semestre creado exitosamente.');
    }

    public function edit(Semestre $semestre)
    {
        return view('admin.semestres.edit', compact('semestre'));
    }

    public function update(StoreSemestreRequest $request, Semestre $semestre)
    {
        if ($request->boolean('activo')) {
            Semestre::where('activo', true)
                    ->where('id', '!=', $semestre->id)
                    ->update(['activo' => false]);
        }

        $semestre->update([
            'nombre'       => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'activo'       => $request->boolean('activo'),
        ]);

        return redirect()->route('admin.semestres.index')
                         ->with('success', 'Semestre actualizado exitosamente.');
    }

    public function destroy(Semestre $semestre)
    {
        $semestre->delete();
        return redirect()->route('admin.semestres.index')
                         ->with('success', 'Semestre eliminado exitosamente.');
    }
}