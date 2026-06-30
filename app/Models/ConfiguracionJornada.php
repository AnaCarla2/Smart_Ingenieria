<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ConfiguracionJornada extends Model
{
    protected $table = 'configuracion_jornada';

    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
        'horas_diarias',
        'horas_semanales',
        'horas_extra_diarias',
        'horas_extra_semanales',
        'descripcion',
    ];

    /**
     * Obtiene la configuración de jornada vigente para una fecha dada.
     * Si no se pasa fecha, usa la fecha actual.
     */
    public static function vigente($fecha = null)
    {
        $fecha = $fecha ?? Carbon::today()->format('Y-m-d');

        return self::where('fecha_inicio', '<=', $fecha)
            ->where(function($q) use ($fecha) {
                $q->whereNull('fecha_fin')
                  ->orWhere('fecha_fin', '>=', $fecha);
            })
            ->orderBy('fecha_inicio', 'desc')
            ->first();
    }
}