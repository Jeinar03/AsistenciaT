<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Reporte de Asistencia</title>
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
        .stats-row {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px; margin-bottom: 24px;
        }
        .stat-card {
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px; padding: 20px; text-align: center;
        }
        .stat-value { font-size: 32px; font-weight: 700; }
        .stat-label { font-size: 12px; color: rgba(255,255,255,0.5); margin-top: 4px; }
        .table-card {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: rgba(255,255,255,0.04); border-bottom: 1px solid rgba(255,255,255,0.08); }
        th { padding: 14px 20px; text-align: left; font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.8px; }
        tbody tr { border-bottom: 1px solid rgba(255,255,255,0.05); }
        tbody tr:last-child { border-bottom: none; }
        td { padding: 16px 20px; font-size: 14px; }
        .alumno-cell { display: flex; align-items: center; gap: 12px; }
        .avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600; flex-shrink: 0;
        }
        .progress-bar {
            width: 100px; height: 8px;
            background: rgba(255,255,255,0.1); border-radius: 4px; overflow: hidden;
        }
        .progress-fill {
            height: 100%; border-radius: 4px; transition: width 0.3s;
        }
        .badge-aprobado { background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.3); border-radius: 20px; padding: 4px 10px; font-size: 11px; font-weight: 600; color: #6ee7b7; }
        .badge-reprobado { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); border-radius: 20px; padding: 4px 10px; font-size: 11px; font-weight: 600; color: #fca5a5; }
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
                <div class="page-title">Reporte de Asistencia</div>
                <div class="page-subtitle">{{ $grupo->materia->nombre }} — Grupo {{ $grupo->clave }}</div>
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-value" style="color: #6ee7b7">{{ $sesionesRealizadas }}</div>
                <div class="stat-label">Sesiones realizadas</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #a78bfa">{{ $grupo->alumnos->count() }}</div>
                <div class="stat-label">Total alumnos</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #fcd34d">{{ $grupo->porcentaje_asistencia_minima }}%</div>
                <div class="stat-label">Asistencia mínima</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: #6ee7b7">
                    {{ $reporteAlumnos->where('aprobado', true)->count() }}
                </div>
                <div class="stat-label">Alumnos aprobados</div>
            </div>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Presentes</th>
                        <th>Faltas</th>
                        <th>% Asistencia</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reporteAlumnos as $item)
                    <tr>
                        <td>
                            <div class="alumno-cell">
                                <div class="avatar">{{ substr($item['alumno']->name, 0, 1) }}</div>
                                <div>
                                    <div style="font-weight: 500">{{ $item['alumno']->name }}</div>
                                    <div style="font-size: 12px; color: rgba(255,255,255,0.4)">
                                        {{ $item['alumno']->matricula ?? $item['alumno']->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td style="color: #6ee7b7; font-weight: 600">{{ $item['presentes'] }}</td>
                        <td style="color: #fca5a5; font-weight: 600">{{ $item['faltas'] }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="progress-bar">
                                    <div class="progress-fill"
                                         style="width: {{ $item['porcentaje'] }}%;
                                                background: {{ $item['aprobado'] ? 'linear-gradient(90deg, #10b981, #3b82f6)' : 'linear-gradient(90deg, #ef4444, #f59e0b)' }}">
                                    </div>
                                </div>
                                <span style="font-weight: 600; color: {{ $item['aprobado'] ? '#6ee7b7' : '#fca5a5' }}">
                                    {{ $item['porcentaje'] }}%
                                </span>
                            </div>
                        </td>
                        <td>
                            <span class="{{ $item['aprobado'] ? 'badge-aprobado' : 'badge-reprobado' }}">
                                {{ $item['aprobado'] ? '✓ Aprobado' : '✗ En riesgo' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding: 40px; color: rgba(255,255,255,0.3);">
                            No hay alumnos inscritos.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>