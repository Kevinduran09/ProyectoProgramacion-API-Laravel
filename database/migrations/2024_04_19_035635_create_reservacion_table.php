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
        Schema::create('Reservacion', function (Blueprint $table) {
            $table->id();
            $table->date('fechaIngreso');
            $table->date('fechaSalida');
            $table->string('estado'); 
            $table->float('PrecioTotal');
            $table->foreignId('usuario_id')->constrained('Usuario')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservacion');
    }
};
