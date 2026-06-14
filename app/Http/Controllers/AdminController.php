<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Empleado;
use App\Models\Asignacion;
use App\Models\Novedad;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Dashboard principal del administrador.
     * Muestra métricas generales, alertas, proyectos y trabajadores.
     */
    public function dashboard()
    {
        // Métricas generales
        $totalProyectos      = Proyecto::count();
        $proyectosActivos    = Proyecto::where('estado', 'activo')->count();
        $totalEmpleados      = Empleado::where('estado', 'activo')->count();
        $novedadesPendientes = Novedad::where('estado', 'pendiente')->count();

        // Alertas del sistema
        $alertas = [];

        // Proyectos desfasados en tiempo
        $proyectosDesfasadosTiempo = Proyecto::where('estado', '!=', 'finalizado')
            ->whereNotNull('fecha_fin')
            ->where('fecha_fin', '<', now()->format('Y-m-d'))
            ->get();

        foreach ($proyectosDesfasadosTiempo as $p) {
            $alertas[] = [
                'tipo'    => 'tiempo',
                'mensaje' => "⏰ El proyecto \"{$p->nombre}\" está desfasado en tiempo.",
                'color'   => 'rojo',
            ];
        }

        // Proyectos desfasados en presupuesto
        $proyectosDesfasadosPresupuesto = Proyecto::where('estado', '!=', 'finalizado')
            ->whereRaw('costo_fabricacion > presupuesto')
            ->get();

        foreach ($proyectosDesfasadosPresupuesto as $p) {
            $alertas[] = [
                'tipo'    => 'presupuesto',
                'mensaje' => "💰 El proyecto \"{$p->nombre}\" ha superado el presupuesto.",
                'color'   => 'rojo',
            ];
        }

        // Proyectos creados pero no iniciados
        $proyectosNoIniciados = Proyecto::where('estado', 'pendiente')
            ->where('fecha_inicio', '<', now()->format('Y-m-d'))
            ->get();

        foreach ($proyectosNoIniciados as $p) {
            $alertas[] = [
                'tipo'    => 'sin_iniciar',
                'mensaje' => "🚨 El proyecto \"{$p->nombre}\" debió iniciar el " . Carbon::parse($p->fecha_inicio)->format('d/m/Y') . " y aún no ha comenzado.",
                'color'   => 'amarillo',
            ];
        }

        // Lista de proyectos
        $proyectos = Proyecto::orderBy('created_at', 'desc')->get();

        // Lista de trabajadores activos
        $trabajadores = Empleado::where('estado', 'activo')
            ->with('user', 'rol')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'totalProyectos',
            'proyectosActivos',
            'totalEmpleados',
            'novedadesPendientes',
            'alertas',
            'proyectos',
            'trabajadores'
        ));
    }

    // ─── PROYECTOS ────────────────────────────────────────────────────────────

    /**
     * Muestra el formulario para crear un nuevo proyecto.
     */
    public function crearProyecto()
    {
        return view('admin.crear-proyecto');
    }

    /**
     * Guarda un nuevo proyecto en la base de datos.
     */
    public function guardarProyecto(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'nullable|date|after_or_equal:fecha_inicio',
            'presupuesto'   => 'required|numeric|min:0',
            'es_platano'    => 'nullable|boolean',
            'observaciones' => 'nullable|string',
        ]);

        Proyecto::create([
            'nombre'            => $request->nombre,
            'descripcion'       => $request->descripcion,
            'fecha_inicio'      => $request->fecha_inicio,
            'fecha_fin'         => $request->fecha_fin,
            'presupuesto'       => $request->presupuesto,
            'costo_fabricacion' => 0,
            'estado'            => 'pendiente',
            'es_platano'        => $request->boolean('es_platano'),
            'observaciones'     => $request->observaciones,
            'user_id'           => auth()->id(),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', '✅ Proyecto creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un proyecto existente.
     */
    public function editarProyecto($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        return view('admin.editar-proyecto', compact('proyecto'));
    }

    /**
     * Actualiza un proyecto existente.
     */
    public function actualizarProyecto(Request $request, $id)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'nullable|date|after_or_equal:fecha_inicio',
            'presupuesto'   => 'required|numeric|min:0',
            'estado'        => 'required|in:pendiente,activo,pausado,finalizado',
            'es_platano'    => 'nullable|boolean',
            'observaciones' => 'nullable|string',
        ]);

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->update([
            'nombre'        => $request->nombre,
            'descripcion'   => $request->descripcion,
            'fecha_inicio'  => $request->fecha_inicio,
            'fecha_fin'     => $request->fecha_fin,
            'presupuesto'   => $request->presupuesto,
            'estado'        => $request->estado,
            'es_platano'    => $request->boolean('es_platano'),
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', '✅ Proyecto actualizado correctamente.');
    }

    // ─── TRABAJADORES ─────────────────────────────────────────────────────────

    /**
     * Muestra el formulario para crear un nuevo trabajador.
     */
    public function crearTrabajador()
    {
        return view('admin.crear-trabajador');
    }

    /**
     * Guarda un nuevo trabajador en la base de datos.
     * Crea primero el usuario y luego el perfil de empleado.
     */
    public function guardarTrabajador(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'cedula'        => 'required|string|unique:empleados,cedula',
            'cargo'         => 'required|string',
            'telefono'      => 'nullable|string',
            'salario'       => 'required|numeric|min:0',
            'fecha_ingreso' => 'required|date',
        ]);

        // Crear usuario con rol trabajador
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make('password'),
            'rol_id'   => Rol::where('nombre', 'trabajador')->first()->id,
        ]);

        // Crear perfil de empleado
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

        return redirect()->route('admin.dashboard')
            ->with('success', '✅ Trabajador creado exitosamente. Contraseña inicial: password');
    }

    /**
     * Inactiva un trabajador (no lo elimina de la base de datos).
     */
    public function inactivarTrabajador($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->update(['estado' => 'inactivo']);

        return redirect()->route('admin.dashboard')
            ->with('success', '✅ Trabajador inactivado correctamente.');
    }

    /**
     * Muestra el formulario para editar un trabajador.
     */
    public function editarTrabajador($id)
    {
        $empleado = Empleado::with('user')->findOrFail($id);
        return view('admin.editar-trabajador', compact('empleado'));
    }

    /**
     * Actualiza los datos de un trabajador existente.
     */
    public function actualizarTrabajador(Request $request, $id)
    {
        $empleado = Empleado::with('user')->findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'cedula'        => 'required|string|unique:empleados,cedula,' . $id,
            'cargo'         => 'required|string',
            'telefono'      => 'nullable|string',
            'salario'       => 'required|numeric|min:0',
            'fecha_ingreso' => 'required|date',
        ]);

        // Actualizar usuario
        $empleado->user->update([
            'name' => $request->name,
        ]);

        // Actualizar empleado
        $empleado->update([
            'cedula'        => $request->cedula,
            'cargo'         => $request->cargo,
            'telefono'      => $request->telefono,
            'salario'       => $request->salario,
            'fecha_ingreso' => $request->fecha_ingreso,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', '✅ Trabajador actualizado correctamente.');
    }
}