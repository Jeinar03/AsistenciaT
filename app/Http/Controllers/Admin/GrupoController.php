<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGrupoRequest;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Semestre;
use App\Models\Horario;
use App\Models\User;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::with(['materia', 'semestre', 'maestro', 'alumnos'])
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);
        return view('admin.grupos.index', compact('grupos'));
    }

    public function create()
    {
        $materias  = Materia::where('activo', true)->orderBy('nombre')->get();
        $semestres = Semestre::where('activo', true)->orderBy('nombre')->get();
        $maestros  = User::where('tipo', 'maestro')->where('activo', true)->orderBy('name')->get();
        return view('admin.grupos.create', compact('materias', 'semestres', 'maestros'));
    }

    public function store(StoreGrupoRequest $request)
    {
        $grupo = Grupo::create([
            'materia_id'                   => $request->materia_id,
            'semestre_id'                  => $request->semestre_id,
            'maestro_id'                   => $request->maestro_id,
            'clave'                        => strtoupper($request->clave),
            'max_alumnos'                  => $request->max_alumnos,
            'porcentaje_asistencia_minima' => $request->porcentaje_asistencia_minima,
            'activo'                       => true,
        ]);

        // Crear horarios
        foreach ($request->horarios as $horario) {
            Horario::create([
                'grupo_id'    => $grupo->id,
                'dia'         => $horario['dia'],
                'hora_inicio' => $horario['hora_inicio'],
                'hora_fin'    => $horario['hora_fin'],
                'aula'        => $horario['aula'] ?? null,
            ]);
        }

        // Generar sesiones automáticamente
        $this->generarSesiones($grupo);

        return redirect()->route('admin.grupos.index')
                         ->with('success', 'Grupo creado exitosamente con sus sesiones.');
    }

    public function edit(Grupo $grupo)
    {
        $grupo->load('horarios');
        $materias  = Materia::where('activo', true)->orderBy('nombre')->get();
        $semestres = Semestre::orderBy('nombre')->get();
        $maestros  = User::where('tipo', 'maestro')->where('activo', true)->orderBy('name')->get();
        return view('admin.grupos.edit', compact('grupo', 'materias', 'semestres', 'maestros'));
    }

    public function update(StoreGrupoRequest $request, Grupo $grupo)
    {
        $grupo->update([
            'materia_id'                   => $request->materia_id,
            'semestre_id'                  => $request->semestre_id,
            'maestro_id'                   => $request->maestro_id,
            'clave'                        => strtoupper($request->clave),
            'max_alumnos'                  => $request->max_alumnos,
            'porcentaje_asistencia_minima' => $request->porcentaje_asistencia_minima,
            'activo'                       => $request->boolean('activo'),
        ]);

        // Actualizar horarios
        $grupo->horarios()->delete();
        foreach ($request->horarios as $horario) {
            Horario::create([
                'grupo_id'    => $grupo->id,
                'dia'         => $horario['dia'],
                'hora_inicio' => $horario['hora_inicio'],
                'hora_fin'    => $horario['hora_fin'],
                'aula'        => $horario['aula'] ?? null,
            ]);
        }

        return redirect()->route('admin.grupos.index')
                         ->with('success', 'Grupo actualizado exitosamente.');
    }

    public function destroy(Grupo $grupo)
    {
        $grupo->delete();
        return redirect()->route('admin.grupos.index')
                         ->with('success', 'Grupo eliminado exitosamente.');
    }

    private function generarSesiones(Grupo $grupo)
    {
        $semestre = $grupo->semestre;
        $horarios = $grupo->horarios;

        $diasSemana = [
            'lunes'     => 1,
            'martes'    => 2,
            'miercoles' => 3,
            'jueves'    => 4,
            'viernes'   => 5,
            'sabado'    => 6,
        ];

        $fechaInicio = $semestre->fecha_inicio->copy();
        $fechaFin    = $semestre->fecha_fin->copy();

        foreach ($horarios as $horario) {
            $diaSemana = $diasSemana[$horario->dia];
            $fecha = $fechaInicio->copy()->next($diaSemana);

            if ($fecha->lt($fechaInicio)) {
                $fecha = $fechaInicio->copy();
            }

            while ($fecha->lte($fechaFin)) {
                \App\Models\Sesion::create([
                    'grupo_id'    => $grupo->id,
                    'horario_id'  => $horario->id,
                    'fecha'       => $fecha->toDateString(),
                    'hora_inicio' => $horario->hora_inicio,
                    'hora_fin'    => $horario->hora_fin,
                    'estado'      => 'programada',
                ]);
                $fecha->addWeek();
            }
        }
    }
}