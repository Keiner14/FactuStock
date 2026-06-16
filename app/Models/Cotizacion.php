<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';
    protected $primaryKey = 'id';

    // Fuerza el nombre del parametro en la ruta
    public function getRouteKeyName()
    {
        return 'id';
    }

    protected $fillable = [
        'consecutivo',
        'cliente_id',
        'subtotal',
        'total_iva',
        'total',
        'estado',
        'observacion',
    ];

    // Relación con el cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación con los items de la cotización
    public function items()
    {
        return $this->hasMany(CotizacionItem::class);
    }

    // Genera el siguiente consecutivo automáticamente
    public static function generarConsecutivo()
    {
        $ultimo = self::max('consecutivo');
        return $ultimo ? $ultimo + 1 : 1;
    }
}