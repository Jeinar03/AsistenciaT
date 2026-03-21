<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCarreraRequest;
use App\Models\Carrera;

class CarreraController extends Controller
{
    public function index()
    {
        $carreras = Carrera::withCount('materias')
                           ->orderBy('created_at', 'desc')
                           ->paginate(10);
        return view('admin.carreras.index', compact('carreras'));
    }

    public function create()
    {
        return view('admin.carreras.create');
    }

    public function store(StoreCarreraRequest $request)
    {
        Carrera::create([
            'clave'  => strtoupper($request->clave),
            'nombre' => $request->nombre,
            'activo' => true,
        ]);

        return redirect()->route('admin.carreras.index')
                         ->with('success', 'Carrera creada exitosamente.');
    }

    public function edit(Carrera $carrera)
    {
        return view('admin.carreras.edit', compact('carrera'));
    }

    public function update(StoreCarreraRequest $request, Carrera $carrera)
    {
        $carrera->update([
            'clave'  => strtoupper($request->clave),
            'nombre' => $request->nombre,
            'activo' => $request->boolean('activo'),
        ]);

        return redirect()->route('admin.carreras.index')
                         ->with('success', 'Carrera actualizada exitosamente.');
    }

    public function destroy(Carrera $carrera)
    {
        $carrera->delete();
        return redirect()->route('admin.carreras.index')
                         ->with('success', 'Carrera eliminada exitosamente.');
    }
}