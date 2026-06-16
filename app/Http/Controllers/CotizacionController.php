<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\CotizacionItem;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Factura;
use App\Models\FacturaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Cotizacion::with('cliente')->orderBy('created_at', 'desc')->get();
        return view('cotizaciones.index', compact('cotizaciones'));
    }

    public function create()
    {
        $consecutivo = Cotizacion::generarConsecutivo();
        return view('cotizaciones.create', compact('consecutivo'));
    }

    public function buscarCliente(Request $request)
    {
        $busqueda = $request->busqueda;
        $cliente  = Cliente::where('cedula', $busqueda)
                          ->orWhere('nombre', 'like', '%' . $busqueda . '%')
                          ->first();

        if ($cliente) {
            return response()->json([
                'encontrado' => true,
                'id'         => $cliente->id,
                'nombre'     => $cliente->nombre,
                'cedula'     => $cliente->cedula,
                'celular'    => $cliente->celular,
                'direccion'  => $cliente->direccion,
            ]);
        }

        return response()->json(['encontrado' => false]);
    }

    public function buscarProducto(Request $request)
    {
        $busqueda = $request->busqueda;
        $producto = Producto::where('codigo', $busqueda)
                           ->orWhere('nombre', 'like', '%' . $busqueda . '%')
                           ->first();

        if ($producto) {
            return response()->json([
                'encontrado' => true,
                'id'         => $producto->id,
                'nombre'     => $producto->nombre,
                'codigo'     => $producto->codigo,
                'iva'        => $producto->iva,
                'stock'      => $producto->stock,
            ]);
        }

        return response()->json(['encontrado' => false]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'              => 'required|exists:clientes,id',
            'items'                   => 'required|array|min:1',
            'items.*.producto_id'     => 'required|exists:productos,id',
            'items.*.cantidad'        => 'required|integer|min:1',
            'items.*.precio_unitario' => 'required|numeric|min:0',
            'observacion'             => 'nullable|string',
        ], [
            'cliente_id.required'  => 'Debe seleccionar un cliente.',
            'items.required'       => 'Debe agregar al menos un producto.',
            'items.*.cantidad.min' => 'La cantidad debe ser al menos 1.',
        ]);

        $subtotal  = 0;
        $total_iva = 0;

        foreach ($request->items as $item) {
            $producto   = Producto::find($item['producto_id']);
            $sub        = $item['cantidad'] * $item['precio_unitario'];
            $iva_item   = $sub * ($producto->iva / 100);
            $subtotal  += $sub;
            $total_iva += $iva_item;
        }

        $total = $subtotal + $total_iva;

        // Corrige la secuencia del ID en PostgreSQL
        $maxId = Cotizacion::max('id') ?? 0;
        DB::statement("SELECT setval('cotizaciones_id_seq', $maxId)");

        $cotizacion = Cotizacion::create([
            'consecutivo' => Cotizacion::generarConsecutivo(),
            'cliente_id'  => $request->cliente_id,
            'subtotal'    => $subtotal,
            'total_iva'   => $total_iva,
            'total'       => $total,
            'observacion' => $request->observacion,
        ]);

        // Corrige secuencia de cotizacion_items
        $maxItemId = CotizacionItem::max('id') ?? 0;
        DB::statement("SELECT setval('cotizacion_items_id_seq', $maxItemId)");

        foreach ($request->items as $item) {
            $producto = Producto::find($item['producto_id']);
            $sub      = $item['cantidad'] * $item['precio_unitario'];

            CotizacionItem::create([
                'cotizacion_id'   => $cotizacion->id,
                'producto_id'     => $producto->id,
                'codigo_producto' => $producto->codigo,
                'nombre_producto' => $producto->nombre,
                'cantidad'        => $item['cantidad'],
                'precio_unitario' => $item['precio_unitario'],
                'iva'             => $producto->iva,
                'subtotal'        => $sub,
            ]);
        }

        return redirect()->to('cotizaciones/' . $cotizacion->id)->with('success', 'Cotización creada correctamente.');
    }

    public function show($id)
    {
        $cotizacion = Cotizacion::with('cliente', 'items')->findOrFail($id);
        return view('cotizaciones.show', compact('cotizacion'));
    }

    public function convertirFactura($id)
    {
        $cotizacion = Cotizacion::with('cliente', 'items')->findOrFail($id);

        foreach ($cotizacion->items as $item) {
            $producto = Producto::find($item->producto_id);
            if ($producto->stock < $item->cantidad) {
                return back()->withErrors(['stock' => "Stock insuficiente para: {$producto->nombre}. Disponible: {$producto->stock}"]);
            }
        }

        // Corrige secuencia de facturas
        $maxFacturaId = Factura::max('id') ?? 0;
        DB::statement("SELECT setval('facturas_id_seq', $maxFacturaId)");

        $factura = Factura::create([
            'consecutivo'    => Factura::generarConsecutivo(),
            'numero_factura' => Factura::generarNumero(),
            'cliente_id'     => $cotizacion->cliente_id,
            'cotizacion_id'  => $cotizacion->id,
            'subtotal'       => $cotizacion->subtotal,
            'total_iva'      => $cotizacion->total_iva,
            'total'          => $cotizacion->total,
            'observacion'    => $cotizacion->observacion,
        ]);

        // Corrige secuencia de factura_items
        $maxFacturaItemId = FacturaItem::max('id') ?? 0;
        DB::statement("SELECT setval('factura_items_id_seq', $maxFacturaItemId)");

        foreach ($cotizacion->items as $item) {
            FacturaItem::create([
                'factura_id'      => $factura->id,
                'producto_id'     => $item->producto_id,
                'codigo_producto' => $item->codigo_producto,
                'nombre_producto' => $item->nombre_producto,
                'cantidad'        => $item->cantidad,
                'precio_unitario' => $item->precio_unitario,
                'iva'             => $item->iva,
                'subtotal'        => $item->subtotal,
            ]);

            $producto = Producto::find($item->producto_id);
            $producto->update(['stock' => $producto->stock - $item->cantidad]);
        }

        $cotizacion->update(['estado' => 'facturada']);

        return redirect()->to('facturas/' . $factura->id)->with('success', 'Factura generada correctamente.');
    }

    public function pdf($id)
    {
        $cotizacion = Cotizacion::with('cliente', 'items')->findOrFail($id);
        $pdf = Pdf::loadView('cotizaciones.pdf', compact('cotizacion'));
        return $pdf->download('cotizacion-' . str_pad($cotizacion->consecutivo, 4, '0', STR_PAD_LEFT) . '.pdf');
    }
}