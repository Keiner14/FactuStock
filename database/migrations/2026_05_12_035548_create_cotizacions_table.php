<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('consecutivo')->unique();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total_iva', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('estado', ['pendiente', 'facturada', 'cancelada'])->default('pendiente');
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};