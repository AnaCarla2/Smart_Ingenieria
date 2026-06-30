<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// ─── MÓDULO: ASISTENCIA PÚBLICA (sin login) ───────────────────────────────
Route::get('/registro-asistencia', [AsistenciaController::class, 'vistaPublica'])->name('asistencia.publica');
Route::post('/registro-asistencia/buscar', [AsistenciaController::class, 'buscarEmpleado'])->name('asistencia.buscar');
Route::post('/registro-asistencia/registrar', [AsistenciaController::class, 'registrar'])->name('asistencia.registrar');

// ─── DASHBOARD (redirige según rol) ───────────────────────────────────────
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// ─── MÓDULO: SUPERVISOR ───────────────────────────────────────────────────
Route::middleware(['auth', 'rol:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', [SupervisorController::class, 'dashboard'])->name('dashboard');

    // Asignaciones
    Route::get('/asignaciones', [SupervisorController::class, 'asignaciones'])->name('asignaciones');
    Route::post('/asignaciones/guardar', [SupervisorController::class, 'guardarAsignacion'])->name('asignaciones.guardar');
    Route::delete('/asignaciones/{id}', [SupervisorController::class, 'eliminarAsignacion'])->name('asignaciones.eliminar');
    Route::get('/asignaciones/{id}/editar', [SupervisorController::class, 'editarAsignacion'])->name('asignaciones.editar');
    Route::patch('/asignaciones/{id}', [SupervisorController::class, 'actualizarAsignacion'])->name('asignaciones.actualizar');
    Route::get('/verificar-horas/{empleadoId}/{fecha}', [SupervisorController::class, 'verificarHoras'])->name('verificar.horas');
   
    // Novedades
    Route::get('/novedades', [SupervisorController::class, 'novedades'])->name('novedades');
    Route::post('/novedades/guardar', [SupervisorController::class, 'guardarNovedad'])->name('novedades.guardar');
});

// ─── MÓDULO: ADMIN ────────────────────────────────────────────────────────
Route::middleware(['auth', 'rol:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Proyectos
    Route::get('/proyectos/crear', [AdminController::class, 'crearProyecto'])->name('proyectos.crear');
    Route::post('/proyectos/guardar', [AdminController::class, 'guardarProyecto'])->name('proyectos.guardar');
    Route::get('/proyectos/{id}/editar', [AdminController::class, 'editarProyecto'])->name('proyectos.editar');
    Route::patch('/proyectos/{id}', [AdminController::class, 'actualizarProyecto'])->name('proyectos.actualizar');

    // Trabajadores
    Route::get('/trabajadores/crear', [AdminController::class, 'crearTrabajador'])->name('trabajadores.crear');
    Route::post('/trabajadores/guardar', [AdminController::class, 'guardarTrabajador'])->name('trabajadores.guardar');
    Route::get('/trabajadores/{id}/editar', [AdminController::class, 'editarTrabajador'])->name('trabajadores.editar');
    Route::patch('/trabajadores/{id}', [AdminController::class, 'actualizarTrabajador'])->name('trabajadores.actualizar');
    Route::patch('/trabajadores/{id}/inactivar', [AdminController::class, 'inactivarTrabajador'])->name('trabajadores.inactivar');
});

// ─── PERFIL ───────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';