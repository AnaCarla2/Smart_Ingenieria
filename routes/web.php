<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AsistenciaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Ruta pública de asistencia (sin login)
Route::get('/registro-asistencia', [AsistenciaController::class, 'vistaPublica'])->name('asistencia.publica');
Route::post('/registro-asistencia/buscar', [AsistenciaController::class, 'buscarEmpleado'])->name('asistencia.buscar');
Route::post('/registro-asistencia/registrar', [AsistenciaController::class, 'registrar'])->name('asistencia.registrar');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';