<?php

namespace App\Http\Controllers;

use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Muestra la lista de todos los productos
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    // Muestra el formulario para crear un nuevo producto
    public function create()
    {
        return view('productos.create');
    }

    // Guarda un nuevo producto en la base de datos
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
            'nombre'    => $request->nombre,
            'codigo'    => $request->codigo,
            'categoria' => $request->categoria,
            'iva'       => $request->iva,
            'stock'     => 0,
            'costo_promedio' => 0,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    // Muestra el formulario para editar un producto existente
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    // Actualiza un producto existente en la base de datos
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

    // Consulta el stock disponible de un producto por nombre o código
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

    // Muestra el informe de todos los productos con sus existencias actuales
    public function informe()
    {
        $productos      = Producto::orderBy('stock', 'asc')->get();
        $totalProductos = $productos->count();
        $totalStock     = $productos->sum('stock');

        return view('productos.informe', compact('productos', 'totalProductos', 'totalStock'));
    }

    // Exporta el informe de productos a Excel
    public function exportar()
    {
        return Excel::download(new ProductosExport(), 'informe_productos.xlsx');
    }

    // Elimina un producto de la base de datos
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}