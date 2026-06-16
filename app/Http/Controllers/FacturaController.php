<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\FacturaItem;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class FacturaController extends Controller
{
    // Muestra la lista de facturas
    public function index()
    {
        $facturas = Factura::with('cliente')->orderBy('created_at', 'desc')->get();
        return view('facturas.index', compact('facturas'));
    }

    // Muestra el formulario para crear una factura directa
    public function create()
    {
        $consecutivo = Factura::generarConsecutivo();
        $numero      = Factura::generarNumero();
        return view('facturas.create', compact('consecutivo', 'numero'));
    }

    // Busca un cliente por cédula o nombre via AJAX
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

    // Busca un producto por código o nombre via AJAX
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

    // Guarda la factura y descuenta el stock
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'                => 'required|exists:clientes,id',
            'items'                     => 'required|array|min:1',
            'items.*.producto_id'       => 'required|exists:productos,id',
            'items.*.cantidad'          => 'required|integer|min:1',
            'items.*.precio_unitario'   => 'required|numeric|min:0',
            'observacion'               => 'nullable|string',
        ], [
            'cliente_id.required'         => 'Debe seleccionar un cliente.',
            'items.required'              => 'Debe agregar al menos un producto.',
            'items.*.cantidad.min'        => 'La cantidad debe ser al menos 1.',
            'items.*.precio_unitario.min' => 'El precio no puede ser negativo.',
        ]);

        // Verificar stock de todos los items antes de guardar
        foreach ($request->items as $item) {
            $producto = Producto::find($item['producto_id']);
            if ($producto->stock < $item['cantidad']) {
                return back()->withErrors([
                    'stock' => "Stock insuficiente para: {$producto->nombre}. Stock disponible: {$producto->stock} unidades."
                ])->withInput();
            }
        }

        // Calcular totales
        $subtotal  = 0;
        $total_iva = 0;

        foreach ($request->items as $item) {
            $producto  = Producto::find($item['producto_id']);
            $sub       = $item['cantidad'] * $item['precio_unitario'];
            $iva_item  = $sub * ($producto->iva / 100);
            $subtotal += $sub;
            $total_iva += $iva_item;
        }

        $total = $subtotal + $total_iva;

        // Crear la factura
        $factura = Factura::create([
            'consecutivo'    => Factura::generarConsecutivo(),
            'numero_factura' => Factura::generarNumero(),
            'cliente_id'     => $request->cliente_id,
            'subtotal'       => $subtotal,
            'total_iva'      => $total_iva,
            'total'          => $total,
            'observacion'    => $request->observacion,
        ]);

        // Guardar items y descontar stock
        foreach ($request->items as $item) {
            $producto = Producto::find($item['producto_id']);
            $sub      = $item['cantidad'] * $item['precio_unitario'];

            FacturaItem::create([
                'factura_id'      => $factura->id,
                'producto_id'     => $producto->id,
                'codigo_producto' => $producto->codigo,
                'nombre_producto' => $producto->nombre,
                'cantidad'        => $item['cantidad'],
                'precio_unitario' => $item['precio_unitario'],
                'iva'             => $producto->iva,
                'subtotal'        => $sub,
            ]);

            // Descontar stock del producto
            $producto->update(['stock' => $producto->stock - $item['cantidad']]);
        }

        return redirect()->route('facturas.show', $factura)->with('success', 'Factura creada correctamente.');
    }

    // Muestra el detalle de una factura
    public function show(Factura $factura)
    {
        $factura->load('cliente', 'items');
        return view('facturas.show', compact('factura'));
    }

    // Genera el PDF de la factura
public function pdf(Factura $factura)
{
    $factura->load('cliente', 'items');
    $pdf = Pdf::loadView('facturas.pdf', compact('factura'));
    return $pdf->download('factura-' . $factura->numero_factura . '.pdf');
}
}