<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'user_id',
        'rol_id',
        'cedula',
        'cargo',
        'telefono',
        'salario',
        'fecha_ingreso',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'empleado_id');
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'empleado_id');
    }

    public function novedades()
    {
        return $this->hasMany(Novedad::class, 'empleado_id');
    }

    public function horasExtrasSemanales()
    {
        $inicioSemana = now()->startOfWeek()->format('Y-m-d');
        $finSemana    = now()->endOfWeek()->format('Y-m-d');

        return $this->asignaciones()
            ->where('es_hora_extra', true)
            ->whereBetween('fecha', [$inicioSemana, $finSemana])
            ->get()
            ->sum(fn($a) => $a->horasCalculadas());
    }
}