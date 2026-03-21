<?php

namespace App\Http\Requests\Maestro;

use Illuminate\Foundation\Http\FormRequest;

class StoreCriterioRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nombre'        => 'required|string|max:100',
            'peso'          => 'required|numeric|min:0|max:100',
            'tipo'          => 'required|in:examen,tarea,proyecto,participacion,asistencia,otro',
            'fecha_entrega' => 'nullable|date',
            'orden'         => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'peso.required'   => 'El peso es obligatorio.',
            'tipo.required'   => 'El tipo es obligatorio.',
        ];
    }
}