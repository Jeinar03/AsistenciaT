<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('grupos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('materia_id')->constrained('materias')->onDelete('restrict');
        $table->foreignId('semestre_id')->constrained('semestres')->onDelete('restrict');
        $table->foreignId('maestro_id')->constrained('users')->onDelete('restrict');
        $table->string('clave', 20); // Ej: "81T", "62L"
        $table->integer('max_alumnos')->default(35);
        $table->decimal('porcentaje_asistencia_minima', 5, 2)->default(80.00);
        $table->boolean('activo')->default(true);
        $table->timestamps();
        $table->softDeletes();

        // Un grupo es único por materia + semestre + clave
        $table->unique(['materia_id', 'semestre_id', 'clave']);
    });
}

public function down(): void
{
    Schema::dropIfExists('grupos');
}
};
