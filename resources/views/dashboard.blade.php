@extends('layouts.app')

@section('content')

<style>
  .dash { font-family: inherit; padding: 0; }

  .hero {
    background: #0C447C;
    border-radius: 12px;
    padding: 2rem 2.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.2rem;
    position: relative;
    overflow: hidden;
    min-height: 130px;
  }

  .hero-watermark {
    position: absolute;
    right: 2rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 90px;
    font-weight: 700;
    color: rgba(255,255,255,0.06);
    letter-spacing: -2px;
    user-select: none;
    pointer-events: none;
    line-height: 1;
  }

  .hero-circle1 {
    position: absolute; right: -30px; top: -40px;
    width: 180px; height: 180px; border-radius: 50%;
    background: rgba(255,255,255,0.05);
  }
  .hero-circle2 {
    position: absolute; right: 80px; bottom: -50px;
    width: 120px; height: 120px; border-radius: 50%;
    background: rgba(255,255,255,0.04);
  }
  .hero-circle3 {
    position: absolute; left: -20px; bottom: -30px;
    width: 100px; height: 100px; border-radius: 50%;
    background: rgba(255,255,255,0.03);
  }

  .hero-content { position: relative; z-index: 1; }

  .hero-greeting {
    font-size: 13px;
    color: rgba(255,255,255,0.55);
    margin-bottom: 0.3rem;
    letter-spacing: 0.03em;
  }

  .hero-name {
    font-size: 22px;
    font-weight: 500;
    color: #fff;
    margin: 0 0 0.4rem;
  }

  .hero-name span { color: #7EC8F7; }

  .hero-sub {
    font-size: 12px;
    color: rgba(255,255,255,0.4);
  }

  .hero-right { position: relative; z-index: 1; text-align: right; }
  .hero-date { font-size: 12px; color: rgba(255,255,255,0.45); margin-bottom: 0.25rem; }
  .hero-time { font-size: 26px; font-weight: 500; color: rgba(255,255,255,0.9); letter-spacing: 2px; }

  .section-label {
    font-size: 11px; font-weight: 600;
    color: #8A93A2;
    text-transform: uppercase; letter-spacing: 0.08em;
    margin: 0 0 0.6rem;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 8px;
  }

  .stat-card {
    background: white;
    border: 1px solid #e8edf3;
    border-radius: 12px;
    padding: 0.9rem 1rem;
    transition: border-color 0.15s, box-shadow 0.15s;
    text-decoration: none;
    display: block;
  }
  .stat-card:hover {
    border-color: #378ADD;
    box-shadow: 0 2px 12px rgba(55,138,221,0.10);
  }

  .stat-icon {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; margin-bottom: 0.65rem;
  }

  .stat-icon.blue   { background: #E6F1FB; color: #185FA5; }
  .stat-icon.green  { background: #EAF3DE; color: #3B6D11; }
  .stat-icon.amber  { background: #FAEEDA; color: #854F0B; }
  .stat-icon.red    { background: #FCEBEB; color: #A32D2D; }
  .stat-icon.purple { background: #EEEDFE; color: #534AB7; }

  .stat-num   { font-size: 22px; font-weight: 700; color: #0C447C; line-height: 1; margin-bottom: 3px; }
  .stat-label { font-size: 11px; color: #8A93A2; text-transform: uppercase; letter-spacing: 0.05em; }
  .stat-link  { display: flex; align-items: center; gap: 3px; font-size: 10px; color: #aab; margin-top: 0.5rem; }
</style>

{{-- Hero --}}
<div class="hero">
    <div class="hero-circle1"></div>
    <div class="hero-circle2"></div>
    <div class="hero-circle3"></div>
    <div class="hero-watermark">FactuStock</div>

    <div class="hero-content">
        <div class="hero-greeting">Panel de control — FactuStock</div>
        <div class="hero-name">
            👋 Bienvenido, <span>{{ auth()->user()->name }}</span>
        </div>
        <div class="hero-sub">
            {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
        </div>
    </div>

    <div class="hero-right">
        <div class="hero-date" id="heroDate"></div>
        <div class="hero-time" id="heroTime"></div>
    </div>
</div>

{{-- Tarjetas --}}
<p class="section-label">Resumen general</p>

<div class="stats-grid">

    @can('clientes')
    <a href="{{ url('clientes') }}" class="stat-card">
        <div class="stat-icon blue">🧑‍💼</div>
        <div class="stat-num">{{ \App\Models\Cliente::count() }}</div>
        <div class="stat-label">Clientes</div>
        <div class="stat-link">→ Ver todos</div>
    </a>
    @endcan

    @can('cotizaciones')
    <a href="{{ route('cotizaciones.index') }}" class="stat-card">
        <div class="stat-icon green">📋</div>
        <div class="stat-num">{{ \App\Models\Cotizacion::count() }}</div>
        <div class="stat-label">Cotizaciones</div>
        <div class="stat-link">→ Ver todas</div>
    </a>
    @endcan

    @can('facturas')
    <a href="{{ route('facturas.index') }}" class="stat-card">
        <div class="stat-icon amber">📄</div>
        <div class="stat-num">{{ \App\Models\Factura::count() }}</div>
        <div class="stat-label">Facturas</div>
        <div class="stat-link">→ Ver todas</div>
    </a>
    @endcan

    @can('productos')
    <a href="{{ url('productos') }}" class="stat-card">
        <div class="stat-icon red">📦</div>
        <div class="stat-num">{{ \App\Models\Producto::count() }}</div>
        <div class="stat-label">Productos</div>
        <div class="stat-link">→ Ver todos</div>
    </a>
    @endcan

    @can('usuarios')
    <a href="{{ url('usuarios') }}" class="stat-card">
        <div class="stat-icon purple">👥</div>
        <div class="stat-num">{{ \App\Models\User::count() }}</div>
        <div class="stat-label">Usuarios</div>
        <div class="stat-link">→ Ver todos</div>
    </a>
    @endcan

</div>

<script>
    function updateTime() {
        const now = new Date();
        const dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
        const meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        document.getElementById('heroDate').textContent =
            dias[now.getDay()] + ', ' + now.getDate() + ' de ' + meses[now.getMonth()];
        const h = String(now.getHours()).padStart(2,'0');
        const m = String(now.getMinutes()).padStart(2,'0');
        document.getElementById('heroTime').textContent = h + ':' + m;
    }
    updateTime();
    setInterval(updateTime, 60000);
</script>

@endsection