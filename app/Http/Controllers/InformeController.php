<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Exports\FacturacionExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InformeController extends Controller
{
    // Construye la consulta de facturas filtrada por rango de fechas
    private function consultaFacturas(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        $query = Factura::with('cliente')->orderBy('created_at', 'desc');

        if ($desde) {
            $query->whereDate('created_at', '>=', $desde);
        }
        if ($hasta) {
            $query->whereDate('created_at', '<=', $hasta);
        }

        return $query;
    }

    // Muestra el informe de facturación en pantalla
    public function facturacion(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        $facturas = $this->consultaFacturas($request)->get();

        $totalFacturas = $facturas->count();
        $totalSubtotal = $facturas->sum('subtotal');
        $totalIva      = $facturas->sum('total_iva');
        $totalGeneral  = $facturas->sum('total');

        return view('informes.facturacion', compact(
            'facturas',
            'desde',
            'hasta',
            'totalFacturas',
            'totalSubtotal',
            'totalIva',
            'totalGeneral'
        ));
    }

    // Genera el PDF del informe de facturación
    public function pdf(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        $facturas = $this->consultaFacturas($request)->get();

        $totalFacturas = $facturas->count();
        $totalSubtotal = $facturas->sum('subtotal');
        $totalIva      = $facturas->sum('total_iva');
        $totalGeneral  = $facturas->sum('total');

        $pdf = Pdf::loadView('informes.facturacion-pdf', compact(
            'facturas',
            'desde',
            'hasta',
            'totalFacturas',
            'totalSubtotal',
            'totalIva',
            'totalGeneral'
        ));

        return $pdf->download('informe-facturacion.pdf');
    }

    // Exporta el informe de facturación a Excel
    public function excel(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        return Excel::download(new FacturacionExport($desde, $hasta), 'informe-facturacion.xlsx');
    }
}
