<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entrada_mercancias', function (Blueprint $table) {
            $table->id();
            $table->integer('consecutivo')->unique(); // Número de entrada
            $table->foreignId('producto_id')->constrained('productos'); // Producto relacionado
            $table->string('codigo_producto'); // Código del producto
            $table->string('nombre_producto'); // Nombre del producto
            $table->integer('cantidad'); // Cantidad que entra
            $table->integer('stock_anterior'); // Stock antes de la entrada
            $table->integer('stock_nuevo'); // Stock después de la entrada
            $table->text('observacion')->nullable(); // Observación opcional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrada_mercancias');
    }
};