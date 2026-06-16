<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\FacturaItem;
use App\Exports\FacturacionExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InformeController extends Controller
{
    public function facturacion(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;

        $query = Factura::with('cliente', 'items');

        if ($desde) $query->whereDate('created_at', '>=', $desde);
        if ($hasta) $query->whereDate('created_at', '<=', $hasta);

        $facturas = $query->orderBy('created_at', 'desc')->get();

        $totalFacturas  = $facturas->count();
        $totalSubtotal  = $facturas->sum('subtotal');
        $totalIva       = $facturas->sum('total_iva');
        $totalGeneral   = $facturas->sum('total');
        $promedioVenta  = $totalFacturas > 0 ? $totalGeneral / $totalFacturas : 0;
        $facturaMaxima  = $facturas->sortByDesc('total')->first();
        $totalClientes  = $facturas->pluck('cliente_id')->unique()->count();

        $productoMasVendido = FacturaItem::selectRaw('nombre_producto, SUM(cantidad) as total_cantidad')
            ->when($desde, fn($q) => $q->whereHas('factura', fn($f) => $f->whereDate('created_at', '>=', $desde)))
            ->when($hasta, fn($q) => $q->whereHas('factura', fn($f) => $f->whereDate('created_at', '<=', $hasta)))
            ->groupBy('nombre_producto')
            ->orderByDesc('total_cantidad')
            ->first();

        $clienteTop = $facturas->groupBy('cliente_id')
            ->map(fn($g) => ['nombre' => $g->first()->cliente->nombre ?? 'N/A', 'total' => $g->sum('total')])
            ->sortByDesc('total')
            ->first();

        return view('informes.facturacion', compact(
            'facturas', 'desde', 'hasta',
            'totalFacturas', 'totalSubtotal', 'totalIva', 'totalGeneral',
            'promedioVenta', 'facturaMaxima', 'totalClientes',
            'productoMasVendido', 'clienteTop'
        ));
    }

    public function facturacionPdf(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;

        $query = Factura::with('cliente');
        if ($desde) $query->whereDate('created_at', '>=', $desde);
        if ($hasta) $query->whereDate('created_at', '<=', $hasta);

        $facturas      = $query->orderBy('created_at', 'desc')->get();
        $totalFacturas = $facturas->count();
        $totalSubtotal = $facturas->sum('subtotal');
        $totalIva      = $facturas->sum('total_iva');
        $totalGeneral  = $facturas->sum('total');

        $pdf = Pdf::loadView('informes.facturacion-pdf', compact(
            'facturas', 'desde', 'hasta',
            'totalFacturas', 'totalSubtotal', 'totalIva', 'totalGeneral'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('informe-facturacion.pdf');
    }

    public function facturacionExcel(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;
        return Excel::download(new FacturacionExport($desde, $hasta), 'informe-facturacion.xlsx');
    }
}