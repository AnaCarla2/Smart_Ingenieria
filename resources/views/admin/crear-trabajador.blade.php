<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Smart Ingeniería — Nuevo Trabajador</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{background:#09090b;color:#fff;font-family:system-ui,sans-serif;min-height:100vh;display:flex}
        .sidebar{width:220px;background:#111113;border-right:1px solid #27272a;display:flex;flex-direction:column;position:fixed;height:100vh;z-index:50}
        .sidebar-logo{padding:18px 16px;border-bottom:1px solid #27272a;display:flex;align-items:center;gap:10px}
        .logo-ic{width:32px;height:32px;background:#f59e0b;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:900;color:#000;flex-shrink:0}
        .sidebar-nav{flex:1;padding:12px 8px;display:flex;flex-direction:column;gap:2px}
        .nav-item{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;color:#71717a;font-size:13px;text-decoration:none;transition:all .15s;cursor:pointer}
        .nav-item:hover{background:#27272a;color:#fff}
        .nav-item.active{background:#1c1c1e;color:#f59e0b;border:1px solid #27272a}
        .nav-icon{font-size:16px;width:20px;text-align:center}
        .sidebar-footer{padding:12px 8px;border-top:1px solid #27272a}
        .main{margin-left:220px;flex:1;display:flex;flex-direction:column}
        .topbar{background:#111113;border-bottom:1px solid #27272a;padding:0 24px;height:54px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        .content{padding:24px;flex:1}
        .form-card{background:#18181b;border:1px solid #27272a;border-radius:12px;padding:24px;max-width:640px}
        .field{display:flex;flex-direction:column;gap:5px;margin-bottom:16px}
        .field label{font-size:11px;color:#71717a;text-transform:uppercase;letter-spacing:.04em;font-weight:600}
        .field input,.field select{background:#27272a;border:1px solid #3f3f46;border-radius:8px;padding:10px 14px;color:#fff;font-size:14px;font-family:inherit;outline:none;transition:border-color .2s;width:100%}
        .field input:focus,.field select:focus{border-color:#f59e0b}
        .field select option{background:#27272a}
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;font-family:inherit;transition:all .15s}
        .btn-amarillo{background:#f59e0b;color:#000}
        .btn-amarillo:hover{background:#fbbf24}
        .btn-gris{background:#27272a;color:#fff}
        .btn-gris:hover{background:#3f3f46}
        .alert-err{background:#7f1d1d;border:1px solid #dc2626;border-radius:8px;padding:12px 16px;color:#fca5a5;font-size:13px;margin-bottom:16px}
    </style>
</head>
    
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-ic">⚙</div>
        <div>
            <p style="color:#fff;font-weight:900;font-size:13px;line-height:1.2">SMART ING.</p>
            <p style="color:#3f3f46;font-size:10px">Administrador</p>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="{{ route('admin.proyectos.crear') }}" class="nav-item">
            <span class="nav-icon">🏗️</span> Nuevo Proyecto
        </a>
        <a href="{{ route('admin.trabajadores.crear') }}" class="nav-item active">
            <span class="nav-icon">👷</span> Nuevo Trabajador
        </a>
    </nav>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item" style="width:100%;background:none;border:none;text-align:left">
                <span class="nav-icon">🚪</span> Cerrar sesión
            </button>
        </form>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <div>
            <p style="color:#fff;font-weight:700;font-size:15px">Nuevo Trabajador</p>
            <p style="color:#52525b;font-size:12px">Registrar nuevo empleado en el sistema</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-gris">← Volver</a>
    </div>

    <div class="content">

        @if($errors->any())
            <div class="alert-err">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif


        <div class="form-card">
            <form method="POST" action="{{ route('admin.trabajadores.guardar') }}">
                @csrf

                <div class="grid-2">
                    <div class="field">
                        <label>Nombre completo *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            placeholder="Ej: Juan Pérez" required/>
                    </div>
                    <div class="field">
                        <label>Correo electrónico *</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="juan@empresa.com" required/>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label>Número de cédula *</label>
                        <input type="text" name="cedula" value="{{ old('cedula') }}"
                            placeholder="Ej: 1023456789" required/>
                    </div>
                    <div class="field">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}"
                            placeholder="Ej: 3001234567"/>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label>Cargo *</label>
                        <select name="cargo" required>
                            <option value="">Seleccionar cargo...</option>
                            <option value="Soldador" {{ old('cargo') == 'Soldador' ? 'selected' : '' }}>Soldador</option>
                            <option value="Armador" {{ old('cargo') == 'Armador' ? 'selected' : '' }}>Armador</option>
                            <option value="Operador de CNC" {{ old('cargo') == 'Operador de CNC' ? 'selected' : '' }}>Operador de CNC</option>
                            <option value="Ayudante Metal Mecánica" {{ old('cargo') == 'Ayudante Metal Mecánica' ? 'selected' : '' }}>Ayudante Metal Mecánica</option>
                            <option value="Mantenimiento" {{ old('cargo') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                            <option value="Oficios Varios" {{ old('cargo') == 'Oficios Varios' ? 'selected' : '' }}>Oficios Varios</option>
                            <option value="SST" {{ old('cargo') == 'SST' ? 'selected' : '' }}>SST</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Salario mensual (COP) *</label>
                        <input type="number" name="salario" value="{{ old('salario') }}"
                            placeholder="Ej: 2800000" min="0" required/>
                    </div>
                </div>

                <div class="field">
                    <label>Fecha de ingreso *</label>
                    <input type="date" name="fecha_ingreso"
                        value="{{ old('fecha_ingreso') }}" required/>
                </div>

                <div style="display:flex;gap:12px;margin-top:8px">
                    <button type="submit" class="btn btn-amarillo">✅ Guardar trabajador</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-gris">Cancelar</a>
                </div>

            </form>
        </div>

    </div>
</div>

</body>
</html>