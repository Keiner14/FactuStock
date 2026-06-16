@extends('layouts.app')

@section('content')

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
        <h2 style="color:#378ADD;">Facturas</h2>
        <a href="{{ route('facturas.create') }}" style="background:#378ADD;color:white;padding:0.4rem 1rem;border-radius:6px;text-decoration:none;font-size:0.82rem;">+ Nueva Factura</a>
    </div>

    <div style="display:flex;flex-direction:column;gap:0.6rem;">
        @forelse($facturas as $factura)
        <div style="background:white;border-radius:8px;padding:0.9rem 1.2rem;display:flex;align-items:center;gap:1.5rem;border:1px solid #e2eaf3;">

            {{-- Numero factura --}}
            <div style="width:60px;height:50px;background:#e8f4fd;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;flex-direction:column;">
                <span style="font-size:0.62rem;color:#8A93A2;">FAC</span>
                <span style="font-size:0.82rem;font-weight:700;color:#378ADD;">{{ str_pad($factura->consecutivo, 4, '0', STR_PAD_LEFT) }}</span>
            </div>

            {{-- Cliente --}}
            <div style="flex:2;">
                <div style="font-weight:700;font-size:0.88rem;color:#0D1117;">{{ $factura->cliente->nombre }}</div>
                <div style="font-size:0.72rem;color:#8A93A2;">{{ $factura->numero_factura }} · Cédula: {{ $factura->cliente->cedula }}</div>
            </div>

            {{-- Total --}}
            <div style="flex:1;text-align:center;">
                <div style="font-size:0.68rem;color:#8A93A2;margin-bottom:2px;">TOTAL</div>
                <div style="font-size:0.95rem;font-weight:700;color:#378ADD;">${{ number_format($factura->total, 2) }}</div>
            </div>

            {{-- Estado --}}
            <div style="flex:1;text-align:center;">
                @if($factura->estado == 'activa')
                    <span style="background:#EAF3DE;color:#27500A;padding:0.2rem 0.7rem;border-radius:20px;font-size:0.75rem;">Activa</span>
                @else
                    <span style="background:#FCEBEB;color:#791F1F;padding:0.2rem 0.7rem;border-radius:20px;font-size:0.75rem;">Anulada</span>
                @endif
            </div>

            {{-- Fecha --}}
            <div style="text-align:right;">
                <div style="font-size:0.72rem;color:#8A93A2;">{{ $factura->created_at->format('d/m/Y') }}</div>
            </div>

            {{-- Acciones --}}
            <div style="display:flex;gap:0.4rem;flex-shrink:0;">
                <a href="{{ route('facturas.show', $factura) }}" style="background:#f0f4f8;color:#378ADD;padding:0.3rem 0.8rem;border-radius:5px;text-decoration:none;font-size:0.78rem;font-weight:600;border:1px solid #e2eaf3;">Ver</a>
            </div>

        </div>
        @empty
        <div style="background:white;border-radius:8px;padding:2rem;text-align:center;color:#8A93A2;font-size:0.875rem;">
            No hay facturas registradas aún.
        </div>
        @endforelse
    </div>

@endsection