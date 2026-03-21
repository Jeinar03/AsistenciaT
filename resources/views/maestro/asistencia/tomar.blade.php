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
        .sesion-info {
            background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2);
            border-radius: 14px; padding: 20px 24px; margin-bottom: 24px;
            display: flex; gap: 32px; align-items: center; flex-wrap: wrap;
        }
        .info-item .info-label { font-size: 11px; color: rgba(255,255,255,0.4); text-transform: uppercase; }
        .info-item .info-value { font-size: 15px; font-weight: 600; margin-top: 3px; }
        .quick-actions { display: flex; gap: 10px; margin-bottom: 20px; }
        .btn-all {
            padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 500;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s;
        }
        .btn-all-present {
            background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.3);
            color: #6ee7b7;
        }
        .btn-all-absent {
            background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5;
        }
        .counter-bar {
            display: flex; gap: 16px; margin-bottom: 16px;
            padding: 12px 20px; background: rgba(255,255,255,0.04); border-radius: 12px;
        }
        .counter-item { font-size: 13px; }
        .counter-num { font-weight: 700; font-size: 18px; }
        .counter-presente .counter-num { color: #6ee7b7; }
        .counter-falta .counter-num { color: #fca5a5; }
        .counter-retardo .counter-num { color: #fcd34d; }
        .alumnos-list {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; overflow: hidden;
        }
        .alumno-row {
            display: flex; align-items: center; padding: 16px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: background 0.2s; gap: 16px;
        }
        .alumno-row:hover { background: rgba(255,255,255,0.03); }
        .alumno-row:last-child { border-bottom: none; }
        .alumno-avatar {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 600; flex-shrink: 0;
        }
        .alumno-info { flex: 1; }
        .alumno-nombre { font-weight: 500; font-size: 15px; }
        .alumno-matricula { font-size: 12px; color: rgba(255,255,255,0.4); margin-top: 2px; }
        .asistencia-opciones { display: flex; gap: 8px; }
        .opcion-btn {
            padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s;
            border: 2px solid transparent;
        }
        .opcion-presente { background: rgba(16,185,129,0.1); color: #6ee7b7; border-color: rgba(16,185,129,0.2); }
        .opcion-presente.selected { background: rgba(16,185,129,0.3); border-color: #10b981; }
        .opcion-retardo { background: rgba(245,158,11,0.1); color: #fcd34d; border-color: rgba(245,158,11,0.2); }
        .opcion-retardo.selected { background: rgba(245,158,11,0.3); border-color: #f59e0b; }
        .opcion-falta { background: rgba(239,68,68,0.1); color: #fca5a5; border-color: rgba(239,68,68,0.2); }
        .opcion-falta.selected { background: rgba(239,68,68,0.3); border-color: #ef4444; }
        .opcion-justificada { background: rgba(99,102,241,0.1); color: #a78bfa; border-color: rgba(99,102,241,0.2); }
        .opcion-justificada.selected { background: rgba(99,102,241,0.3); border-color: #6366f1; }
        .form-actions { display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            border: none; border-radius: 12px; color: white;
            padding: 14px 28px; font-size: 15px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.3s; box-shadow: 0 4px 15px rgba(16,185,129,0.4);
        }
        .btn-primary:hover { transform: translateY(-2px); }
        .empty-state { text-align: center; padding: 40px; color: rgba(255,255,255,0.3); font-size: 15px; }
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
            <a href="{{ route('maestro.asistencia.sesiones', $sesion->grupo_id) }}" class="btn-back">
                <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                Volver
            </a>
            <div>
                <div class="page-title">Lista de Asistencia</div>
                <div class="page-subtitle">{{ $sesion->grupo->materia->nombre }} — {{ $sesion->fecha->format('d/m/Y') }}</div>
            </div>
        </div>

        <div class="sesion-info">
            <div class="info-item">
                <div class="info-label">Fecha</div>
                <div class="info-value">{{ $sesion->fecha->translatedFormat('l d \d\e F') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Horario</div>
                <div class="info-value">{{ substr($sesion->hora_inicio,0,5) }} — {{ substr($sesion->hora_fin,0,5) }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Grupo</div>
                <div class="info-value">{{ $sesion->grupo->clave }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Total alumnos</div>
                <div class="info-value">{{ $sesion->grupo->alumnos->count() }}</div>
            </div>
        </div>

        @if($sesion->grupo->alumnos->count() > 0)
        <form method="POST" action="{{ route('maestro.asistencia.guardar', $sesion) }}">
            @csrf
            <div class="quick-actions">
                <button type="button" class="btn-all btn-all-present" onclick="marcarTodos('presente')">✓ Todos Presentes</button>
                <button type="button" class="btn-all btn-all-absent" onclick="marcarTodos('falta')">✗ Todos Ausentes</button>
            </div>
            <div class="counter-bar">
                <div class="counter-item counter-presente">
                    <div class="counter-num" id="count-presente">0</div>
                    <div>Presentes</div>
                </div>
                <div class="counter-item counter-retardo">
                    <div class="counter-num" id="count-retardo">0</div>
                    <div>Retardos</div>
                </div>
                <div class="counter-item counter-falta">
                    <div class="counter-num" id="count-falta">{{ $sesion->grupo->alumnos->count() }}</div>
                    <div>Faltas</div>
                </div>
            </div>
            <div class="alumnos-list">
                @foreach($sesion->grupo->alumnos as $alumno)
                @php $estadoActual = $asistencias[$alumno->id] ?? 'falta'; @endphp
                <div class="alumno-row">
                    <div class="alumno-avatar">{{ substr($alumno->name, 0, 1) }}</div>
                    <div class="alumno-info">
                        <div class="alumno-nombre">{{ $alumno->name }}</div>
                        <div class="alumno-matricula">{{ $alumno->matricula ?? $alumno->email }}</div>
                    </div>
                    <div class="asistencia-opciones">
                        <input type="hidden" name="asistencia[{{ $alumno->id }}]"
                               id="input-{{ $alumno->id }}" value="{{ $estadoActual }}">
                        <button type="button"
                                class="opcion-btn opcion-presente {{ $estadoActual == 'presente' ? 'selected' : '' }}"
                                onclick="setEstado({{ $alumno->id }}, 'presente', this)">P</button>
                        <button type="button"
                                class="opcion-btn opcion-retardo {{ $estadoActual == 'retardo' ? 'selected' : '' }}"
                                onclick="setEstado({{ $alumno->id }}, 'retardo', this)">R</button>
                        <button type="button"
                                class="opcion-btn opcion-falta {{ $estadoActual == 'falta' ? 'selected' : '' }}"
                                onclick="setEstado({{ $alumno->id }}, 'falta', this)">F</button>
                        <button type="button"
                                class="opcion-btn opcion-justificada {{ $estadoActual == 'justificada' ? 'selected' : '' }}"
                                onclick="setEstado({{ $alumno->id }}, 'justificada', this)">J</button>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">💾 Guardar Asistencia</button>
            </div>
        </form>
        @else
        <div class="alumnos-list">
            <div class="empty-state">👥 No hay alumnos inscritos en este grupo aún.</div>
        </div>
        @endif
    </main>
</div>
<script>
function setEstado(alumnoId, estado, btn) {
    document.getElementById('input-' + alumnoId).value = estado;
    const row = btn.closest('.asistencia-opciones');
    row.querySelectorAll('.opcion-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    updateCounters();
}
function marcarTodos(estado) {
    document.querySelectorAll('.alumno-row').forEach(row => {
        const input = row.querySelector('input[type="hidden"]');
        const alumnoId = input.name.match(/\d+/)[0];
        const btn = row.querySelector('.opcion-' + estado);
        if (btn) {
            input.value = estado;
            row.querySelectorAll('.opcion-btn').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
        }
    });
    updateCounters();
}
function updateCounters() {
    let presente = 0, retardo = 0, falta = 0;
    document.querySelectorAll('input[name^="asistencia"]').forEach(input => {
        if (input.value === 'presente') presente++;
        else if (input.value === 'retardo') retardo++;
        else falta++;
    });
    document.getElementById('count-presente').textContent = presente;
    document.getElementById('count-retardo').textContent = retardo;
    document.getElementById('count-falta').textContent = falta;
}
updateCounters();
</script>
</body>
</html>