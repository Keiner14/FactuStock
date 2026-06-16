@extends('layouts.app')

@section('content')

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
        <h2 style="color:#378ADD;">Cotizaciones</h2>
        <a href="{{ route('cotizaciones.create') }}" style="background:#378ADD;color:white;padding:0.4rem 1rem;border-radius:6px;text-decoration:none;font-size:0.82rem;">+ Nueva Cotización</a>
    </div>

    <div style="display:flex;flex-direction:column;gap:0.6rem;">
        @forelse($cotizaciones as $cotizacion)
        <div style="background:white;border-radius:8px;padding:0.9rem 1.2rem;display:flex;align-items:center;gap:1.5rem;border:1px solid #e2eaf3;">

            {{-- Consecutivo --}}
            <div style="width:50px;height:50px;background:#e8f4fd;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;flex-direction:column;">
                <span style="font-size:0.62rem;color:#8A93A2;">COT</span>
                <span style="font-size:0.95rem;font-weight:700;color:#378ADD;">{{ str_pad($cotizacion->consecutivo, 4, '0', STR_PAD_LEFT) }}</span>
            </div>

            {{-- Cliente --}}
            <div style="flex:2;">
                <div style="font-weight:700;font-size:0.88rem;color:#0D1117;">{{ $cotizacion->cliente->nombre }}</div>
                <div style="font-size:0.72rem;color:#8A93A2;">Cédula: {{ $cotizacion->cliente->cedula }}</div>
            </div>

            {{-- Total --}}
            <div style="flex:1;text-align:center;">
                <div style="font-size:0.68rem;color:#8A93A2;margin-bottom:2px;">TOTAL</div>
                <div style="font-size:0.95rem;font-weight:700;color:#378ADD;">${{ number_format($cotizacion->total, 2) }}</div>
            </div>

            {{-- Estado --}}
            <div style="flex:1;text-align:center;">
                @if($cotizacion->estado == 'pendiente')
                    <span style="background:#FEF3CD;color:#856404;padding:0.2rem 0.7rem;border-radius:20px;font-size:0.75rem;">Pendiente</span>
                @elseif($cotizacion->estado == 'facturada')
                    <span style="background:#EAF3DE;color:#27500A;padding:0.2rem 0.7rem;border-radius:20px;font-size:0.75rem;">Facturada</span>
                @else
                    <span style="background:#FCEBEB;color:#791F1F;padding:0.2rem 0.7rem;border-radius:20px;font-size:0.75rem;">Cancelada</span>
                @endif
            </div>

            {{-- Fecha --}}
            <div style="text-align:right;">
                <div style="font-size:0.72rem;color:#8A93A2;">{{ $cotizacion->created_at->format('d/m/Y') }}</div>
            </div>

            {{-- Acciones --}}
            <div style="display:flex;gap:0.4rem;flex-shrink:0;">
                <a href="{{ route('cotizaciones.show', $cotizacion) }}" style="background:#f0f4f8;color:#378ADD;padding:0.3rem 0.8rem;border-radius:5px;text-decoration:none;font-size:0.78rem;font-weight:600;border:1px solid #e2eaf3;">Ver</a>
            </div>

        </div>
        @empty
        <div style="background:white;border-radius:8px;padding:2rem;text-align:center;color:#8A93A2;font-size:0.875rem;">
            No hay cotizaciones registradas aún.
        </div>
        @endforelse
    </div>

@endsection