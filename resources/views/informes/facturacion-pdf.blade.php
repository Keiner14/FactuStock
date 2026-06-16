<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; margin: 25px 35px; }

        .header {
            display: table;
            width: 100%;
            border-bottom: 3px solid #378ADD;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .header-logo { display: table-cell; vertical-align: middle; width: 45%; }
        .header-logo img { height: 50px; }

        .header-titulo { display: table-cell; vertical-align: middle; text-align: right; width: 55%; }
        .header-titulo h1 { font-size: 22px; color: #378ADD; font-weight: bold; letter-spacing: 1px; }
        .header-titulo p { font-size: 9px; color: #888; margin-top: 2px; }

        .periodo {
            background: #eef5fd;
            padding: 8px 12px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 10px;
            color: #4F5869;
        }

        .resumen { display: table; width: 100%; margin-bottom: 18px; border-spacing: 8px 0; }
        .resumen-celda {
            display: table-cell;
            width: 25%;
            background: #f5f7fa;
            border: 1px solid #e2eaf3;
            border-radius: 6px;
            padding: 10px;
            text-align: center;
        }
        .resumen-celda .num { font-size: 15px; font-weight: bold; color: #378ADD; }
        .resumen-celda .num.verde { color: #1f8f4e; }
        .resumen-celda .lbl { font-size: 8px; color: #888; text-transform: uppercase; margin-top: 3px; }

        table.detalle { width: 100%; border-collapse: collapse; font-size: 10px; }
        table.detalle thead th {
            background: #378ADD;
            color: white;
            padding: 7px 8px;
            text-align: left;
            font-size: 9px;
        }
        table.detalle thead th.r { text-align: right; }
        table.detalle thead th.c { text-align: center; }
        table.detalle tbody td { padding: 6px 8px; border-bottom: 1px solid #eef0f3; }
        table.detalle tbody td.r { text-align: right; }
        table.detalle tbody td.c { text-align: center; }
        table.detalle tfoot td {
            padding: 8px;
            font-weight: bold;
            background: #f5f7fa;
            border-top: 2px solid #378ADD;
        }
        table.detalle tfoot td.r { text-align: right; }

        .footer { margin-top: 25px; text-align: center; font-size: 8px; color: #aaa; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-logo">
            <img src="{{ public_path('images/factustock-logo.png') }}" alt="FactuStock">
        </div>
        <div class="header-titulo">
            <h1>INFORME DE FACTURACIÓN</h1>
            <p>Generado el {{ now()->format('d/m/Y h:i A') }}</p>
        </div>
    </div>

    <div class="periodo">
        <strong>Periodo:</strong>
        @if($desde && $hasta)
            {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}
        @elseif($desde)
            Desde {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }}
        @elseif($hasta)
            Hasta {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}
        @else
            Todas las facturas
        @endif
    </div>

    <div class="resumen">
        <div class="resumen-celda">
            <div class="num">{{ $totalFacturas }}</div>
            <div class="lbl">Facturas</div>
        </div>
        <div class="resumen-celda">
            <div class="num">${{ number_format($totalSubtotal, 2, ',', '.') }}</div>
            <div class="lbl">Subtotal</div>
        </div>
        <div class="resumen-celda">
            <div class="num">${{ number_format($totalIva, 2, ',', '.') }}</div>
            <div class="lbl">IVA recaudado</div>
        </div>
        <div class="resumen-celda">
            <div class="num verde">${{ number_format($totalGeneral, 2, ',', '.') }}</div>
            <div class="lbl">Total facturado</div>
        </div>
    </div>

    <table class="detalle">
        <thead>
            <tr>
                <th>N° Factura</th>
                <th>Cliente</th>
                <th class="r">Subtotal</th>
                <th class="r">IVA</th>
                <th class="r">Total</th>
                <th class="c">Estado</th>
                <th class="c">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($facturas as $factura)
            <tr>
                <td>{{ $factura->numero_factura }}</td>
                <td>{{ $factura->cliente->nombre ?? 'Sin cliente' }}</td>
                <td class="r">${{ number_format($factura->subtotal, 2, ',', '.') }}</td>
                <td class="r">${{ number_format($factura->total_iva, 2, ',', '.') }}</td>
                <td class="r">${{ number_format($factura->total, 2, ',', '.') }}</td>
                <td class="c">{{ ucfirst($factura->estado) }}</td>
                <td class="c">{{ $factura->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:20px;color:#aaa;">No hay facturas en el periodo seleccionado.</td>
            </tr>
            @endforelse
        </tbody>
        @if($facturas->count() > 0)
        <tfoot>
            <tr>
                <td colspan="2">TOTALES</td>
                <td class="r">${{ number_format($totalSubtotal, 2, ',', '.') }}</td>
                <td class="r">${{ number_format($totalIva, 2, ',', '.') }}</td>
                <td class="r">${{ number_format($totalGeneral, 2, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        FactuStock — Informe de facturación · Documento generado automáticamente
    </div>

</body>
</html>
