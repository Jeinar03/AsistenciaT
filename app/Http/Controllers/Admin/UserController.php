<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Services\AuditoriaService;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->paginate(10);
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'matricula' => $request->matricula,
            'telefono'  => $request->telefono,
            'tipo'      => $request->tipo,
            'activo'    => true,
        ]);
        $user->assignRole($request->role);
        AuditoriaService::registrar('crear', 'usuarios', 'Creo el usuario ' . $user->name);
        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'matricula' => $request->matricula,
            'telefono'  => $request->telefono,
            'tipo'      => $request->tipo,
            'activo'    => $request->boolean('activo'),
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        $user->syncRoles([$request->role]);
        AuditoriaService::registrar('editar', 'usuarios', 'Edito el usuario ' . $user->name);
        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }
        AuditoriaService::registrar('eliminar', 'usuarios', 'Elimino el usuario ' . $user->name);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}