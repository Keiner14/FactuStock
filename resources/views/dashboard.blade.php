@extends('layouts.app')

@section('content')

<style>
  .page {
    min-height: calc(100vh - 120px);
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
  }

  .hero-top {
    background: linear-gradient(135deg, #0C447C 0%, #1a6db5 50%, #0C447C 100%);
    border-radius: 14px;
    padding: 2.5rem 3rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    overflow: hidden;
  }

  .hero-circle1 {
    position: absolute; right: -40px; top: -40px;
    width: 200px; height: 200px; border-radius: 50%;
    border: 40px solid rgba(255,255,255,0.05);
  }
  .hero-circle2 {
    position: absolute; left: -30px; bottom: -50px;
    width: 160px; height: 160px; border-radius: 50%;
    border: 30px solid rgba(255,255,255,0.04);
  }
  .hero-circle3 {
    position: absolute; right: 200px; bottom: -60px;
    width: 130px; height: 130px; border-radius: 50%;
    border: 25px solid rgba(255,255,255,0.03);
  }

  .hero-left-text { position: relative; z-index: 1; }

  .hero-brand {
    font-size: 11px;
    letter-spacing: 0.2em;
    color: rgba(255,255,255,0.35);
    text-transform: uppercase;
    margin-bottom: 1rem;
  }

  .hero-bienvenido {
    font-size: 42px;
    font-weight: 500;
    color: #fff;
    letter-spacing: -0.5px;
    line-height: 1;
    margin-bottom: 0.6rem;
  }

  .hero-nombre {
    font-size: 20px;
    font-weight: 400;
    color: #7EC8F7;
    font-style: italic;
  }

  .hero-right-text {
    position: relative; z-index: 1;
    text-align: right;
  }

  .hero-time {
    font-size: 48px;
    font-weight: 500;
    color: #fff;
    letter-spacing: 3px;
    line-height: 1;
  }

  .hero-date {
    font-size: 13px;
    color: rgba(255,255,255,0.4);
    margin-top: 6px;
  }

  .logo-area {
    flex: 1;
    background: #f0f2f5;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 280px;
    position: relative;
    overflow: hidden;
  }

  .logo-area-bg {
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(0,0,0,0.04) 1px, transparent 1px);
    background-size: 24px 24px;
  }

  .logo-area img {
    position: relative;
    z-index: 1;
    max-width: 400px;
    width: 65%;
    opacity: 0.45;
    filter: none;
    user-select: none;
    pointer-events: none;
  }
</style>

<div class="page">

  {{-- Hero azul --}}
  <div class="hero-top">
    <div class="hero-circle1"></div>
    <div class="hero-circle2"></div>
    <div class="hero-circle3"></div>

    <div class="hero-left-text">
      <div class="hero-brand">FactuStock · Panel de control</div>
      <div class="hero-bienvenido">Bienvenido</div>
      <div class="hero-nombre">"{{ auth()->user()->name }}"</div>
    </div>

    <div class="hero-right-text">
      <div class="hero-time" id="horaTop">--:--</div>
      <div class="hero-date" id="fechaTop"></div>
    </div>
  </div>

  {{-- Logo abajo --}}
  <div class="logo-area">
    <div class="logo-area-bg"></div>
    <img src="{{ asset('images/factustock-logo.png') }}" alt="FactuStock Logo">
  </div>

</div>

<script>
  function tick() {
    const now = new Date();
    const dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    const meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
    document.getElementById('horaTop').textContent =
      String(now.getHours()).padStart(2,'0') + ':' + String(now.getMinutes()).padStart(2,'0');
    document.getElementById('fechaTop').textContent =
      dias[now.getDay()] + ', ' + now.getDate() + ' de ' + meses[now.getMonth()] + ' de ' + now.getFullYear();
  }
  tick();
  setInterval(tick, 1000);
</script>

@endsection