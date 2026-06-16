<?php

namespace App\Http\Controllers;

use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Producto;
use App\Models\EntradaMercancia;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255|unique:productos,nombre',
            'codigo'   => 'required|string|unique:productos,codigo',
            'categoria'=> 'nullable|string|max:255',
            'iva'      => 'required|numeric|min:0',
        ], [
            'nombre.required'  => 'El nombre del producto es obligatorio.',
            'nombre.unique'    => 'Ya existe un producto con ese nombre.',
            'codigo.required'  => 'El código del producto es obligatorio.',
            'codigo.unique'    => 'Este código ya está registrado.',
            'iva.required'     => 'El IVA es obligatorio.',
            'iva.numeric'      => 'El IVA debe ser un número.',
        ]);

        Producto::create([
            'nombre'         => $request->nombre,
            'codigo'         => $request->codigo,
            'categoria'      => $request->categoria,
            'iva'            => $request->iva,
            'stock'          => 0,
            'costo_promedio' => 0,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255|unique:productos,nombre,' . $producto->id,
            'codigo'   => 'required|string|unique:productos,codigo,' . $producto->id,
            'categoria'=> 'nullable|string|max:255',
            'iva'      => 'required|numeric|min:0',
        ], [
            'nombre.required'  => 'El nombre del producto es obligatorio.',
            'nombre.unique'    => 'Ya existe un producto con ese nombre.',
            'codigo.required'  => 'El código del producto es obligatorio.',
            'codigo.unique'    => 'Este código ya está registrado.',
            'iva.required'     => 'El IVA es obligatorio.',
            'iva.numeric'      => 'El IVA debe ser un número.',
        ]);

        $producto->update([
            'nombre'    => $request->nombre,
            'codigo'    => $request->codigo,
            'categoria' => $request->categoria,
            'iva'       => $request->iva,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function consultar(Request $request)
    {
        $producto = null;
        $busqueda = $request->busqueda;

        if ($busqueda) {
            $producto = Producto::where('nombre', 'like', '%' . $busqueda . '%')
                               ->orWhere('codigo', 'like', '%' . $busqueda . '%')
                               ->first();
        }

        return view('productos.consultar', compact('producto', 'busqueda'));
    }

    public function informe()
    {
        $productos      = Producto::orderBy('stock', 'asc')->get();
        $totalProductos = $productos->count();
        $totalStock     = $productos->sum('stock');

        return view('productos.informe', compact('productos', 'totalProductos', 'totalStock'));
    }

    public function exportar()
    {
        return Excel::download(new ProductosExport(), 'informe_productos.xlsx');
    }

    public function destroy(Producto $producto)
    {
        // Verificar si tiene entradas de mercancía relacionadas
        $tieneMovimientos = EntradaMercancia::where('producto_id', $producto->id)->count();

        if ($tieneMovimientos > 0) {
            return redirect()->route('productos.index')
                ->with('error', 'No se puede eliminar "' . $producto->nombre . '" porque ya tiene movimientos de inventario registrados.');
        }

        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}