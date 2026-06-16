<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'categoria',
        'descripcion',
        'stock',
        'costo_promedio',
        'iva',
    ];

    // Calcula el costo promedio ponderado al recibir una nueva entrada
    public function calcularCostoPromedio($cantidad_nueva, $costo_nuevo)
    {
        $stock_actual    = $this->stock;
        $costo_actual    = $this->costo_promedio;

        // Formula: (stock_actual * costo_actual + cantidad_nueva * costo_nuevo) / (stock_actual + cantidad_nueva)
        if ($stock_actual + $cantidad_nueva == 0) {
            return $costo_nuevo;
        }

        return ($stock_actual * $costo_actual + $cantidad_nueva * $costo_nuevo) / ($stock_actual + $cantidad_nueva);
    }
}