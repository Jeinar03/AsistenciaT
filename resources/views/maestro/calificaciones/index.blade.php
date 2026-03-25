<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Calificaciones</title>
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
        .alert { padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7; }
        .table-wrapper {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; overflow: auto;
        }
        table { width: 100%; border-collapse: collapse; min-width: 600px; }
        thead tr { background: rgba(255,255,255,0.05); }
        th {
            padding: 14px 16px; text-align: left; font-size: 12px; font-weight: 600;
            color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.8px;
            border-bottom: 1px solid rgba(255,255,255,0.08); white-space: nowrap;
        }
        th.criterio-header {
            text-align: center; min-width: 100px;
        }
        tbody tr { border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s; }
        tbody tr:hover { background: rgba(255,255,255,0.03); }
        tbody tr:last-child { border-bottom: none; }
        td { padding: 14px 16px; font-size: 14px; }
        .alumno-cell { display: flex; align-items: center; gap: 10px; }
        .avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600; flex-shrink: 0;
        }
        .cal-input {
            width: 80px; padding: 8px 10px; text-align: center;
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px; color: white; font-size: 14px;
            font-family: 'Inter', sans-serif; outline: none; transition: all 0.2s;
        }
        .cal-input:focus {
            border-color: rgba(16,185,129,0.6); box-shadow: 0 0 0 3px rgba(16,185,129,0.15);
            background: rgba(255,255,255,0.12);
        }
        .cal-input::-webkit-inner-spin-button { -webkit-appearance: none; }
        td.criterio-cell { text-align: center; }
        .promedio-cell {
            font-weight: 700; font-size: 16px; text-align: center;
        }
        .form-actions {
            display: flex; justify-content: flex-end; padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            border: none; border-radius: 12px; color: white;
            padding: 12px 28px; font-size: 14px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.3s; box-shadow: 0 4px 15px rgba(16,185,129,0.3);
        }
        .btn-primary:hover { transform: translateY(-2px); }
        .criterio-peso {
            font-size: 10px; color: rgba(255,255,255,0.4);
            display: block; margin-top: 2px;
        }
        .empty-state {
            text-align: center; padding: 40px;
            color: rgba(255,255,255,0.3); font-size: 15px;
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
        <a href="{{ route('maestro.asistencia.index') }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
            Tomar Asistencia
        </a>
        <a href="{{ route('maestro.criterios.index', $grupo) }}" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
            Criterios
        </a>
        <a href="{{ route('maestro.calificaciones.index', $grupo) }}" class="sidebar-item active">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/></svg>
            Calificaciones
        </a>
    </aside>
    <main class="main">
        <div class="page-header">
            <a href="{{ route('maestro.criterios.index', $grupo) }}" class="btn-back">
                <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                Volver
            </a>
            <div>
                <div class="page-title">Calificaciones</div>
                <div class="page-subtitle">{{ $grupo->materia->nombre }} — Grupo {{ $grupo->clave }}</div>
            </div>
            </div>
            <a href="{{ route('maestro.reporte.calificaciones.pdf', $grupo) }}" style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#ef4444,#dc2626);border-radius:12px;color:white;padding:10px 20px;font-size:14px;font-weight:600;text-decoration:none;box-shadow:0 4px 15px rgba(239,68,68,0.4);">?? Exportar PDF</a>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        @if($criterios->count() == 0)
            <div class="table-wrapper">
                <div class="empty-state">📊 Define los criterios de evaluación primero.</div>
            </div>
        @elseif($grupo->alumnos->count() == 0)
            <div class="table-wrapper">
                <div class="empty-state">👥 No hay alumnos inscritos en este grupo.</div>
            </div>
        @else
        <form method="POST" action="{{ route('maestro.calificaciones.guardar', $grupo) }}">
            @csrf
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            @foreach($criterios as $criterio)
                            <th class="criterio-header">
                                {{ $criterio->nombre }}
                                <span class="criterio-peso">{{ $criterio->peso }}%</span>
                            </th>
                            @endforeach
                            <th style="text-align:center">Promedio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grupo->alumnos as $alumno)
                        <tr>
                            <td>
                                <div class="alumno-cell">
                                    <div class="avatar">{{ substr($alumno->name, 0, 1) }}</div>
                                    <div>
                                        <div style="font-weight:500">{{ $alumno->name }}</div>
                                        <div style="font-size:12px;color:rgba(255,255,255,0.4)">{{ $alumno->matricula ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            @foreach($criterios as $criterio)
                            <td class="criterio-cell">
                                <input type="number"
                                       name="calificaciones[{{ $alumno->id }}][{{ $criterio->id }}]"
                                       class="cal-input"
                                       value="{{ $calificaciones[$alumno->id][$criterio->id] ?? '' }}"
                                       min="0" max="100" step="0.1"
                                       placeholder="—"
                                       onchange="calcularPromedio({{ $alumno->id }})">
                            </td>
                            @endforeach
                            <td class="promedio-cell">
                                <span id="promedio-{{ $alumno->id }}" style="color: #6ee7b7">—</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        💾 Guardar Calificaciones
                    </button>
                </div>
            </div>
        </form>
        @endif
    </main>
</div>
<script>
const criterios = @json($criterios->map(fn($c) => ['id' => $c->id, 'peso' => $c->peso]));

function calcularPromedio(alumnoId) {
    let total = 0;
    let pesoTotal = 0;
    criterios.forEach(criterio => {
        const input = document.querySelector(`input[name="calificaciones[${alumnoId}][${criterio.id}]"]`);
        if (input && input.value !== '') {
            total += parseFloat(input.value) * (criterio.peso / 100);
            pesoTotal += criterio.peso;
        }
    });
    const span = document.getElementById(`promedio-${alumnoId}`);
    if (pesoTotal > 0) {
        const promedio = (total / pesoTotal * 100).toFixed(1);
        span.textContent = promedio;
        span.style.color = promedio >= 60 ? '#6ee7b7' : '#fca5a5';
    } else {
        span.textContent = '—';
    }
}
</script>
</body>
</html>
