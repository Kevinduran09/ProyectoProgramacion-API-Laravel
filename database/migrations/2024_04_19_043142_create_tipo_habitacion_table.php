<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('TipoHabitacion', function (Blueprint $table) {
            $table->id();
            $table->string('tipoHabitacion');
            $table->integer('capacidad');
            $table->timestamps();
        });

        // Especificar que esta migración debe ejecutarse primero
        Schema::table('TipoHabitacion', function (Blueprint $table) {
            $table->after('id', function ($table) {
                // No se agregan columnas adicionales en este caso
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TipoHabitacion');
    }
};
