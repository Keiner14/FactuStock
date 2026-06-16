<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntradaMercancia extends Model
{
    protected $fillable = [
        'consecutivo',
        'producto_id',
        'codigo_producto',
        'nombre_producto',
        'cantidad',
        'costo_unitario',
        'costo_promedio_nuevo',
        'stock_anterior',
        'stock_nuevo',
        'observacion',
    ];

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Genera el siguiente consecutivo automáticamente
    public static function generarConsecutivo()
    {
        $ultimo = self::max('consecutivo');
        return $ultimo ? $ultimo + 1 : 1;
    }
}