<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FactuStock — Olvidé mi contraseña</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; background: #f0f4f8; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.10); padding: 2.5rem 2rem; width: 100%; max-width: 380px; }
        .logo { display: block; margin: 0 auto 1.5rem; width: 160px; }
        h1 { font-size: 1.3rem; color: #0C447C; text-align: center; margin-bottom: 0.4rem; }
        .subtitle { text-align: center; font-size: 0.82rem; color: #8A93A2; margin-bottom: 1.5rem; line-height: 1.5; }
        .success { background: #EAF3DE; color: #27500A; border-radius: 8px; padding: 0.6rem 0.9rem; font-size: 0.82rem; margin-bottom: 1rem; }
        label { display: block; font-size: 0.85rem; color: #4F5869; margin-bottom: 0.3rem; }
        input[type="email"] { width: 100%; height: 44px; border: 1.5px solid #D5D9E0; border-radius: 8px; padding: 0 12px; font-size: 0.9rem; margin-bottom: 1rem; outline: none; }
        input:focus { border-color: #378ADD; }
        .error { font-size: 0.78rem; color: #A32D2D; margin-top: -0.75rem; margin-bottom: 0.75rem; }
        button { width: 100%; height: 46px; background: #185FA5; color: #fff; border: none; border-radius: 8px; font-size: 0.95rem; font-weight: 600; cursor: pointer; }
        button:hover { background: #0C447C; }
        .footer { text-align: center; font-size: 0.8rem; color: #8A93A2; margin-top: 1.25rem; }
        .footer a { color: #185FA5; text-decoration: none; }
    </style>
</head>
<body>
<div class="card">
    <img src="{{ asset('images/factustock-logo.png') }}" alt="FactuStock" class="logo">
    <h1>¿Olvidaste tu contraseña?</h1>
    <p class="subtitle">Ingresa tu correo y te enviaremos un enlace para restablecerla.</p>

    @if (session('status'))
        <div class="success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label>Correo electrónico</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email') <p class="error">{{ $message }}</p> @enderror
        <button type="submit">Enviar enlace de restablecimiento</button>
    </form>

    <p class="footer"><a href="{{ route('login') }}">← Volver al inicio de sesión</a></p>
</div>
</body>
</html>