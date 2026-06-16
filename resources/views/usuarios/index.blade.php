@extends('layouts.app')

@section('content')

<style>
    /* ===== ENCABEZADO ===== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e2eaf3;
    }

    .page-title-group h2 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #378ADD;
        margin: 0;
    }

    .page-title-group .subtitle {
        font-size: 0.78rem;
        color: #8A93A2;
        margin-top: 0.2rem;
    }

    .btn-nuevo {
        background: #378ADD;
        color: white;
        padding: 0.55rem 1.2rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.82rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: background 0.15s;
    }

    .btn-nuevo:hover { background: #2a7bc8; color: white; }

    /* ===== TARJETAS DE RESUMEN ===== */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: white;
        padding: 1rem 1.2rem;
        border-radius: 10px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 0.9rem;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        background: #eef5fd;
        color: #378ADD;
        flex-shrink: 0;
    }

    .stat-icon.admin { background: #fff4e6; color: #f39c12; }
    .stat-icon.vendedor { background: #e8f5e9; color: #1f8f4e; }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2C3E50;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.72rem;
        color: #8A93A2;
        margin-top: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* ===== BARRA DE BÚSQUEDA ===== */
    .search-bar {
        background: white;
        padding: 0.7rem 1rem;
        border-radius: 10px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        margin-bottom: 1rem;
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

    /* ===== AVATAR USUARIO ===== */
    .user-cell {
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

    .user-name {
        font-weight: 600;
        color: #2C3E50;
    }

    .user-id {
        font-size: 0.7rem;
        color: #8A93A2;
    }

    /* ===== BADGE DE ROL ===== */
    .badge-rol {
        display: inline-block;
        padding: 0.25rem 0.7rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .badge-admin {
        background: #fff4e6;
        color: #b45f06;
    }

    .badge-vendedor {
        background: #e8f5e9;
        color: #1f8f4e;
    }

    /* ===== BOTONES DE ACCIÓN ===== */
    .acciones-cell {
        display: flex;
        gap: 0.4rem;
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

{{-- ===== ENCABEZADO ===== --}}
<div class="page-header">
    <div class="page-title-group">
        <h2>Gestión de Usuarios</h2>
        <div class="subtitle">Administra los usuarios del sistema y sus roles</div>
    </div>
    <a href="{{ route('usuarios.create') }}" class="btn-nuevo">
        <span>＋</span> Nuevo Usuario
    </a>
</div>

{{-- ===== TARJETAS DE RESUMEN ===== --}}
@php
    $totalUsuarios = $usuarios->count();
    $totalAdmin = $usuarios->where('rol', 'administrador')->count();
    $totalVendedor = $usuarios->where('rol', 'vendedor')->count();
@endphp

<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div>
            <div class="stat-value">{{ $totalUsuarios }}</div>
            <div class="stat-label">Total de usuarios</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon admin">👑</div>
        <div>
            <div class="stat-value">{{ $totalAdmin }}</div>
            <div class="stat-label">Administradores</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon vendedor">🧑‍💼</div>
        <div>
            <div class="stat-value">{{ $totalVendedor }}</div>
            <div class="stat-label">Vendedores</div>
        </div>
    </div>
</div>

{{-- ===== BARRA DE BÚSQUEDA ===== --}}
<div class="search-bar">
    <span class="icon">🔍</span>
    <input type="text" id="buscador" placeholder="Buscar por nombre o correo electrónico...">
</div>

{{-- ===== TABLA ===== --}}
<div class="tabla-card">
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Correo electrónico</th>
                <th>Rol</th>
                <th style="text-align:right;">Acciones</th>
            </tr>
        </thead>
        <tbody id="tabla-body">
            @forelse($usuarios as $usuario)
            <tr>
                <td>
                    <div class="user-cell">
                        <div class="avatar">{{ strtoupper(substr($usuario->name, 0, 2)) }}</div>
                        <div>
                            <div class="user-name">{{ $usuario->name }}</div>
                            <div class="user-id">ID #{{ str_pad($usuario->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $usuario->email }}</td>
                <td>
                    @if($usuario->rol === 'administrador')
                        <span class="badge-rol badge-admin">Administrador</span>
                    @else
                        <span class="badge-rol badge-vendedor">Vendedor</span>
                    @endif
                </td>
                <td>
                    <div class="acciones-cell" style="justify-content:flex-end;">
                        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn-accion btn-editar">
                            ✏️ Editar
                        </a>
                        <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" style="display:inline" onsubmit="return confirm('¿Eliminar al usuario {{ $usuario->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn-accion btn-eliminar">🗑️ Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="tabla-empty">No hay usuarios registrados en el sistema.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    // Buscador en tiempo real
    document.getElementById('buscador').addEventListener('input', function(e) {
        const filtro = e.target.value.toLowerCase();
        const filas = document.querySelectorAll('#tabla-body tr');
        filas.forEach(fila => {
            const texto = fila.textContent.toLowerCase();
            fila.style.display = texto.includes(filtro) ? '' : 'none';
        });
    });
</script>

@endsection