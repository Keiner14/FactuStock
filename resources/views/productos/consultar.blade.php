@extends('layouts.app')

@section('content')

    <h2 style="color:#378ADD; margin-bottom:1rem;">Consultar Existencias</h2>

    <div style="background:white;padding:1rem;border-radius:8px;max-width:500px;box-shadow:0 1px 4px rgba(0,0,0,0.08);margin-bottom:1rem;">
        <form method="GET" action="{{ route('productos.consultar') }}">

            <div style="display:flex;align-items:center;gap:0.75rem;">
                <input
                    type="text"
                    name="busqueda"
                    value="{{ $busqueda ?? '' }}"
                    placeholder="Buscar por nombre o código..."
                    style="flex:1;height:36px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 10px;font-size:0.85rem;"
                    autofocus>
                <button type="submit" style="background:#378ADD;color:white;padding:0.4rem 1.2rem;border:none;border-radius:5px;cursor:pointer;font-size:0.85rem;">
                    Buscar
                </button>
            </div>

        </form>
    </div>

    {{-- Resultado de la busqueda --}}
    @if($busqueda)
        @if($producto)
            <div style="background:white;padding:1.2rem;border-radius:8px;max-width:500px;box-shadow:0 1px 4px rgba(0,0,0,0.08);">
                <h3 style="color:#378ADD;margin-bottom:1rem;font-size:1rem;">Resultado de la búsqueda</h3>

                <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                    <label style="width:140px;font-size:0.8rem;color:#4F5869;font-weight:600;">Nombre:</label>
                    <span style="font-size:0.85rem;">{{ $producto->nombre }}</span>
                </div>

                <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                    <label style="width:140px;font-size:0.8rem;color:#4F5869;font-weight:600;">Código:</label>
                    <span style="font-size:0.85rem;">{{ $producto->codigo }}</span>
                </div>

                <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                    <label style="width:140px;font-size:0.8rem;color:#4F5869;font-weight:600;">Categoría:</label>
                    <span style="font-size:0.85rem;">{{ $producto->categoria ?? 'Sin categoría' }}</span>
                </div>

                <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                    <label style="width:140px;font-size:0.8rem;color:#4F5869;font-weight:600;">Precio de venta:</label>
                    <span style="font-size:0.85rem;">${{ number_format($producto->precio_venta, 2) }}</span>
                </div>

                <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                    <label style="width:140px;font-size:0.8rem;color:#4F5869;font-weight:600;">Stock disponible:</label>
                    @if($producto->stock > 10)
                        <span style="background:#EAF3DE;color:#27500A;padding:0.2rem 0.7rem;border-radius:5px;font-size:0.85rem;font-weight:600;">
                            {{ $producto->stock }} unidades
                        </span>
                    @elseif($producto->stock > 0)
                        <span style="background:#FEF3CD;color:#856404;padding:0.2rem 0.7rem;border-radius:5px;font-size:0.85rem;font-weight:600;">
                            {{ $producto->stock }} unidades (stock bajo)
                        </span>
                    @else
                        <span style="background:#FCEBEB;color:#791F1F;padding:0.2rem 0.7rem;border-radius:5px;font-size:0.85rem;font-weight:600;">
                            Sin stock
                        </span>
                    @endif
                </div>

            </div>
        @else
            <div style="background:#FCEBEB;color:#791F1F;padding:0.75rem 1rem;border-radius:8px;max-width:500px;font-size:0.875rem;">
                No se encontró ningún producto con ese nombre o código.
            </div>
        @endif
    @endif

@endsection