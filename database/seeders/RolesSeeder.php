<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'maestro']);
        Role::create(['name' => 'alumno']);

        // Permisos de admin
        Permission::create(['name' => 'gestionar usuarios']);
        Permission::create(['name' => 'gestionar semestres']);
        Permission::create(['name' => 'gestionar carreras']);
        Permission::create(['name' => 'ver reportes globales']);

        // Permisos de maestro
        Permission::create(['name' => 'tomar asistencia']);
        Permission::create(['name' => 'gestionar criterios']);
        Permission::create(['name' => 'registrar calificaciones']);
        Permission::create(['name' => 'publicar asignaciones']);

        // Permisos de alumno
        Permission::create(['name' => 'ver asistencia']);
        Permission::create(['name' => 'ver calificaciones']);
        Permission::create(['name' => 'ver asignaciones']);

        // Asignar permisos a roles
        Role::findByName('admin')->givePermissionTo(Permission::all());
        Role::findByName('maestro')->givePermissionTo([
            'tomar asistencia',
            'gestionar criterios',
            'registrar calificaciones',
            'publicar asignaciones',
        ]);
        Role::findByName('alumno')->givePermissionTo([
            'ver asistencia',
            'ver calificaciones',
            'ver asignaciones',
        ]);
    }
}