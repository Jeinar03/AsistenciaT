<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('semestres', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 50); // Ej: "2026-1", "Enero-Junio 2026"
        $table->date('fecha_inicio');
        $table->date('fecha_fin');
        $table->boolean('activo')->default(false);
        $table->timestamps();
        $table->softDeletes();
    });
}

public function down(): void
{
    Schema::dropIfExists('semestres');
}
};
