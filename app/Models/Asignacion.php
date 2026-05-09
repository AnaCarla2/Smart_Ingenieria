<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignaciones';

    protected $fillable = [
        'empleado_id',
        'proyecto_id',
        'supervisor_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'tarea',
        'es_hora_extra',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function horasCalculadas()
    {
        if (!$this->hora_inicio || !$this->hora_fin) return 0;
        $inicio = strtotime($this->hora_inicio);
        $fin    = strtotime($this->hora_fin);
        return max(0, ($fin - $inicio) / 3600);
    }
}