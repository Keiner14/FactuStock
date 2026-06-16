<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entrada_mercancias', function (Blueprint $table) {
            // Agregar costo unitario y costo promedio resultante
            $table->decimal('costo_unitario', 10, 2)->default(0)->after('cantidad');
            $table->decimal('costo_promedio_nuevo', 10, 2)->default(0)->after('costo_unitario');
        });
    }

    public function down(): void
    {
        Schema::table('entrada_mercancias', function (Blueprint $table) {
            $table->dropColumn(['costo_unitario', 'costo_promedio_nuevo']);
        });
    }
};