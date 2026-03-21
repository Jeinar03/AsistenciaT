<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,'.$userId,
            'password'  => 'nullable|string|min:8|confirmed',
            'matricula' => 'nullable|string|max:20|unique:users,matricula,'.$userId,
            'telefono'  => 'nullable|string|max:20',
            'tipo'      => 'required|in:admin,maestro,alumno',
            'role'      => 'required|string|exists:roles,name',
            'activo'    => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.unique'   => 'Este correo ya está registrado.',
            'password.min'   => 'La contraseña debe tener al menos 8 caracteres.',
            'tipo.required'  => 'El tipo de usuario es obligatorio.',
            'role.required'  => 'El rol es obligatorio.',
        ];
    }
}