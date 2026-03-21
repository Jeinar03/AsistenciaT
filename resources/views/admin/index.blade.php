<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Auditoría</title>
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
        .page-header { margin-bottom: 24px; }
        .page-title { font-size: 26px; font-weight: 700; }
        .page-subtitle { font-size: 14px; color: rgba(255,255,255,0.5); margin-top: 4px; }
        .table-card {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: rgba(255,255,255,0.04); border-bottom: 1px solid rgba(255,255,255,0.08); }
        th { padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.8px; }
        tbody tr { border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s; }
        tbody tr:hover { background: rgba(255,255,255,0.03); }
        tbody tr:last-child { border-bottom: none; }
        td { padding: 14px 16px; font-size: 13px; }
        .user-cell { display: flex; align-items: center; gap: 10px; }
        .avatar {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 600; flex-shrink: 0;
        }
        .badge-accion {
            display: inline-flex; padding: 3px 10px; border-radius: 6px;
            font-size: 11px; font-weight: 600; text-transform: uppercase;
        }
        .accion-crear { background: rgba(16,185,129,0.2); color: #6ee7b7; }
        .accion-editar { background: rgba(59,130,246,0.2); color: #93c5fd; }
        .accion-eliminar { background: rgba(239,68,68,0.2); color: #fca5a5; }
        .accion-login { background: rgba(99,102,241,0.2); color: #a78bfa; }
        .accion-logout { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.5); }
        .accion-default { background: rgba(245,158,11,0.2); color: #fcd34d; }
        .modulo-badge {
            display: inline-flex; padding: 3px 8px; border-radius: 6px;
            font-size: 11px; background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.6);
        }
        .fecha-cell { font-size: 12px; color: rgba(255,255,255,0.5); }
        .fecha-cell span { display: block; color: white; font-size: 13px; font-weight: 500; }
        .empty-state { text-align: center; padding: 60px; color: rgba(255,255,255,0.3); font-size: 15px; }
        .stats-row {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px; margin-bottom: 24px;
        }
        .stat-card {
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px; padding: 16px; text-align: center;
        }
        .stat-num { font-size: 28px; font-weight: 700; }
        .stat-lbl { font-size: 12px; color: rgba(255,255,255,0.4); margin-top: 4px; }
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
        <a href="{{ route('admin.grupos.index') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z"/></svg>
            Grupos
        </a>
        <div class="sidebar-section">Reportes</div>
        <a href="#" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
            Reportes
        </a>
        <a href="{{ route('admin.auditoria.index') }}" class="sidebar-item active">
            <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
            Auditoría
        </a>
    </aside>
    <main class="main">
        <div class="page-header">
            <div class="page-title">🛡️ Log de Auditoría</div>
            <div class="page-subtitle">Registro de todas las acciones en el sistema</div>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-num" style="color:#a78bfa">{{ $logs->total() }}</div>
                <div class="stat-lbl">Total registros</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color:#6ee7b7">{{ $logs->where('accion', 'crear')->count() }}</div>
                <div class="stat-lbl">Creaciones</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color:#93c5fd">{{ $logs->where('accion', 'editar')->count() }}</div>
                <div class="stat-lbl">Ediciones</div>
            </div>
            <div class="stat-card">
                <div class="stat-num" style="color:#fca5a5">{{ $logs->where('accion', 'eliminar')->count() }}</div>
                <div class="stat-lbl">Eliminaciones</div>
            </div>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Módulo</th>
                        <th>Descripción</th>
                        <th>IP</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="avatar">{{ substr($log->user?->name ?? 'S', 0, 1) }}</div>
                                <div>
                                    <div style="font-weight:500">{{ $log->user?->name ?? 'Sistema' }}</div>
                                    <div style="font-size:11px;color:rgba(255,255,255,0.4)">{{ $log->user?->tipo ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $claseAccion = match($log->accion) {
                                    'crear' => 'accion-crear',
                                    'editar' => 'accion-editar',
                                    'eliminar' => 'accion-eliminar',
                                    'login' => 'accion-login',
                                    'logout' => 'accion-logout',
                                    default => 'accion-default'
                                };
                            @endphp
                            <span class="badge-accion {{ $claseAccion }}">{{ $log->accion }}</span>
                        </td>
                        <td><span class="modulo-badge">{{ $log->modulo }}</span></td>
                        <td style="max-width:250px; color:rgba(255,255,255,0.7)">{{ $log->descripcion }}</td>
                        <td style="font-size:12px; color:rgba(255,255,255,0.4); font-family:monospace">{{ $log->ip }}</td>
                        <td>
                            <div class="fecha-cell">
                                <span>{{ $log->created_at->format('d/m/Y') }}</span>
                                {{ $log->created_at->format('H:i:s') }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            🛡️ No hay registros de auditoría aún.<br>
                            <small style="font-size:13px">Los registros aparecerán aquí cuando el sistema detecte actividad.</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:20px">{{ $logs->links() }}</div>
    </main>
</div>
</body>
</html>