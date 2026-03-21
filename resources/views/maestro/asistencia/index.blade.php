<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Tomar Asistencia</title>
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
            background: linear-gradient(135deg, #10b981, #3b82f6);
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
            background: linear-gradient(135deg, #10b981, #3b82f6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600;
        }
        .user-name { font-size: 14px; font-weight: 500; }
        .user-role { font-size: 11px; color: #6ee7b7; }
        .btn-logout {
            background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3);
            border-radius: 10px; color: #fca5a5; padding: 8px 16px;
            font-size: 13px; font-weight: 500; cursor: pointer;
            text-decoration: none; font-family: 'Inter', sans-serif;
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
            background: linear-gradient(135deg, rgba(16,185,129,0.25), rgba(59,130,246,0.2));
            color: white; border: 1px solid rgba(16,185,129,0.3);
        }
        .sidebar-item svg { width: 18px; height: 18px; fill: currentColor; flex-shrink: 0; }
        .main { flex: 1; padding: 32px; overflow-y: auto; }
        .page-title { font-size: 26px; font-weight: 700; margin-bottom: 8px; }
        .page-subtitle { font-size: 14px; color: rgba(255,255,255,0.5); margin-bottom: 28px; }
        .grupos-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .grupo-card {
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; padding: 24px; transition: all 0.2s;
        }
        .grupo-card:hover { transform: translateY(-4px); border-color: rgba(16,185,129,0.3); }
        .grupo-header {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 12px;
        }
        .grupo-clave {
            background: linear-gradient(135deg, #10b981, #3b82f6);
            border-radius: 8px; padding: 4px 12px;
            font-size: 13px; font-weight: 700;
        }
        .grupo-alumnos {
            font-size: 12px; color: rgba(255,255,255,0.4);
        }
        .grupo-materia { font-size: 16px; font-weight: 600; margin-bottom: 6px; }
        .grupo-semestre { font-size: 12px; color: rgba(255,255,255,0.4); margin-bottom: 16px; }
        .grupo-actions { display: flex; gap: 8px; }
        .btn-sesiones {
            flex: 1; padding: 10px; border-radius: 10px; text-align: center;
            background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.3);
            color: #6ee7b7; font-size: 13px; font-weight: 500;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-sesiones:hover { background: rgba(16,185,129,0.35); color: white; }
        .btn-reporte {
            padding: 10px 16px; border-radius: 10px;
            background: rgba(99,102,241,0.2); border: 1px solid rgba(99,102,241,0.3);
            color: #a78bfa; font-size: 13px; font-weight: 500;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-reporte:hover { background: rgba(99,102,241,0.35); color: white; }
        .empty-state {
            text-align: center; padding: 60px;
            background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px; color: rgba(255,255,255,0.3); font-size: 16px;
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
        <a href="{{ route('maestro.dashboard') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            Dashboard
        </a>
        <div class="sidebar-section">Mis Clases</div>
        <a href="{{ route('maestro.asistencia.index') }}" class="sidebar-item active">
            <svg viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
            Tomar Asistencia
        </a>
    </aside>
    <main class="main">
        <div class="page-title">Tomar Asistencia 📋</div>
        <div class="page-subtitle">Selecciona un grupo para gestionar la asistencia</div>

        @if($grupos->count() > 0)
        <div class="grupos-grid">
            @foreach($grupos as $grupo)
            <div class="grupo-card">
                <div class="grupo-header">
                    <span class="grupo-clave">{{ $grupo->clave }}</span>
                    <span class="grupo-alumnos">{{ $grupo->alumnos->count() }} alumnos</span>
                </div>
                <div class="grupo-materia">{{ $grupo->materia->nombre }}</div>
                <div class="grupo-semestre">📅 {{ $grupo->semestre->nombre }}</div>
                <div class="grupo-actions">
                    <a href="{{ route('maestro.asistencia.sesiones', $grupo) }}" class="btn-sesiones">
                        Ver Sesiones
                    </a>
                    <a href="{{ route('maestro.asistencia.reporte', $grupo) }}" class="btn-reporte">
                        Reporte
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            📚 No tienes grupos asignados aún.
        </div>
        @endif
    </main>
</div>
</body>
</html>