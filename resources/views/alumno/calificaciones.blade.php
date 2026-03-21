<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Mis Calificaciones</title>
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
        .page-header { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; }
        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px; color: rgba(255,255,255,0.7);
            padding: 8px 14px; font-size: 13px; text-decoration: none;
        }
        .btn-back svg { width: 16px; height: 16px; fill: currentColor; }
        .page-title { font-size: 24px; font-weight: 700; }
        .page-subtitle { font-size: 13px; color: rgba(255,255,255,0.5); margin-top: 3px; }
        .promedio-card {
            background: linear-gradient(135deg, rgba(59,130,246,0.15), rgba(139,92,246,0.1));
            border: 1px solid rgba(59,130,246,0.2); border-radius: 16px;
            padding: 28px; margin-bottom: 24px; text-align: center;
        }
        .promedio-num {
            font-size: 64px; font-weight: 700; line-height: 1;
            color: {{ isset($promedio) && $promedio !== null ? ($promedio >= 60 ? '#6ee7b7' : '#fca5a5') : '#a78bfa' }};
        }
        .promedio-label { font-size: 14px; color: rgba(255,255,255,0.5); margin-top: 8px; }
        .promedio-status {
            display: inline-flex; align-items: center; gap: 6px;
            margin-top: 12px; padding: 6px 16px; border-radius: 20px;
            font-size: 13px; font-weight: 600;
        }
        .status-aprobado { background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7; }
        .status-reprobado { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; }
        .status-pendiente { background: rgba(99,102,241,0.2); border: 1px solid rgba(99,102,241,0.3); color: #a78bfa; }
        .criterios-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 16px; margin-bottom: 24px;
        }
        .criterio-card {
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px; padding: 20px;
        }
        .criterio-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .criterio-nombre { font-size: 14px; font-weight: 600; }
        .criterio-peso {
            font-size: 11px; color: rgba(255,255,255,0.4);
            background: rgba(255,255,255,0.08); border-radius: 6px; padding: 2px 8px;
        }
        .criterio-cal {
            font-size: 42px; font-weight: 700; text-align: center; margin: 8px 0;
        }
        .criterio-tipo {
            font-size: 11px; text-align: center; text-transform: uppercase;
            letter-spacing: 0.8px; color: rgba(255,255,255,0.4);
        }
        .cal-bar { height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; overflow: hidden; margin-top: 10px; }
        .cal-fill { height: 100%; border-radius: 3px; }
        .cal-fill.alta { background: linear-gradient(90deg, #10b981, #3b82f6); }
        .cal-fill.media { background: linear-gradient(90deg, #f59e0b, #10b981); }
        .cal-fill.baja { background: linear-gradient(90deg, #ef4444, #f59e0b); }
        .sin-cal { font-size: 14px; color: rgba(255,255,255,0.3); text-align: center; padding: 10px 0; }
        .empty-state {
            text-align: center; padding: 40px;
            background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px; color: rgba(255,255,255,0.3); font-size: 15px;
        }
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
        <a href="{{ route('alumno.dashboard') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            Mi Dashboard
        </a>
        <div class="sidebar-section">Mis Materias</div>
        <a href="{{ route('alumno.mi.asistencia', $grupo) }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
            Mi Asistencia
        </a>
        <a href="{{ route('alumno.mi.calificaciones', $grupo) }}" class="sidebar-item active">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
            Mis Calificaciones
        </a>
    </aside>
    <main class="main">
        <div class="page-header">
            <a href="{{ route('alumno.dashboard') }}" class="btn-back">
                <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                Volver
            </a>
            <div>
                <div class="page-title">Mis Calificaciones</div>
                <div class="page-subtitle">{{ $grupo->materia->nombre }} — Grupo {{ $grupo->clave }}</div>
            </div>
        </div>

        @if($criterios->count() == 0)
            <div class="empty-state">📊 El maestro aún no ha definido criterios de evaluación.</div>
        @else
        <div class="promedio-card">
            <div class="promedio-num">
                {{ $promedio !== null ? $promedio : '—' }}
            </div>
            <div class="promedio-label">Promedio general</div>
            @if($promedio !== null)
                <div class="promedio-status {{ $promedio >= 60 ? 'status-aprobado' : 'status-reprobado' }}">
                    {{ $promedio >= 60 ? '✓ Aprobado' : '✗ Reprobado' }}
                </div>
            @else
                <div class="promedio-status status-pendiente">⏳ Calificaciones pendientes</div>
            @endif
        </div>

        <div class="criterios-grid">
            @foreach($criterios as $criterio)
            @php $cal = $calificaciones[$criterio->id] ?? null; @endphp
            <div class="criterio-card">
                <div class="criterio-header">
                    <div class="criterio-nombre">{{ $criterio->nombre }}</div>
                    <span class="criterio-peso">{{ $criterio->peso }}%</span>
                </div>
                @if($cal !== null)
                    <div class="criterio-cal" style="color: {{ $cal >= 60 ? '#6ee7b7' : '#fca5a5' }}">
                        {{ $cal }}
                    </div>
                    <div class="cal-bar">
                        <div class="cal-fill {{ $cal >= 80 ? 'alta' : ($cal >= 60 ? 'media' : 'baja') }}"
                             style="width: {{ $cal }}%"></div>
                    </div>
                @else
                    <div class="sin-cal">⏳ Sin calificar</div>
                @endif
                <div class="criterio-tipo">{{ $criterio->tipo }}</div>
            </div>
            @endforeach
        </div>
        @endif
    </main>
</div>
</body>
</html>