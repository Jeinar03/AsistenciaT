<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('asistencias', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sesion_id')->constrained('sesiones')->onDelete('cascade');
        $table->foreignId('alumno_id')->constrained('users')->onDelete('restrict');
        $table->enum('estado', ['presente','falta','retardo','justificada'])->default('falta');
        $table->text('justificacion')->nullable();
        $table->foreignId('registrado_por')->constrained('users')->onDelete('restrict');
        $table->timestamps();

        // Un alumno solo puede tener una asistencia por sesión
        $table->unique(['sesion_id', 'alumno_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('asistencias');
}
};
