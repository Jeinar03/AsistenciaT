<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Editar Grupo</title>
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
            background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(139,92,246,0.2));
            color: white; border: 1px solid rgba(99,102,241,0.3);
        }
        .sidebar-item svg { width: 18px; height: 18px; fill: currentColor; flex-shrink: 0; }
        .main { flex: 1; padding: 32px; overflow-y: auto; }
        .page-header { display: flex; align-items: center; gap: 16px; margin-bottom: 28px; }
        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px; color: rgba(255,255,255,0.7);
            padding: 8px 14px; font-size: 13px; text-decoration: none;
        }
        .btn-back svg { width: 16px; height: 16px; fill: currentColor; }
        .page-title { font-size: 26px; font-weight: 700; }
        .page-subtitle { font-size: 14px; color: rgba(255,255,255,0.5); margin-top: 4px; }
        .form-card {
            background: rgba(255,255,255,0.06); backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1); border-radius: 16px;
            padding: 32px; max-width: 700px;
        }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-label { font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.7); }
        .form-input, .form-select {
            padding: 12px 16px; background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12); border-radius: 10px;
            color: white; font-size: 14px; font-family: 'Inter', sans-serif;
            outline: none; transition: all 0.3s;
        }
        .form-input:focus, .form-select:focus {
            border-color: rgba(99,102,241,0.6);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }
        .form-select option { background: #302b63; color: white; }
        .section-title {
            font-size: 14px; font-weight: 600; color: rgba(255,255,255,0.5);
            text-transform: uppercase; letter-spacing: 1px;
            margin: 24px 0 16px; padding-bottom: 8px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .horario-row {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px; padding: 16px; margin-bottom: 12px;
        }
        .horario-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 12px; align-items: end; }
        .btn-remove-horario {
            padding: 10px 14px; border-radius: 8px;
            background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5; font-size: 16px; cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .btn-add-horario {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(99,102,241,0.2); border: 1px solid rgba(99,102,241,0.3);
            border-radius: 10px; color: #a78bfa; padding: 10px 16px;
            font-size: 13px; font-weight: 500; cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .toggle-group {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px; background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12); border-radius: 10px;
        }
        .toggle { position: relative; width: 44px; height: 24px; }
        .toggle input { opacity: 0; width: 0; height: 0; }
        .slider {
            position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255,255,255,0.2); border-radius: 24px; transition: 0.3s;
        }
        .slider:before {
            position: absolute; content: ""; height: 18px; width: 18px;
            left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: 0.3s;
        }
        input:checked + .slider { background: #6366f1; }
        input:checked + .slider:before { transform: translateX(20px); }
        .toggle-label { font-size: 14px; color: rgba(255,255,255,0.7); }
        .form-actions { display: flex; gap: 12px; justify-content: flex-end; margin-top: 28px; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none; border-radius: 12px; color: white;
            padding: 12px 24px; font-size: 14px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.3s; box-shadow: 0 4px 15px rgba(99,102,241,0.4);
        }
        .btn-secondary {
            display: inline-flex; align-items: center;
            background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px; color: rgba(255,255,255,0.7);
            padding: 12px 24px; font-size: 14px; font-weight: 600;
            text-decoration: none; font-family: 'Inter', sans-serif;
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
                <div class="page-title">Editar Grupo</div>
                <div class="page-subtitle">{{ $grupo->materia->nombre }} — {{ $grupo->clave }}</div>
            </div>
        </div>
        <div class="form-card">
            <form method="POST" action="{{ route('admin.grupos.update', $grupo) }}">
                @csrf @method('PUT')
                <div class="form-grid">
                    <div class="form-group full">
                        <label class="form-label">Materia *</label>
                        <select name="materia_id" class="form-select">
                            @foreach($materias as $materia)
                                <option value="{{ $materia->id }}" {{ $grupo->materia_id == $materia->id ? 'selected' : '' }}>
                                    {{ $materia->clave }} — {{ $materia->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Semestre *</label>
                        <select name="semestre_id" class="form-select">
                            @foreach($semestres as $semestre)
                                <option value="{{ $semestre->id }}" {{ $grupo->semestre_id == $semestre->id ? 'selected' : '' }}>
                                    {{ $semestre->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Maestro *</label>
                        <select name="maestro_id" class="form-select">
                            @foreach($maestros as $maestro)
                                <option value="{{ $maestro->id }}" {{ $grupo->maestro_id == $maestro->id ? 'selected' : '' }}>
                                    {{ $maestro->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Clave *</label>
                        <input type="text" name="clave" class="form-input"
                               value="{{ old('clave', $grupo->clave) }}"
                               style="text-transform: uppercase">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Máx. alumnos</label>
                        <input type="number" name="max_alumnos" class="form-input"
                               value="{{ old('max_alumnos', $grupo->max_alumnos) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">% Asistencia mínima</label>
                        <input type="number" name="porcentaje_asistencia_minima" class="form-input"
                               value="{{ old('porcentaje_asistencia_minima', $grupo->porcentaje_asistencia_minima) }}"
                               step="0.01">
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Estado</label>
                        <div class="toggle-group">
                            <label class="toggle">
                                <input type="checkbox" name="activo" value="1"
                                       {{ old('activo', $grupo->activo) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                            <span class="toggle-label">Grupo activo</span>
                        </div>
                    </div>
                </div>

                <div class="section-title">🕐 Horarios</div>
                <div id="horariosContainer">
                    @foreach($grupo->horarios as $i => $horario)
                    <div class="horario-row">
                        <div class="horario-grid">
                            <div class="form-group" style="margin:0">
                                <label class="form-label">Día</label>
                                <select name="horarios[{{ $i }}][dia]" class="form-select">
                                    @foreach(['lunes','martes','miercoles','jueves','viernes','sabado'] as $dia)
                                    <option value="{{ $dia }}" {{ $horario->dia == $dia ? 'selected' : '' }}>
                                        {{ ucfirst($dia) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="margin:0">
                                <label class="form-label">Inicio</label>
                                <input type="time" name="horarios[{{ $i }}][hora_inicio]"
                                       class="form-input" value="{{ substr($horario->hora_inicio, 0, 5) }}">
                            </div>
                            <div class="form-group" style="margin:0">
                                <label class="form-label">Fin</label>
                                <input type="time" name="horarios[{{ $i }}][hora_fin]"
                                       class="form-input" value="{{ substr($horario->hora_fin, 0, 5) }}">
                            </div>
                            <div class="form-group" style="margin:0">
                                <label class="form-label">Aula</label>
                                <input type="text" name="horarios[{{ $i }}][aula]"
                                       class="form-input" value="{{ $horario->aula }}">
                            </div>
                            <button type="button" class="btn-remove-horario" onclick="removeHorario(this)">✕</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn-add-horario" onclick="addHorario()">
                    + Agregar otro día
                </button>

                <div class="form-actions">
                    <a href="{{ route('admin.grupos.index') }}" class="btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </main>
</div>
<script>
let horarioCount = {{ $grupo->horarios->count() }};
function addHorario() {
    const container = document.getElementById('horariosContainer');
    const idx = horarioCount++;
    container.insertAdjacentHTML('beforeend', `
        <div class="horario-row">
            <div class="horario-grid">
                <div class="form-group" style="margin:0">
                    <label class="form-label">Día</label>
                    <select name="horarios[${idx}][dia]" class="form-select">
                        <option value="lunes">Lunes</option>
                        <option value="martes">Martes</option>
                        <option value="miercoles">Miércoles</option>
                        <option value="jueves">Jueves</option>
                        <option value="viernes">Viernes</option>
                        <option value="sabado">Sábado</option>
                    </select>
                </div>
                <div class="form-group" style="margin:0">
                    <label class="form-label">Inicio</label>
                    <input type="time" name="horarios[${idx}][hora_inicio]" class="form-input" value="07:00">
                </div>
                <div class="form-group" style="margin:0">
                    <label class="form-label">Fin</label>
                    <input type="time" name="horarios[${idx}][hora_fin]" class="form-input" value="09:00">
                </div>
                <div class="form-group" style="margin:0">
                    <label class="form-label">Aula</label>
                    <input type="text" name="horarios[${idx}][aula]" class="form-input" placeholder="Ej: A101">
                </div>
                <button type="button" class="btn-remove-horario" onclick="removeHorario(this)">✕</button>
            </div>
        </div>
    `);
}
function removeHorario(btn) {
    const rows = document.querySelectorAll('.horario-row');
    if (rows.length > 1) btn.closest('.horario-row').remove();
}
</script>
</body>
</html>