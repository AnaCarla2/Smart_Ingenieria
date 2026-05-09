<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyectos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'presupuesto',
        'costo_fabricacion',
        'estado',
        'es_platano',
        'user_id',
    ];

    protected $casts = [
        'es_platano' => 'boolean',
    ];

    public function administrador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'proyecto_id');
    }

    public function estaDesfasadoEnTiempo()
    {
        return $this->fecha_fin &&
               now()->format('Y-m-d') > $this->fecha_fin &&
               $this->estado !== 'finalizado';
    }

    public function estaDesfasadoEnPresupuesto()
    {
        return $this->costo_fabricacion > $this->presupuesto;
    }

    public function noIniciado()
    {
        return $this->estado === 'pendiente' &&
               now()->format('Y-m-d') > $this->fecha_inicio;
    }
}