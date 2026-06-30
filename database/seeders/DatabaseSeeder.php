<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Proyecto;
use App\Models\Asistencia;
use App\Models\Asignacion;
use App\Models\Novedad;
use App\Models\ConfiguracionJornada;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Configuración de jornada laboral — Ley 2101 de 2021 ─────────────
        ConfiguracionJornada::create([
            'fecha_inicio'          => '2024-01-01',
            'fecha_fin'             => '2026-07-14',
            'horas_diarias'         => 8,
            'horas_semanales'       => 44,
            'horas_extra_diarias'   => 2,
            'horas_extra_semanales' => 12,
            'descripcion'           => 'Jornada 44h semanales — Ley 2101',
        ]);

        ConfiguracionJornada::create([
            'fecha_inicio'          => '2026-07-15',
            'fecha_fin'             => null,
            'horas_diarias'         => 8,
            'horas_semanales'       => 42,
            'horas_extra_diarias'   => 2,
            'horas_extra_semanales' => 12,
            'descripcion'           => 'Jornada 42h semanales — Ley 2101 reducción final',
        ]);

        // ─── Roles ────────────────────────────────────────────────────────────
        $rolTrabajador = Rol::create(['nombre' => 'trabajador',  'descripcion' => 'Registra su asistencia diaria']);
        $rolSupervisor = Rol::create(['nombre' => 'supervisor',  'descripcion' => 'Asigna personal y registra tiempos']);
        $rolAdmin      = Rol::create(['nombre' => 'admin',       'descripcion' => 'Gestiona proyectos y trabajadores']);
        $rolDirector   = Rol::create(['nombre' => 'director',    'descripcion' => 'Consulta avances de proyectos']);
        $rolGerente    = Rol::create(['nombre' => 'gerente',     'descripcion' => 'Reportes estratégicos y costos']);

        // ─── Usuarios ─────────────────────────────────────────────────────────
        $gerente = User::create([
            'name'     => 'Carlos Gerente',
            'email'    => 'gerente@empresa.com',
            'password' => Hash::make('password'),
            'rol_id'   => $rolGerente->id,
        ]);

        $director = User::create([
            'name'     => 'Ana Directora',
            'email'    => 'director@empresa.com',
            'password' => Hash::make('password'),
            'rol_id'   => $rolDirector->id,
        ]);

        $admin = User::create([
            'name'     => 'Luis Admin',
            'email'    => 'admin@empresa.com',
            'password' => Hash::make('password'),
            'rol_id'   => $rolAdmin->id,
        ]);

        $supervisor = User::create([
            'name'     => 'Pedro Supervisor',
            'email'    => 'supervisor@empresa.com',
            'password' => Hash::make('password'),
            'rol_id'   => $rolSupervisor->id,
        ]);

        $userTrabajador1 = User::create([
            'name'     => 'Carlos Mendoza',
            'email'    => 'carlos@empresa.com',
            'password' => Hash::make('password'),
            'rol_id'   => $rolTrabajador->id,
        ]);

        $userTrabajador2 = User::create([
            'name'     => 'Luis Parra',
            'email'    => 'luis@empresa.com',
            'password' => Hash::make('password'),
            'rol_id'   => $rolTrabajador->id,
        ]);

        $userTrabajador3 = User::create([
            'name'     => 'Pedro Gómez',
            'email'    => 'pedro@empresa.com',
            'password' => Hash::make('password'),
            'rol_id'   => $rolTrabajador->id,
        ]);

        // ─── Empleados ────────────────────────────────────────────────────────
        $empleado1 = Empleado::create([
            'user_id'       => $userTrabajador1->id,
            'rol_id'        => $rolTrabajador->id,
            'cedula'        => '1023456789',
            'cargo'         => 'Soldador',
            'telefono'      => '3001234567',
            'salario'       => 2800000,
            'fecha_ingreso' => '2024-01-15',
            'estado'        => 'activo',
        ]);

        $empleado2 = Empleado::create([
            'user_id'       => $userTrabajador2->id,
            'rol_id'        => $rolTrabajador->id,
            'cedula'        => '1034567890',
            'cargo'         => 'Operador de CNC',
            'telefono'      => '3009876543',
            'salario'       => 3200000,
            'fecha_ingreso' => '2024-03-01',
            'estado'        => 'activo',
        ]);

        $empleado3 = Empleado::create([
            'user_id'       => $userTrabajador3->id,
            'rol_id'        => $rolTrabajador->id,
            'cedula'        => '1056789012',
            'cargo'         => 'Armador',
            'telefono'      => '3007654321',
            'salario'       => 2600000,
            'fecha_ingreso' => '2024-02-01',
            'estado'        => 'activo',
        ]);

        // ─── Proyectos ────────────────────────────────────────────────────────
        $proyecto1 = Proyecto::create([
            'nombre'            => 'Estructura Metálica Bodega A',
            'descripcion'       => 'Fabricación estructura metálica',
            'fecha_inicio'      => '2026-02-01',
            'fecha_fin'         => '2026-06-30',
            'presupuesto'       => 120000000,
            'costo_fabricacion' => 0,
            'estado'            => 'activo',
            'es_platano'        => false,
            'user_id'           => $admin->id,
        ]);

        $proyecto2 = Proyecto::create([
            'nombre'            => 'Operación de Plátano',
            'descripcion'       => 'Operaciones de mantenimiento plátano',
            'fecha_inicio'      => '2026-01-01',
            'fecha_fin'         => '2026-12-31',
            'presupuesto'       => 50000000,
            'costo_fabricacion' => 0,
            'estado'            => 'activo',
            'es_platano'        => true,
            'user_id'           => $admin->id,
        ]);

        $proyecto3 = Proyecto::create([
            'nombre'            => 'Remodelación Oficinas',
            'descripcion'       => 'Remodelación completa de oficinas',
            'fecha_inicio'      => '2026-03-01',
            'fecha_fin'         => '2026-08-31',
            'presupuesto'       => 80000000,
            'costo_fabricacion' => 0,
            'estado'            => 'activo',
            'es_platano'        => false,
            'user_id'           => $admin->id,
        ]);

        // ─── Asistencia ───────────────────────────────────────────────────────
        Asistencia::create([
            'empleado_id'     => $empleado1->id,
            'fecha'           => now()->format('Y-m-d'),
            'hora_entrada'    => '06:00:00',
            'hora_salida'     => '17:00:00',
            'metodo_registro' => 'manual',
            'estado'          => 'presente',
        ]);

        Asistencia::create([
            'empleado_id'     => $empleado2->id,
            'fecha'           => now()->format('Y-m-d'),
            'hora_entrada'    => '06:05:00',
            'hora_salida'     => '17:00:00',
            'metodo_registro' => 'manual',
            'estado'          => 'presente',
        ]);

        // ─── Asignaciones ─────────────────────────────────────────────────────
        Asignacion::create([
            'empleado_id'   => $empleado1->id,
            'proyecto_id'   => $proyecto1->id,
            'supervisor_id' => $supervisor->id,
            'fecha'         => now()->format('Y-m-d'),
            'hora_inicio'   => '07:00:00',
            'hora_fin'      => '12:00:00',
            'tarea'         => 'Soldadura columnas principales',
            'es_hora_extra' => false,
        ]);

        Asignacion::create([
            'empleado_id'   => $empleado1->id,
            'proyecto_id'   => $proyecto2->id,
            'supervisor_id' => $supervisor->id,
            'fecha'         => now()->format('Y-m-d'),
            'hora_inicio'   => '12:00:00',
            'hora_fin'      => '17:00:00',
            'tarea'         => 'Mantenimiento equipo plátano',
            'es_hora_extra' => false,
        ]);

        // ─── Novedad ──────────────────────────────────────────────────────────
        Novedad::create([
            'empleado_id'  => $empleado3->id,
            'tipo'         => 'permiso_personal',
            'fecha_inicio' => now()->format('Y-m-d'),
            'fecha_fin'    => now()->format('Y-m-d'),
            'descripcion'  => 'Permiso por cita médica',
            'estado'       => 'aprobado',
            'aprobado_por' => $supervisor->id,
        ]);
    }
}