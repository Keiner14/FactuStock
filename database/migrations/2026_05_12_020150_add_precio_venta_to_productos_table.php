<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->renameColumn('precio', 'costo');
            $table->decimal('precio_venta', 10, 2)->default(0)->after('costo');
            $table->decimal('porcentaje_ganancia', 5, 2)->default(30)->after('precio_venta');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->renameColumn('costo', 'precio');
            $table->dropColumn(['precio_venta', 'porcentaje_ganancia']);
        });
    }
};