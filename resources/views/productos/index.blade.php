@extends('layouts.app')

@section('content')

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
        <h2 style="color:#378ADD;">Lista de Productos</h2>
        <a href="{{ route('productos.create') }}" style="background:#378ADD;color:white;padding:0.4rem 1rem;border-radius:6px;text-decoration:none;font-size:0.82rem;">+ Nuevo Producto</a>
    </div>

    <div style="display:flex;flex-direction:column;gap:0.6rem;">
        @foreach($productos as $producto)
        <div style="background:white;border-radius:8px;padding:0.9rem 1.2rem;display:flex;align-items:center;gap:1.5rem;border:1px solid #e2eaf3;">

            {{-- Numero --}}
            <div style="width:32px;height:32px;background:#378ADD;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:0.78rem;font-weight:700;flex-shrink:0;">
                {{ $loop->iteration }}
            </div>

            {{-- Nombre y categoria --}}
            <div style="flex:2;">
                <div style="font-weight:700;font-size:0.9rem;color:#0D1117;">{{ $producto->nombre }}</div>
                <div style="font-size:0.72rem;color:#8A93A2;">{{ $producto->categoria ?? 'Sin categoría' }} · Cód: {{ $producto->codigo }}</div>
            </div>

            {{-- Costo promedio --}}
            <div style="flex:1;text-align:center;">
                <div style="font-size:0.68rem;color:#8A93A2;margin-bottom:2px;">COSTO PROMEDIO</div>
                <div style="font-size:0.88rem;font-weight:600;">${{ number_format($producto->costo_promedio, 2) }}</div>
            </div>

            {{-- IVA --}}
            <div style="flex:1;text-align:center;">
                <div style="font-size:0.68rem;color:#8A93A2;margin-bottom:2px;">IVA</div>
                <div style="font-size:0.88rem;font-weight:600;color:#378ADD;">{{ $producto->iva }}%</div>
            </div>

            {{-- Stock --}}
            <div style="flex:1;text-align:center;">
                <div style="font-size:0.68rem;color:#8A93A2;margin-bottom:4px;">STOCK</div>
                @if($producto->stock > 10)
                    <span style="background:#EAF3DE;color:#27500A;padding:0.2rem 0.7rem;border-radius:20px;font-size:0.75rem;font-weight:600;">{{ $producto->stock }}</span>
                @elseif($producto->stock > 0)
                    <span style="background:#FEF3CD;color:#856404;padding:0.2rem 0.7rem;border-radius:20px;font-size:0.75rem;font-weight:600;">{{ $producto->stock }}</span>
                @else
                    <span style="background:#FCEBEB;color:#791F1F;padding:0.2rem 0.7rem;border-radius:20px;font-size:0.75rem;font-weight:600;">0</span>
                @endif
            </div>

            {{-- Acciones --}}
            <div style="display:flex;gap:0.4rem;flex-shrink:0;">
                <a href="{{ route('productos.edit', $producto) }}" style="background:#f0f4f8;color:#378ADD;padding:0.3rem 0.8rem;border-radius:5px;text-decoration:none;font-size:0.78rem;font-weight:600;border:1px solid #e2eaf3;">Editar</a>
                <form method="POST" action="{{ route('productos.destroy', $producto) }}" style="display:inline" onsubmit="return confirm('¿Eliminar producto?')">
                    @csrf @method('DELETE')
                    <button style="background:#FCEBEB;color:#dc2626;padding:0.3rem 0.8rem;border-radius:5px;border:1px solid #fca5a5;cursor:pointer;font-size:0.78rem;font-weight:600;">Eliminar</button>
                </form>
            </div>

        </div>
        @endforeach
    </div>

@endsection