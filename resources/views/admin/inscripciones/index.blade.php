<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Inscripciones</title>
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
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600;
        }
        .user-name { font-size: 14px; font-weight: 500; }
        .user-role { font-size: 11px; color: #a78bfa; }
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
            background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(139,92,246,0.2));
            color: white; border: 1px solid rgba(99,102,241,0.3);
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
        .alert { padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7; }
        .alert-error { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; }
        .grupo-info {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px; padding: 20px 24px; margin-bottom: 24px;
            display: flex; gap: 32px;
        }
        .info-label { font-size: 11px; color: rgba(255,255,255,0.4); text-transform: uppercase; }
        .info-value { font-size: 15px; font-weight: 600; margin-top: 3px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .card {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; overflow: hidden;
        }
        .card-header {
            padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.08);
            font-size: 15px; font-weight: 600; display: flex;
            align-items: center; justify-content: space-between;
        }
        .count-badge {
            background: rgba(99,102,241,0.3); border-radius: 20px;
            padding: 3px 10px; font-size: 12px; color: #a78bfa;
        }
        .alumno-item {
            display: flex; align-items: center; padding: 14px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05); gap: 12px;
            transition: background 0.2s;
        }
        .alumno-item:hover { background: rgba(255,255,255,0.03); }
        .alumno-item:last-child { border-bottom: none; }
        .avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600; flex-shrink: 0;
        }
        .alumno-name { font-size: 14px; font-weight: 500; flex: 1; }
        .alumno-mat { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 2px; }
        .btn-inscribir {
            padding: 6px 14px; border-radius: 8px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none; color: white; font-size: 12px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s;
        }
        .btn-inscribir:hover { opacity: 0.85; }
        .btn-remover {
            padding: 6px 14px; border-radius: 8px;
            background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5; font-size: 12px; font-weight: 500;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s;
        }
        .btn-remover:hover { background: rgba(239,68,68,0.3); color: white; }
        .empty-state {
            padding: 30px; text-align: center;
            color: rgba(255,255,255,0.3); font-size: 14px;
        }
        .inscribir-form { display: flex; align-items: center; gap: 8px; }
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
        <a href="{{ route('admin.dashboard') }}" class="sidebar-item">
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
        <a href="{{ route('admin.grupos.index') }}" class="sidebar-item active">
            <svg viewBox="0 0 24 24"><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z"/></svg>
            Grupos
        </a>
        <div class="sidebar-section">Reportes</div>
        <a href="#" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
            Reportes
        </a>
    </aside>
    <main class="main">
        <div class="page-header">
            <a href="{{ route('admin.grupos.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                Volver
            </a>
            <div>
                <div class="page-title">Inscripciones — {{ $grupo->clave }}</div>
                <div class="page-subtitle">{{ $grupo->materia->nombre }} · {{ $grupo->semestre->nombre }}</div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif

        <div class="grupo-info">
            <div>
                <div class="info-label">Maestro</div>
                <div class="info-value">{{ $grupo->maestro->name }}</div>
            </div>
            <div>
                <div class="info-label">Alumnos inscritos</div>
                <div class="info-value">{{ $grupo->alumnos->count() }} / {{ $grupo->max_alumnos }}</div>
            </div>
            <div>
                <div class="info-label">Asistencia mínima</div>
                <div class="info-value">{{ $grupo->porcentaje_asistencia_minima }}%</div>
            </div>
        </div>

        <div class="grid-2">
            <!-- Alumnos inscritos -->
            <div class="card">
                <div class="card-header">
                    Alumnos Inscritos
                    <span class="count-badge">{{ $grupo->alumnos->count() }}</span>
                </div>
                @forelse($grupo->alumnos as $alumno)
                <div class="alumno-item">
                    <div class="avatar">{{ substr($alumno->name, 0, 1) }}</div>
                    <div style="flex:1">
                        <div class="alumno-name">{{ $alumno->name }}</div>
                        <div class="alumno-mat">{{ $alumno->matricula ?? $alumno->email }}</div>
                    </div>
                    <form method="POST"
                          action="{{ route('admin.inscripciones.desinscribir', [$grupo, $alumno]) }}"
                          onsubmit="return confirm('¿Remover alumno del grupo?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-remover">Remover</button>
                    </form>
                </div>
                @empty
                <div class="empty-state">No hay alumnos inscritos aún.</div>
                @endforelse
            </div>

            <!-- Alumnos disponibles -->
            <div class="card">
                <div class="card-header">
                    Alumnos Disponibles
                    <span class="count-badge">{{ $alumnosDisponibles->count() }}</span>
                </div>
                @forelse($alumnosDisponibles as $alumno)
                <div class="alumno-item">
                    <div class="avatar">{{ substr($alumno->name, 0, 1) }}</div>
                    <div style="flex:1">
                        <div class="alumno-name">{{ $alumno->name }}</div>
                        <div class="alumno-mat">{{ $alumno->matricula ?? $alumno->email }}</div>
                    </div>
                    <form method="POST"
                          action="{{ route('admin.inscripciones.inscribir', $grupo) }}"
                          class="inscribir-form">
                        @csrf
                        <input type="hidden" name="alumno_id" value="{{ $alumno->id }}">
                        <button type="submit" class="btn-inscribir">Inscribir</button>
                    </form>
                </div>
                @empty
                <div class="empty-state">No hay alumnos disponibles.</div>
                @endforelse
            </div>
        </div>
    </main>
</div>
</body>
</html>