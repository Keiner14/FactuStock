@extends('layouts.app')

@section('content')

<style>
    .form-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e2eaf3;
    }

    .form-header h2 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #378ADD;
        margin: 0;
    }

    .form-header .subtitle {
        font-size: 0.78rem;
        color: #8A93A2;
        margin-top: 0.2rem;
    }

    .form-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
    }

    @media (max-width: 900px) {
        .form-container { grid-template-columns: 1fr; }
    }

    .seccion-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        padding: 1.3rem 1.5rem;
    }

    .seccion-titulo {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.78rem;
        font-weight: 700;
        color: #378ADD;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
        padding-bottom: 0.6rem;
        border-bottom: 1px solid #f0f4f8;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.9rem;
    }

    .form-grid.full { grid-template-columns: 1fr; }

    .form-group { display: flex; flex-direction: column; }

    .form-group label {
        font-size: 0.74rem;
        font-weight: 600;
        color: #4F5869;
        margin-bottom: 0.35rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .form-group label .req { color: #e74c3c; }

    .form-group input,
    .form-group select {
        height: 38px;
        border: 1.5px solid #D5D9E0;
        border-radius: 7px;
        padding: 0 0.7rem;
        font-size: 0.85rem;
        color: #333;
        transition: border 0.15s, box-shadow 0.15s;
        outline: none;
        background: white;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #378ADD;
        box-shadow: 0 0 0 3px rgba(55,138,221,0.12);
    }

    .form-group .hint {
        font-size: 0.7rem;
        color: #8A93A2;
        margin-top: 0.3rem;
    }

    .permisos-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.6rem;
    }

    .permiso-item {
        background: #f8fbff;
        border: 1.5px solid #e2eaf3;
        border-radius: 8px;
        padding: 0.7rem 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        cursor: pointer;
        transition: all 0.15s;
    }

    .permiso-item:hover {
        border-color: #378ADD;
        background: #eef5fd;
    }

    .permiso-item input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: #378ADD;
        flex-shrink: 0;
    }

    .permiso-info { flex: 1; }

    .permiso-nombre {
        font-size: 0.82rem;
        font-weight: 600;
        color: #2C3E50;
    }

    .permiso-desc {
        font-size: 0.7rem;
        color: #8A93A2;
        margin-top: 0.15rem;
    }

    .permisos-acciones {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.8rem;
    }

    .btn-mini {
        background: white;
        border: 1.5px solid #D5D9E0;
        color: #4F5869;
        padding: 0.3rem 0.7rem;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-mini:hover { border-color: #378ADD; color: #378ADD; }

    .form-actions {
        grid-column: 1 / -1;
        display: flex;
        gap: 0.7rem;
        justify-content: flex-end;
        margin-top: 0.5rem;
    }

    .btn-guardar {
        background: #378ADD;
        color: white;
        padding: 0.7rem 1.6rem;
        border-radius: 8px;
        border: none;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-guardar:hover { background: #2a7bc8; }

    .btn-cancelar {
        background: white;
        color: #4F5869;
        padding: 0.7rem 1.6rem;
        border-radius: 8px;
        border: 1.5px solid #D5D9E0;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
    }

    .btn-cancelar:hover { border-color: #378ADD; color: #378ADD; }

    .error-msg {
        background: #fcebeb;
        color: #791f1f;
        padding: 0.6rem 0.9rem;
        border-radius: 8px;
        font-size: 0.8rem;
        margin-bottom: 1rem;
    }

    .error-msg ul { margin: 0; padding-left: 1.2rem; }

    .admin-aviso {
        background: #fff4e6;
        border: 1px solid #f39c12;
        color: #b45f06;
        padding: 0.6rem 0.9rem;
        border-radius: 8px;
        font-size: 0.75rem;
        margin-bottom: 0.8rem;
    }

    /* Checkbox deshabilitado para admin */
    .permiso-item input[type="checkbox"]:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .permiso-item:has(input:disabled) {
        opacity: 0.75;
        cursor: not-allowed;
    }
</style>

@php
    $listaPermisos = [
        'clientes'            => ['🧑‍💼 Clientes', 'Ver, crear, editar y eliminar clientes'],
        'productos'           => ['📦 Productos', 'Gestión del catálogo de productos'],
        'entradas'            => ['📥 Entradas de mercancía', 'Registrar entradas al inventario'],
        'cotizaciones'        => ['📋 Cotizaciones', 'Crear y consultar cotizaciones'],
        'facturas'            => ['📄 Facturas', 'Generar y consultar facturas'],
        'informe_facturacion' => ['📊 Informe de facturación', 'Acceso al reporte de facturación'],
        'usuarios'            => ['👥 Usuarios', 'Crear y administrar usuarios'],
    ];
@endphp

<div class="form-header">
    <h2>Crear nuevo usuario</h2>
    <div class="subtitle">Completa los datos del usuario y define sus permisos de acceso al sistema</div>
</div>

@if($errors->any())
<div class="error-msg">
    <strong>Por favor corrige los siguientes errores:</strong>
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('usuarios.store') }}" autocomplete="off">
    @csrf

    <div class="form-container">

        <div class="seccion-card">
            <div class="seccion-titulo">
                <span>👤</span> Información personal
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Nombre <span class="req">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>Apellidos <span class="req">*</span></label>
                    <input type="text" name="apellidos" value="{{ old('apellidos') }}" required>
                </div>

                <div class="form-group">
                    <label>Teléfono <span class="req">*</span></label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}" required>
                </div>

                <div class="form-group">
                    <label>Dirección <span class="req">*</span></label>
                    <input type="text" name="direccion" value="{{ old('direccion') }}" required>
                </div>
            </div>

            <div class="seccion-titulo" style="margin-top:1.5rem;">
                <span>🔐</span> Credenciales de acceso
            </div>

            <div class="form-grid full">
                <div class="form-group">
                    <label>Correo electrónico <span class="req">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required autocomplete="off">
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Contraseña <span class="req">*</span></label>
                    <input type="password" name="password" required autocomplete="new-password">
                    <div class="hint">Mínimo 8 caracteres</div>
                </div>

                <div class="form-group">
                    <label>Confirmar contraseña <span class="req">*</span></label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-grid full" style="margin-top:0.5rem;">
                <div class="form-group">
                    <label>Tipo de usuario <span class="req">*</span></label>
                    <select name="rol" id="rolSelect" required>
                        <option value="">Seleccionar...</option>
                        <option value="administrador" {{ old('rol') === 'administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="vendedor" {{ old('rol') === 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="seccion-card">
            <div class="seccion-titulo">
                <span>🛡️</span> Permisos de acceso
            </div>

            <div id="avisoAdmin" class="admin-aviso" style="display:none;">
                ℹ️ El rol <strong>Administrador</strong> tiene acceso a todos los módulos del sistema automáticamente.
            </div>

            <div class="permisos-acciones">
                <button type="button" class="btn-mini" onclick="marcarTodos(true)">✓ Seleccionar todos</button>
                <button type="button" class="btn-mini" onclick="marcarTodos(false)">✗ Desmarcar todos</button>
            </div>

            <div class="permisos-grid">
                @foreach($listaPermisos as $key => $info)
                <label class="permiso-item">
                    <input type="checkbox"
                           name="permisos[]"
                           value="{{ $key }}"
                           class="check-permiso"
                           {{ in_array($key, old('permisos', [])) ? 'checked' : '' }}>
                    <div class="permiso-info">
                        <div class="permiso-nombre">{{ $info[0] }}</div>
                        <div class="permiso-desc">{{ $info[1] }}</div>
                    </div>
                </label>
                @endforeach
            </div>

            <div class="hint" style="margin-top:1rem;font-size:0.72rem;color:#8A93A2;">
                💡 Los permisos definen a qué módulos podrá acceder el usuario dentro del sistema.
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('usuarios.index') }}" class="btn-cancelar">Cancelar</a>
            <button type="submit" class="btn-guardar">💾 Crear usuario</button>
        </div>

    </div>
</form>

<script>
    const rolSelect = document.getElementById('rolSelect');
    const avisoAdmin = document.getElementById('avisoAdmin');
    const checkboxes = document.querySelectorAll('.check-permiso');

    // Permisos por defecto para vendedor
    const permisosVendedor = ['clientes', 'cotizaciones', 'facturas'];

    function marcarTodos(estado) {
        // Solo funciona si no es admin
        if (rolSelect.value === 'administrador') return;
        checkboxes.forEach(c => {
            c.checked = estado;
            c.disabled = false;
        });
    }

    function actualizarSegunRol() {
        const rol = rolSelect.value;

        if (rol === 'administrador') {
            // Marcar todos y bloquear edición
            checkboxes.forEach(c => {
                c.checked = true;
                c.disabled = true;
            });
            avisoAdmin.style.display = 'block';

        } else if (rol === 'vendedor') {
            // Solo marcar los 3 por defecto, resto desmarcado, todos editables
            checkboxes.forEach(c => {
                c.checked = permisosVendedor.includes(c.value);
                c.disabled = false;
            });
            avisoAdmin.style.display = 'none';

        } else {
            // Sin rol: todo limpio
            checkboxes.forEach(c => {
                c.checked = false;
                c.disabled = false;
            });
            avisoAdmin.style.display = 'none';
        }
    }

    rolSelect.addEventListener('change', actualizarSegunRol);
    actualizarSegunRol(); // ejecutar al cargar
</script>

@endsection