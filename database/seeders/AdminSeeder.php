<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'      => 'Administrador',
            'email'     => 'admin@asistenciat.com',
            'password'  => bcrypt('Admin1234!'),
            'matricula' => 'ADMIN001',
            'tipo'      => 'admin',
            'activo'    => true,
        ]);

        $admin->assignRole('admin');
    }
}