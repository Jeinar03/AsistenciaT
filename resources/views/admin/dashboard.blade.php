<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Panel Admin</title>
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
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 10px rgba(99,102,241,0.4);
        }
        .brand-icon svg { width: 20px; height: 20px; fill: white; }
        .brand-name { font-size: 18px; font-weight: 700; color: white; }
        .navbar-right { display: flex; align-items: center; gap: 16px; }
        .user-badge {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px; padding: 8px 16px;
        }
        .user-avatar {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600;
        }
        .user-name { font-size: 14px; font-weight: 500; }
        .user-role { font-size: 11px; color: #a78bfa; }
        .btn-logout {
            background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3);
            border-radius: 10px; color: #fca5a5; padding: 8px 16px;
            font-size: 13px; font-weight: 500; cursor: pointer;
            text-decoration: none; transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.25); color: white; }
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
            background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(139,92,246,0.2));
            color: white; border: 1px solid rgba(99,102,241,0.3);
        }
        .sidebar-item svg { width: 18px; height: 18px; fill: currentColor; flex-shrink: 0; }
        .main { flex: 1; padding: 32px; overflow-y: auto; }
        .page-header { margin-bottom: 32px; }
        .page-title { font-size: 28px; font-weight: 700; color: white; }
        .page-subtitle { font-size: 14px; color: rgba(255,255,255,0.5); margin-top: 4px; }
        .stats-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px; margin-bottom: 32px;
        }
        .stat-card {
            background: rgba(255,255,255,0.07); backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1); border-radius: 16px;
            padding: 24px; transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-4px); }
        .stat-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .stat-icon svg { width: 22px; height: 22px; fill: white; }
        .stat-icon.purple { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .stat-icon.blue   { background: linear-gradient(135deg, #3b82f6, #6366f1); }
        .stat-icon.green  { background: linear-gradient(135deg, #10b981, #3b82f6); }
        .stat-icon.pink   { background: linear-gradient(135deg, #ec4899, #8b5cf6); }
        .stat-value { font-size: 36px; font-weight: 700; color: white; line-height: 1; }
        .stat-label { font-size: 13px; color: rgba(255,255,255,0.5); margin-top: 6px; }
        .section-title { font-size: 18px; font-weight: 600; margin-bottom: 16px; color: white; }
        .actions-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px; margin-bottom: 32px;
        }
        .action-card {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px; padding: 20px; text-align: center;
            cursor: pointer; transition: all 0.2s; text-decoration: none; color: white;
        }
        .action-card:hover {
            background: rgba(99,102,241,0.2); border-color: rgba(99,102,241,0.4);
            transform: translateY(-2px);
        }
        .action-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 12px; box-shadow: 0 4px 12px rgba(99,102,241,0.3);
        }
        .action-icon svg { width: 24px; height: 24px; fill: white; }
        .action-label { font-size: 13px; font-weight: 500; }
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
                <div class="user-role">Administrador</div>
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
        <a href="{{ route('admin.dashboard') }}" class="sidebar-item active">
            <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            Dashboard
        </a>
        <div class="sidebar-section">Gestión</div>
        <a href="{{ route('admin.users.index') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            Usuarios
        </a>
        <a href="{{ route('admin.carreras.index') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
            Carreras
        </a>
        <a href="{{ route('admin.semestres.index') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
            Semestres
        </a>
        <a href="{{ route('admin.materias.index') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M14 6l-1-2H5v17h2v-7h5l1 2h7V6h-6zm4 8h-4l-1-2H7V6h5l1 2h5v6z"/></svg>
            Materias
        </a>
        <a href="{{ route('admin.grupos.index') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z"/></svg>
            Grupos
        </a>
        <div class="sidebar-section">Reportes</div>
        <a href="#" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
            Reportes
        </a>
        <a href="#" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
            Auditoría
        </a>
    </aside>
    <main class="main">
        <div class="page-header">
            <div class="page-title">¡Bienvenido, {{ auth()->user()->name }}! 👋</div>
            <div class="page-subtitle">Panel de administración — {{ now()->format('d \d\e F \d\e Y') }}</div>
        </div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon purple">
                        <svg viewBox="0 0 24 24"><path d="M20 6h-2.18c.07-.44.18-.88.18-1.33C18 2.54 15.6 1 13.5 1c-1.93 0-3.19 1.07-4 2.44C8.69 2.07 7.43 1 5.5 1 3.4 1 1 2.54 1 4.67 1 5.12 1.11 5.56 1.18 6H-1v2h2v11c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8h2V6zM9.26 6c-.2-.63-.26-1.22-.26-1.33C9 3.6 9.9 3 10.5 3c.95 0 1.5.73 1.5 1.67 0 .41-.06 1.01-.26 1.33H9.26zM7 8h10v11H7V8z"/></svg>
                    </div>
                </div>
                <div class="stat-value">{{ $stats['total_maestros'] }}</div>
                <div class="stat-label">Maestros registrados</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon blue">
                        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    </div>
                </div>
                <div class="stat-value">{{ $stats['total_alumnos'] }}</div>
                <div class="stat-label">Alumnos registrados</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon green">
                        <svg viewBox="0 0 24 24"><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z"/></svg>
                    </div>
                </div>
                <div class="stat-value">{{ $stats['total_grupos'] }}</div>
                <div class="stat-label">Grupos activos</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon pink">
                        <svg viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
                    </div>
                </div>
                <div class="stat-value">
                    @if($stats['semestre_activo'])
                        <span style="font-size:16px">{{ $stats['semestre_activo']->nombre }}</span>
                    @else
                        <span style="font-size:16px; color: rgba(255,255,255,0.3)">N/A</span>
                    @endif
                </div>
                <div class="stat-label">Semestre activo</div>
            </div>
        </div>

        <div class="section-title">Acciones rápidas</div>
        <div class="actions-grid">
            <a href="{{ route('admin.users.create') }}" class="action-card">
                <div class="action-icon">
                    <svg viewBox="0 0 24 24"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <div class="action-label">Nuevo Usuario</div>
            </a>
            <a href="{{ route('admin.semestres.create') }}" class="action-card">
                <div class="action-icon">
                    <svg viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
                </div>
                <div class="action-label">Nuevo Semestre</div>
            </a>
            <a href="{{ route('admin.carreras.create') }}" class="action-card">
                <div class="action-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
                </div>
                <div class="action-label">Nueva Carrera</div>
            </a>
            <a href="{{ route('admin.grupos.index') }}" class="action-card">
                <div class="action-icon">
                    <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/></svg>
                </div>
                <div class="action-label">Ver Grupos</div>
            </a>
        </div>
    </main>
</div>
</body>
</html>