@extends('layouts.app')

@section('content')

<style>
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.active { display: flex; }

    .modal-box {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        text-align: center;
        animation: modalIn 0.2s ease;
    }

    @keyframes modalIn {
        from { transform: scale(0.92); opacity: 0; }
        to   { transform: scale(1);    opacity: 1; }
    }

    .modal-icono {
        width: 64px;
        height: 64px;
        background: #fdecea;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin: 0 auto 1.2rem;
    }

    .modal-titulo {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2C3E50;
        margin-bottom: 0.5rem;
    }

    .modal-desc {
        font-size: 0.85rem;
        color: #8A93A2;
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }

    .modal-nombre { color: #e74c3c; font-weight: 600; }

    .modal-btns {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }

    .btn-modal-cancelar {
        flex: 1;
        padding: 0.65rem;
        border-radius: 8px;
        border: 1.5px solid #D5D9E0;
        background: white;
        color: #4F5869;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: border-color 0.15s;
    }

    .btn-modal-cancelar:hover { border-color: #378ADD; color: #378ADD; }

    .btn-modal-eliminar {
        flex: 1;
        padding: 0.65rem;
        border-radius: 8px;
        border: none;
        background: #e74c3c;
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s;
    }

    .btn-modal-eliminar:hover { background: #c0392b; }
</style>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
    <h2 style="color:#378ADD;">Lista de Productos</h2>
    <a href="{{ route('productos.create') }}" style="background:#378ADD;color:white;padding:0.4rem 1rem;border-radius:6px;text-decoration:none;font-size:0.82rem;">+ Nuevo Producto</a>
</div>

<div style="display:flex;flex-direction:column;gap:0.6rem;">
    @foreach($productos as $producto)
    <div style="background:white;border-radius:8px;padding:0.9rem 1.2rem;display:flex;align-items:center;gap:1.5rem;border:1px solid #e2eaf3;">

        {{-- Numero --}}
        <div style="width:32px;height:32px;background:#378ADD;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:0.78rem;font-weight:700;flex-shrink:0;">
            {{ $loop->iteration }}
        </div>

        {{-- Nombre y categoria --}}
        <div style="flex:2;">
            <div style="font-weight:700;font-size:0.9rem;color:#0D1117;">{{ $producto->nombre }}</div>
            <div style="font-size:0.72rem;color:#8A93A2;">{{ $producto->categoria ?? 'Sin categoría' }} · Cód: {{ $producto->codigo }}</div>
        </div>

        {{-- Costo promedio --}}
        <div style="flex:1;text-align:center;">
            <div style="font-size:0.68rem;color:#8A93A2;margin-bottom:2px;">COSTO PROMEDIO</div>
            <div style="font-size:0.88rem;font-weight:600;">${{ number_format($producto->costo_promedio, 2) }}</div>
        </div>

        {{-- IVA --}}
        <div style="flex:1;text-align:center;">
            <div style="font-size:0.68rem;color:#8A93A2;margin-bottom:2px;">IVA</div>
            <div style="font-size:0.88rem;font-weight:600;color:#378ADD;">{{ $producto->iva }}%</div>
        </div>

        {{-- Stock --}}
        <div style="flex:1;text-align:center;">
            <div style="font-size:0.68rem;color:#8A93A2;margin-bottom:4px;">STOCK</div>
            @if($producto->stock > 10)
                <span style="background:#EAF3DE;color:#27500A;padding:0.2rem 0.7rem;border-radius:20px;font-size:0.75rem;font-weight:600;">{{ $producto->stock }}</span>
            @elseif($producto->stock > 0)
                <span style="background:#FEF3CD;color:#856404;padding:0.2rem 0.7rem;border-radius:20px;font-size:0.75rem;font-weight:600;">{{ $producto->stock }}</span>
            @else
                <span style="background:#FCEBEB;color:#791F1F;padding:0.2rem 0.7rem;border-radius:20px;font-size:0.75rem;font-weight:600;">0</span>
            @endif
        </div>

        {{-- Acciones --}}
        <div style="display:flex;gap:0.4rem;flex-shrink:0;">
            <a href="{{ route('productos.edit', $producto) }}"
               style="background:#f0f4f8;color:#378ADD;padding:0.3rem 0.8rem;border-radius:5px;text-decoration:none;font-size:0.78rem;font-weight:600;border:1px solid #e2eaf3;">
               Editar
            </a>

            {{-- Formulario oculto --}}
            <form id="form-eliminar-{{ $producto->id }}"
                  method="POST"
                  action="{{ route('productos.destroy', $producto) }}"
                  style="display:none;">
                @csrf
                @method('DELETE')
            </form>

            <button onclick="abrirModal({{ $producto->id }}, '{{ addslashes($producto->nombre) }}')"
                    style="background:#FCEBEB;color:#dc2626;padding:0.3rem 0.8rem;border-radius:5px;border:1px solid #fca5a5;cursor:pointer;font-size:0.78rem;font-weight:600;">
                Eliminar
            </button>
        </div>

    </div>
    @endforeach
</div>

{{-- MODAL --}}
<div class="modal-overlay" id="modalEliminar">
    <div class="modal-box">
        <div class="modal-icono">🗑️</div>
        <div class="modal-titulo">¿Eliminar producto?</div>
        <div class="modal-desc">
            Estás a punto de eliminar <span class="modal-nombre" id="modalNombre"></span>.<br>
            Esta acción no se puede deshacer.
        </div>
        <div class="modal-btns">
            <button class="btn-modal-cancelar" onclick="cerrarModal()">Cancelar</button>
            <button class="btn-modal-eliminar" onclick="confirmarEliminar()">Sí, eliminar</button>
        </div>
    </div>
</div>

<script>
    let formIdActual = null;

    function abrirModal(id, nombre) {
        formIdActual = id;
        document.getElementById('modalNombre').textContent = nombre;
        document.getElementById('modalEliminar').classList.add('active');
    }

    function cerrarModal() {
        formIdActual = null;
        document.getElementById('modalEliminar').classList.remove('active');
    }

    function confirmarEliminar() {
        if (formIdActual) {
            document.getElementById('form-eliminar-' + formIdActual).submit();
        }
    }

    document.getElementById('modalEliminar').addEventListener('click', function(e) {
        if (e.target === this) cerrarModal();
    });
</script>

@endsection