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
        max-width: 850px;
    }

    .seccion-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        padding: 1.5rem 1.8rem;
        margin-bottom: 1.2rem;
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
        margin-bottom: 1.2rem;
        padding-bottom: 0.6rem;
        border-bottom: 1px solid #f0f4f8;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
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
    .form-group select,
    .form-group textarea {
        height: 40px;
        border: 1.5px solid #D5D9E0;
        border-radius: 7px;
        padding: 0 0.8rem;
        font-size: 0.88rem;
        color: #333;
        outline: none;
        background: white;
        font-family: inherit;
    }

    .form-group textarea {
        height: auto;
        min-height: 80px;
        padding: 0.6rem 0.8rem;
        resize: vertical;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #378ADD;
        box-shadow: 0 0 0 3px rgba(55,138,221,0.12);
    }

    .form-group .hint {
        font-size: 0.7rem;
        color: #8A93A2;
        margin-top: 0.3rem;
    }

    .input-con-icono {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-con-icono .icono-prefijo {
        position: absolute;
        left: 0.7rem;
        color: #8A93A2;
        font-size: 0.9rem;
        pointer-events: none;
    }

    .input-con-icono input {
        padding-left: 2.1rem !important;
        width: 100%;
    }

    .form-actions {
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
        display: inline-flex;
        align-items: center;
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

    .info-box {
        background: #eef5fd;
        border-left: 3px solid #378ADD;
        padding: 0.7rem 1rem;
        border-radius: 6px;
        font-size: 0.78rem;
        color: #2C5985;
        margin-bottom: 1.2rem;
    }
</style>

<div class="form-header">
    <h2>Crear nuevo producto</h2>
    <div class="subtitle">Registra un nuevo producto en el catálogo del inventario</div>
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

<form method="POST" action="{{ route('productos.store') }}" autocomplete="off">
    @csrf

    <div class="form-container">

        {{-- ===== INFORMACIÓN DEL PRODUCTO ===== --}}
        <div class="seccion-card">
            <div class="seccion-titulo">
                <span>📦</span> Información del producto
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Código <span class="req">*</span></label>
                    <div class="input-con-icono">
                        <span class="icono-prefijo"></span>
                        <input type="text" name="codigo" value="{{ old('codigo') }}" required>
                    </div>
                    <div class="hint">Identificador único del producto</div>
                </div>

                <div class="form-group">
                    <label>Nombre <span class="req">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required>
                </div>

                <div class="form-group">
                    <label>Categoría</label>
                    <input type="text" name="categoria" value="{{ old('categoria') }}">
                    <div class="hint">Agrupa productos similares</div>
                </div>

                <div class="form-group">
                    <label>IVA (%) <span class="req">*</span></label>
                    <select name="iva" required>
                        <option value="">Seleccionar...</option>
                        <option value="0" {{ old('iva') === '0' ? 'selected' : '' }}>0% — Exento</option>
                        <option value="5" {{ old('iva') === '5' ? 'selected' : '' }}>5% — Reducido</option>
                        <option value="19" {{ old('iva') === '19' ? 'selected' : '' }}>19% — General</option>
                    </select>
                </div>
            </div>

            <div class="form-grid full" style="margin-top:1rem;">
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="descripcion">{{ old('descripcion') }}</textarea>
                    <div class="hint">Información adicional sobre el producto (opcional)</div>
                </div>
            </div>
        </div>

        {{-- ===== AVISO IMPORTANTE ===== --}}
        <div class="info-box">
            💡 <strong>Nota:</strong> El stock y el costo del producto se calculan automáticamente desde las entradas de mercancía registradas. Después de crear el producto podrás registrar entradas para asignarle stock inicial.
        </div>

        {{-- ===== BOTONES ===== --}}
        <div class="form-actions">
            <a href="{{ route('productos.index') }}" class="btn-cancelar">Cancelar</a>
            <button type="submit" class="btn-guardar">💾 Crear producto</button>
        </div>

    </div>
</form>

@endsection