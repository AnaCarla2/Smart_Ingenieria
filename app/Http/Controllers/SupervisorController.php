<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Asignacion;
use App\Models\Empleado;
use App\Models\Novedad;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SupervisorController extends Controller
{
    /**
     * Dashboard principal del supervisor.
     * Muestra métricas del día: presentes, proyectos activos y novedades pendientes.
     */
    public function dashboard()
    {
        $hoy = Carbon::today()->format('Y-m-d');

        // Trabajadores presentes hoy
        $presentes = Asistencia::whereDate('fecha', $hoy)
            ->where('estado', 'presente')
            ->with('empleado.user')
            ->get();

        // Proyectos activos
        $proyectos = Proyecto::where('estado', 'activo')->get();

        // Novedades pendientes
        $novedadesPendientes = Novedad::where('estado', 'pendiente')
            ->with('empleado.user')
            ->get();

        // Total empleados activos
        $totalEmpleados = Empleado::where('estado', 'activo')->count();

        return view('supervisor.dashboard', compact(
            'presentes',
            'proyectos',
            'novedadesPendientes',
            'totalEmpleados',
            'hoy'
        ));
    }

    /**
     * Lista todos los trabajadores activos del sistema.
     * El supervisor puede ver, crear, editar e inactivar trabajadores.
     */
    public function trabajadores()
    {
        $trabajadores = Empleado::where('estado', 'activo')
            ->with('user', 'rol')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('supervisor.trabajadores', compact('trabajadores'));
    }

    /**
     * Muestra el formulario para crear un nuevo trabajador.
     */
    public function crearTrabajador()
    {
        return view('supervisor.crear-trabajador');
    }

    /**
     * Guarda un nuevo trabajador en la base de datos.
     * Crea primero el usuario y luego el perfil de empleado.
     */
    public function guardarTrabajador(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'cedula'       => 'required|string|unique:empleados,cedula',
            'cargo'        => 'required|string',
            'telefono'     => 'nullable|string',
            'salario'      => 'required|numeric|min:0',
            'fecha_ingreso'=> 'required|date',
        ]);

        // Crear usuario
        $user = \App\Models\User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'rol_id'   => \App\Models\Rol::where('nombre', 'trabajador')->first()->id,
        ]);

        // Crear empleado
        Empleado::create([
            'user_id'       => $user->id,
            'rol_id'        => $user->rol_id,
            'cedula'        => $request->cedula,
            'cargo'         => $request->cargo,
            'telefono'      => $request->telefono,
            'salario'       => $request->salario,
            'fecha_ingreso' => $request->fecha_ingreso,
            'estado'        => 'activo',
        ]);

        return redirect()->route('supervisor.trabajadores')
            ->with('success', '✅ Trabajador creado exitosamente.');
    }

    /**
     * Inactiva un trabajador (no lo elimina).
     */
    public function inactivarTrabajador($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->update(['estado' => 'inactivo']);

        return redirect()->route('supervisor.trabajadores')
            ->with('success', '✅ Trabajador inactivado correctamente.');
    }

    /**
     * Muestra la vista de asignaciones del día.
     * El supervisor asigna trabajadores presentes a proyectos con horas.
     */
    public function asignaciones(Request $request)
    {
        $fecha = $request->get('fecha', Carbon::today()->format('Y-m-d'));

        // Trabajadores presentes en la fecha seleccionada
        $presentes = Asistencia::whereDate('fecha', $fecha)
            ->where('estado', 'presente')
            ->with('empleado.user')
            ->get();

        // Proyectos activos disponibles
        $proyectos = Proyecto::where('estado', 'activo')->get();

        // Asignaciones ya registradas para esa fecha
        $asignaciones = Asignacion::whereDate('fecha', $fecha)
            ->with('empleado.user', 'proyecto')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('supervisor.asignaciones', compact(
            'presentes',
            'proyectos',
            'asignaciones',
            'fecha'
        ));
    }

    /**
     * Guarda una nueva asignación de trabajador a proyecto.
     * Valida que las horas no superen la jornada del trabajador.
     */
    public function guardarAsignacion(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'proyecto_id' => 'required|exists:proyectos,id',
            'fecha'       => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin'    => 'required|after:hora_inicio',
            'tarea'       => 'nullable|string',
            'es_hora_extra'=> 'nullable|boolean',
        ]);

        Asignacion::create([
            'empleado_id'   => $request->empleado_id,
            'proyecto_id'   => $request->proyecto_id,
            'supervisor_id' => auth()->id(),
            'fecha'         => $request->fecha,
            'hora_inicio'   => $request->hora_inicio,
            'hora_fin'      => $request->hora_fin,
            'tarea'         => $request->tarea,
            'es_hora_extra' => $request->boolean('es_hora_extra'),
        ]);

        return redirect()->route('supervisor.asignaciones', ['fecha' => $request->fecha])
            ->with('success', '✅ Asignación registrada correctamente.');
    }

    /**
     * Elimina una asignación registrada por error.
     */
    public function eliminarAsignacion($id)
    {
        Asignacion::findOrFail($id)->delete();

        return back()->with('success', '✅ Asignación eliminada.');
    }

    /**
     * Muestra la vista de novedades.
     */
    public function novedades()
    {
        $novedades = Novedad::with('empleado.user', 'aprobadoPor')
            ->orderBy('created_at', 'desc')
            ->get();

        $empleados = Empleado::where('estado', 'activo')->with('user')->get();

        return view('supervisor.novedades', compact('novedades', 'empleados'));
    }

    /**
     * Guarda una nueva novedad para un empleado.
     */
    public function guardarNovedad(Request $request)
    {
        $request->validate([
            'empleado_id'  => 'required|exists:empleados,id',
            'tipo'         => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            'descripcion'  => 'required|string',
        ]);

        Novedad::create([
            'empleado_id'  => $request->empleado_id,
            'tipo'         => $request->tipo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'descripcion'  => $request->descripcion,
            'estado'       => 'aprobado',
            'aprobado_por' => auth()->id(),
        ]);

        return redirect()->route('supervisor.novedades')
            ->with('success', '✅ Novedad registrada correctamente.');
    }
}