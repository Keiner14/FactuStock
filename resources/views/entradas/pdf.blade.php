<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }

        .header {
            background: #0C447C;
            padding: 20px 30px;
            margin-bottom: 25px;
        }

        .logo-text { font-size: 22px; font-weight: bold; color: white; }
        .logo-sub { font-size: 10px; color: rgba(255,255,255,0.6); margin-top: 3px; }
        .entrada-num-label { font-size: 10px; color: rgba(255,255,255,0.6); }
        .entrada-num-val { font-size: 22px; font-weight: bold; color: #7EC8F7; }

        .body { padding: 0 30px; }

        .seccion-titulo {
            font-size: 10px;
            font-weight: bold;
            color: #378ADD;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1.5px solid #e2eaf3;
            padding-bottom: 5px;
            margin-bottom: 12px;
            margin-top: 18px;
        }

        .info-label {
            font-size: 9px;
            color: #8A93A2;
            text-transform: uppercase;
            display: block;
            margin-bottom: 2px;
        }

        .info-val {
            font-size: 12px;
            font-weight: bold;
            color: #0D1117;
        }

        table { width: 100%; border-collapse: collapse; }

        table.detalle thead { background: #378ADD; color: white; }

        table.detalle thead th {
            padding: 8px 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }

        table.detalle tbody tr { border-bottom: 1px solid #f0f4f8; }

        table.detalle tbody td {
            padding: 9px 10px;
            font-size: 11px;
        }

        .badge-green {
            background: #EAF3DE;
            color: #27500A;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: bold;
        }

        .obs-box {
            background: #fff4e6;
            border-left: 3px solid #f39c12;
            padding: 10px 15px;
            font-size: 11px;
            color: #4F5869;
            margin-top: 5px;
        }

        .total-box {
            background: #0C447C;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
        }

        .costo-box {
            background: #f8fbff;
            border: 1px solid #e2eaf3;
            border-radius: 6px;
            padding: 10px 15px;
        }

        .footer {
            margin-top: 35px;
            border-top: 1px solid #e2eaf3;
            padding: 12px 30px 0;
            font-size: 9px;
            color: #8A93A2;
        }

        .elaborado {
            font-size: 10px;
            color: #4F5869;
            font-weight: bold;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="logo-text">FactuStock</div>
                    <div class="logo-sub">Sistema de Gestión de Inventario</div>
                </td>
                <td style="text-align:right;">
                    <div class="entrada-num-label">Entrada de Mercancía</div>
                    <div class="entrada-num-val">N° {{ str_pad($entrada->consecutivo, 4, '0', STR_PAD_LEFT) }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="body">

        {{-- Info general --}}
        <div class="seccion-titulo">Información de la entrada</div>
        <table>
            <tr>
                <td style="width:25%;padding:5px 8px;">
                    <span class="info-label">Consecutivo</span>
                    <span class="info-val">N° {{ str_pad($entrada->consecutivo, 4, '0', STR_PAD_LEFT) }}</span>
                </td>
                <td style="width:25%;padding:5px 8px;">
                    <span class="info-label">Fecha de registro</span>
                    <span class="info-val">{{ $entrada->created_at->format('d/m/Y') }}</span>
                </td>
                <td style="width:25%;padding:5px 8px;">
                    <span class="info-label">Hora</span>
                    <span class="info-val">{{ $entrada->created_at->format('h:i A') }}</span>
                </td>
                <td style="width:25%;padding:5px 8px;">
                    <span class="info-label">Registrado por</span>
                    <span class="info-val">{{ $usuario->name }}</span>
                </td>
            </tr>
        </table>

        {{-- Detalle producto --}}
        <div class="seccion-titulo">Detalle del producto</div>
        <table class="detalle">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre del producto</th>
                    <th>Cantidad</th>
                    <th>Costo unitario</th>
                    <th>Stock anterior</th>
                    <th>Stock nuevo</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $entrada->codigo_producto }}</td>
                    <td>{{ $entrada->nombre_producto }}</td>
                    <td><span class="badge-green">+{{ $entrada->cantidad }}</span></td>
                    <td>${{ number_format($entrada->costo_unitario, 2) }}</td>
                    <td>{{ $entrada->stock_anterior }}</td>
                    <td><strong>{{ $entrada->stock_nuevo }}</strong></td>
                    <td><strong>${{ number_format($entrada->cantidad * $entrada->costo_unitario, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        {{-- Observacion --}}
        <div class="seccion-titulo">Observación</div>
        <div class="obs-box">
            {{ $entrada->observacion ?? 'Sin observación registrada.' }}
        </div>

        {{-- Totales --}}
        <table style="margin-top:15px;">
            <tr>
                <td style="width:60%;padding-right:10px;">
                    <div class="costo-box">
                        <table>
                            <tr>
                                <td style="font-size:11px;color:#8A93A2;">Nuevo costo promedio del producto</td>
                                <td style="text-align:right;font-size:13px;font-weight:bold;color:#0C447C;">${{ number_format($entrada->costo_promedio_nuevo, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td style="width:40%;">
                    <div class="total-box">
                        <table>
                            <tr>
                                <td style="font-size:11px;color:rgba(255,255,255,0.7);">Total entrada</td>
                                <td style="text-align:right;font-size:18px;font-weight:bold;color:#7EC8F7;">${{ number_format($entrada->cantidad * $entrada->costo_unitario, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

    </div>

    {{-- Footer --}}
    <div class="footer">
        <table>
            <tr>
                <td>
                    <div class="elaborado">Elaborado por: {{ $usuario->name }} {{ $usuario->apellidos }}</div>
                    <div style="margin-top:3px;">Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('h:i A') }}</div>
                </td>
                <td style="text-align:right;">
                    <div>FactuStock · Sistema de Gestión</div>
                    <div>Documento generado automáticamente</div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>