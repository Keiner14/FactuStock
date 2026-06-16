<?php

namespace App\Exports;

use App\Models\Factura;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class FacturacionExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $desde;
    protected $hasta;

    public function __construct($desde = null, $hasta = null)
    {
        $this->desde = $desde;
        $this->hasta = $hasta;
    }

    public function collection()
    {
        $query = Factura::with('cliente');
        if ($this->desde) $query->whereDate('created_at', '>=', $this->desde);
        if ($this->hasta) $query->whereDate('created_at', '<=', $this->hasta);
        return $query->orderBy('created_at', 'desc')->get();
    }

    public function title(): string { return 'Informe de Facturación'; }

    public function headings(): array
    {
        return [
            'N° Factura',
            'Cliente',
            'Subtotal',
            'IVA',
            'Total',
            'Estado',
            'Fecha',
        ];
    }

    public function map($factura): array
    {
        return [
            $factura->numero_factura,
            $factura->cliente->nombre ?? 'Sin cliente',
            '$' . number_format($factura->subtotal, 2, ',', '.'),
            '$' . number_format($factura->total_iva, 2, ',', '.'),
            '$' . number_format($factura->total, 2, ',', '.'),
            ucfirst($factura->estado ?? 'activa'),
            $factura->created_at->format('d/m/Y'),
        ];
    }
}