@extends('layouts.app')

@section('content')

    <h2 style="color:#378ADD; margin-bottom:1rem;">Informe de Existencias</h2>

    {{-- Resumen general --}}
    <div style="display:flex;gap:1rem;margin-bottom:1.5rem;">
        <div style="background:white;padding:1rem 1.5rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);text-align:center;">
            <div style="font-size:1.5rem;font-weight:700;color:#378ADD;">{{ $totalProductos }}</div>
            <div style="font-size:0.8rem;color:#4F5869;">Total productos</div>
        </div>
        <div style="background:white;padding:1rem 1.5rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);text-align:center;">
            <div style="font-size:1.5rem;font-weight:700;color:#378ADD;">{{ $totalStock }}</div>
            <div style="font-size:0.8rem;color:#4F5869;">Total unidades en stock</div>
        </div>
    </div>

    {{-- Boton para exportar a Excel --}}
    <a href="{{ route('productos.exportar') }}" style="background:#27a744;color:white;padding:0.5rem 1rem;border-radius:6px;text-decoration:none;font-size:0.875rem;margin-bottom:1rem;display:inline-block;">
        📥 Exportar a Excel
    </a>

    {{-- Tabla de productos --}}
    <table style="width:100%;border-collapse:collapse;margin-top:1rem;background:white;border-radius:8px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.08);">
        <thead style="background:#378ADD;color:white;">
            <tr>
                <th style="padding:0.75rem;">#</th>
                <th style="padding:0.75rem;">Nombre</th>
                <th style="padding:0.75rem;">Código</th>
                <th style="padding:0.75rem;">Categoría</th>
                <th style="padding:0.75rem;">Costo Unitario</th>
                <th style="padding:0.75rem;">Stock</th>
                <th style="padding:0.75rem;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr style="border-bottom:1px solid #f0f4f8;">
                <td style="padding:0.75rem;">{{ $loop->iteration }}</td>
                <td style="padding:0.75rem;">{{ $producto->nombre }}</td>
                <td style="padding:0.75rem;">{{ $producto->codigo }}</td>
                <td style="padding:0.75rem;">{{ $producto->categoria ?? 'Sin categoría' }}</td>
                <td style="padding:0.75rem;">${{ number_format($producto->costo_promedio, 2) }}</td>
                <td style="padding:0.75rem;">{{ $producto->stock }}</td>
                <td style="padding:0.75rem;">
                    @if($producto->stock > 10)
                        <span style="background:#EAF3DE;color:#27500A;padding:0.2rem 0.7rem;border-radius:5px;font-size:0.78rem;">
                            Disponible
                        </span>
                    @elseif($producto->stock > 0)
                        <span style="background:#FEF3CD;color:#856404;padding:0.2rem 0.7rem;border-radius:5px;font-size:0.78rem;">
                            Stock bajo
                        </span>
                    @else
                        <span style="background:#FCEBEB;color:#791F1F;padding:0.2rem 0.7rem;border-radius:5px;font-size:0.78rem;">
                            Sin stock
                        </span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection