<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrupoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $grupoId = $this->route('grupo')?->id;

        return [
            'materia_id'                  => 'required|exists:materias,id',
            'semestre_id'                 => 'required|exists:semestres,id',
            'maestro_id'                  => 'required|exists:users,id',
            'clave'                       => 'required|string|max:20',
            'max_alumnos'                 => 'required|integer|min:1|max:100',
            'porcentaje_asistencia_minima'=> 'required|numeric|min:0|max:100',
            'horarios'                    => 'required|array|min:1',
            'horarios.*.dia'              => 'required|in:lunes,martes,miercoles,jueves,viernes,sabado',
            'horarios.*.hora_inicio'      => 'required|date_format:H:i',
            'horarios.*.hora_fin'         => 'required|date_format:H:i|after:horarios.*.hora_inicio',
        ];
    }

    public function messages(): array
    {
        return [
            'materia_id.required'  => 'Selecciona una materia.',
            'semestre_id.required' => 'Selecciona un semestre.',
            'maestro_id.required'  => 'Selecciona un maestro.',
            'clave.required'       => 'La clave del grupo es obligatoria.',
            'horarios.required'    => 'Agrega al menos un horario.',
        ];
    }
}