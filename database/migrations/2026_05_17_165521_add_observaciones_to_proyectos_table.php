<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega el campo observaciones a la tabla proyectos.
     */
    public function up(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->text('observaciones')->nullable()->after('es_platano');
        });
    }

    public function down(): void
    {
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropColumn('observaciones');
        });
    }
};