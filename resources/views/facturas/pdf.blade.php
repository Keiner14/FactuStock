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
            background: white;
            border-bottom: 3px solid #378ADD;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-logo {
            display: table-cell;
            vertical-align: middle;
            width: 40%;
        }

        .header-logo img { height: 60px; }

        .header-titulo {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 60%;
        }

        .header-titulo h1 {
            font-size: 28px;
            color: #378ADD;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .header-titulo p {
            font-size: 10px;
            color: #888;
            margin-top: 2px;
        }

        .numero-box {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .numero-izq {
            display: table-cell;
            width: 60%;
        }

        .badge-numero {
            background: #378ADD;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
        }

        .badge-estado {
            background: #EAF3DE;
            color: #27500A;
            padding: 4px 10px;
            border-radius: 10px;
            font-size: 10px;
            margin-left: 8px;
        }

        .fecha { font-size: 10px; color: #888; margin-top: 5px; }

        .cliente-box {
            background: #f8fafd;
            border: 1px solid #e2eaf3;
            border-left: 4px solid #378ADD;
            border-radius: 5px;
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        .cliente-titulo {
            font-size: 11px;
            font-weight: bold;
            color: #378ADD;
            margin-bottom: 6px;
        }

        .cliente-grid { display: table; width: 100%; }
        .cliente-col { display: table-cell; width: 50%; font-size: 11px; padding: 2px 0; }
        .label { color: #888; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }

        thead tr { background: #378ADD; color: white; }
        th { padding: 8px; text-align: left; font-size: 10px; }
        td { padding: 7px 8px; font-size: 10px; border-bottom: 1px solid #f0f4f8; }
        tr:nth-child(even) td { background: #f9fbfd; }

        .totales-box {
            float: right;
            width: 230px;
            border: 1px solid #e2eaf3;
            border-radius: 5px;
            overflow: hidden;
        }

        .t-row { display: table; width: 100%; padding: 6px 12px; border-bottom: 1px solid #f0f4f8; }
        .t-label { display: table-cell; color: #888; font-size: 11px; }
        .t-valor { display: table-cell; text-align: right; font-weight: bold; font-size: 11px; }

        .t-total {
            background: #378ADD;
            padding: 8px 12px;
            display: table;
            width: 100%;
        }
        .t-total .t-label { color: white; font-size: 13px; font-weight: bold; }
        .t-total .t-valor { color: white; font-size: 13px; font-weight: bold; }

        .footer {
            clear: both;
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #aaa;
            border-top: 1px solid #e2eaf3;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-logo">
            <img src="{{ public_path('images/factustock-logo.png') }}" alt="FactuStock">
        </div>
        <div class="header-titulo">
            <h1>FACTURA</h1>
            <p>Sistema de Facturación e Inventario</p>
        </div>
    </div>

    {{-- NUMERO Y FECHA --}}
    <div class="numero-box">
        <div class="numero-izq">
            <span class="badge-numero">{{ $factura->numero_factura }}</span>
            <span class="badge-estado">{{ ucfirst($factura->estado) }}</span>
            <div class="fecha">Fecha: {{ $factura->created_at->format('d/m/Y h:i A') }}</div>
        </div>
    </div>

    {{-- CLIENTE --}}
    <div class="cliente-box">
        <div class="cliente-titulo">👤 DATOS DEL CLIENTE</div>
        <div class="cliente-grid">
            <div class="cliente-col"><span class="label">Nombre: </span><strong>{{ $factura->cliente->nombre }}</strong></div>
            <div class="cliente-col"><span class="label">Cédula: </span><strong>{{ $factura->cliente->cedula }}</strong></div>
        </div>
        <div class="cliente-grid" style="margin-top:3px;">
            <div class="cliente-col"><span class="label">Celular: </span><strong>{{ $factura->cliente->celular }}</strong></div>
            <div class="cliente-col"><span class="label">Dirección: </span><strong>{{ $factura->cliente->direccion }}</strong></div>
        </div>
    </div>

    {{-- PRODUCTOS --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Cant.</th>
                <th>Precio Unit.</th>
                <th>IVA</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factura->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->codigo_producto }}</td>
                <td>{{ $item->nombre_producto }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>${{ number_format($item->precio_unitario, 2, ',', '.') }}</td>
                <td>{{ $item->iva }}%</td>
                <td>${{ number_format($item->subtotal, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTALES --}}
    <div class="totales-box">
        <div class="t-row">
            <div class="t-label">Subtotal:</div>
            <div class="t-valor">${{ number_format($factura->subtotal, 2, ',', '.') }}</div>
        </div>
        <div class="t-row">
            <div class="t-label">IVA:</div>
            <div class="t-valor">${{ number_format($factura->total_iva, 2, ',', '.') }}</div>
        </div>
        <div class="t-total">
            <div class="t-label">TOTAL:</div>
            <div class="t-valor">${{ number_format($factura->total, 2, ',', '.') }}</div>
        </div>
    </div>

    @if($factura->observacion)
    <div style="clear:both;margin-top:15px;font-size:11px;background:#f8fafd;padding:8px 12px;border-radius:5px;">
        <strong>Observación:</strong> {{ $factura->observacion }}
    </div>
    @endif

    {{-- FOOTER --}}
    <div class="footer">
        <strong style="color:#378ADD;">FactuStock</strong> · Sistema de Facturación e Inventario · {{ date('Y') }}
    </div>

</body>
</html>