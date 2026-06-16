<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Cotizacion;
use App\Models\CotizacionItem;
use App\Models\Factura;
use App\Models\FacturaItem;
use App\Models\EntradaMercancia;

class ImportarDatos extends Command
{
    protected $signature = 'datos:importar';
    protected $description = 'Importa los datos desde datos_export.json a la base de datos actual';

    public function handle()
    {
        $ruta = base_path('datos_export.json');

        if (!file_exists($ruta)) {
            $this->error('No se encontró el archivo datos_export.json');
            return;
        }

        $datos = json_decode(file_get_contents($ruta), true);

        $this->importarTabla('users', User::class, $datos['users']);
        $this->importarTabla('clientes', Cliente::class, $datos['clientes']);
        $this->importarTabla('productos', Producto::class, $datos['productos']);
        $this->importarTabla('cotizaciones', Cotizacion::class, $datos['cotizaciones']);
        $this->importarTabla('cotizacion_items', CotizacionItem::class, $datos['cotizacion_items']);
        $this->importarTabla('facturas', Factura::class, $datos['facturas']);
        $this->importarTabla('factura_items', FacturaItem::class, $datos['factura_items']);
        $this->importarTabla('entrada_mercancias', EntradaMercancia::class, $datos['entrada_mercancias']);

        $this->info('¡Importación completada!');
    }

    private function importarTabla(string $nombre, string $modelo, array $registros)
    {
        $tabla = (new $modelo)->getTable();
        $columnasReales = DB::getSchemaBuilder()->getColumnListing($tabla);
        $insertados = 0;

        foreach ($registros as $registro) {
            $existe = DB::table($tabla)->where('id', $registro['id'])->exists();

            if (!$existe) {
                // Quitar cualquier campo que no exista realmente en la tabla destino
                $registro = array_intersect_key_safe($registro, $columnasReales);

                // Convertir cualquier valor array (ej: columnas JSON) a string JSON
                foreach ($registro as $campo => $valor) {
                    if (is_array($valor)) {
                        $registro[$campo] = json_encode($valor);
                    }
                }

                DB::table($tabla)->insert($registro);
                $insertados++;
            }
        }

        $this->line("- {$nombre}: {$insertados} de " . count($registros) . " insertados");
    }
}

function array_intersect_key_safe(array $registro, array $columnasReales): array
{
    $resultado = [];
    foreach ($registro as $campo => $valor) {
        if (in_array($campo, $columnasReales)) {
            $resultado[$campo] = $valor;
        }
    }
    return $resultado;
}