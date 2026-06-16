<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Producto::orderBy('nombre')->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Código',
            'Nombre',
            'Presentación',
            'IVA (%)',
            'Costo Unitario',
            'Stock',
            'Estado',
        ];
    }

    public function map($producto): array
    {
        if ($producto->stock > 10) {
            $estado = 'Disponible';
        } elseif ($producto->stock > 0) {
            $estado = 'Stock bajo';
        } else {
            $estado = 'Sin stock';
        }

        return [
            $producto->id,
            $producto->codigo,
            $producto->nombre,
            $producto->categoria ?? 'Sin categoría',
            $producto->iva . '%',
            '$' . number_format($producto->costo_promedio, 2),
            $producto->stock,
            $estado,
        ];
    }
}