@extends('layouts.app')

@section('content')

    <h2 style="color:#378ADD; margin-bottom:1rem;">Registrar Entrada de Mercancía</h2>

    <div style="background:white;padding:1rem;border-radius:8px;max-width:480px;box-shadow:0 1px 4px rgba(0,0,0,0.08);">

        {{-- Consecutivo --}}
        <div style="background:#e8f4fd;border-radius:6px;padding:0.5rem 1rem;margin-bottom:1rem;font-size:0.82rem;color:#185FA5;font-weight:600;">
            📋 Entrada N° {{ str_pad($consecutivo, 4, '0', STR_PAD_LEFT) }}
        </div>

        <form method="POST" action="{{ route('entradas.store') }}">
            @csrf

            {{-- Codigo del producto --}}
            <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                <label style="width:150px;font-size:0.8rem;color:#4F5869;flex-shrink:0;">Código producto</label>
                <div style="flex:1;">
                    <input type="text" name="codigo_producto" id="codigo_producto" value="{{ old('codigo_producto') }}" style="width:100%;height:30px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 8px;font-size:0.8rem;" placeholder="Ingresa el código..." autofocus autocomplete="off">
                    @error('codigo_producto') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Info del producto encontrado --}}
            <div id="producto_info" style="display:none;background:#f0f9f0;border:1px solid #c3e6cb;border-radius:6px;padding:0.6rem 1rem;margin-bottom:0.75rem;font-size:0.8rem;">
                <div><strong>Nombre:</strong> <span id="producto_nombre"></span></div>
                <div><strong>Categoría:</strong> <span id="producto_categoria"></span></div>
                <div><strong>Stock actual:</strong> <span id="producto_stock"></span> unidades</div>
                <div><strong>Costo promedio actual:</strong> $<span id="producto_costo"></span></div>
            </div>

            {{-- Error producto no encontrado --}}
            <div id="producto_error" style="display:none;background:#FCEBEB;border:1px solid #f5c6cb;border-radius:6px;padding:0.6rem 1rem;margin-bottom:0.75rem;font-size:0.8rem;color:#791F1F;">
                ⚠ Este código no existe en el inventario.
            </div>

            {{-- Cantidad --}}
            <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                <label style="width:150px;font-size:0.8rem;color:#4F5869;flex-shrink:0;">Cantidad</label>
                <div style="flex:1;">
                    <input type="number" name="cantidad" value="{{ old('cantidad') }}" min="1" style="width:100%;height:30px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 8px;font-size:0.8rem;" required>
                    @error('cantidad') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Costo unitario --}}
            <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                <label style="width:150px;font-size:0.8rem;color:#4F5869;flex-shrink:0;">Costo unitario</label>
                <div style="flex:1;">
                    <input type="number" step="0.01" name="costo_unitario" value="{{ old('costo_unitario') }}" min="0" style="width:100%;height:30px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 8px;font-size:0.8rem;" required>
                    @error('costo_unitario') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Observacion --}}
            <div style="display:flex;align-items:center;margin-bottom:1rem;gap:0.75rem;">
                <label style="width:150px;font-size:0.8rem;color:#4F5869;flex-shrink:0;">Observación</label>
                <div style="flex:1;">
                    <textarea name="observacion" style="width:100%;border:1.5px solid #D5D9E0;border-radius:5px;padding:6px 8px;font-size:0.8rem;resize:vertical;" rows="2">{{ old('observacion') }}</textarea>
                </div>
            </div>

            <div style="border-top:1px solid #f0f4f8;padding-top:0.75rem;">
                <button type="submit" style="background:#378ADD;color:white;padding:0.4rem 1.2rem;border:none;border-radius:5px;cursor:pointer;font-size:0.82rem;">Registrar entrada</button>
                <a href="{{ route('entradas.index') }}" style="margin-left:0.5rem;color:#8A93A2;font-size:0.8rem;text-decoration:none;">Cancelar</a>
            </div>

        </form>
    </div>

    {{-- Script para buscar producto por codigo en tiempo real --}}
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
                        document.getElementById('producto_stock').textContent = data.stock;
                        document.getElementById('producto_costo').textContent = parseFloat(data.costo_promedio).toFixed(2);
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