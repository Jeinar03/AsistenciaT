<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('sesiones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('grupo_id')->constrained('grupos')->onDelete('cascade');
        $table->foreignId('horario_id')->constrained('horarios')->onDelete('cascade');
        $table->date('fecha');
        $table->time('hora_inicio');
        $table->time('hora_fin');
        $table->enum('estado', ['programada','realizada','cancelada'])->default('programada');
        $table->string('tema', 255)->nullable();
        $table->text('observaciones')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('sesiones');
}
};
