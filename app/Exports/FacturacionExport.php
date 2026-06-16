<?php

namespace App\Exports;

use App\Models\Factura;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FacturacionExport implements FromCollection, WithHeadings, WithMapping
{
    protected $desde;
    protected $hasta;

    public function __construct($desde = null, $hasta = null)
    {
        $this->desde = $desde;
        $this->hasta = $hasta;
    }

    // Retorna las facturas filtradas por rango de fechas
    public function collection()
    {
        $query = Factura::with('cliente')->orderBy('created_at', 'desc');

        if ($this->desde) {
            $query->whereDate('created_at', '>=', $this->desde);
        }
        if ($this->hasta) {
            $query->whereDate('created_at', '<=', $this->hasta);
        }

        return $query->get();
    }

    // Mapea cada factura a una fila del Excel
    public function map($factura): array
    {
        return [
            $factura->numero_factura,
            optional($factura->cliente)->nombre ?? 'Sin cliente',
            optional($factura->cliente)->cedula ?? '',
            number_format($factura->subtotal, 2, '.', ''),
            number_format($factura->total_iva, 2, '.', ''),
            number_format($factura->total, 2, '.', ''),
            ucfirst($factura->estado),
            $factura->created_at->format('d/m/Y'),
        ];
    }

    // Encabezados de las columnas
    public function headings(): array
    {
        return [
            'N° Factura',
            'Cliente',
            'Cédula',
            'Subtotal',
            'IVA',
            'Total',
            'Estado',
            'Fecha',
        ];
    }
}
