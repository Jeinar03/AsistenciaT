<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('auditoria_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
        $table->string('accion', 100); // Ej: "login", "calificacion.update"
        $table->string('modelo', 100)->nullable(); // Ej: "Calificacion"
        $table->unsignedBigInteger('modelo_id')->nullable();
        $table->json('datos_anteriores')->nullable();
        $table->json('datos_nuevos')->nullable();
        $table->string('ip', 45)->nullable();
        $table->string('user_agent')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('auditoria_logs');
}
};
