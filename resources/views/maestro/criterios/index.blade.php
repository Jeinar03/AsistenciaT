<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Criterios de Evaluación</title>
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
        .alert-error { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .card {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; overflow: hidden;
        }
        .card-header {
            padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.08);
            font-size: 15px; font-weight: 600;
        }
        .card-body { padding: 20px; }
        .peso-bar {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px; padding: 16px; margin-bottom: 20px;
        }
        .peso-label { font-size: 13px; color: rgba(255,255,255,0.5); margin-bottom: 8px; }
        .peso-progress {
            height: 10px; background: rgba(255,255,255,0.1);
            border-radius: 5px; overflow: hidden; margin-bottom: 6px;
        }
        .peso-fill {
            height: 100%; border-radius: 5px;
            background: linear-gradient(90deg, #10b981, #3b82f6);
            transition: width 0.3s;
        }
        .peso-fill.over { background: linear-gradient(90deg, #ef4444, #f59e0b); }
        .peso-num { font-size: 14px; font-weight: 600; }
        .criterio-item {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px; padding: 16px; margin-bottom: 10px;
            display: flex; align-items: center; gap: 12px;
        }
        .criterio-orden {
            width: 28px; height: 28px;
            background: rgba(99,102,241,0.3); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; flex-shrink: 0;
        }
        .criterio-info { flex: 1; }
        .criterio-nombre { font-size: 14px; font-weight: 600; }
        .criterio-meta { font-size: 12px; color: rgba(255,255,255,0.4); margin-top: 3px; }
        .criterio-peso {
            font-size: 18px; font-weight: 700; color: #a78bfa;
            min-width: 60px; text-align: right;
        }
        .badge-tipo {
            display: inline-flex; padding: 3px 8px; border-radius: 6px;
            font-size: 10px; font-weight: 600; text-transform: uppercase;
        }
        .tipo-examen { background: rgba(239,68,68,0.2); color: #fca5a5; }
        .tipo-tarea { background: rgba(59,130,246,0.2); color: #93c5fd; }
        .tipo-proyecto { background: rgba(245,158,11,0.2); color: #fcd34d; }
        .tipo-participacion { background: rgba(16,185,129,0.2); color: #6ee7b7; }
        .tipo-asistencia { background: rgba(139,92,246,0.2); color: #c4b5fd; }
        .tipo-otro { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.6); }
        .btn-delete-criterio {
            padding: 6px 12px; border-radius: 8px;
            background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5; font-size: 12px; cursor: pointer;
            font-family: 'Inter', sans-serif; transition: all 0.2s;
        }
        .btn-delete-criterio:hover { background: rgba(239,68,68,0.3); color: white; }
        .form-group { margin-bottom: 16px; }
        .form-label { font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.7); margin-bottom: 6px; display: block; }
        .form-input, .form-select {
            width: 100%; padding: 11px 14px;
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px; color: white; font-size: 14px;
            font-family: 'Inter', sans-serif; outline: none; transition: all 0.3s;
        }
        .form-input:focus, .form-select:focus {
            border-color: rgba(16,185,129,0.6); box-shadow: 0 0 0 3px rgba(16,185,129,0.15);
        }
        .form-input::placeholder { color: rgba(255,255,255,0.3); }
        .form-select option { background: #302b63; }
        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .btn-primary {
            width: 100%; padding: 12px;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            border: none; border-radius: 10px; color: white;
            font-size: 14px; font-weight: 600; cursor: pointer;
            font-family: 'Inter', sans-serif; transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(16,185,129,0.3);
        }
        .btn-primary:hover { transform: translateY(-2px); }
        .empty-state {
            text-align: center; padding: 30px;
            color: rgba(255,255,255,0.3); font-size: 14px;
        }
        .btn-calificaciones {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none; border-radius: 12px; color: white;
            padding: 10px 20px; font-size: 14px; font-weight: 600;
            text-decoration: none; transition: all 0.3s; margin-top: 16px;
            box-shadow: 0 4px 15px rgba(99,102,241,0.3);
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
        <a href="{{ route('maestro.criterios.index', $grupo) }}" class="sidebar-item active">
            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
            Criterios
        </a>
    </aside>
    <main class="main">
        <div class="page-header">
            <a href="{{ route('maestro.dashboard') }}" class="btn-back">
                <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                Volver
            </a>
            <div>
                <div class="page-title">Criterios de Evaluación</div>
                <div class="page-subtitle">{{ $grupo->materia->nombre }} — Grupo {{ $grupo->clave }}</div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        @endif

        <div class="grid-2">
            <!-- Lista de criterios -->
            <div>
                <div class="peso-bar">
                    <div class="peso-label">Peso total asignado</div>
                    <div class="peso-progress">
                        <div class="peso-fill {{ $totalPeso > 100 ? 'over' : '' }}"
                             style="width: {{ min($totalPeso, 100) }}%"></div>
                    </div>
                    <div class="peso-num" style="color: {{ $totalPeso > 100 ? '#fca5a5' : ($totalPeso == 100 ? '#6ee7b7' : '#fcd34d') }}">
                        {{ $totalPeso }}% / 100%
                        @if($totalPeso == 100) ✓ @elseif($totalPeso > 100) ⚠️ Excede 100% @else (faltan {{ 100 - $totalPeso }}%) @endif
                    </div>
                </div>

                @forelse($criterios as $criterio)
                <div class="criterio-item">
                    <div class="criterio-orden">{{ $criterio->orden }}</div>
                    <div class="criterio-info">
                        <div class="criterio-nombre">{{ $criterio->nombre }}</div>
                        <div class="criterio-meta">
                            <span class="badge-tipo tipo-{{ $criterio->tipo }}">{{ $criterio->tipo }}</span>
                            @if($criterio->fecha_entrega)
                                · {{ $criterio->fecha_entrega->format('d/m/Y') }}
                            @endif
                        </div>
                    </div>
                    <div class="criterio-peso">{{ $criterio->peso }}%</div>
                    <form method="POST" action="{{ route('maestro.criterios.destroy', [$grupo, $criterio]) }}"
                          onsubmit="return confirm('¿Eliminar criterio?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete-criterio">✕</button>
                    </form>
                </div>
                @empty
                <div class="empty-state">📊 No hay criterios definidos aún.</div>
                @endforelse

                @if($totalPeso == 100)
                <a href="{{ route('maestro.calificaciones.index', $grupo) }}" class="btn-calificaciones">
                    📝 Ir a Calificaciones
                </a>
                @endif
            </div>

            <!-- Formulario nuevo criterio -->
            <div class="card">
                <div class="card-header">➕ Nuevo Criterio</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('maestro.criterios.store', $grupo) }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="nombre" class="form-input"
                                   placeholder="Ej: Examen Parcial 1" required>
                        </div>
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label">Peso % *</label>
                                <input type="number" name="peso" class="form-input"
                                       placeholder="30" min="0" max="100" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Orden *</label>
                                <input type="number" name="orden" class="form-input"
                                       value="{{ $criterios->count() + 1 }}" min="1" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tipo *</label>
                            <select name="tipo" class="form-select" required>
                                <option value="examen">Examen</option>
                                <option value="tarea">Tarea</option>
                                <option value="proyecto">Proyecto</option>
                                <option value="participacion">Participación</option>
                                <option value="asistencia">Asistencia</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Fecha de entrega</label>
                            <input type="date" name="fecha_entrega" class="form-input">
                        </div>
                        <button type="submit" class="btn-primary">Agregar Criterio</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>