<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
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
                return view('dashboards.supervisor');
            case 'trabajador':
                return view('dashboards.trabajador');
            default:
                abort(403, 'Rol no reconocido.');
        }
    }
}