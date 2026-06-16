@extends('layouts.app')

@section('content')

<style>
    .inicio-hero {
        position: relative;
        min-height: 240px;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, #0C447C 0%, #378ADD 100%);
        box-shadow: 0 4px 24px rgba(55,138,221,0.25);
    }

    .inicio-hero-logo {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.07;
    }

    .inicio-hero-logo img {
        width: 380px;
        filter: brightness(10);
    }

    .inicio-hero-texto {
        position: relative;
        text-align: center;
        color: white;
        padding: 1rem;
    }

    .inicio-hero-texto h2 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .inicio-hero-texto p {
        font-size: 1rem;
        opacity: 0.85;
    }

    .cards-resumen {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 1.2rem;
        margin-bottom: 2rem;
    }

    .card-stat {
        background: white;
        border-radius: 12px;
        padding: 1.4rem 1.5rem;
        box-shadow: 0 2px 12px rgba(55,138,221,0.10);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.15s, box-shadow 0.15s;
        text-decoration: none;
        cursor: pointer;
    }

    .card-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 20px rgba(55,138,221,0.18);
    }

    .card-stat:nth-child(1) { border-left: 4px solid #378ADD; }
    .card-stat:nth-child(2) { border-left: 4px solid #27ae60; }
    .card-stat:nth-child(3) { border-left: 4px solid #f39c12; }
    .card-stat:nth-child(4) { border-left: 4px solid #e74c3c; }
    .card-stat:nth-child(5) { border-left: 4px solid #8e44ad; }

    .card-stat .icono { font-size: 2.2rem; line-height: 1; }

    .card-stat .info .numero {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0C447C;
        line-height: 1;
    }

    .card-stat .info .etiqueta {
        font-size: 0.78rem;
        color: #888;
        margin-top: 0.3rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>

{{-- Hero con logo de fondo --}}
<div class="inicio-hero">
    <div class="inicio-hero-logo">
        <img src="{{ asset('images/factustock-logo.png') }}" alt="logo fondo">
    </div>
    <div class="inicio-hero-texto">
        <h2>👋 Bienvenido, {{ auth()->user()->name }}</h2>
        <p>{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</p>
        <p style="margin-top:0.5rem; font-size:0.9rem; opacity:0.7;">Panel de control — FactuStock</p>
    </div>
</div>

{{-- Tarjetas de resumen --}}
<div class="cards-resumen">

    @can('vendedor')
    <a href="{{ url('clientes') }}" class="card-stat">
        <div class="icono">🧑‍💼</div>
        <div class="info">
            <div class="numero">{{ \App\Models\Cliente::count() }}</div>
            <div class="etiqueta">Clientes</div>
        </div>
    </a>

    <a href="{{ route('cotizaciones.index') }}" class="card-stat">
        <div class="icono">📋</div>
        <div class="info">
            <div class="numero">{{ \App\Models\Cotizacion::count() }}</div>
            <div class="etiqueta">Cotizaciones</div>
        </div>
    </a>

    <a href="{{ route('facturas.index') }}" class="card-stat">
        <div class="icono">📄</div>
        <div class="info">
            <div class="numero">{{ \App\Models\Factura::count() }}</div>
            <div class="etiqueta">Facturas</div>
        </div>
    </a>
    @endcan

    @can('admin')
    <a href="{{ url('productos') }}" class="card-stat">
        <div class="icono">📦</div>
        <div class="info">
            <div class="numero">{{ \App\Models\Producto::count() }}</div>
            <div class="etiqueta">Productos</div>
        </div>
    </a>

    <a href="{{ url('usuarios') }}" class="card-stat">
        <div class="icono">👥</div>
        <div class="info">
            <div class="numero">{{ \App\Models\User::count() }}</div>
            <div class="etiqueta">Usuarios</div>
        </div>
    </a>
    @endcan

</div>

@endsection