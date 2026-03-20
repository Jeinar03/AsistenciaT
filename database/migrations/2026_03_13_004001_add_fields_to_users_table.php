<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('matricula')->unique()->nullable()->after('name');
        $table->string('telefono', 20)->nullable()->after('matricula');
        $table->enum('tipo', ['admin', 'maestro', 'alumno'])->default('alumno')->after('telefono');
        $table->boolean('activo')->default(true)->after('tipo');
        $table->timestamp('ultimo_acceso')->nullable()->after('activo');
        $table->softDeletes();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['matricula','telefono','tipo','activo','ultimo_acceso','deleted_at']);
    });
}

};
