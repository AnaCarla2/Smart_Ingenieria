<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Redirige al usuario a su dashboard según su rol.
     */
    public function index()
    {
        $usuario = auth()->user();
        $rol = $usuario->rol->nombre;

        switch ($rol) {
            case 'gerente':
                return view('dashboards.gerente');
            case 'director':
                return view('dashboards.director');
            case 'admin':
                return view('dashboards.admin');
            case 'supervisor':
                return redirect()->route('supervisor.dashboard');
            case 'trabajador':
                return view('dashboards.trabajador');
            default:
                abort(403, 'Rol no reconocido.');
        }
    }
}