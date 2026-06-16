@extends('layouts.app')

@section('content')

<style>
    /* ===== BARRA DE BÚSQUEDA + BOTÓN ===== */
    .top-bar {
        display: flex;
        gap: 0.8rem;
        margin-bottom: 1rem;
        align-items: center;
    }

    .search-bar {
        flex: 1;
        background: white;
        padding: 0.7rem 1rem;
        border-radius: 10px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .search-bar input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 0.85rem;
        padding: 0.3rem 0;
        color: #333;
    }

    .search-bar .icon {
        color: #8A93A2;
        font-size: 1rem;
    }

    .btn-nuevo {
        background: #378ADD;
        color: white;
        padding: 0.65rem 1.2rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.82rem;
        font-weight: 600;
        white-space: nowrap;
        transition: background 0.15s;
    }

    .btn-nuevo:hover { background: #2a7bc8; color: white; }

    /* ===== TABLA ===== */
    .tabla-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .tabla-card table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
    }

    .tabla-card thead {
        background: #f5f9ff;
        border-bottom: 2px solid #e2eaf3;
    }

    .tabla-card thead th {
        padding: 0.85rem 1rem;
        font-weight: 600;
        text-align: left;
        color: #378ADD;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .tabla-card tbody tr {
        border-bottom: 1px solid #f0f4f8;
        transition: background 0.1s;
    }

    .tabla-card tbody tr:hover { background: #f8fbff; }
    .tabla-card tbody tr:last-child { border-bottom: none; }

    .tabla-card tbody td {
        padding: 0.75rem 1rem;
        color: #444;
        vertical-align: middle;
    }

    /* ===== AVATAR CLIENTE ===== */
    .cliente-cell {
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }

    .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #378ADD, #6BB0EC);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .cliente-name {
        font-weight: 600;
        color: #2C3E50;
    }

    .cliente-id {
        font-size: 0.7rem;
        color: #8A93A2;
    }

    /* ===== CONTACTO ===== */
    .contacto-info {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        color: #555;
    }

    .contacto-info .icon-mini {
        color: #378ADD;
        font-size: 0.85rem;
    }

    /* ===== BOTONES DE ACCIÓN ===== */
    .acciones-cell {
        display: flex;
        gap: 0.4rem;
        justify-content: flex-end;
    }

    .btn-accion {
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.74rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        transition: opacity 0.15s;
    }

    .btn-accion:hover { opacity: 0.85; }

    .btn-editar {
        background: #f39c12;
        color: white;
    }

    .btn-eliminar {
        background: #e74c3c;
        color: white;
    }

    .tabla-empty {
        padding: 2.5rem;
        text-align: center;
        color: #8A93A2;
        font-size: 0.85rem;
    }
</style>

{{-- ===== BARRA DE BÚSQUEDA + BOTÓN NUEVO ===== --}}
<div class="top-bar">
    <div class="search-bar">
        <span class="icon">🔍</span>
        <input type="text" id="buscador" placeholder="Buscar por nombre, número de cédula, celular o dirección...">
    </div>
    <a href="{{ route('clientes.create') }}" class="btn-nuevo">＋ Nuevo Cliente</a>
</div>

{{-- ===== TABLA ===== --}}
<div class="tabla-card">
    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Cédula</th>
                <th>Celular</th>
                <th>Dirección</th>
                <th style="text-align:right;">Acciones</th>
            </tr>
        </thead>
        <tbody id="tabla-body">
            @forelse($clientes as $cliente)
            <tr>
                <td data-search="{{ $cliente->nombre }}">
                    <div class="cliente-cell">
                        <div class="avatar">{{ strtoupper(substr($cliente->nombre, 0, 2)) }}</div>
                        <div>
                            <div class="cliente-name">{{ $cliente->nombre }}</div>
                            <div class="cliente-id">ID #{{ str_pad($cliente->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                </td>
                <td data-search="{{ $cliente->cedula }}">
                    <div class="contacto-info">
                        <span class="icon-mini">🆔</span>
                        {{ $cliente->cedula ?? '—' }}
                    </div>
                </td>
                <td data-search="{{ $cliente->celular }}">
                    <div class="contacto-info">
                        <span class="icon-mini">📱</span>
                        {{ $cliente->celular ?? '—' }}
                    </div>
                </td>
                <td data-search="{{ $cliente->direccion }}">
                    <div class="contacto-info">
                        <span class="icon-mini">📍</span>
                        {{ $cliente->direccion ?? '—' }}
                    </div>
                </td>
                <td>
                    <div class="acciones-cell">
                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn-accion btn-editar">
                            ✏️ Editar
                        </a>
                        <form method="POST" action="{{ route('clientes.destroy', $cliente) }}" style="display:inline" onsubmit="return confirm('¿Eliminar al cliente {{ $cliente->nombre }}?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn-accion btn-eliminar">🗑️ Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="tabla-empty">No hay clientes registrados en el sistema.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    // Buscador en tiempo real (nombre, cédula, celular, dirección)
    document.getElementById('buscador').addEventListener('input', function(e) {
        const filtro = e.target.value.toLowerCase().trim();
        const filas = document.querySelectorAll('#tabla-body tr');
        filas.forEach(fila => {
            const celdas = fila.querySelectorAll('td[data-search]');
            let coincide = false;
            celdas.forEach(celda => {
                const valor = (celda.dataset.search || '').toLowerCase();
                if (valor.includes(filtro)) coincide = true;
            });
            fila.style.display = coincide ? '' : 'none';
        });
    });
</script>

@endsection