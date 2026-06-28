<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Smart Ingeniería — Trabajadores</title>
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
        .form-card{background:#18181b;border:1px solid #27272a;border-radius:12px;padding:24px;margin-bottom:24px}
        .form-title{font-size:15px;font-weight:700;color:#fff;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid #27272a}
        .section{background:#18181b;border:1px solid #27272a;border-radius:12px;overflow:hidden;margin-bottom:24px}
        .section-head{padding:16px 20px;border-bottom:1px solid #27272a;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px}
        .section-title{font-size:14px;font-weight:700;color:#fff}
        .field{display:flex;flex-direction:column;gap:5px;margin-bottom:16px}
        .field label{font-size:11px;color:#a1a1aa;text-transform:uppercase;letter-spacing:.04em;font-weight:600}
        .field input,.field select{background:#27272a;border:1px solid #3f3f46;border-radius:8px;padding:10px 14px;color:#e4e4e7;font-size:14px;font-family:inherit;outline:none;transition:border-color .2s;width:100%}
        .field input:focus,.field select:focus{border-color:#f59e0b}
        .field select option{background:#27272a}
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;font-family:inherit;transition:all .15s}
        .btn-amarillo{background:#f59e0b;color:#000}
        .btn-amarillo:hover{background:#fbbf24}
        .btn-gris{background:#27272a;color:#e4e4e7}
        .btn-gris:hover{background:#3f3f46}
        .btn-rojo{background:#7f1d1d;color:#f87171;border:1px solid #dc2626}
        .btn-rojo:hover{background:#991b1b}
        .alert-ok{background:#14532d;border:1px solid #16a34a;border-radius:8px;padding:12px 16px;color:#86efac;font-size:13px;margin-bottom:16px}
        .alert-err{background:#7f1d1d;border:1px solid #dc2626;border-radius:8px;padding:12px 16px;color:#fca5a5;font-size:13px;margin-bottom:16px}
        table{width:100%;border-collapse:collapse}
        th{padding:10px 16px;text-align:left;font-size:11px;color:#a1a1aa;text-transform:uppercase;letter-spacing:.04em;background:#111113;font-weight:600}
        td{padding:12px 16px;font-size:13px;color:#d4d4d8;border-bottom:1px solid #27272a}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#1c1c1e}
        .badge{display:inline-block;padding:3px 8px;border-radius:4px;font-size:11px;font-weight:700}
        .badge-verde{background:#14532d;color:#34d399}
        .badge-rojo{background:#7f1d1d;color:#f87171}
        .buscador{background:#27272a;border:1px solid #3f3f46;border-radius:8px;padding:7px 12px;color:#e4e4e7;font-size:13px;outline:none;width:220px}
        .buscador:focus{border-color:#f59e0b}
        .avatar{width:34px;height:34px;border-radius:50%;background:#27272a;border:1px solid #3f3f46;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#f59e0b;flex-shrink:0}
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

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-ic">⚙</div>
        <div>
            <p style="color:#fff;font-weight:900;font-size:13px;line-height:1.2">SMART ING.</p>
            <p style="color:#71717a;font-size:10px">Administrador</p>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="{{ route('admin.proyectos.crear') }}" class="nav-item">
            <span class="nav-icon">🏗️</span> Proyectos
        </a>
        <a href="{{ route('admin.trabajadores.crear') }}" class="nav-item active">
            <span class="nav-icon">👷</span> Trabajadores
        </a>
    </nav>
</aside>

<div class="main">
    <div class="topbar">
        <div>
            <p style="color:#fff;font-weight:700;font-size:15px">Gestión de Trabajadores</p>
            <p style="color:#71717a;font-size:12px">Registrar y administrar empleados</p>
        </div>
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
    </div>

    <div class="content">

        @if(session('success'))
            <div class="alert-ok">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-err">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Formulario crear trabajador --}}
        <div class="form-card">
            <p class="form-title">+ Nuevo Trabajador</p>
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
                <div class="grid-3">
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
                    <div class="field">
                        <label>Fecha de ingreso *</label>
                        <input type="date" name="fecha_ingreso"
                            value="{{ old('fecha_ingreso') }}" required/>
                    </div>
                </div>
                <div class="grid-2">
                    <div class="field">
                        <label>Cargo *</label>
                        <select name="cargo" required>
                            <option value="">Seleccionar cargo...</option>
                            <option value="Soldador">Soldador</option>
                            <option value="Armador">Armador</option>
                            <option value="Operador de CNC">Operador de CNC</option>
                            <option value="Ayudante Metal Mecánica">Ayudante Metal Mecánica</option>
                            <option value="Mantenimiento">Mantenimiento</option>
                            <option value="Oficios Varios">Oficios Varios</option>
                            <option value="SST">SST</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Salario mensual (COP) *</label>
                        <input type="number" name="salario" value="{{ old('salario') }}"
                            placeholder="Ej: 2800000" min="0" required/>
                    </div>
                </div>
                <button type="submit" class="btn btn-amarillo">✅ Guardar trabajador</button>
            </form>
        </div>

        {{-- Tabla de trabajadores --}}
        <div class="section">
            <div class="section-head">
                <span class="section-title">👷 Todos los trabajadores</span>
                <input type="text" class="buscador" id="buscadorTrabajador"
                    placeholder="🔍 Buscar trabajador..." onkeyup="filtrarTrabajadores()"/>
            </div>
            <table id="tablaTrabajadores">
                <thead>
                    <tr>
                        <th>Trabajador</th>
                        <th>Cédula</th>
                        <th>Cargo</th>
                        <th>Teléfono</th>
                        <th>Salario</th>
                        <th>Ingreso</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trabajadores as $empleado)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="avatar">{{ strtoupper(substr($empleado->user->name, 0, 2)) }}</div>
                                    <div>
                                        <p style="color:#fff;font-weight:700;font-size:13px">{{ $empleado->user->name }}</p>
                                        <p style="color:#71717a;font-size:11px">{{ $empleado->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $empleado->cedula }}</td>
                            <td>{{ $empleado->cargo }}</td>
                            <td>{{ $empleado->telefono ?? '—' }}</td>
                            <td style="color:#f59e0b;font-weight:700">
                                ${{ number_format($empleado->salario, 0, ',', '.') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($empleado->fecha_ingreso)->format('d/m/Y') }}</td>
                            <td>
                                @if($empleado->estado === 'activo')
                                    <span class="badge badge-verde">Activo</span>
                                @else
                                    <span class="badge badge-rojo">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex;gap:6px">
                                    <a href="{{ route('admin.trabajadores.editar', $empleado->id) }}"
                                        class="btn btn-gris" style="padding:5px 10px;font-size:11px">Editar</a>
                                    <form method="POST" action="{{ route('admin.trabajadores.inactivar', $empleado->id) }}"
                                        onsubmit="return confirm('¿Inactivar a {{ $empleado->user->name }}?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-rojo"
                                            style="padding:5px 10px;font-size:11px">Inactivar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;color:#71717a;padding:32px">
                                No hay trabajadores registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
function filtrarTrabajadores() {
    const input = document.getElementById('buscadorTrabajador').value.toLowerCase();
    const filas = document.querySelectorAll('#tablaTrabajadores tbody tr');
    filas.forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>

</body>
</html>