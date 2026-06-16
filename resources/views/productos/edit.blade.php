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

    .form-group input,
    .form-group select {
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

    .form-group input:focus,
    .form-group select:focus {
        border-color: #378ADD;
        box-shadow: 0 0 0 3px rgba(55,138,221,0.12);
    }

    .form-group .error-msg {
        font-size: 0.72rem;
        color: #e74c3c;
        margin-top: 0.3rem;
    }

    .info-card {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.8rem;
        margin-bottom: 1.2rem;
    }

    .info-item {
        background: #f8fbff;
        border: 1.5px solid #e2eaf3;
        border-radius: 10px;
        padding: 0.9rem 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .info-item .info-label {
        font-size: 0.7rem;
        color: #8A93A2;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }

    .info-item .info-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0C447C;
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

    .stock-badge {
        display: inline-block;
        padding: 0.2rem 0.7rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>

<div class="form-header">
    <h2>📦 Editar producto</h2>
    <div class="subtitle">Modifica los datos del producto y guarda los cambios</div>
</div>

<div class="form-card">

    {{-- Info stock y costo --}}
    <div class="info-card">
        <div class="info-item">
            <div class="info-label">📦 Stock actual</div>
            <div class="info-value">
                @if($producto->stock > 10)
                    <span class="stock-badge" style="background:#EAF3DE;color:#27500A;">{{ $producto->stock }} und</span>
                @elseif($producto->stock > 0)
                    <span class="stock-badge" style="background:#FEF3CD;color:#856404;">{{ $producto->stock }} und</span>
                @else
                    <span class="stock-badge" style="background:#FCEBEB;color:#791F1F;">Sin stock</span>
                @endif
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">💰 Costo promedio</div>
            <div class="info-value">${{ number_format($producto->costo_promedio, 2) }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('productos.update', $producto) }}">
        @csrf
        @method('PUT')

        <div class="seccion-titulo">
            <span>📋</span> Información del producto
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Código <span class="req">*</span></label>
                <input type="text" name="codigo"
                       value="{{ old('codigo', $producto->codigo) }}" required>
                @error('codigo')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Nombre <span class="req">*</span></label>
                <input type="text" name="nombre"
                       value="{{ old('nombre', $producto->nombre) }}" required>
                @error('nombre')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Presentación</label>
                <select name="categoria">
                    <option value="">Seleccionar...</option>
                    <option value="und"  {{ old('categoria', $producto->categoria) === 'und'  ? 'selected' : '' }}>Unidad (und)</option>
                    <option value="caja" {{ old('categoria', $producto->categoria) === 'caja' ? 'selected' : '' }}>Caja</option>
                    <option value="kg"   {{ old('categoria', $producto->categoria) === 'kg'   ? 'selected' : '' }}>Kilo (kg)</option>
                    <option value="mts"  {{ old('categoria', $producto->categoria) === 'mts'  ? 'selected' : '' }}>Metro (mts)</option>
                    <option value="lt"   {{ old('categoria', $producto->categoria) === 'lt'   ? 'selected' : '' }}>Litro (lt)</option>
                </select>
                @error('categoria')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>IVA (%) <span class="req">*</span></label>
                <select name="iva" required>
                    <option value="0"  {{ old('iva', $producto->iva) == '0'  ? 'selected' : '' }}>0% — Excluido</option>
                    <option value="5"  {{ old('iva', $producto->iva) == '5'  ? 'selected' : '' }}>5%</option>
                    <option value="19" {{ old('iva', $producto->iva) == '19' ? 'selected' : '' }}>19%</option>
                </select>
                @error('iva')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-guardar">💾 Guardar cambios</button>
            <a href="{{ route('productos.index') }}" class="btn-cancelar">Cancelar</a>
        </div>

    </form>
</div>

@endsection