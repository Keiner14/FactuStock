<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->integer('consecutivo')->unique();
            $table->string('numero_factura')->unique();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->unsignedBigInteger('cotizacion_id')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total_iva', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('estado', ['activa', 'anulada'])->default('activa');
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};