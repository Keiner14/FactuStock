<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FactuStock — Iniciar Sesión</title>
    <link rel="icon" type="image/png" href="{{ asset('images/factustock-logo.png') }}">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
 
        body {
            font-family: sans-serif;
            background: #f0f4f8;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
 
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.10);
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 380px;
        }
 
        .logo {
            display: block;
            margin: 0 auto 1.5rem;
            width: 160px;
        }
 
        h1 {
            font-size: 1.3rem;
            color: #378ADD;
            text-align: center;
            margin-bottom: 1.5rem;
        }
 
        label {
            display: block;
            font-size: 0.85rem;
            color: #4F5869;
            margin-bottom: 0.3rem;
        }
 
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            height: 44px;
            border: 1.5px solid #D5D9E0;
            border-radius: 8px;
            padding: 0 12px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            outline: none;
        }
 
        input:focus { border-color: #378ADD; }
 
        .meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.82rem;
            margin-bottom: 1.25rem;
        }
 
        .meta a { color: #378ADD; text-decoration: none; }
 
        button {
            width: 100%;
            height: 46px;
            background: #378ADD;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
        }
 
        button:hover { background: #2a7bc8; }
 
        .error {
            background: #FCEBEB;
            color: #791F1F;
            border-radius: 8px;
            padding: 0.6rem 0.9rem;
            font-size: 0.82rem;
            margin-bottom: 1rem;
        }
 
        .footer {
            text-align: center;
            font-size: 0.8rem;
            color: #8A93A2;
            margin-top: 1.25rem;
        }
 
        .footer a { color: #378ADD; text-decoration: none; }

        /* Oculta el campo señuelo usado para bloquear el autocompletado */
        .campo-trampa {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
            pointer-events: none;
            left: -9999px;
        }
    </style>
</head>
<body>
 
<div class="card">
 
    <img src="{{ asset('images/factustock-logo.png') }}" alt="FactuStock" class="logo">
 
    <h1>Iniciar sesión</h1>
 
    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
 
    <form method="POST" action="{{ route('login') }}" autocomplete="off">
        @csrf

        {{-- Campos señuelo: hacen que Chrome guarde sus datos aquí en vez de en los campos reales --}}
        <input type="text" name="fake_user" class="campo-trampa" tabindex="-1" autocomplete="off">
        <input type="password" name="fake_pass" class="campo-trampa" tabindex="-1" autocomplete="off">
 
        <label for="email">Correo electrónico</label>
        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="tu@correo.com"
            autocomplete="nope"
            autofocus
            readonly
            onfocus="this.removeAttribute('readonly')"
        >
 
        <label for="password">Contraseña</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="••••••••"
            autocomplete="current-password"
        >
 
        <div class="meta">
            <label style="display:flex;align-items:center;gap:6px;cursor:pointer;">
                <input type="checkbox" name="remember"> Recordarme
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            @endif
        </div>
 
        <button type="submit">Iniciar sesión</button>
 
    </form>
 
    @if (Route::has('register'))
        <p class="footer">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
    @endif
 
</div>
 
</body>
</html>