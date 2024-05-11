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
        Schema::create('Usuario', function (Blueprint $table) {
            $table->id();
            $table->string('cedula')->unique()->ond;
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('correo')->unique();
            $table->string('nomUsuario')->unique();
            $table->string('contraseña');
            $table->unsignedBigInteger('rol_id');
            $table->foreign('rol_id')->references('id')->on('Rol')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
