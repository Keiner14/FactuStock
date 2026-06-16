@extends('layouts.app')

@section('content')

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
        <h2 style="color:#378ADD;font-size:1.25rem;">📊 Informe de Facturación</h2>
        <div style="display:flex;gap:0.5rem;">
            <a href="{{ route('informes.facturacion.pdf', request()->only(['desde','hasta'])) }}"
               style="background:#378ADD;color:white;padding:0.4rem 0.9rem;border-radius:6px;text-decoration:none;font-size:0.78rem;font-weight:600;">
                🖨️ Imprimir PDF
            </a>
            <a href="{{ route('informes.facturacion.excel', request()->only(['desde','hasta'])) }}"
               style="background:#1f8f4e;color:white;padding:0.4rem 0.9rem;border-radius:6px;text-decoration:none;font-size:0.78rem;font-weight:600;">
                📥 Exportar a Excel
            </a>
        </div>
    </div>

    {{-- ===== FILTRO POR FECHAS ===== --}}
    <div style="background:white;padding:0.9rem 1.1rem;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,0.06);margin-bottom:1.25rem;">
        <form method="GET" action="{{ route('informes.facturacion') }}" style="display:flex;align-items:flex-end;gap:0.9rem;flex-wrap:wrap;">
            <div>
                <label style="display:block;font-size:0.72rem;color:#8A93A2;margin-bottom:0.25rem;">Desde</label>
                <input type="date" name="desde" value="{{ $desde }}"
                       style="height:32px;border:1.5px solid #D5D9E0;border-radius:6px;padding:0 8px;font-size:0.8rem;">
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;color:#8A93A2;margin-bottom:0.25rem;">Hasta</label>
                <input type="date" name="hasta" value="{{ $hasta }}"
                       style="height:32px;border:1.5px solid #D5D9E0;border-radius:6px;padding:0 8px;font-size:0.8rem;">
            </div>
            <button type="submit"
                    style="background:#378ADD;color:white;height:32px;padding:0 1.1rem;border:none;border-radius:6px;cursor:pointer;font-size:0.8rem;font-weight:600;">
                Filtrar
            </button>
            @if($desde || $hasta)
                <a href="{{ route('informes.facturacion') }}"
                   style="color:#8A93A2;font-size:0.78rem;text-decoration:none;height:32px;display:flex;align-items:center;">
                    Limpiar filtro
                </a>
            @endif
        </form>
    </div>

    {{-- ===== TARJETAS DE RESUMEN ===== --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:0.9rem;margin-bottom:1.25rem;">
        <div style="background:white;border-radius:10px;padding:0.9rem 1.1rem;box-shadow:0 1px 4px rgba(0,0,0,0.06);border-left:3px solid #378ADD;">
            <div style="font-size:1.4rem;font-weight:700;color:#378ADD;line-height:1;">{{ $totalFacturas }}</div>
            <div style="font-size:0.7rem;color:#8A93A2;margin-top:0.3rem;text-transform:uppercase;letter-spacing:0.04em;">Facturas</div>
        </div>
        <div style="background:white;border-radius:10px;padding:0.9rem 1.1rem;box-shadow:0 1px 4px rgba(0,0,0,0.06);border-left:3px solid #378ADD;">
            <div style="font-size:1.4rem;font-weight:700;color:#333;line-height:1;">${{ number_format($totalSubtotal, 2, ',', '.') }}</div>
            <div style="font-size:0.7rem;color:#8A93A2;margin-top:0.3rem;text-transform:uppercase;letter-spacing:0.04em;">Subtotal</div>
        </div>
        <div style="background:white;border-radius:10px;padding:0.9rem 1.1rem;box-shadow:0 1px 4px rgba(0,0,0,0.06);border-left:3px solid #378ADD;">
            <div style="font-size:1.4rem;font-weight:700;color:#333;line-height:1;">${{ number_format($totalIva, 2, ',', '.') }}</div>
            <div style="font-size:0.7rem;color:#8A93A2;margin-top:0.3rem;text-transform:uppercase;letter-spacing:0.04em;">IVA recaudado</div>
        </div>
        <div style="background:white;border-radius:10px;padding:0.9rem 1.1rem;box-shadow:0 1px 4px rgba(0,0,0,0.06);border-left:3px solid #1f8f4e;">
            <div style="font-size:1.4rem;font-weight:700;color:#1f8f4e;line-height:1;">${{ number_format($totalGeneral, 2, ',', '.') }}</div>
            <div style="font-size:0.7rem;color:#8A93A2;margin-top:0.3rem;text-transform:uppercase;letter-spacing:0.04em;">Total facturado</div>
        </div>
    </div>

    {{-- ===== TABLA DE FACTURAS ===== --}}
    <div style="background:white;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;font-size:0.8rem;">
            <thead style="background:#378ADD;color:white;">
                <tr>
                    <th style="padding:0.6rem 0.75rem;text-align:left;">N° Factura</th>
                    <th style="padding:0.6rem 0.75rem;text-align:left;">Cliente</th>
                    <th style="padding:0.6rem 0.75rem;text-align:right;">Subtotal</th>
                    <th style="padding:0.6rem 0.75rem;text-align:right;">IVA</th>
                    <th style="padding:0.6rem 0.75rem;text-align:right;">Total</th>
                    <th style="padding:0.6rem 0.75rem;text-align:center;">Estado</th>
                    <th style="padding:0.6rem 0.75rem;text-align:center;">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facturas as $factura)
                <tr style="border-bottom:1px solid #f0f4f8;">
                    <td style="padding:0.55rem 0.75rem;font-weight:600;color:#378ADD;">{{ $factura->numero_factura }}</td>
                    <td style="padding:0.55rem 0.75rem;">{{ $factura->cliente->nombre ?? 'Sin cliente' }}</td>
                    <td style="padding:0.55rem 0.75rem;text-align:right;">${{ number_format($factura->subtotal, 2, ',', '.') }}</td>
                    <td style="padding:0.55rem 0.75rem;text-align:right;">${{ number_format($factura->total_iva, 2, ',', '.') }}</td>
                    <td style="padding:0.55rem 0.75rem;text-align:right;font-weight:700;">${{ number_format($factura->total, 2, ',', '.') }}</td>
                    <td style="padding:0.55rem 0.75rem;text-align:center;">
                        @if($factura->estado == 'activa')
                            <span style="background:#EAF3DE;color:#27500A;padding:0.15rem 0.6rem;border-radius:20px;font-size:0.7rem;">Activa</span>
                        @else
                            <span style="background:#FCEBEB;color:#791F1F;padding:0.15rem 0.6rem;border-radius:20px;font-size:0.7rem;">Anulada</span>
                        @endif
                    </td>
                    <td style="padding:0.55rem 0.75rem;text-align:center;color:#8A93A2;">{{ $factura->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:2rem;text-align:center;color:#8A93A2;font-size:0.85rem;">
                        No hay facturas en el periodo seleccionado.
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($facturas->count() > 0)
            <tfoot>
                <tr style="background:#f5f7fa;font-weight:700;border-top:2px solid #e2eaf3;">
                    <td colspan="2" style="padding:0.6rem 0.75rem;">TOTALES</td>
                    <td style="padding:0.6rem 0.75rem;text-align:right;">${{ number_format($totalSubtotal, 2, ',', '.') }}</td>
                    <td style="padding:0.6rem 0.75rem;text-align:right;">${{ number_format($totalIva, 2, ',', '.') }}</td>
                    <td style="padding:0.6rem 0.75rem;text-align:right;color:#1f8f4e;">${{ number_format($totalGeneral, 2, ',', '.') }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

@endsection
