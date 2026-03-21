<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Panel Alumno</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            min-height: 100vh; color: white;
        }
        .navbar {
            background: rgba(255,255,255,0.06); backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 0 32px; height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .navbar-brand { display: flex; align-items: center; gap: 12px; }
        .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 10px rgba(59,130,246,0.4);
        }
        .brand-icon svg { width: 20px; height: 20px; fill: white; }
        .brand-name { font-size: 18px; font-weight: 700; }
        .navbar-right { display: flex; align-items: center; gap: 16px; }
        .user-badge {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px; padding: 8px 16px;
        }
        .user-avatar {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600;
        }
        .user-name { font-size: 14px; font-weight: 500; }
        .user-role { font-size: 11px; color: #93c5fd; }
        .btn-logout {
            background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3);
            border-radius: 10px; color: #fca5a5; padding: 8px 16px;
            font-size: 13px; cursor: pointer; text-decoration: none; font-family: 'Inter', sans-serif;
        }
        .layout { display: flex; min-height: calc(100vh - 64px); }
        .sidebar {
            width: 240px; background: rgba(255,255,255,0.04);
            border-right: 1px solid rgba(255,255,255,0.08);
            padding: 24px 16px; flex-shrink: 0;
        }
        .sidebar-section {
            margin-bottom: 8px; font-size: 11px; font-weight: 600;
            color: rgba(255,255,255,0.3); letter-spacing: 1px;
            text-transform: uppercase; padding: 0 12px; margin-top: 24px;
        }
        .sidebar-section:first-child { margin-top: 0; }
        .sidebar-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px;
            color: rgba(255,255,255,0.6); text-decoration: none;
            font-size: 14px; font-weight: 500; transition: all 0.2s; margin-bottom: 2px;
        }
        .sidebar-item:hover { background: rgba(255,255,255,0.08); color: white; }
        .sidebar-item.active {
            background: linear-gradient(135deg, rgba(59,130,246,0.25), rgba(139,92,246,0.2));
            color: white; border: 1px solid rgba(59,130,246,0.3);
        }
        .sidebar-item svg { width: 18px; height: 18px; fill: currentColor; flex-shrink: 0; }
        .main { flex: 1; padding: 32px; overflow-y: auto; }
        .page-header { margin-bottom: 32px; }
        .page-title { font-size: 28px; font-weight: 700; }
        .page-subtitle { font-size: 14px; color: rgba(255,255,255,0.5); margin-top: 4px; }
        .materias-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }
        .materia-card {
            background: rgba(255,255,255,0.07); backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1); border-radius: 16px;
            padding: 24px; transition: transform 0.2s;
        }
        .materia-card:hover { transform: translateY(-4px); }
        .materia-card.riesgo { border-color: rgba(239,68,68,0.3); background: rgba(239,68,68,0.05); }
        .materia-header {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 16px;
        }
        .materia-clave {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 8px; padding: 4px 12px;
            font-size: 12px; font-weight: 700;
        }
        .badge-ok { background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.3); border-radius: 20px; padding: 4px 10px; font-size: 11px; font-weight: 600; color: #6ee7b7; }
        .badge-riesgo { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); border-radius: 20px; padding: 4px 10px; font-size: 11px; font-weight: 600; color: #fca5a5; }
        .materia-nombre { font-size: 17px; font-weight: 700; margin-bottom: 4px; }
        .materia-maestro { font-size: 13px; color: rgba(255,255,255,0.5); margin-bottom: 16px; }
        .stats-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; }
        .stat-box {
            background: rgba(255,255,255,0.05); border-radius: 12px;
            padding: 14px; text-align: center;
        }
        .stat-num { font-size: 24px; font-weight: 700; }
        .stat-lbl { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 3px; }
        .progress-section { margin-bottom: 8px; }
        .progress-label {
            display: flex; justify-content: space-between;
            font-size: 12px; color: rgba(255,255,255,0.5); margin-bottom: 6px;
        }
        .progress-bar { height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 4px; transition: width 0.5s; }
        .progress-fill.ok { background: linear-gradient(90deg, #10b981, #3b82f6); }
        .progress-fill.riesgo { background: linear-gradient(90deg, #ef4444, #f59e0b); }
        .minimo-line {
            font-size: 11px; color: rgba(255,255,255,0.3); margin-top: 4px; text-align: right;
        }
        .empty-state {
            grid-column: 1/-1; text-align: center; padding: 60px;
            background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px; color: rgba(255,255,255,0.3); font-size: 16px;
        }
        .welcome-card {
            background: linear-gradient(135deg, rgba(59,130,246,0.15), rgba(139,92,246,0.1));
            border: 1px solid rgba(59,130,246,0.2); border-radius: 16px;
            padding: 24px; margin-bottom: 28px;
            display: flex; align-items: center; gap: 20px;
        }
        .welcome-avatar {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 24px; font-weight: 700; flex-shrink: 0;
        }
        .welcome-name { font-size: 20px; font-weight: 700; }
        .welcome-sub { font-size: 13px; color: rgba(255,255,255,0.5); margin-top: 4px; }
        .section-title { font-size: 18px; font-weight: 600; margin-bottom: 16px; }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="navbar-brand">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
        </div>
        <span class="brand-name">AsistenciaT</span>
    </div>
    <div class="navbar-right">
        <div class="user-badge">
            <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Alumno</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">Cerrar sesión</button>
        </form>
    </div>
</nav>
<div class="layout">
    <aside class="sidebar">
        <div class="sidebar-section">Principal</div>
        <a href="{{ route('alumno.dashboard') }}" class="sidebar-item active">
            <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            Mi Dashboard
        </a>
        <div class="sidebar-section">Mis Materias</div>
        <a href="{{ route('alumno.dashboard') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
            Asistencias
        </a>
        <a href="{{ route('alumno.dashboard') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
            Calificaciones
        </a>
    </aside>
    <main class="main">
        <div class="welcome-card">
            <div class="welcome-avatar">{{ substr($alumno->name, 0, 1) }}</div>
            <div>
                <div class="welcome-name">¡Hola, {{ $alumno->name }}! 👋</div>
                <div class="welcome-sub">
                    Matrícula: {{ $alumno->matricula ?? 'Sin matrícula' }} ·
                    {{ now()->format('d \d\e F \d\e Y') }}
                </div>
            </div>
        </div>

        <div class="section-title">Mis Materias</div>

        @if($resumen->count() > 0)
        <div class="materias-grid">
            @foreach($resumen as $item)
            @php $grupo = $item['grupo']; @endphp
            <div class="materia-card {{ !$item['aprobado'] && $item['totalSesiones'] > 0 ? 'riesgo' : '' }}">
                <div class="materia-header">
                    <span class="materia-clave">{{ $grupo->materia->clave }}</span>
                    @if($item['totalSesiones'] > 0)
                        <span class="{{ $item['aprobado'] ? 'badge-ok' : 'badge-riesgo' }}">
                            {{ $item['aprobado'] ? '✓ Regular' : '⚠ En riesgo' }}
                        </span>
                    @endif
                </div>
                <div class="materia-nombre">{{ $grupo->materia->nombre }}</div>
                <div class="materia-maestro">👨‍🏫 {{ $grupo->maestro->name }} · Grupo {{ $grupo->clave }}</div>

                <div class="stats-row">
                    <div class="stat-box">
                        <div class="stat-num" style="color: #6ee7b7">{{ $item['presentes'] }}</div>
                        <div class="stat-lbl">Asistencias</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-num" style="color: {{ $item['promedio'] !== null ? ($item['promedio'] >= 60 ? '#6ee7b7' : '#fca5a5') : '#a78bfa' }}">
                            {{ $item['promedio'] !== null ? $item['promedio'] : '—' }}
                        </div>
                        <div class="stat-lbl">Promedio</div>
                    </div>
                </div>

                <div class="progress-section">
                    <div class="progress-label">
                        <span>Asistencia</span>
                        <span>{{ $item['porcentaje'] }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill {{ $item['aprobado'] ? 'ok' : 'riesgo' }}"
                             style="width: {{ $item['porcentaje'] }}%"></div>
                    </div>
                    <div class="minimo-line">Mínimo requerido: {{ $grupo->porcentaje_asistencia_minima }}%</div>
                </div>

                @if(!$item['aprobado'] && $item['totalSesiones'] > 0)
                <div style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2);
                            border-radius: 10px; padding: 10px 14px; font-size: 12px; color: #fca5a5; margin-top: 12px;">
                    ⚠️ Tu asistencia está por debajo del mínimo requerido. ¡Atención!
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="materias-grid">
            <div class="empty-state">
                📚 No estás inscrito en ninguna materia aún. Contacta al administrador.
            </div>
        </div>
        @endif
    </main>
</div>
</body>
</html>