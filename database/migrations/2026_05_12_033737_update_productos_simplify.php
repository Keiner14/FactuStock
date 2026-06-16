<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Eliminar columnas que ya no se usan
            $table->dropColumn(['costo', 'precio_venta', 'porcentaje_ganancia']);

            // Agregar nuevas columnas
            $table->decimal('costo_promedio', 10, 2)->default(0)->after('stock');
            $table->decimal('iva', 5, 2)->default(19)->after('costo_promedio');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['costo_promedio', 'iva']);
            $table->decimal('costo', 10, 2)->default(0);
            $table->decimal('precio_venta', 10, 2)->default(0);
            $table->decimal('porcentaje_ganancia', 5, 2)->default(0);
        });
    }
};