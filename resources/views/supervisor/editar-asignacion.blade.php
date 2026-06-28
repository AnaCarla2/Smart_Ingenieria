<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Smart Ingeniería — Editar Asignación</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{background:#09090b;color:#e4e4e7;font-family:system-ui,sans-serif;min-height:100vh;display:flex}
        .sidebar{width:220px;background:#111113;border-right:1px solid #27272a;display:flex;flex-direction:column;position:fixed;height:100vh;z-index:50}
        .sidebar-logo{padding:18px 16px;border-bottom:1px solid #27272a;display:flex;align-items:center;gap:10px}
        .logo-ic{width:32px;height:32px;background:#f59e0b;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:900;color:#000;flex-shrink:0}
        .sidebar-nav{flex:1;padding:12px 8px;display:flex;flex-direction:column;gap:2px}
        .nav-item{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;color:#a1a1aa;font-size:13px;text-decoration:none;transition:all .15s;cursor:pointer}
        .nav-item:hover{background:#27272a;color:#fff}
        .nav-item.active{background:#1c1c1e;color:#f59e0b;border:1px solid #27272a}
        .nav-icon{font-size:16px;width:20px;text-align:center}
        .main{margin-left:220px;flex:1;display:flex;flex-direction:column}
        .topbar{background:#111113;border-bottom:1px solid #27272a;padding:0 24px;height:54px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        .content{padding:24px;flex:1}
        .form-card{background:#18181b;border:1px solid #27272a;border-radius:12px;padding:24px;max-width:600px}
        .form-title{font-size:15px;font-weight:700;color:#fff;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid #27272a}
        .field{display:flex;flex-direction:column;gap:5px;margin-bottom:16px}
        .field label{font-size:11px;color:#a1a1aa;text-transform:uppercase;letter-spacing:.04em;font-weight:600}
        .field input,.field select,.field textarea{background:#27272a;border:1px solid #3f3f46;border-radius:8px;padding:10px 14px;color:#e4e4e7;font-size:14px;font-family:inherit;outline:none;transition:border-color .2s;width:100%}
        .field input:focus,.field select:focus,.field textarea:focus{border-color:#f59e0b}
        .field select option{background:#27272a}
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;font-family:inherit;transition:all .15s}
        .btn-amarillo{background:#f59e0b;color:#000}
        .btn-amarillo:hover{background:#fbbf24}
        .btn-gris{background:#27272a;color:#e4e4e7}
        .btn-gris:hover{background:#3f3f46}
        .alert-err{background:#7f1d1d;border:1px solid #dc2626;border-radius:8px;padding:12px 16px;color:#fca5a5;font-size:13px;margin-bottom:16px}
        .info-box{background:#1c1c1e;border:1px solid #27272a;border-radius:8px;padding:12px 16px;margin-bottom:16px}
        /* Dropdown usuario */
        .user-menu{position:relative}
        .user-btn{display:flex;align-items:center;gap:8px;cursor:pointer;background:none;border:none;padding:0}
        .user-avatar{width:32px;height:32px;border-radius:50%;background:#27272a;border:1px solid #3f3f46;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#f59e0b}
        .user-dropdown{display:none;position:absolute;right:0;top:42px;background:#18181b;border:1px solid #27272a;border-radius:10px;min-width:180px;z-index:100;overflow:hidden}
        .user-dropdown.show{display:block}
        .dropdown-item{padding:10px 16px;font-size:13px;color:#a1a1aa;cursor:pointer;border:none;background:none;width:100%;text-align:left;font-family:inherit}
        .dropdown-item:hover{background:#27272a;color:#fff}
        .dropdown-divider{border-top:1px solid #27272a}
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-ic">⚙</div>
        <div>
            <p style="color:#fff;font-weight:900;font-size:13px;line-height:1.2">SMART ING.</p>
            <p style="color:#71717a;font-size:10px">Supervisor</p>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('supervisor.dashboard') }}" class="nav-item">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="{{ route('supervisor.asignaciones') }}" class="nav-item active">
            <span class="nav-icon">📋</span> Asignaciones
        </a>
        <a href="{{ route('supervisor.novedades') }}" class="nav-item">
            <span class="nav-icon">📌</span> Novedades
        </a>
    </nav>
</aside>

<div class="main">
    <div class="topbar">
        <div>
            <p style="color:#fff;font-weight:700;font-size:15px">Editar Asignación</p>
            <p style="color:#71717a;font-size:12px">Modificar tiempos y proyecto asignado</p>
        </div>
        <div class="user-menu">
            <button class="user-btn" onclick="toggleDropdown()">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                <div style="text-align:left">
                    <p style="color:#fff;font-size:12px;font-weight:700">{{ auth()->user()->name }}</p>
                    <p style="color:#71717a;font-size:11px">Supervisor</p>
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
    </div>

    <div class="content">

        @if($errors->any())
            <div class="alert-err">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Info del trabajador --}}
        <div class="info-box" style="margin-bottom:20px">
            <p style="color:#a1a1aa;font-size:11px;text-transform:uppercase;letter-spacing:.04em;margin-bottom:6px">Trabajador</p>
            <p style="color:#fff;font-weight:700;font-size:15px">{{ $asignacion->empleado->user->name }}</p>
            <p style="color:#71717a;font-size:12px">{{ $asignacion->empleado->cargo }} · Fecha: {{ \Carbon\Carbon::parse($asignacion->fecha)->format('d/m/Y') }}</p>
        </div>

        <div class="form-card">
            <p class="form-title">Editar asignación</p>
            <form method="POST" action="{{ route('supervisor.asignaciones.actualizar', $asignacion->id) }}">
                @csrf
                @method('PATCH')

                <div class="field">
                    <label>Proyecto *</label>
                    <select name="proyecto_id" required>
                        @foreach($proyectos as $proyecto)
                            <option value="{{ $proyecto->id }}"
                                {{ $asignacion->proyecto_id == $proyecto->id ? 'selected' : '' }}>
                                {{ $proyecto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label>Hora inicio *</label>
                        <input type="time" name="hora_inicio"
                            value="{{ \Carbon\Carbon::parse($asignacion->hora_inicio)->format('H:i') }}" required/>
                    </div>
                    <div class="field">
                        <label>Hora fin *</label>
                        <input type="time" name="hora_fin"
                            value="{{ \Carbon\Carbon::parse($asignacion->hora_fin)->format('H:i') }}" required/>
                    </div>
                </div>

                <div class="field">
                    <label>Descripción de la tarea</label>
                    <textarea name="tarea" rows="3"
                        placeholder="Descripción de la tarea realizada...">{{ $asignacion->tarea }}</textarea>
                </div>

                <div style="display:flex;gap:12px;margin-top:8px">
                    <button type="submit" class="btn btn-amarillo">✅ Guardar cambios</button>
                    <a href="{{ route('supervisor.asignaciones', ['fecha' => $fecha]) }}" class="btn btn-gris">Cancelar</a>
                </div>

            </form>
        </div>

    </div>
</div>

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

</body>
</html>