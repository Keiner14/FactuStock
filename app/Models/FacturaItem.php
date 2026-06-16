<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaItem extends Model
{
    protected $fillable = [
        'factura_id',
        'producto_id',
        'codigo_producto',
        'nombre_producto',
        'cantidad',
        'precio_unitario',
        'iva',
        'subtotal',
    ];

    // Relación con la factura
    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}