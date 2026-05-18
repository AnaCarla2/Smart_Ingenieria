<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Proyecto;
use App\Models\Asistencia;
use App\Models\Asignacion;
use App\Models\Novedad;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
   public function run(): void
{
    $this->call([
        DemoSeeder::class,
    ]);
}
}