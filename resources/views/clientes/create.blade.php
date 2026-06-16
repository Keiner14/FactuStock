@extends('layouts.app')

@section('content')

    <h2 style="color:#378ADD; margin-bottom:1rem;">Crear nuevo cliente</h2>

    <div style="background:white;padding:1rem;border-radius:8px;max-width:420px;box-shadow:0 1px 4px rgba(0,0,0,0.08);">
        <form method="POST" action="{{ route('clientes.store') }}">
            @csrf

            <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                <label style="width:130px;font-size:0.8rem;color:#4F5869;flex-shrink:0;">Nombre</label>
                <div style="flex:1;">
                    <input type="text" name="nombre" value="{{ old('nombre') }}" style="width:100%;height:30px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 8px;font-size:0.8rem;" required>
                    @error('nombre') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                <label style="width:130px;font-size:0.8rem;color:#4F5869;flex-shrink:0;">Cédula</label>
                <div style="flex:1;">
                    <input type="text" name="cedula" value="{{ old('cedula') }}" style="width:100%;height:30px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 8px;font-size:0.8rem;" required>
                    @error('cedula') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div style="display:flex;align-items:center;margin-bottom:0.6rem;gap:0.75rem;">
                <label style="width:130px;font-size:0.8rem;color:#4F5869;flex-shrink:0;">Celular</label>
                <div style="flex:1;">
                    <input type="text" name="celular" value="{{ old('celular') }}" style="width:100%;height:30px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 8px;font-size:0.8rem;" required>
                    @error('celular') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div style="display:flex;align-items:center;margin-bottom:1rem;gap:0.75rem;">
                <label style="width:130px;font-size:0.8rem;color:#4F5869;flex-shrink:0;">Dirección</label>
                <div style="flex:1;">
                    <input type="text" name="direccion" value="{{ old('direccion') }}" style="width:100%;height:30px;border:1.5px solid #D5D9E0;border-radius:5px;padding:0 8px;font-size:0.8rem;" required>
                    @error('direccion') <small style="color:red;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div style="border-top:1px solid #f0f4f8;padding-top:0.75rem;">
                <button type="submit" style="background:#378ADD;color:white;padding:0.4rem 1.2rem;border:none;border-radius:5px;cursor:pointer;font-size:0.82rem;">Crear cliente</button>
                <a href="{{ route('clientes.index') }}" style="margin-left:0.5rem;color:#8A93A2;font-size:0.8rem;text-decoration:none;">Cancelar</a>
            </div>

        </form>
    </div>

@endsection