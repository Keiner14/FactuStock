<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellidos')->after('name');
            $table->string('rut')->unique()->after('apellidos');
            $table->string('telefono')->after('rut');
            $table->string('direccion')->after('telefono');
            $table->enum('rol', ['administrador', 'vendedor'])->default('vendedor')->after('direccion');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['apellidos', 'rut', 'telefono', 'direccion', 'rol']);
        });
    }
};