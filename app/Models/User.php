<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function empleado()
    {
        return $this->hasOne(Empleado::class, 'user_id');
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'user_id');
    }

    public function novedadesAprobadas()
    {
        return $this->hasMany(Novedad::class, 'aprobado_por');
    }
}