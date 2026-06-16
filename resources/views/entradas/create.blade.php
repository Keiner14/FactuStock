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

    .consecutivo-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #e8f4fd;
        border: 1.5px solid #b5d4f4;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
        font-weight: 700;
        color: #185FA5;
        margin-bottom: 1.2rem;
        width: 100%;
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
    .form-group textarea {
        border: 1.5px solid #D5D9E0;
        border-radius: 7px;
        padding: 0 0.9rem;
        font-size: 0.85rem;
        color: #333;
        transition: border 0.15s, box-shadow 0.15s;
        outline: none;
        background: white;
    }

    .form-group input { height: 42px; }

    .form-group textarea {
        padding: 0.6rem 0.9rem;
        resize: vertical;
        min-height: 80px;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #378ADD;
        box-shadow: 0 0 0 3px rgba(55,138,221,0.12);
    }

    .form-group .error-msg {
        font-size: 0.72rem;
        color: #e74c3c;
        margin-top: 0.3rem;
    }

    /* Producto encontrado */
    .producto-info {
        display: none;
        background: #f0f9f0;
        border: 1.5px solid #c3e6cb;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        display: none;
    }

    .producto-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.6rem;
    }

    .producto-info-item {
        display: flex;
        flex-direction: column;
    }

    .producto-info-label {
        font-size: 0.68rem;
        color: #3B6D11;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .producto-info-value {
        font-size: 0.88rem;
        font-weight: 600;
        color: #27500A;
    }

    .producto-error {
        display: none;
        background: #FCEBEB;
        border: 1.5px solid #fca5a5;
        border-radius: 10px;
        padding: 0.8rem 1rem;
        margin-bottom: 1rem;
        font-size: 0.82rem;
        color: #791F1F;
        font-weight: 500;
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
    <h2>📥 Registrar Entrada de Mercancía</h2>
    <div class="subtitle">Registra el ingreso de productos al inventario</div>
</div>

<div class="form-card">

    <div class="consecutivo-badge">
        📋 Entrada N° {{ str_pad($consecutivo, 4, '0', STR_PAD_LEFT) }}
    </div>

    <form method="POST" action="{{ route('entradas.store') }}">
        @csrf

        <div class="seccion-titulo">
            <span>🔍</span> Buscar producto
        </div>

        <div class="form-grid full">
            <div class="form-group">
                <label>Código del producto <span class="req">*</span></label>
                <input type="text"
                       name="codigo_producto"
                       id="codigo_producto"
                       value="{{ old('codigo_producto') }}"
                       placeholder="Ingresa el código del producto..."
                       autofocus autocomplete="off">
                @error('codigo_producto')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Producto encontrado --}}
        <div class="producto-info" id="producto_info">
            <div class="producto-info-grid">
                <div class="producto-info-item">
                    <div class="producto-info-label">📦 Nombre</div>
                    <div class="producto-info-value" id="producto_nombre"></div>
                </div>
                <div class="producto-info-item">
                    <div class="producto-info-label">🏷️ Presentación</div>
                    <div class="producto-info-value" id="producto_categoria"></div>
                </div>
                <div class="producto-info-item">
                    <div class="producto-info-label">📊 Stock actual</div>
                    <div class="producto-info-value" id="producto_stock"></div>
                </div>
                <div class="producto-info-item">
                    <div class="producto-info-label">💰 Costo promedio</div>
                    <div class="producto-info-value" id="producto_costo"></div>
                </div>
            </div>
        </div>

        {{-- Producto no encontrado --}}
        <div class="producto-error" id="producto_error">
            ⚠️ Este código no existe en el inventario.
        </div>

        <div class="seccion-titulo">
            <span>📋</span> Datos de la entrada
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Cantidad <span class="req">*</span></label>
                <input type="number" name="cantidad"
                       value="{{ old('cantidad') }}"
                       min="1" required
                       placeholder="0">
                @error('cantidad')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Costo unitario <span class="req">*</span></label>
                <input type="number" step="0.01" name="costo_unitario"
                       value="{{ old('costo_unitario') }}"
                       min="0" required
                       placeholder="0.00">
                @error('costo_unitario')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-grid full">
            <div class="form-group">
                <label>Observación</label>
                <textarea name="observacion"
                          placeholder="Notas adicionales sobre esta entrada...">{{ old('observacion') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-guardar">💾 Registrar entrada</button>
            <a href="{{ route('entradas.index') }}" class="btn-cancelar">Cancelar</a>
        </div>

    </form>
</div>

<script>
    const codigoInput = document.getElementById('codigo_producto');
    const productoInfo = document.getElementById('producto_info');
    const productoError = document.getElementById('producto_error');

    codigoInput.addEventListener('blur', function () {
        const codigo = this.value.trim();
        if (!codigo) return;

        fetch(`{{ route('entradas.buscar') }}?codigo=${codigo}`)
            .then(res => res.json())
            .then(data => {
                if (data.encontrado) {
                    document.getElementById('producto_nombre').textContent = data.nombre;
                    document.getElementById('producto_categoria').textContent = data.categoria;
                    document.getElementById('producto_stock').textContent = data.stock + ' unidades';
                    document.getElementById('producto_costo').textContent = '$' + parseFloat(data.costo_promedio).toFixed(2);
                    productoInfo.style.display = 'block';
                    productoError.style.display = 'none';
                } else {
                    productoInfo.style.display = 'none';
                    productoError.style.display = 'block';
                }
            });
    });
</script>

@endsection