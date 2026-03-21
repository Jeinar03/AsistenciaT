<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMateriaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $materiaId = $this->route('materia')?->id;

        return [
            'carrera_id' => 'required|exists:carreras,id',
            'clave'      => 'required|string|max:20|unique:materias,clave,'.$materiaId,
            'nombre'     => 'required|string|max:150',
            'creditos'   => 'required|integer|min:0|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'carrera_id.required' => 'Selecciona una carrera.',
            'carrera_id.exists'   => 'La carrera seleccionada no existe.',
            'clave.required'      => 'La clave es obligatoria.',
            'clave.unique'        => 'Esta clave ya está registrada.',
            'nombre.required'     => 'El nombre es obligatorio.',
            'creditos.required'   => 'Los créditos son obligatorios.',
        ];
    }
}