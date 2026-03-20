<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('asignaciones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('grupo_id')->constrained('grupos')->onDelete('cascade');
        $table->foreignId('criterio_id')->nullable()->constrained('criterios_evaluacion')->onDelete('set null');
        $table->string('titulo', 200);
        $table->text('descripcion')->nullable();
        $table->date('fecha_publicacion');
        $table->date('fecha_entrega')->nullable();
        $table->boolean('visible')->default(true);
        $table->timestamps();
        $table->softDeletes();
    });
}

public function down(): void
{
    Schema::dropIfExists('asignaciones');
}
};
