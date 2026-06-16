@extends('layouts.app')

@section('content')

<style>
  .hero {
    background: #0C447C;
    border-radius: 12px;
    padding: 2rem 2.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
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

  /* Logo grande debajo */
  .logo-section {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 3rem;
    opacity: 0.08;
  }

  .logo-section img {
    width: 420px;
    max-width: 80%;
    filter: grayscale(100%);
  }
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

{{-- Logo grande opacado --}}
<div class="logo-section">
    <img src="{{ asset('images/factustock-logo.png') }}" alt="FactuStock">
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