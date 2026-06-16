@extends('layouts.app')

@section('content')

<style>
  .hero-wrap {
    border-radius: 14px;
    overflow: hidden;
    display: grid;
    grid-template-columns: 1fr 1fr;
    border: 1px solid #e2eaf3;
    min-height: calc(100vh - 120px);
  }

  .hero-left {
    background: #0C447C;
    padding: 3rem;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
  }

  .op2-arc {
    position: absolute; right: -50px; top: -50px;
    width: 220px; height: 220px; border-radius: 50%;
    border: 45px solid rgba(255,255,255,0.05);
  }
  .op2-arc2 {
    position: absolute; right: -20px; bottom: -60px;
    width: 170px; height: 170px; border-radius: 50%;
    border: 35px solid rgba(255,255,255,0.04);
  }
  .op2-arc3 {
    position: absolute; left: -40px; top: 40%;
    width: 130px; height: 130px; border-radius: 50%;
    border: 25px solid rgba(255,255,255,0.03);
  }

  .hero-brand {
    font-size: 11px;
    letter-spacing: 0.18em;
    color: rgba(255,255,255,0.3);
    text-transform: uppercase;
    position: relative;
    z-index: 1;
  }

  .hero-center {
    position: relative;
    z-index: 1;
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 2rem 0;
  }

  .hero-emoji {
    font-size: 52px;
    margin-bottom: 1.2rem;
    display: block;
  }

  .hero-welcome {
    font-size: 20px;
    color: rgba(255,255,255,0.55);
    margin-bottom: 0.5rem;
  }

  .hero-name {
    font-size: 48px;
    font-weight: 500;
    color: #fff;
    line-height: 1.1;
  }

  .hero-name span { color: #7EC8F7; }

  .hero-bottom {
    position: relative;
    z-index: 1;
    text-align: center;
  }

  .hero-date {
    font-size: 13px;
    color: rgba(255,255,255,0.35);
  }

  /* Derecha */
  .hero-right {
    background: white;
    padding: 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .time-block {
    text-align: center;
    padding: 1.5rem 0;
    border-bottom: 1px solid #f0f4f8;
    margin-bottom: 1.5rem;
  }

  .time-num {
    font-size: 64px;
    font-weight: 500;
    color: #0C447C;
    letter-spacing: 4px;
    line-height: 1;
  }

  .time-lbl {
    font-size: 11px;
    color: #8A93A2;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-top: 8px;
  }

  .stats-list {
    display: flex;
    flex-direction: column;
    gap: 0;
    flex: 1;
    justify-content: center;
  }

  .stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid #f0f4f8;
    text-decoration: none;
    transition: all 0.15s;
    border-radius: 0;
  }

  .stat-row:last-child { border-bottom: none; }

  .stat-row:hover {
    background: #f8fbff;
    border-radius: 8px;
    padding-left: 8px;
    padding-right: 8px;
  }

  .stat-row-left {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: #4F5869;
  }

  .stat-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
  }

  .stat-row-num {
    font-size: 20px;
    font-weight: 500;
    color: #0C447C;
  }
</style>

<div class="hero-wrap">

  {{-- Lado izquierdo --}}
  <div class="hero-left">
    <div class="op2-arc"></div>
    <div class="op2-arc2"></div>
    <div class="op2-arc3"></div>

    <div class="hero-brand">FactuStock · Panel de control</div>

    <div class="hero-center">
      <span class="hero-emoji">👋</span>
      <div class="hero-welcome">Bienvenido,</div>
      <div class="hero-name">
        <span>{{ auth()->user()->name }}</span>
      </div>
    </div>

    <div class="hero-bottom">
      <div class="hero-date" id="heroDate"></div>
    </div>
  </div>

  {{-- Lado derecho --}}
  <div class="hero-right">

    <div class="time-block">
      <div class="time-num" id="heroTime">--:--</div>
      <div class="time-lbl">Hora local</div>
    </div>

    <div class="stats-list">

      @can('clientes')
      <a href="{{ url('clientes') }}" class="stat-row">
        <span class="stat-row-left">
          <span class="stat-dot" style="background:#185FA5"></span>
          Clientes
        </span>
        <span class="stat-row-num">{{ \App\Models\Cliente::count() }}</span>
      </a>
      @endcan

      @can('cotizaciones')
      <a href="{{ route('cotizaciones.index') }}" class="stat-row">
        <span class="stat-row-left">
          <span class="stat-dot" style="background:#3B6D11"></span>
          Cotizaciones
        </span>
        <span class="stat-row-num">{{ \App\Models\Cotizacion::count() }}</span>
      </a>
      @endcan

      @can('facturas')
      <a href="{{ route('facturas.index') }}" class="stat-row">
        <span class="stat-row-left">
          <span class="stat-dot" style="background:#854F0B"></span>
          Facturas
        </span>
        <span class="stat-row-num">{{ \App\Models\Factura::count() }}</span>
      </a>
      @endcan

      @can('productos')
      <a href="{{ url('productos') }}" class="stat-row">
        <span class="stat-row-left">
          <span class="stat-dot" style="background:#A32D2D"></span>
          Productos
        </span>
        <span class="stat-row-num">{{ \App\Models\Producto::count() }}</span>
      </a>
      @endcan

      @can('usuarios')
      <a href="{{ url('usuarios') }}" class="stat-row">
        <span class="stat-row-left">
          <span class="stat-dot" style="background:#534AB7"></span>
          Usuarios
        </span>
        <span class="stat-row-num">{{ \App\Models\User::count() }}</span>
      </a>
      @endcan

    </div>
  </div>

</div>

<script>
  function updateTime() {
    const now = new Date();
    const dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    const meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
    document.getElementById('heroDate').textContent =
      dias[now.getDay()] + ', ' + now.getDate() + ' de ' + meses[now.getMonth()] + ' de ' + now.getFullYear();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    document.getElementById('heroTime').textContent = h + ':' + m;
  }
  updateTime();
  setInterval(updateTime, 1000);
</script>

@endsection