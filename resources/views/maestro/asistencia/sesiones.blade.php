<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Sesiones</title>
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
            background: linear-gradient(135deg, rgba(16,185,129,0.25), rgba(59,130,246,0.2));
            color: white; border: 1px solid rgba(16,185,129,0.3);
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
        .alert { padding: 14px 18px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; }
        .alert-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7; }
        .grupo-info {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px; padding: 20px 24px; margin-bottom: 24px;
            display: flex; gap: 32px; align-items: center;
        }
        .info-item { }
        .info-label { font-size: 11px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.8px; }
        .info-value { font-size: 15px; font-weight: 600; margin-top: 3px; }
        .table-card {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: rgba(255,255,255,0.04); border-bottom: 1px solid rgba(255,255,255,0.08); }
        th { padding: 14px 20px; text-align: left; font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.8px; }
        tbody tr { border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s; }
        tbody tr:hover { background: rgba(255,255,255,0.04); }
        tbody tr:last-child { border-bottom: none; }
        td { padding: 16px 20px; font-size: 14px; }
        .fecha-cell { display: flex; align-items: center; gap: 12px; }
        .fecha-badge {
            background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.25);
            border-radius: 10px; padding: 8px 12px; text-align: center; min-width: 56px;
        }
        .fecha-dia { font-size: 20px; font-weight: 700; color: #6ee7b7; line-height: 1; }
        .fecha-mes { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 2px; }
        .badge {
            display: inline-flex; align-items: center;
            padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;
        }
        .badge-programada { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.5); }
        .badge-realizada { background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7; }
        .badge-cancelada { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; }
        .btn-tomar {
            padding: 7px 16px; border-radius: 8px;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            border: none; color: white; font-size: 12px; font-weight: 600;
            text-decoration: none; transition: all 0.2s; cursor: pointer;
        }
        .btn-tomar:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-ver {
            padding: 7px 16px; border-radius: 8px;
            background: rgba(99,102,241,0.2); border: 1px solid rgba(99,102,241,0.3);
            color: #a78bfa; font-size: 12px; font-weight: 500;
            text-decoration: none; transition: all 0.2s;
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
        <div class="page-header">
            <a href="{{ route('maestro.asistencia.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                Volver
            </a>
            <div>
                <div class="page-title">Sesiones — {{ $grupo->clave }}</div>
                <div class="page-subtitle">{{ $grupo->materia->nombre }}</div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        <div class="grupo-info">
            <div class="info-item">
                <div class="info-label">Grupo</div>
                <div class="info-value">{{ $grupo->clave }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Materia</div>
                <div class="info-value">{{ $grupo->materia->clave }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Semestre</div>
                <div class="info-value">{{ $grupo->semestre->nombre }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Total sesiones</div>
                <div class="info-value">{{ $sesiones->total() }}</div>
            </div>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sesiones as $sesion)
                    <tr>
                        <td>
                            <div class="fecha-cell">
                                <div class="fecha-badge">
                                    <div class="fecha-dia">{{ $sesion->fecha->format('d') }}</div>
                                    <div class="fecha-mes">{{ $sesion->fecha->format('M') }}</div>
                                </div>
                                <div>
                                    <div style="font-weight: 500">{{ $sesion->fecha->translatedFormat('l') }}</div>
                                    <div style="font-size: 12px; color: rgba(255,255,255,0.4)">{{ $sesion->fecha->format('Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="color: rgba(255,255,255,0.6)">
                            {{ substr($sesion->hora_inicio, 0, 5) }} — {{ substr($sesion->hora_fin, 0, 5) }}
                        </td>
                        <td>
                            <span class="badge badge-{{ $sesion->estado }}">
                                {{ ucfirst($sesion->estado) }}
                            </span>
                        </td>
                        <td>
                            @if($sesion->estado === 'programada')
                                <a href="{{ route('maestro.asistencia.tomar', $sesion) }}" class="btn-tomar">
                                    Tomar Asistencia
                                </a>
                            @else
                                <a href="{{ route('maestro.asistencia.tomar', $sesion) }}" class="btn-ver">
                                    Ver/Editar
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding: 40px; color: rgba(255,255,255,0.3);">
                            No hay sesiones registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top: 20px">{{ $sesiones->links() }}</div>
    </main>
</div>
</body>
</html>