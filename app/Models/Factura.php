<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $fillable = [
        'consecutivo',
        'numero_factura',
        'cliente_id',
        'cotizacion_id',
        'subtotal',
        'total_iva',
        'total',
        'estado',
        'observacion',
    ];

    // Relación con el cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con los items de la factura
    public function items()
    {
        return $this->hasMany(FacturaItem::class);
    }

    // Relación con la cotización origen
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    // Genera el siguiente consecutivo automáticamente
    public static function generarConsecutivo()
    {
        $ultimo = self::max('consecutivo');
        return $ultimo ? $ultimo + 1 : 1;
    }

    // Genera el número de factura con formato
    public static function generarNumero()
    {
        $consecutivo = self::generarConsecutivo();
        return 'FAC-' . str_pad($consecutivo, 6, '0', STR_PAD_LEFT);
    }
}