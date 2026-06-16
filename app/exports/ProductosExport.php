<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductosExport implements FromCollection, WithHeadings
{
    // Retorna todos los productos para exportar
    public function collection()
    {
        return Producto::select(
            'nombre',
            'codigo',
            'categoria',
            'costo',
            'porcentaje_ganancia',
            'precio_venta',
            'stock'
        )->get();
    }

    // Encabezados de las columnas en el Excel
    public function headings(): array
    {
        return [
            'Nombre',
            'Código',
            'Categoría',
            'Costo',
            '% Ganancia',
            'Precio de Venta',
            'Stock',
        ];
    }
}