<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Cotizacion;
use App\Models\CotizacionItem;
use App\Models\Factura;
use App\Models\FacturaItem;
use App\Models\EntradaMercancia;

class ExportarDatos extends Command
{
    protected $signature = 'datos:exportar';
    protected $description = 'Exporta todos los datos de la base de datos local a un archivo JSON';

    public function handle()
    {
        $datos = [
            'users'              => User::all()->toArray(),
            'clientes'           => Cliente::all()->toArray(),
            'productos'          => Producto::all()->toArray(),
            'cotizaciones'       => Cotizacion::all()->toArray(),
            'cotizacion_items'   => CotizacionItem::all()->toArray(),
            'facturas'           => Factura::all()->toArray(),
            'factura_items'      => FacturaItem::all()->toArray(),
            'entrada_mercancias' => EntradaMercancia::all()->toArray(),
        ];

        $json = json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents(base_path('datos_export.json'), $json);

        $this->info('Datos exportados correctamente a datos_export.json');
        foreach ($datos as $tabla => $registros) {
            $this->line("- {$tabla}: " . count($registros) . " registros");
        }
    }
}