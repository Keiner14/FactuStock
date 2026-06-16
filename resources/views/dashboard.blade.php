@extends('layouts.app')

@section('content')

<style>
  .page {
    min-height: calc(100vh - 120px);
    display: flex;
    flex-direction: column;
    background: white;
    padding: 2rem 2.5rem;
  }

  .topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .topbar-brand {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.18em;
    color: #8A93A2;
    text-transform: uppercase;
  }

  .topbar-right { text-align: right; }

  .topbar-time {
    font-size: 13px;
    font-weight: 500;
    color: #4F5869;
    letter-spacing: 0.05em;
  }

  .topbar-date {
    font-size: 11px;
    color: #8A93A2;
    margin-top: 2px;
  }

  .main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 0 2rem;
    text-align: center;
  }

  .welcome-title {
    font-size: 56px;
    font-weight: 500;
    color: #0C1A2E;
    letter-spacing: -1px;
    line-height: 1;
    margin-bottom: 1.2rem;
  }

  .welcome-divider {
    display: flex;
    align-items: center;
    gap: 1rem;
    justify-content: center;
  }

  .welcome-line {
    width: 3px;
    height: 22px;
    background: #0C447C;
    border-radius: 2px;
  }

  .welcome-name {
    font-size: 18px;
    color: #4F5869;
    font-style: italic;
  }

  .logo-area {
    margin-top: 2.5rem;
    width: 100%;
    background: #1A4F7A;
    border-radius: 12px;
    min-height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .logo-watermark {
    font-size: 80px;
    font-weight: 700;
    color: rgba(255,255,255,0.08);
    letter-spacing: -2px;
    user-select: none;
    pointer-events: none;
  }
</style>

<div class="page">

  <div class="topbar">
    <div class="topbar-brand">FactuStock</div>
    <div class="topbar-right">
      <div class="topbar-time" id="horaTop">--:--</div>
      <div class="topbar-date" id="fechaTop"></div>
    </div>
  </div>

  <div class="main-content">
    <div class="welcome-title">BIENVENIDO</div>
    <div class="welcome-divider">
      <div class="welcome-line"></div>
      <div class="welcome-name">"{{ auth()->user()->name }}"</div>
    </div>

    <div class="logo-area">
      <div class="logo-watermark">FactuStock</div>
    </div>
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
      dias[now.getDay()] + ', ' + now.getDate() + ' de ' + meses[now.getMonth()];
  }
  tick();
  setInterval(tick, 1000);
</script>

@endsection