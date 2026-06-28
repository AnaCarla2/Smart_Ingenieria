<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Smart Ingeniería — Editar Proyecto</title>
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
        .field input,.field select,.field textarea{background:#27272a;border:1px solid #3f3f46;border-radius:8px;padding:10px 14px;color:#fff;font-size:14px;font-family:inherit;outline:none;transition:border-color .2s;width:100%}
        .field input:focus,.field select:focus,.field textarea:focus{border-color:#f59e0b}
        .field select option{background:#27272a}
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;font-family:inherit;transition:all .15s}
        .btn-amarillo{background:#f59e0b;color:#000}
        .btn-amarillo:hover{background:#fbbf24}
        .btn-gris{background:#27272a;color:#fff}
        .btn-gris:hover{background:#3f3f46}
        .alert-err{background:#7f1d1d;border:1px solid #dc2626;border-radius:8px;padding:12px 16px;color:#fca5a5;font-size:13px;margin-bottom:16px}
        .checkbox-row{display:flex;align-items:center;gap:10px;padding:12px 14px;background:#27272a;border:1px solid #3f3f46;border-radius:8px;cursor:pointer}
        .checkbox-row input{width:16px;height:16px;accent-color:#f59e0b}
        .user-menu{position:relative}
        .user-btn{display:flex;align-items:center;gap:8px;cursor:pointer;background:none;border:none;padding:0}
        .user-avatar{width:32px;height:32px;border-radius:50%;background:#27272a;border:1px solid #3f3f46;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#f59e0b}
        .user-dropdown{display:none;position:absolute;right:0;top:42px;background:#18181b;border:1px solid #27272a;border-radius:10px;min-width:180px;z-index:100;overflow:hidden}
        .user-dropdown.show{display:block}
        .dropdown-item{padding:10px 16px;font-size:13px;color:#a1a1aa;cursor:pointer;border:none;background:none;width:100%;text-align:left;font-family:inherit}
        .dropdown-item:hover{background:#27272a;color:#fff}
    </style>
</head>
<script>
function toggleDropdown() {
    document.getElementById('userDropdown').classList.toggle('show');
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.user-menu')) {
        document.getElementById('userDropdown').classList.remove('show');
    }
});
</script>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-ic">⚙</div>
        <div>
            <p style="color:#fff;font-weight:900;font-size:13px;line-height:1.2">SMART ING.</p>
            <p style="color:#3f3f46;font-size:10px">Administrador</p>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item active">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="{{ route('admin.proyectos.crear') }}" class="nav-item">
            <span class="nav-icon">🏗️</span> Nuevo Proyecto
        </a>
    </nav>
    <div class="user-menu">
            <button class="user-btn" onclick="toggleDropdown()">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                <div style="text-align:left">
                    <p style="color:#fff;font-size:12px;font-weight:700">{{ auth()->user()->name }}</p>
                    <p style="color:#71717a;font-size:11px">Administrador</p>
                </div>
            </button>
            <div class="user-dropdown" id="userDropdown">
                <div style="padding:12px 16px;border-bottom:1px solid #27272a">
                    <p style="color:#fff;font-size:13px;font-weight:700">{{ auth()->user()->name }}</p>
                    <p style="color:#71717a;font-size:11px">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item" style="color:#f87171">
                        🚪 Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
</aside>

{{-- MAIN --}}
<div class="main">
    <div class="topbar">
        <div>
            <p style="color:#fff;font-weight:700;font-size:15px">Editar Proyecto</p>
            <p style="color:#52525b;font-size:12px">{{ $proyecto->nombre }}</p>
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
            <form method="POST" action="{{ route('admin.proyectos.actualizar', $proyecto->id) }}">
                @csrf
                @method('PATCH')

                <div class="field">
                    <label>Nombre del proyecto *</label>
                    <input type="text" name="nombre"
                        value="{{ old('nombre', $proyecto->nombre) }}" required/>
                </div>

                <div class="field">
                    <label>Descripción</label>
                    <textarea name="descripcion" rows="3">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label>Fecha de inicio *</label>
                        <input type="date" name="fecha_inicio"
                            value="{{ old('fecha_inicio', $proyecto->fecha_inicio) }}" required/>
                    </div>
                    <div class="field">
                        <label>Fecha de finalización</label>
                        <input type="date" name="fecha_fin"
                            value="{{ old('fecha_fin', $proyecto->fecha_fin) }}"/>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label>Presupuesto total (COP) *</label>
                        <input type="number" name="presupuesto"
                            value="{{ old('presupuesto', $proyecto->presupuesto) }}" min="0" required/>
                    </div>
                    <div class="field">
                        <label>Estado *</label>
                        <select name="estado" required>
                            <option value="pendiente" {{ $proyecto->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="activo" {{ $proyecto->estado === 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="pausado" {{ $proyecto->estado === 'pausado' ? 'selected' : '' }}>Pausado</option>
                            <option value="finalizado" {{ $proyecto->estado === 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label>Tipo de proyecto</label>
                    <label class="checkbox-row">
                        <input type="checkbox" name="es_platano" value="1"
                            {{ old('es_platano', $proyecto->es_platano) ? 'checked' : '' }}/>
                        <div>
                            <p style="color:#fff;font-size:13px;font-weight:700">Operación tipo Plátano</p>
                            <p style="color:#71717a;font-size:11px">Marcar si es una operación continua sin fecha de cierre definida</p>
                        </div>
                    </label>
                </div>
<div class="field">
    <label>Observaciones</label>
    <textarea name="observaciones" rows="3"
        placeholder="Observaciones adicionales del proyecto...">{{ old('observaciones', $proyecto->observaciones) }}</textarea>
</div>
                <div style="display:flex;gap:12px;margin-top:8px">
                    <button type="submit" class="btn btn-amarillo">✅ Guardar cambios</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-gris">Cancelar</a>
                </div>

            </form>
        </div>

    </div>
</div>

</body>
</html>