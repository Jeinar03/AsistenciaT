<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('criterios_evaluacion', function (Blueprint $table) {
        $table->id();
        $table->foreignId('grupo_id')->constrained('grupos')->onDelete('cascade');
        $table->string('nombre', 100); // Ej: "Examen Parcial 1", "Proyecto Final"
        $table->decimal('peso', 5, 2); // Porcentaje: 30.00, 20.00, etc.
        $table->enum('tipo', ['examen','tarea','proyecto','participacion','asistencia','otro']);
        $table->date('fecha_entrega')->nullable();
        $table->integer('orden')->default(1);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('criterios_evaluacion');
}
};
