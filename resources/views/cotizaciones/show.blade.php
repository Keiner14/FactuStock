@extends('layouts.app')

@section('content')

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
        <h2 style="color:#378ADD;">Cotización N° {{ str_pad($cotizacion->consecutivo, 4, '0', STR_PAD_LEFT) }}</h2>
        <div style="display:flex;gap:0.5rem;">
            @if($cotizacion->estado == 'pendiente')
                <form method="POST" action="{{ url('cotizaciones/' . $cotizacion->id . '/convertir-factura') }}">
                    @csrf
                    <button type="submit" style="background:#27a744;color:white;padding:0.4rem 1rem;border:none;border-radius:6px;cursor:pointer;font-size:0.82rem;" onclick="return confirm('¿Convertir esta cotización en factura?')">
                        📄 Convertir a Factura
                    </button>
                </form>
            @endif
            <a href="{{ url('cotizaciones/' . $cotizacion->id . '/pdf') }}" style="background:#f59e0b;color:white;padding:0.4rem 1rem;border-radius:6px;text-decoration:none;font-size:0.82rem;">📥 Descargar PDF</a>
            <a href="{{ route('cotizaciones.index') }}" style="background:#f0f4f8;color:#378ADD;padding:0.4rem 1rem;border-radius:6px;text-decoration:none;font-size:0.82rem;border:1px solid #e2eaf3;">← Volver</a>
        </div>
    </div>

    @if($errors->any())
        <div style="background:#FCEBEB;color:#791F1F;padding:0.75rem 1rem;border-radius:8px;margin-bottom:1rem;font-size:0.875rem;">
            @foreach($errors->all() as $error)
                <div>⚠ {{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- Datos del cliente --}}
    <div style="background:white;padding:1rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:1rem;">
        <h3 style="font-size:0.85rem;color:#378ADD;margin-bottom:0.75rem;">👤 Datos del Cliente</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;font-size:0.82rem;">
            <div><span style="color:#8A93A2;">Nombre:</span> <strong>{{ $cotizacion->cliente->nombre }}</strong></div>
            <div><span style="color:#8A93A2;">Cédula:</span> <strong>{{ $cotizacion->cliente->cedula }}</strong></div>
            <div><span style="color:#8A93A2;">Celular:</span> <strong>{{ $cotizacion->cliente->celular }}</strong></div>
            <div><span style="color:#8A93A2;">Dirección:</span> <strong>{{ $cotizacion->cliente->direccion }}</strong></div>
        </div>
    </div>

    {{-- Items --}}
    <div style="background:white;padding:1rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:1rem;">
        <h3 style="font-size:0.85rem;color:#378ADD;margin-bottom:0.75rem;">📦 Productos</h3>
        <table style="width:100%;border-collapse:collapse;font-size:0.82rem;">
            <thead style="background:#f0f4f8;">
                <tr>
                    <th style="padding:0.6rem;text-align:left;">Código</th>
                    <th style="padding:0.6rem;text-align:left;">Nombre</th>
                    <th style="padding:0.6rem;text-align:center;">Cantidad</th>
                    <th style="padding:0.6rem;text-align:center;">Precio Unit.</th>
                    <th style="padding:0.6rem;text-align:center;">IVA</th>
                    <th style="padding:0.6rem;text-align:center;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cotizacion->items as $item)
                <tr style="border-bottom:1px solid #f0f4f8;">
                    <td style="padding:0.6rem;">{{ $item->codigo_producto }}</td>
                    <td style="padding:0.6rem;">{{ $item->nombre_producto }}</td>
                    <td style="padding:0.6rem;text-align:center;">{{ $item->cantidad }}</td>
                    <td style="padding:0.6rem;text-align:center;">${{ number_format($item->precio_unitario, 2, ',', '.') }}</td>
                    <td style="padding:0.6rem;text-align:center;">{{ $item->iva }}%</td>
                    <td style="padding:0.6rem;text-align:center;">${{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Totales --}}
    <div style="background:white;padding:1rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);max-width:300px;margin-left:auto;">
        <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:0.4rem;">
            <span style="color:#8A93A2;">Subtotal:</span>
            <strong>${{ number_format($cotizacion->subtotal, 2, ',', '.') }}</strong>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:0.4rem;">
            <span style="color:#8A93A2;">IVA:</span>
            <strong>${{ number_format($cotizacion->total_iva, 2, ',', '.') }}</strong>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:0.95rem;border-top:1px solid #f0f4f8;padding-top:0.4rem;">
            <span style="font-weight:700;">TOTAL:</span>
            <strong style="color:#378ADD;">${{ number_format($cotizacion->total, 2, ',', '.') }}</strong>
        </div>
    </div>

    @if($cotizacion->observacion)
        <div style="background:white;padding:1rem;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-top:1rem;font-size:0.82rem;">
            <span style="color:#8A93A2;">Observación:</span> {{ $cotizacion->observacion }}
        </div>
    @endif

@endsection