<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('horarios', function (Blueprint $table) {
        $table->id();
        $table->foreignId('grupo_id')->constrained('grupos')->onDelete('cascade');
        $table->enum('dia', ['lunes','martes','miercoles','jueves','viernes','sabado']);
        $table->time('hora_inicio');
        $table->time('hora_fin');
        $table->string('aula', 50)->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('horarios');
}
};
