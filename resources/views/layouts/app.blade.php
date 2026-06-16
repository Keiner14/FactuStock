<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FactuStock</title>
    <link rel="icon" type="image/png" href="{{ asset('images/factustock-logo.png') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: sans-serif; background: #f5f7fa; }

        .header {
            background: white;
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(55,138,221,0.15);
            border-bottom: 2px solid #e2eaf3;
        }

        .header img { height: 45px; margin-right: 10px; }
        .header h1 { font-size: 1.3rem; display: inline; color: #378ADD; font-weight: 700; }
        .usuario { color: #555; font-size: 0.85rem; margin-right: 0.75rem; }

        .logout {
            background: #378ADD;
            color: white;
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.82rem;
            font-weight: 600;
        }
        .logout:hover { background: #2a7bc8; }

        .layout { display: flex; min-height: calc(100vh - 57px); }

        .sidebar {
            width: 220px;
            background: white;
            border-right: 2px solid #e2eaf3;
            padding: 0.75rem 0;
        }

        .seccion {
            font-size: 0.68rem;
            color: #378ADD;
            padding: 0.9rem 1.2rem 0.3rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 700;
            border-top: 1px solid #edf2f7;
        }

        .seccion:first-child { border-top: none; }

        .sidebar a, .sidebar button {
            display: block;
            width: 100%;
            padding: 0.5rem 1rem;
            color: #555;
            text-decoration: none;
            font-size: 0.82rem;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
            border-left: 3px solid transparent;
        }

        .sidebar a:hover, .sidebar button:hover {
            background: #eef5fd;
            color: #378ADD;
            border-left: 3px solid #378ADD;
        }

        .submenu { display: none; background: #f5f7fa; }
        .submenu.abierto { display: block; }
        .submenu a { padding-left: 2rem; font-size: 0.78rem; color: #777; border-left: none; }
        .submenu a:hover { color: #378ADD; background: #eef5fd; border-left: none; }

        .contenido { flex: 1; padding: 1.5rem; }

        .alerta-ok {
            background: #EAF3DE;
            color: #27500A;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

<div class="header">
    <div style="display:flex;align-items:center;">
        <img src="{{ asset('images/factustock-logo.png') }}" alt="logo">
        <h1>FactuStock</h1>
    </div>
    <div style="display:flex;align-items:center;">
        <span class="usuario">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout">Cerrar sesión</button>
        </form>
    </div>
</div>

<div class="layout">
    <div class="sidebar">

        <div class="seccion">Principal</div>
        <a href="{{ url('dashboard') }}">🏠 Inicio</a>

        {{-- ===== GESTIONAR ===== --}}
        @if(auth()->user()->tienePermiso('usuarios') || auth()->user()->tienePermiso('clientes'))
            <div class="seccion">Gestión</div>

            @can('usuarios')
            <button onclick="abrir('usuarios')">👥 Usuarios ▾</button>
            <div class="submenu" id="usuarios">
                <a href="{{ url('usuarios') }}">Lista de usuarios</a>
                <a href="{{ url('usuarios/create') }}">Crear usuario</a>
            </div>
            @endcan

            @can('clientes')
            <button onclick="abrir('clientes')">🧑‍💼 Clientes ▾</button>
            <div class="submenu" id="clientes">
                <a href="{{ url('clientes') }}">Lista de clientes</a>
                <a href="{{ url('clientes/create') }}">Crear cliente</a>
            </div>
            @endcan
        @endif

        {{-- ===== INVENTARIO ===== --}}
        @if(auth()->user()->tienePermiso('productos') || auth()->user()->tienePermiso('entradas'))
            <div class="seccion">Inventario</div>
            <button onclick="abrir('inventario')">📦 Inventario ▾</button>
            <div class="submenu" id="inventario">
                @can('productos')
                    <a href="{{ url('productos/create') }}">Crear producto</a>
                @endcan
                @can('entradas')
                    <a href="{{ route('entradas.create') }}">Registrar entrada</a>
                    <a href="{{ route('entradas.index') }}">Historial entradas</a>
                @endcan
                @can('productos')
                    <a href="{{ url('productos') }}">Lista de productos</a>
                    <a href="{{ route('productos.consultar') }}">Consultar stock</a>
                    <a href="{{ route('productos.informe') }}">Informe existencias</a>
                @endcan
            </div>
        @endif

        {{-- ===== VENTAS ===== --}}
        @if(auth()->user()->tienePermiso('cotizaciones') || auth()->user()->tienePermiso('facturas'))
            <div class="seccion">Ventas</div>
            <button onclick="abrir('ventas')">💰 Ventas ▾</button>
            <div class="submenu" id="ventas">
                @can('cotizaciones')
                    <a href="{{ route('cotizaciones.index') }}">Cotizaciones</a>
                    <a href="{{ route('cotizaciones.create') }}">Nueva cotización</a>
                @endcan
                @can('facturas')
                    <a href="{{ route('facturas.index') }}">Facturas</a>
                    <a href="{{ route('facturas.create') }}">Nueva factura</a>
                @endcan
            </div>
        @endif

        {{-- ===== REPORTES ===== --}}
        @can('informe_facturacion')
            <div class="seccion">Reportes</div>
            <a href="{{ url('informes/facturacion') }}">📊 Informe facturación</a>
        @endcan

    </div>

    <div class="contenido">
        @if(session('success'))
            <div class="alerta-ok">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</div>

<script>
    function abrir(id) {
        document.getElementById(id).classList.toggle('abierto');
    }
</script>

</body>
</html>