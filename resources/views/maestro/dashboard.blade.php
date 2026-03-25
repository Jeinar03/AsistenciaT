<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Panel Maestro</title>
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
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 0 32px; height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .navbar-brand { display: flex; align-items: center; gap: 12px; }
        .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 10px rgba(16,185,129,0.4);
        }
        .brand-icon svg { width: 20px; height: 20px; fill: white; }
        .brand-name { font-size: 18px; font-weight: 700; }
        .navbar-right { display: flex; align-items: center; gap: 16px; }
        .user-badge {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px; padding: 8px 16px;
        }
        .user-avatar {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600;
        }
        .user-name { font-size: 14px; font-weight: 500; }
        .user-role { font-size: 11px; color: #6ee7b7; }
        .btn-logout {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.3);
            border-radius: 10px; color: #fca5a5;
            padding: 8px 16px; font-size: 13px; font-weight: 500;
            cursor: pointer; text-decoration: none;
            transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.25); color: white; }
        .layout { display: flex; min-height: calc(100vh - 64px); }
        .sidebar {
            width: 240px;
            background: rgba(255,255,255,0.04);
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
            font-size: 14px; font-weight: 500;
            transition: all 0.2s; margin-bottom: 2px;
        }
        .sidebar-item:hover { background: rgba(255,255,255,0.08); color: white; }
        .sidebar-item.active {
            background: linear-gradient(135deg, rgba(16,185,129,0.25), rgba(59,130,246,0.2));
            color: white; border: 1px solid rgba(16,185,129,0.3);
        }
        .sidebar-item svg { width: 18px; height: 18px; fill: currentColor; flex-shrink: 0; }
        .main { flex: 1; padding: 32px; overflow-y: auto; }
        .page-header { margin-bottom: 32px; }
        .page-title { font-size: 28px; font-weight: 700; }
        .page-subtitle { font-size: 14px; color: rgba(255,255,255,0.5); margin-top: 4px; }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px; margin-bottom: 32px;
        }
        .stat-card {
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; padding: 24px;
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-4px); }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
        }
        .stat-icon svg { width: 22px; height: 22px; fill: white; }
        .stat-icon.green  { background: linear-gradient(135deg, #10b981, #3b82f6); }
        .stat-icon.blue   { background: linear-gradient(135deg, #3b82f6, #6366f1); }
        .stat-icon.purple { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .stat-value { font-size: 36px; font-weight: 700; line-height: 1; }
        .stat-label { font-size: 13px; color: rgba(255,255,255,0.5); margin-top: 6px; }
        .section-title { font-size: 18px; font-weight: 600; margin-bottom: 16px; }
        .grupos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px; margin-bottom: 32px;
        }
        .grupo-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px; padding: 20px;
            transition: all 0.2s; cursor: pointer;
            text-decoration: none; color: white;
        }
        .grupo-card:hover {
            background: rgba(16,185,129,0.15);
            border-color: rgba(16,185,129,0.3);
            transform: translateY(-2px);
        }
        .grupo-header {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 12px;
        }
        .grupo-clave {
            background: linear-gradient(135deg, rgba(16,185,129,0.3), rgba(59,130,246,0.2));
            border: 1px solid rgba(16,185,129,0.4);
            border-radius: 8px; padding: 4px 10px;
            font-size: 12px; font-weight: 600; color: #6ee7b7;
        }
        .grupo-alumnos {
            font-size: 12px; color: rgba(255,255,255,0.4);
            display: flex; align-items: center; gap: 4px;
        }
        .grupo-alumnos svg { width: 14px; height: 14px; fill: currentColor; }
        .grupo-materia { font-size: 16px; font-weight: 600; margin-bottom: 4px; }
        .grupo-semestre { font-size: 12px; color: rgba(255,255,255,0.4); }
        .grupo-footer {
            margin-top: 14px; padding-top: 14px;
            border-top: 1px solid rgba(255,255,255,0.08);
            display: flex; gap: 8px;
        }
        .btn-small {
            flex: 1; padding: 8px;
            border-radius: 8px; font-size: 12px; font-weight: 500;
            text-align: center; text-decoration: none;
            transition: all 0.2s; border: none; cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .btn-asistencia {
            background: rgba(16,185,129,0.2);
            border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7;
        }
        .btn-asistencia:hover { background: rgba(16,185,129,0.35); }
        .btn-calificaciones {
            background: rgba(99,102,241,0.2);
            border: 1px solid rgba(99,102,241,0.3); color: #a78bfa;
        }
        .btn-calificaciones:hover { background: rgba(99,102,241,0.35); }
        .sesiones-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; overflow: hidden;
        }
        .sesiones-header {
            padding: 18px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            font-size: 15px; font-weight: 600;
        }
        .sesion-item {
            display: flex; align-items: center;
            padding: 16px 24px; gap: 16px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: background 0.2s;
        }
        .sesion-item:hover { background: rgba(255,255,255,0.03); }
        .sesion-item:last-child { border-bottom: none; }
        .sesion-fecha {
            min-width: 80px;
            background: rgba(16,185,129,0.15);
            border: 1px solid rgba(16,185,129,0.25);
            border-radius: 10px; padding: 8px 12px;
            text-align: center;
        }
        .sesion-dia { font-size: 20px; font-weight: 700; color: #6ee7b7; line-height: 1; }
        .sesion-mes { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 2px; }
        .sesion-info { flex: 1; }
        .sesion-materia { font-size: 14px; font-weight: 500; }
        .sesion-hora { font-size: 12px; color: rgba(255,255,255,0.4); margin-top: 3px; }
        .empty-state {
            padding: 40px; text-align: center;
            color: rgba(255,255,255,0.3); font-size: 14px;
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
                <div class="user-role">Maestro</div>
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
        <a href="{{ route('maestro.dashboard') }}" class="sidebar-item active">
            <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            Dashboard
        </a>
        <div class="sidebar-section">Mis Clases</div>
        <a href="{{ route('maestro.asistencia.index') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z"/></svg>
            Mis Grupos
        </a>
<a href="{{ route('maestro.asistencia.index') }}" class="sidebar-item">
    <svg viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
    Tomar Asistencia
</a>
        <a href="{{ route('maestro.asistencia.index') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
            Calificaciones
        </a>
        <a href="#" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/></svg>
            Asignaciones
        </a>
        <div class="sidebar-section">Reportes</div>
        <a href="#" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
            Mis Reportes
        </a>
    </aside>

    <main class="main">
        <div class="page-header">
            <div class="page-title">¡Bienvenido, {{ $maestro->name }}! 👨‍🏫</div>
            <div class="page-subtitle">Panel del maestro — {{ now()->format('d \d\e F \d\e Y') }}</div>
        </div>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon green">
                    <svg viewBox="0 0 24 24"><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z"/></svg>
                </div>
                <div class="stat-value">{{ $grupos->count() }}</div>
                <div class="stat-label">Grupos activos</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                </div>
                <div class="stat-value">{{ $totalAlumnos }}</div>
                <div class="stat-label">Total alumnos</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <svg viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
                </div>
                <div class="stat-value">{{ $proximasSesiones->count() }}</div>
                <div class="stat-label">Próximas sesiones</div>
            </div>
        </div>

        <!-- MIS GRUPOS -->
        <div class="section-title">Mis Grupos</div>
        @if($grupos->count() > 0)
        <div class="grupos-grid">
            @foreach($grupos as $grupo)
            <div class="grupo-card">
                <div class="grupo-header">
                    <span class="grupo-clave">{{ $grupo->clave }}</span>
                    <span class="grupo-alumnos">
                        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        {{ $grupo->alumnos->count() }} alumnos
                    </span>
                </div>
                <div class="grupo-materia">{{ $grupo->materia->nombre }}</div>
                <div class="grupo-semestre">{{ $grupo->semestre->nombre ?? 'Sin semestre' }}</div>
                <div class="grupo-footer">
                   <a href="{{ route('maestro.asistencia.sesiones', $grupo->id) }}" class="btn-small btn-asistencia">Asistencia</a>
                    <a href="{{ route('maestro.calificaciones.index', $grupo->id) }}" class="btn-small btn-calificaciones">Calificaciones</a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="sesiones-card" style="margin-bottom: 32px;">
            <div class="empty-state">
                📚 No tienes grupos asignados aún. Contacta al administrador.
            </div>
        </div>
        @endif

        <!-- PRÓXIMAS SESIONES -->
        <div class="section-title">Próximas Sesiones</div>
        <div class="sesiones-card">
            @if($proximasSesiones->count() > 0)
                @foreach($proximasSesiones as $sesion)
                <div class="sesion-item">
                    <div class="sesion-fecha">
                        <div class="sesion-dia">{{ $sesion->fecha->format('d') }}</div>
                        <div class="sesion-mes">{{ $sesion->fecha->format('M') }}</div>
                    </div>
                    <div class="sesion-info">
                        <div class="sesion-materia">{{ $sesion->grupo->materia->nombre }}</div>
                        <div class="sesion-hora">
                            {{ $sesion->hora_inicio }} — {{ $sesion->hora_fin }}
                            · Grupo {{ $sesion->grupo->clave }}
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    📅 No hay sesiones programadas próximamente.
                </div>
            @endif
        </div>
    </main>
</div>

</body>
</html>
