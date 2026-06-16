<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionItem extends Model
{
    protected $fillable = [
        'cotizacion_id',
        'producto_id',
        'codigo_producto',
        'nombre_producto',
        'cantidad',
        'precio_unitario',
        'iva',
        'subtotal',
    ];

    // Relación con la cotización
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}