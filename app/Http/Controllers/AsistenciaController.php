<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AsistenciaController extends Controller
{
    public function vistaPublica()
    {
        return view('asistencia.publica');
    }

    public function buscarEmpleado(Request $request)
    {
        $request->validate([
            'cedula' => 'required|string',
        ]);

        $empleado = Empleado::where('cedula', $request->cedula)
            ->where('estado', 'activo')
            ->with('user')
            ->first();

        if (!$empleado) {
            return back()->with('error', 'Cédula no encontrada. Verifica el número e intenta de nuevo.');
        }

        $hoy = Carbon::today()->format('Y-m-d');
        $asistenciaHoy = Asistencia::where('empleado_id', $empleado->id)
            ->where('fecha', $hoy)
            ->first();

        $accion = 'entrada';
        if ($asistenciaHoy && $asistenciaHoy->hora_entrada && !$asistenciaHoy->hora_salida) {
            $accion = 'salida';
        } elseif ($asistenciaHoy && $asistenciaHoy->hora_salida) {
            $accion = 'completo';
        }

        return view('asistencia.publica', compact('empleado', 'asistenciaHoy', 'accion'));
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'accion'      => 'required|in:entrada,salida',
        ]);

        $empleado  = Empleado::find($request->empleado_id);
        $hoy       = Carbon::today()->format('Y-m-d');
        $horaAhora = Carbon::now()->format('H:i:s');

        $fotoPath = null;
        if ($request->filled('foto_base64')) {
            $fotoData = $request->foto_base64;
            $fotoData = str_replace('data:image/jpeg;base64,', '', $fotoData);
            $fotoData = str_replace(' ', '+', $fotoData);
            $nombreFoto = 'asistencia/fotos/' . $empleado->cedula . '_' . $hoy . '_' . $request->accion . '.jpg';
            Storage::disk('public')->put($nombreFoto, base64_decode($fotoData));
            $fotoPath = $nombreFoto;
        }

        if ($request->accion === 'entrada') {
            $yaRegistrado = Asistencia::where('empleado_id', $empleado->id)
                ->where('fecha', $hoy)
                ->exists();

            if ($yaRegistrado) {
                return back()->with('error', 'Ya tienes una entrada registrada hoy.');
            }

            Asistencia::create([
                'empleado_id'     => $empleado->id,
                'fecha'           => $hoy,
                'hora_entrada'    => $horaAhora,
                'metodo_registro' => $fotoPath ? 'fotografia' : 'manual',
                'estado'          => 'presente',
                'observacion'     => $fotoPath ? 'foto:' . $fotoPath : 'Sin foto',
            ]);

            $mensaje = '✅ Entrada registrada a las ' . Carbon::now()->format('H:i');

        } else {
            $asistencia = Asistencia::where('empleado_id', $empleado->id)
                ->where('fecha', $hoy)
                ->first();

            if (!$asistencia) {
                return back()->with('error', 'No tienes entrada registrada hoy.');
            }

            if ($asistencia->hora_salida) {
                return back()->with('error', 'Ya tienes una salida registrada hoy.');
            }

            $asistencia->update([
                'hora_salida' => $horaAhora,
                'observacion' => $asistencia->observacion . ($fotoPath ? ' | foto_salida:' . $fotoPath : ''),
            ]);

            $mensaje = '✅ Salida registrada a las ' . Carbon::now()->format('H:i');
        }

        return redirect()->route('asistencia.publica')->with('success', $mensaje . ' — ' . $empleado->user->name);
    }
}