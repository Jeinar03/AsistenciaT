<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Iniciar Sesión</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Burbujas de fondo estilo Frutiger Aero */
        body::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(99,102,241,0.3), transparent 70%);
            top: -100px; left: -100px;
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(139,92,246,0.25), transparent 70%);
            bottom: -80px; right: -80px;
            border-radius: 50%;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.4),
                inset 0 1px 0 rgba(255,255,255,0.2);
        }

        .logo-area {
            text-align: center;
            margin-bottom: 36px;
        }

        .logo-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            box-shadow: 0 4px 20px rgba(99,102,241,0.5);
        }

        .logo-icon svg {
            width: 32px; height: 32px;
            fill: white;
        }

        .logo-title {
            font-size: 26px;
            font-weight: 700;
            color: white;
            letter-spacing: -0.5px;
        }

        .logo-subtitle {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
            margin-top: 4px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,0.7);
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            color: white;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input::placeholder { color: rgba(255,255,255,0.3); }

        .form-input:focus {
            background: rgba(255,255,255,0.1);
            border-color: rgba(99,102,241,0.7);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
        }

        .form-input.error {
            border-color: rgba(239,68,68,0.7);
            box-shadow: 0 0 0 3px rgba(239,68,68,0.15);
        }

        .error-msg {
            font-size: 12px;
            color: #f87171;
            margin-top: 6px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 13px;
            color: rgba(255,255,255,0.6);
        }

        .remember-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: #6366f1;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            color: #a78bfa;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover { color: #c4b5fd; }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(99,102,241,0.4);
            letter-spacing: 0.3px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(99,102,241,0.6);
        }

        .btn-login:active { transform: translateY(0); }

        .session-error {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.3);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #fca5a5;
            text-align: center;
        }

        /* Orbes decorativos */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
            z-index: 1;
        }

        .orb-1 {
            width: 200px; height: 200px;
            background: rgba(99,102,241,0.4);
            top: 10%; right: 10%;
            animation: float 7s ease-in-out infinite;
        }

        .orb-2 {
            width: 150px; height: 150px;
            background: rgba(139,92,246,0.35);
            bottom: 15%; left: 5%;
            animation: float 9s ease-in-out infinite reverse;
        }

        .orb-3 {
            width: 100px; height: 100px;
            background: rgba(167,139,250,0.3);
            top: 50%; left: 50%;
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body>

    <!-- Orbes decorativos -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="login-container">
        <div class="glass-card">

            <!-- Logo -->
            <div class="logo-area">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                    </svg>
                </div>
                <div class="logo-title">AsistenciaT</div>
                <div class="logo-subtitle">Sistema de Control de Asistencia</div>
            </div>

            <!-- Error de sesión -->
            @if (session('status'))
                <div class="session-error">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label" for="email">Correo electrónico</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                        value="{{ old('email') }}"
                        placeholder="correo@ejemplo.com"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    @error('email')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label" for="password">Contraseña</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Recuérdame y Olvidé contraseña -->
                <div class="remember-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember">
                        Recordarme
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    Iniciar Sesión
                </button>

            </form>
        </div>
    </div>

</body>
</html>