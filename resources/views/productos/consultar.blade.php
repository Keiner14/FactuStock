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

    .search-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        padding: 1.2rem 1.5rem;
        max-width: 580px;
        margin-bottom: 1.2rem;
    }

    .search-input-group {
        display: flex;
        gap: 0.7rem;
        align-items: center;
    }

    .search-input-group input {
        flex: 1;
        height: 42px;
        border: 1.5px solid #D5D9E0;
        border-radius: 7px;
        padding: 0 0.9rem;
        font-size: 0.85rem;
        color: #333;
        outline: none;
        transition: border 0.15s, box-shadow 0.15s;
    }

    .search-input-group input:focus {
        border-color: #378ADD;
        box-shadow: 0 0 0 3px rgba(55,138,221,0.12);
    }

    .btn-buscar {
        background: #378ADD;
        color: white;
        padding: 0 1.5rem;
        height: 42px;
        border: none;
        border-radius: 7px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.15s;
    }

    .btn-buscar:hover { background: #2a7bc8; }

    .resultado-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        max-width: 580px;
        overflow: hidden;
    }

    .resultado-header {
        background: linear-gradient(135deg, #0C447C, #378ADD);
        padding: 1.2rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .resultado-avatar {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .resultado-nombre {
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
    }

    .resultado-codigo {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.6);
        margin-top: 2px;
    }

    .resultado-body {
        padding: 1.2rem 1.5rem;
    }

    .dato-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.7rem 0;
        border-bottom: 1px solid #f0f4f8;
        font-size: 0.85rem;
    }

    .dato-row:last-child { border-bottom: none; }

    .dato-label {
        color: #8A93A2;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .dato-valor {
        font-weight: 600;
        color: #2C3E50;
    }

    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .badge-green  { background: #EAF3DE; color: #27500A; }
    .badge-yellow { background: #FEF3CD; color: #856404; }
    .badge-red    { background: #FCEBEB; color: #791F1F; }

    .no-encontrado {
        background: #FCEBEB;
        border: 1.5px solid #fca5a5;
        color: #791F1F;
        padding: 1rem 1.2rem;
        border-radius: 10px;
        max-width: 580px;
        font-size: 0.85rem;
        font-weight: 500;
    }
</style>

<div class="form-header">
    <h2>🔍 Consultar Existencias</h2>
    <div class="subtitle">Busca un producto por nombre o código para ver su stock</div>
</div>

<div class="search-card">
    <form method="GET" action="{{ route('productos.consultar') }}">
        <div class="search-input-group">
            <input type="text"
                   name="busqueda"
                   value="{{ $busqueda ?? '' }}"
                   placeholder="Buscar por nombre o código del producto..."
                   autofocus>
            <button type="submit" class="btn-buscar">🔍 Buscar</button>
        </div>
    </form>
</div>

@if($busqueda)
    @if($producto)
        <div class="resultado-card">
            <div class="resultado-header">
                <div class="resultado-avatar">📦</div>
                <div>
                    <div class="resultado-nombre">{{ $producto->nombre }}</div>
                    <div class="resultado-codigo">Cód: {{ $producto->codigo }}</div>
                </div>
            </div>
            <div class="resultado-body">
                <div class="dato-row">
                    <span class="dato-label">🏷️ Presentación</span>
                    <span class="dato-valor">{{ $producto->categoria ?? 'Sin categoría' }}</span>
                </div>
                <div class="dato-row">
                    <span class="dato-label">💰 Costo unitario</span>
                    <span class="dato-valor">${{ number_format($producto->costo_promedio, 2) }}</span>
                </div>
                <div class="dato-row">
                    <span class="dato-label">📊 IVA</span>
                    <span class="dato-valor">{{ $producto->iva }}%</span>
                </div>
                <div class="dato-row">
                    <span class="dato-label">📦 Stock disponible</span>
                    @if($producto->stock > 10)
                        <span class="badge badge-green">{{ $producto->stock }} unidades</span>
                    @elseif($producto->stock > 0)
                        <span class="badge badge-yellow">{{ $producto->stock }} unidades — Stock bajo</span>
                    @else
                        <span class="badge badge-red">Sin stock</span>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="no-encontrado">
            ⚠️ No se encontró ningún producto con ese nombre o código.
        </div>
    @endif
@endif

@endsection