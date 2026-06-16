<?php

namespace App\Http\Controllers;

use App\Models\EntradaMercancia;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class EntradaMercanciaController extends Controller
{
    public function index()
    {
        $entradas = EntradaMercancia::orderBy('created_at', 'desc')->get();
        return view('entradas.index', compact('entradas'));
    }

    public function create()
    {
        $consecutivo = EntradaMercancia::generarConsecutivo();
        return view('entradas.create', compact('consecutivo'));
    }

    public function buscarProducto(Request $request)
    {
        $producto = Producto::where('codigo', $request->codigo)->first();

        if ($producto) {
            return response()->json([
                'encontrado'      => true,
                'nombre'          => $producto->nombre,
                'stock'           => $producto->stock,
                'costo_promedio'  => $producto->costo_promedio,
                'categoria'       => $producto->categoria ?? 'Sin categoría',
            ]);
        }

        return response()->json(['encontrado' => false]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo_producto' => 'required|string',
            'cantidad'        => 'required|integer|min:1',
            'costo_unitario'  => 'required|numeric|min:0',
            'observacion'     => 'nullable|string',
        ], [
            'codigo_producto.required' => 'El código del producto es obligatorio.',
            'cantidad.required'        => 'La cantidad es obligatoria.',
            'cantidad.min'             => 'La cantidad debe ser al menos 1.',
            'costo_unitario.required'  => 'El costo unitario es obligatorio.',
            'costo_unitario.numeric'   => 'El costo unitario debe ser un número.',
            'costo_unitario.min'       => 'El costo unitario no puede ser negativo.',
        ]);

        $producto = Producto::where('codigo', $request->codigo_producto)->first();

        if (!$producto) {
            return back()->withErrors(['codigo_producto' => 'El código ingresado no existe en el inventario.'])->withInput();
        }

        $costo_promedio_nuevo = $producto->calcularCostoPromedio($request->cantidad, $request->costo_unitario);
        $stock_anterior = $producto->stock;
        $stock_nuevo    = $stock_anterior + $request->cantidad;

        $producto->update([
            'stock'          => $stock_nuevo,
            'costo_promedio' => $costo_promedio_nuevo,
        ]);

        $maxId = EntradaMercancia::max('id') ?? 0;
        if ($maxId > 0) {
            DB::statement("SELECT setval('entrada_mercancias_id_seq', $maxId)");
        }

        EntradaMercancia::create([
            'consecutivo'          => EntradaMercancia::generarConsecutivo(),
            'producto_id'          => $producto->id,
            'codigo_producto'      => $producto->codigo,
            'nombre_producto'      => $producto->nombre,
            'cantidad'             => $request->cantidad,
            'costo_unitario'       => $request->costo_unitario,
            'costo_promedio_nuevo' => $costo_promedio_nuevo,
            'stock_anterior'       => $stock_anterior,
            'stock_nuevo'          => $stock_nuevo,
            'observacion'          => $request->observacion,
        ]);

        return redirect()->route('entradas.index')->with('success', 'Entrada registrada correctamente. Stock y costo promedio actualizados.');
    }

    public function pdf($id)
    {
        $entrada = EntradaMercancia::findOrFail($id);
        $usuario = auth()->user();
        $pdf = Pdf::loadView('entradas.pdf', compact('entrada', 'usuario'));
        return $pdf->download('entrada-' . str_pad($entrada->consecutivo, 4, '0', STR_PAD_LEFT) . '.pdf');
    }
}