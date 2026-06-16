<?php

use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EntradaMercanciaController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ─── USUARIOS ───────────────────────────────────────
    Route::middleware('can:usuarios')->group(function () {
        Route::resource('usuarios', UsuarioController::class);
    });

    // ─── PRODUCTOS ──────────────────────────────────────
    Route::middleware('can:productos')->group(function () {
        Route::get('productos/consultar', [ProductoController::class, 'consultar'])->name('productos.consultar');
        Route::get('productos/informe', [ProductoController::class, 'informe'])->name('productos.informe');
        Route::get('productos/exportar', [ProductoController::class, 'exportar'])->name('productos.exportar');
        Route::resource('productos', ProductoController::class);
    });

    // ─── ENTRADAS DE MERCANCÍA ──────────────────────────
    Route::middleware('can:entradas')->group(function () {
        Route::get('entradas/buscar-producto', [EntradaMercanciaController::class, 'buscarProducto'])->name('entradas.buscar');
        Route::resource('entradas', EntradaMercanciaController::class)->only(['index', 'create', 'store']);
    });

    // ─── CLIENTES ───────────────────────────────────────
    Route::middleware('can:clientes')->group(function () {
        Route::resource('clientes', ClienteController::class);
    });

    // ─── COTIZACIONES ───────────────────────────────────
    Route::middleware('can:cotizaciones')->group(function () {
        Route::get('cotizaciones/buscar-cliente', [CotizacionController::class, 'buscarCliente'])->name('cotizaciones.buscar-cliente');
        Route::get('cotizaciones/buscar-producto', [CotizacionController::class, 'buscarProducto'])->name('cotizaciones.buscar-producto');
        Route::get('cotizaciones/{cotizacion}/pdf', [CotizacionController::class, 'pdf'])->name('cotizaciones.pdf');
        Route::post('cotizaciones/{cotizacion}/convertir-factura', [CotizacionController::class, 'convertirFactura'])->name('cotizaciones.convertir-factura');
        Route::resource('cotizaciones', CotizacionController::class)->only(['index', 'create', 'store', 'show']);
    });

    // ─── FACTURAS ───────────────────────────────────────
    Route::middleware('can:facturas')->group(function () {
        Route::get('facturas/buscar-cliente', [FacturaController::class, 'buscarCliente'])->name('facturas.buscar-cliente');
        Route::get('facturas/buscar-producto', [FacturaController::class, 'buscarProducto'])->name('facturas.buscar-producto');
        Route::get('facturas/{factura}/pdf', [FacturaController::class, 'pdf'])->name('facturas.pdf');
        Route::resource('facturas', FacturaController::class)->only(['index', 'create', 'store', 'show']);
    });
});

require __DIR__.'/auth.php';