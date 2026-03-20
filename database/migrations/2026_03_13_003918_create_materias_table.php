<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('materias', function (Blueprint $table) {
        $table->id();
        $table->foreignId('carrera_id')->constrained('carreras')->onDelete('restrict');
        $table->string('clave', 20)->unique();
        $table->string('nombre', 150);
        $table->integer('creditos')->default(0);
        $table->boolean('activo')->default(true);
        $table->timestamps();
        $table->softDeletes();
    });
}

public function down(): void
{
    Schema::dropIfExists('materias');
}
};
