<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarreraRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $carreraId = $this->route('carrera')?->id;

        return [
            'clave'  => 'required|string|max:20|unique:carreras,clave,'.$carreraId,
            'nombre' => 'required|string|max:150',
            'activo' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'clave.required'  => 'La clave es obligatoria.',
            'clave.unique'    => 'Esta clave ya está registrada.',
            'nombre.required' => 'El nombre es obligatorio.',
        ];
    }
}