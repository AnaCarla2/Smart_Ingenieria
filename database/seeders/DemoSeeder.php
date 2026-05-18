<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $roles = [
            ['nombre' => 'gerente', 'descripcion' => 'Gerente general'],
            ['nombre' => 'director', 'descripcion' => 'Director de área'],
            ['nombre' => 'admin', 'descripcion' => 'Administrador'],
            ['nombre' => 'supervisor', 'descripcion' => 'Supervisor de obra'],
            ['nombre' => 'trabajador', 'descripcion' => 'Trabajador de campo'],
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(['nombre' => $rol['nombre']], $rol);
        }

        // Usuarios y empleados
        $usuarios = [
            ['name' => 'Gerente', 'email' => 'gerente@empresa.com', 'rol' => 'gerente', 'cedula' => '10000001', 'cargo' => 'Gerente General'],
            ['name' => 'Director', 'email' => 'director@empresa.com', 'rol' => 'director', 'cedula' => '10000002', 'cargo' => 'Director de Área'],
            ['name' => 'Administrador', 'email' => 'admin@empresa.com', 'rol' => 'admin', 'cedula' => '10000003', 'cargo' => 'Administrador'],
            ['name' => 'Supervisor', 'email' => 'supervisor@empresa.com', 'rol' => 'supervisor', 'cedula' => '10000004', 'cargo' => 'Supervisor de Obra'],
            ['name' => 'Carlos López', 'email' => 'carlos@empresa.com', 'rol' => 'trabajador', 'cedula' => '10000005', 'cargo' => 'Operario'],
            ['name' => 'Luis Martínez', 'email' => 'luis@empresa.com', 'rol' => 'trabajador', 'cedula' => '10000006', 'cargo' => 'Operario'],
            ['name' => 'Pedro García', 'email' => 'pedro@empresa.com', 'rol' => 'trabajador', 'cedula' => '10000007', 'cargo' => 'Operario'],
        ];

        foreach ($usuarios as $u) {
            $rol = DB::table('roles')->where('nombre', $u['rol'])->first();

            DB::table('users')->updateOrInsert(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'email' => $u['email'],
                    'password' => Hash::make('password'),
                    'rol_id' => $rol->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $user = DB::table('users')->where('email', $u['email'])->first();

            DB::table('empleados')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'rol_id' => $rol->id,
                    'cedula' => $u['cedula'],
                    'cargo' => $u['cargo'],
                    'telefono' => '3000000000',
                    'salario' => 2000000,
                    'fecha_ingreso' => now(),
                    'estado' => 'activo',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}