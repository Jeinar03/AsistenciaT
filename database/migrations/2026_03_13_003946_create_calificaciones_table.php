<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('calificaciones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('criterio_id')->constrained('criterios_evaluacion')->onDelete('cascade');
        $table->foreignId('alumno_id')->constrained('users')->onDelete('restrict');
        $table->decimal('calificacion', 5, 2)->nullable(); // 0.00 a 100.00
        $table->text('comentario')->nullable();
        $table->foreignId('registrado_por')->constrained('users')->onDelete('restrict');
        $table->timestamps();

        // Un alumno solo puede tener una calificación por criterio
        $table->unique(['criterio_id', 'alumno_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('calificaciones');
}
};
