<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsistenciaT — Editar Usuario</title>
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
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 0 32px; height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .navbar-brand { display: flex; align-items: center; gap: 12px; }
        .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 10px rgba(99,102,241,0.4);
        }
        .brand-icon svg { width: 20px; height: 20px; fill: white; }
        .brand-name { font-size: 18px; font-weight: 700; }
        .navbar-right { display: flex; align-items: center; gap: 16px; }
        .user-badge {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px; padding: 8px 16px;
        }
        .user-avatar {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600;
        }
        .user-name { font-size: 14px; font-weight: 500; }
        .user-role { font-size: 11px; color: #a78bfa; }
        .btn-logout {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.3);
            border-radius: 10px; color: #fca5a5;
            padding: 8px 16px; font-size: 13px; font-weight: 500;
            cursor: pointer; text-decoration: none;
            transition: all 0.2s; font-family: 'Inter', sans-serif;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.25); color: white; }
        .layout { display: flex; min-height: calc(100vh - 64px); }
        .sidebar {
            width: 240px;
            background: rgba(255,255,255,0.04);
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
            font-size: 14px; font-weight: 500;
            transition: all 0.2s; margin-bottom: 2px;
        }
        .sidebar-item:hover { background: rgba(255,255,255,0.08); color: white; }
        .sidebar-item.active {
            background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(139,92,246,0.2));
            color: white; border: 1px solid rgba(99,102,241,0.3);
        }
        .sidebar-item svg { width: 18px; height: 18px; fill: currentColor; flex-shrink: 0; }
        .main { flex: 1; padding: 32px; overflow-y: auto; }
        .page-header {
            display: flex; align-items: center;
            gap: 16px; margin-bottom: 28px;
        }
        .btn-back {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px; color: rgba(255,255,255,0.7);
            padding: 8px 14px; font-size: 13px;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-back:hover { background: rgba(255,255,255,0.12); color: white; }
        .btn-back svg { width: 16px; height: 16px; fill: currentColor; }
        .page-title { font-size: 26px; font-weight: 700; }
        .page-subtitle { font-size: 14px; color: rgba(255,255,255,0.5); margin-top: 4px; }
        .user-preview {
            display: flex; align-items: center; gap: 16px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; padding: 20px 24px;
            margin-bottom: 24px; max-width: 700px;
        }
        .preview-avatar {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; font-weight: 700; flex-shrink: 0;
        }
        .preview-name { font-size: 18px; font-weight: 600; }
        .preview-email { font-size: 13px; color: rgba(255,255,255,0.5); margin-top: 3px; }
        .preview-badge {
            margin-left: auto;
            padding: 6px 14px; border-radius: 20px;
            font-size: 12px; font-weight: 600;
            background: rgba(99,102,241,0.2);
            border: 1px solid rgba(99,102,241,0.4); color: #a78bfa;
        }
        .form-card {
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; padding: 32px;
            max-width: 700px;
        }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-label { font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.7); }
        .form-label span { font-size: 11px; color: rgba(255,255,255,0.3); margin-left: 4px; }
        .form-input, .form-select {
            padding: 12px 16px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px; color: white;
            font-size: 14px; font-family: 'Inter', sans-serif;
            outline: none; transition: all 0.3s;
        }
        .form-input::placeholder { color: rgba(255,255,255,0.3); }
        .form-input:focus, .form-select:focus {
            border-color: rgba(99,102,241,0.6);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
            background: rgba(255,255,255,0.1);
        }
        .form-select option { background: #302b63; color: white; }
        .form-input.is-invalid { border-color: rgba(239,68,68,0.6); }
        .invalid-feedback { font-size: 12px; color: #f87171; }
        .form-divider {
            grid-column: 1 / -1;
            border: none; border-top: 1px solid rgba(255,255,255,0.08);
            margin: 8px 0;
        }
        .section-label {
            grid-column: 1 / -1; font-size: 12px; font-weight: 600;
            color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px;
        }
        .toggle-group {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px;
        }
        .toggle { position: relative; width: 44px; height: 24px; }
        .toggle input { opacity: 0; width: 0; height: 0; }
        .slider {
            position: absolute; cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255,255,255,0.2);
            border-radius: 24px; transition: 0.3s;
        }
        .slider:before {
            position: absolute; content: "";
            height: 18px; width: 18px; left: 3px; bottom: 3px;
            background: white; border-radius: 50%; transition: 0.3s;
        }
        input:checked + .slider { background: #6366f1; }
        input:checked + .slider:before { transform: translateX(20px); }
        .toggle-label { font-size: 14px; color: rgba(255,255,255,0.7); }
        .form-actions {
            display: flex; gap: 12px;
            justify-content: flex-end; margin-top: 28px;
        }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none; border-radius: 12px; color: white;
            padding: 12px 24px; font-size: 14px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.3s; box-shadow: 0 4px 15px rgba(99,102,241,0.4);
        }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px; color: rgba(255,255,255,0.7);
            padding: 12px 24px; font-size: 14px; font-weight: 600;
            cursor: pointer; font-family: 'Inter', sans-serif;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.12); color: white; }
        .password-hint {
            font-size: 12px; color: rgba(255,255,255,0.35);
            margin-top: 4px;
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
        <a href="{{ route('admin.users.index') }}" class="sidebar-item active">
            <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
            Usuarios
        </a>
        <a href="#" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
            Carreras
        </a>
        <a href="#" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
            Semestres
        </a>
        <a href="#" class="sidebar-item">
            <svg viewBox="0 0 24 24"><path d="M14 6l-1-2H5v17h2v-7h5l1 2h7V6h-6zm4 8h-4l-1-2H7V6h5l1 2h5v6z"/></svg>
            Materias
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
            <a href="{{ route('admin.users.index') }}" class="btn-back">
                <svg viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                Volver
            </a>
            <div>
                <div class="page-title">Editar Usuario</div>
                <div class="page-subtitle">Modifica los datos del usuario</div>
            </div>
        </div>

        <!-- Preview del usuario -->
        <div class="user-preview">
            <div class="preview-avatar">{{ substr($user->name, 0, 1) }}</div>
            <div>
                <div class="preview-name">{{ $user->name }}</div>
                <div class="preview-email">{{ $user->email }}</div>
            </div>
            @foreach($user->roles as $role)
                <div class="preview-badge">{{ ucfirst($role->name) }}</div>
            @endforeach
        </div>

        <div class="form-card">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PATCH')
                <div class="form-grid">

                    <div class="section-label">Información personal</div>

                    <div class="form-group">
                        <label class="form-label">Nombre completo *</label>
                        <input type="text" name="name"
                               class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               value="{{ old('name', $user->name) }}" placeholder="Ej: Juan Pérez">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Correo electrónico *</label>
                        <input type="email" name="email"
                               class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               value="{{ old('email', $user->email) }}" placeholder="correo@ejemplo.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Matrícula</label>
                        <input type="text" name="matricula" class="form-input"
                               value="{{ old('matricula', $user->matricula) }}" placeholder="Ej: 2023001">
                        @error('matricula')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-input"
                               value="{{ old('telefono', $user->telefono) }}" placeholder="Ej: 7531234567">
                    </div>

                    <hr class="form-divider">
                    <div class="section-label">Acceso y rol</div>

                    <div class="form-group">
                        <label class="form-label">Tipo de usuario *</label>
                        <select name="tipo" class="form-select">
                            <option value="admin"   {{ old('tipo', $user->tipo) == 'admin'   ? 'selected' : '' }}>Administrador</option>
                            <option value="maestro" {{ old('tipo', $user->tipo) == 'maestro' ? 'selected' : '' }}>Maestro</option>
                            <option value="alumno"  {{ old('tipo', $user->tipo) == 'alumno'  ? 'selected' : '' }}>Alumno</option>
                        </select>
                        @error('tipo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Rol del sistema *</label>
                        <select name="role" class="form-select">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group full">
                        <label class="form-label">
                            Estado de la cuenta
                        </label>
                        <div class="toggle-group">
                            <label class="toggle">
                                <input type="checkbox" name="activo" value="1"
                                       {{ old('activo', $user->activo) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                            <span class="toggle-label">Usuario activo</span>
                        </div>
                    </div>

                    <hr class="form-divider">
                    <div class="section-label">Cambiar contraseña</div>

                    <div class="form-group">
                        <label class="form-label">
                            Nueva contraseña <span>(opcional)</span>
                        </label>
                        <input type="password" name="password"
                               class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Dejar vacío para no cambiar">
                        <div class="password-hint">Mínimo 8 caracteres</div>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Confirmar nueva contraseña</label>
                        <input type="password" name="password_confirmation"
                               class="form-input" placeholder="Repite la nueva contraseña">
                    </div>

                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </main>
</div>

</body>
</html>