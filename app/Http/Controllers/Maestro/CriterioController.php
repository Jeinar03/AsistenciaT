<?php

namespace App\Http\Controllers\Maestro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Maestro\StoreCriterioRequest;
use App\Models\Grupo;
use App\Models\CriterioEvaluacion;
use Illuminate\Support\Facades\Auth;

class CriterioController extends Controller
{
    public function index(Grupo $grupo)
    {
        if ($grupo->maestro_id !== Auth::id()) abort(403);

        $criterios = CriterioEvaluacion::where('grupo_id', $grupo->id)
                                        ->orderBy('orden')
                                        ->get();
        $totalPeso = $criterios->sum('peso');

        return view('maestro.criterios.index', compact('grupo', 'criterios', 'totalPeso'));
    }

    public function store(StoreCriterioRequest $request, Grupo $grupo)
    {
        if ($grupo->maestro_id !== Auth::id()) abort(403);

        CriterioEvaluacion::create([
            'grupo_id'      => $grupo->id,
            'nombre'        => $request->nombre,
            'peso'          => $request->peso,
            'tipo'          => $request->tipo,
            'fecha_entrega' => $request->fecha_entrega,
            'orden'         => $request->orden,
        ]);

        return back()->with('success', 'Criterio agregado exitosamente.');
    }

    public function destroy(Grupo $grupo, CriterioEvaluacion $criterio)
    {
        if ($grupo->maestro_id !== Auth::id()) abort(403);
        $criterio->delete();
        return back()->with('success', 'Criterio eliminado.');
    }
}