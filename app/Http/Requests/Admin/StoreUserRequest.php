<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
            'matricula' => 'nullable|string|max:20|unique:users,matricula',
            'telefono'  => 'nullable|string|max:20',
            'tipo'      => 'required|in:admin,maestro,alumno',
            'role'      => 'required|string|exists:roles,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'El nombre es obligatorio.',
            'email.required'     => 'El correo es obligatorio.',
            'email.unique'       => 'Este correo ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'matricula.unique'   => 'Esta matrícula ya está registrada.',
            'tipo.required'      => 'El tipo de usuario es obligatorio.',
            'role.required'      => 'El rol es obligatorio.',
        ];
    }
}