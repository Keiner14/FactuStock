@extends('layouts.app')

@section('content')

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
        <h2 style="color:#378ADD;">Historial de Entradas</h2>
        <a href="{{ route('entradas.create') }}" style="background:#378ADD;color:white;padding:0.4rem 1rem;border-radius:6px;text-decoration:none;font-size:0.82rem;">+ Nueva Entrada</a>
    </div>

    <div style="display:flex;flex-direction:column;gap:0.6rem;">
        @forelse($entradas as $entrada)
        <div style="background:white;border-radius:8px;padding:0.9rem 1.2rem;display:flex;align-items:center;gap:1.5rem;border:1px solid #e2eaf3;">

            {{-- Consecutivo --}}
            <div style="width:50px;height:50px;background:#e8f4fd;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;flex-direction:column;">
                <span style="font-size:0.62rem;color:#8A93A2;">N°</span>
                <span style="font-size:0.95rem;font-weight:700;color:#378ADD;">{{ str_pad($entrada->consecutivo, 4, '0', STR_PAD_LEFT) }}</span>
            </div>

            {{-- Producto --}}
            <div style="flex:2;">
                <div style="font-weight:700;font-size:0.88rem;color:#0D1117;">{{ $entrada->nombre_producto }}</div>
                <div style="font-size:0.72rem;color:#8A93A2;">Código: {{ $entrada->codigo_producto }}</div>
            </div>

            {{-- Cantidad --}}
            <div style="flex:1;text-align:center;">
                <div style="font-size:0.68rem;color:#8A93A2;margin-bottom:2px;">CANTIDAD</div>
                <div style="font-size:0.95rem;font-weight:700;color:#27a744;">+{{ $entrada->cantidad }}</div>
            </div>

            {{-- Costo unitario --}}
            <div style="flex:1;text-align:center;">
                <div style="font-size:0.68rem;color:#8A93A2;margin-bottom:2px;">COSTO UND</div>
                <div style="font-size:0.88rem;font-weight:600;">${{ number_format($entrada->costo_unitario, 2) }}</div>
            </div>

            {{-- Stock nuevo --}}
            <div style="flex:1;text-align:center;">
                <div style="font-size:0.68rem;color:#8A93A2;margin-bottom:2px;">STOCK NUEVO</div>
                <div style="font-size:0.88rem;font-weight:700;color:#378ADD;">{{ $entrada->stock_nuevo }}</div>
            </div>

            {{-- Observacion --}}
            <div style="flex:2;">
                <div style="font-size:0.68rem;color:#8A93A2;margin-bottom:2px;">OBSERVACIÓN</div>
                <div style="font-size:0.78rem;color:#4F5869;">{{ $entrada->observacion ?? 'Sin observación' }}</div>
            </div>

            {{-- Total entrada --}}
            <div style="flex:1;text-align:center;">
                <div style="font-size:0.68rem;color:#8A93A2;margin-bottom:2px;">TOTAL ENTRADA</div>
                <div style="font-size:0.88rem;font-weight:700;color:#0C447C;">${{ number_format($entrada->cantidad * $entrada->costo_unitario, 2) }}</div>
            </div>

            {{-- Fecha --}}
            <div style="flex:1;text-align:right;">
                <div style="font-size:0.68rem;color:#8A93A2;">{{ $entrada->created_at->format('d/m/Y') }}</div>
                <div style="font-size:0.68rem;color:#8A93A2;">{{ $entrada->created_at->format('h:i A') }}</div>
            </div>

        </div>
        @empty
        <div style="background:white;border-radius:8px;padding:2rem;text-align:center;color:#8A93A2;font-size:0.875rem;">
            No hay entradas registradas aún.
        </div>
        @endforelse
    </div>

@endsection