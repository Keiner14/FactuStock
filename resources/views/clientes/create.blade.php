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

    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        padding: 1.5rem;
        max-width: 580px;
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
        gap: 1rem;
        margin-bottom: 1rem;
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

    .form-group input {
        height: 42px;
        border: 1.5px solid #D5D9E0;
        border-radius: 7px;
        padding: 0 0.9rem;
        font-size: 0.85rem;
        color: #333;
        transition: border 0.15s, box-shadow 0.15s;
        outline: none;
        background: white;
    }

    .form-group input:focus {
        border-color: #378ADD;
        box-shadow: 0 0 0 3px rgba(55,138,221,0.12);
    }

    .form-group .error-msg {
        font-size: 0.72rem;
        color: #e74c3c;
        margin-top: 0.3rem;
    }

    .avatar-preview {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #f8fbff;
        border: 1.5px solid #e2eaf3;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.2rem;
    }

    .avatar-circle {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: linear-gradient(135deg, #378ADD, #6BB0EC);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .avatar-info .nombre-preview {
        font-size: 0.95rem;
        font-weight: 600;
        color: #2C3E50;
    }

    .avatar-info .id-preview {
        font-size: 0.72rem;
        color: #8A93A2;
        margin-top: 2px;
    }

    .form-actions {
        display: flex;
        gap: 0.7rem;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #f0f4f8;
        margin-top: 0.5rem;
    }

    .btn-guardar {
        background: #378ADD;
        color: white;
        padding: 0.7rem 1.8rem;
        border-radius: 8px;
        border: none;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s;
    }

    .btn-guardar:hover { background: #2a7bc8; }

    .btn-cancelar {
        background: white;
        color: #4F5869;
        padding: 0.7rem 1.4rem;
        border-radius: 8px;
        border: 1.5px solid #D5D9E0;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: border-color 0.15s;
    }

    .btn-cancelar:hover { border-color: #378ADD; color: #378ADD; }
</style>

<div class="form-header">
    <h2>🧑‍💼 Crear nuevo cliente</h2>
    <div class="subtitle">Completa los datos para registrar un nuevo cliente en el sistema</div>
</div>

<div class="form-card">

    <div class="avatar-preview">
        <div class="avatar-circle" id="avatarCircle">?</div>
        <div class="avatar-info">
            <div class="nombre-preview" id="nombrePreview">Nombre del cliente</div>
            <div class="id-preview">Nuevo cliente</div>
        </div>
    </div>

    <form method="POST" action="{{ route('clientes.store') }}">
        @csrf

        <div class="seccion-titulo">
            <span>📋</span> Información del cliente
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Nombre <span class="req">*</span></label>
                <input type="text" name="nombre" id="inputNombre"
                       value="{{ old('nombre') }}" required>
                @error('nombre')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Cédula <span class="req">*</span></label>
                <input type="text" name="cedula"
                       value="{{ old('cedula') }}" required>
                @error('cedula')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Celular <span class="req">*</span></label>
                <input type="text" name="celular"
                       value="{{ old('celular') }}" required>
                @error('celular')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Dirección <span class="req">*</span></label>
                <input type="text" name="direccion"
                       value="{{ old('direccion') }}" required>
                @error('direccion')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Email campo completo --}}
        <div class="form-grid full">
            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="ejemplo@correo.com">
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-guardar">💾 Crear cliente</button>
            <a href="{{ route('clientes.index') }}" class="btn-cancelar">Cancelar</a>
        </div>

    </form>
</div>

<script>
    const inputNombre = document.getElementById('inputNombre');
    const avatarCircle = document.getElementById('avatarCircle');
    const nombrePreview = document.getElementById('nombrePreview');

    inputNombre.addEventListener('input', function() {
        const val = this.value.trim();
        avatarCircle.textContent = val.length >= 2
            ? val.substring(0, 2).toUpperCase()
            : (val.length === 1 ? val.toUpperCase() : '?');
        nombrePreview.textContent = val || 'Nombre del cliente';
    });
</script>

@endsection