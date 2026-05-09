<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'rol_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}