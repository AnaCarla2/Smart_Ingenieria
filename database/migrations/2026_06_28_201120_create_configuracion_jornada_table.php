<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla de configuración de jornada laboral.
     * Permite actualizar los límites sin tocar el código.
     * Ley 2101 de 2021 — reducción gradual de jornada en Colombia.
     */
    public function up(): void
    {
        Schema::create('configuracion_jornada', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio');        // Desde cuándo aplica esta jornada
            $table->date('fecha_fin')->nullable(); // Hasta cuándo aplica (null = indefinido)
            $table->decimal('horas_diarias', 4, 2)->default(8);    // Máximo horas diarias normales
            $table->decimal('horas_semanales', 4, 2)->default(44); // Máximo horas semanales normales
            $table->decimal('horas_extra_diarias', 4, 2)->default(2);   // Máximo extras por día
            $table->decimal('horas_extra_semanales', 4, 2)->default(12); // Máximo extras por semana
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_jornada');
    }
};