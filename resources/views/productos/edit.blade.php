@extends('layouts.app')

@section('content')

    <h2 style="color:#378ADD; margin-bottom:1rem;">Editar producto</h2>

    <div style="background:white;padding:1rem;border-radius:8px;max-width:420px;box-shadow:0 1px 4px rgba(0,0,0,0.08);">
        <form method="POST" action="{{ route('productos.update', $producto) }}">
            @csrf
            @method('PUT')

            <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                <label style="width:130px;font-size:0.8rem;color:#4F5869;flex-shrink:0;">Código</label>
                <div style="flex:1;">
                    <input type="text" name="codigo" value="{{ old('codigo', $producto->codigo) }}" style="width:100%;height:30px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 8px;font-size:0.8rem;" required>
                    @error('codigo') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                <label style="width:130px;font-size:0.8rem;color:#4F5869;flex-shrink:0;">Nombre</label>
                <div style="flex:1;">
                    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" style="width:100%;height:30px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 8px;font-size:0.8rem;" required>
                    @error('nombre') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                <label style="width:130px;font-size:0.8rem;color:#4F5869;flex-shrink:0;">Categoría</label>
                <div style="flex:1;">
                    <input type="text" name="categoria" value="{{ old('categoria', $producto->categoria) }}" style="width:100%;height:30px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 8px;font-size:0.8rem;">
                    @error('categoria') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div style="display:flex;align-items:center;margin-bottom:1rem;gap:0.75rem;">
                <label style="width:130px;font-size:0.8rem;color:#4F5869;flex-shrink:0;">IVA (%)</label>
                <div style="flex:1;">
                    <select name="iva" style="width:100%;height:30px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 8px;font-size:0.8rem;" required>
                        <option value="0" {{ old('iva', $producto->iva) == '0' ? 'selected' : '' }}>0% - Excluido</option>
                        <option value="5" {{ old('iva', $producto->iva) == '5' ? 'selected' : '' }}>5%</option>
                        <option value="19" {{ old('iva', $producto->iva) == '19' ? 'selected' : '' }}>19%</option>
                    </select>
                    @error('iva') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Info de stock y costo promedio (solo lectura) --}}
            <div style="background:#f0f4f8;border-radius:6px;padding:0.6rem 1rem;margin-bottom:1rem;font-size:0.78rem;color:#4F5869;">
                <div>📦 Stock actual: <strong>{{ $producto->stock }}</strong> unidades</div>
                <div>💰 Costo promedio: <strong>${{ number_format($producto->costo_promedio, 2) }}</strong></div>
            </div>

            <div style="border-top:1px solid #f0f4f8;padding-top:0.75rem;">
                <button type="submit" style="background:#378ADD;color:white;padding:0.4rem 1.2rem;border:none;border-radius:5px;cursor:pointer;font-size:0.82rem;">Guardar cambios</button>
                <a href="{{ route('productos.index') }}" style="margin-left:0.5rem;color:#8A93A2;font-size:0.8rem;text-decoration:none;">Cancelar</a>
            </div>

        </form>
    </div>

@endsection