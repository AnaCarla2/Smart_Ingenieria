<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Smart Ingeniería — Asignaciones</title>
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
        .section{background:#18181b;border:1px solid #27272a;border-radius:12px;overflow:hidden;margin-bottom:24px}
        .section-head{padding:16px 20px;border-bottom:1px solid #27272a;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px}
        .section-title{font-size:14px;font-weight:700;color:#fff}
        table{width:100%;border-collapse:collapse}
        th{padding:10px 16px;text-align:left;font-size:11px;color:#a1a1aa;text-transform:uppercase;letter-spacing:.04em;background:#111113;font-weight:600}
        td{padding:12px 16px;font-size:13px;color:#d4d4d8;border-bottom:1px solid #27272a}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#1c1c1e}
        .badge{display:inline-block;padding:3px 8px;border-radius:4px;font-size:11px;font-weight:700}
        .badge-verde{background:#14532d;color:#34d399}
        .badge-amarillo{background:#451a03;color:#f59e0b}
        .badge-rojo{background:#7f1d1d;color:#f87171}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;font-family:inherit;transition:all .15s}
        .btn-amarillo{background:#f59e0b;color:#000}
        .btn-amarillo:hover{background:#fbbf24}
        .btn-gris{background:#27272a;color:#e4e4e7}
        .btn-gris:hover{background:#3f3f46}
        .btn-rojo{background:#7f1d1d;color:#f87171;border:1px solid #dc2626}
        .btn-rojo:hover{background:#991b1b}
        .alert-ok{background:#14532d;border:1px solid #16a34a;border-radius:8px;padding:12px 16px;color:#86efac;font-size:13px;margin-bottom:16px}
        .field{display:flex;flex-direction:column;gap:5px}
        .field label{font-size:11px;color:#a1a1aa;text-transform:uppercase;letter-spacing:.04em;font-weight:600}
        .field input,.field select,.field textarea{background:#27272a;border:1px solid #3f3f46;border-radius:8px;padding:9px 12px;color:#e4e4e7;font-size:13px;font-family:inherit;outline:none;transition:border-color .2s;width:100%}
        .field input:focus,.field select:focus,.field textarea:focus{border-color:#f59e0b}
        .field select option{background:#27272a}
        .grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px}
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
        .form-card{background:#18181b;border:1px solid #27272a;border-radius:12px;padding:20px;margin-bottom:24px}
        .form-title{font-size:14px;font-weight:700;color:#fff;margin-bottom:16px}
        /* Dropdown usuario */
        .user-menu{position:relative}
        .user-btn{display:flex;align-items:center;gap:8px;cursor:pointer;background:none;border:none;padding:0}
        .user-avatar{width:32px;height:32px;border-radius:50%;background:#27272a;border:1px solid #3f3f46;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#f59e0b}
        .user-dropdown{display:none;position:absolute;right:0;top:42px;background:#18181b;border:1px solid #27272a;border-radius:10px;min-width:180px;z-index:100;overflow:hidden}
        .user-dropdown.show{display:block}
        .dropdown-item{padding:10px 16px;font-size:13px;color:#a1a1aa;cursor:pointer;border:none;background:none;width:100%;text-align:left;font-family:inherit}
        .dropdown-item:hover{background:#27272a;color:#fff}
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
            <p style="color:#fff;font-weight:700;font-size:15px">Asignaciones</p>
            <p style="color:#71717a;font-size:12px">Asignar trabajadores a proyectos por horas</p>
        </div>
        <div style="display:flex;align-items:center;gap:16px">
            {{-- Filtro de fecha --}}
            <form method="GET" action="{{ route('supervisor.asignaciones') }}" style="display:flex;align-items:center;gap:8px">
                <input type="date" name="fecha" value="{{ $fecha }}"
                    style="background:#27272a;border:1px solid #3f3f46;border-radius:8px;padding:7px 12px;color:#e4e4e7;font-size:12px;outline:none"/>
                <button type="submit" class="btn btn-gris">Filtrar</button>
            </form>
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
    </div>

    <div class="content">

        @if(session('success'))
            <div class="alert-ok">{{ session('success') }}</div>
        @endif

        {{-- Formulario nueva asignación --}}
        @if($presentes->count() > 0)
        <div class="form-card">
            <p class="form-title">+ Nueva asignación — {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</p>
            <form method="POST" action="{{ route('supervisor.asignaciones.guardar') }}">
                @csrf
                <input type="hidden" name="fecha" value="{{ $fecha }}"/>
                <div class="grid-2" style="margin-bottom:12px">
                    <div class="field">
                        <label>Trabajador *</label>
                        <select name="empleado_id" required>
                            <option value="">Seleccionar trabajador...</option>
                            @foreach($presentes as $asistencia)
                                <option value="{{ $asistencia->empleado->id }}">
                                    {{ $asistencia->empleado->user->name }} — {{ $asistencia->empleado->cargo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Proyecto *</label>
                        <select name="proyecto_id" required>
                            <option value="">Seleccionar proyecto...</option>
                            @foreach($proyectos as $proyecto)
                                <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid-3" style="margin-bottom:12px">
                    <div class="field">
                        <label>Hora inicio *</label>
                        <input type="time" name="hora_inicio" required/>
                    </div>
                    <div class="field">
                        <label>Hora fin *</label>
                        <input type="time" name="hora_fin" required/>
                    </div>
                    <div class="field">
                        <label>Descripción de la tarea</label>
                        <input type="text" name="tarea" placeholder="Ej: Soldadura columnas..."/>
                    </div>
                </div>
                {{-- Alerta de horas --}}
                <div id="alertaHoras" style="display:none;background:#451a03;border:1px solid #f59e0b;border-radius:8px;padding:12px 16px;margin-bottom:12px">
                    <p style="color:#f59e0b;font-size:13px;font-weight:700" id="alertaHorasTexto"></p>
                </div>

                <button type="submit" class="btn btn-amarillo">✅ Registrar asignación</button>
            </form>
        </div>
        @else
        <div style="background:#18181b;border:1px solid #27272a;border-radius:12px;padding:24px;text-align:center;margin-bottom:24px">
            <p style="color:#71717a;font-size:14px">No hay trabajadores con asistencia el {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</p>
            <p style="color:#3f3f46;font-size:12px;margin-top:6px">Solo se pueden asignar trabajadores que hayan registrado asistencia</p>
        </div>
        @endif

        {{-- Tabla asignaciones --}}
        <div class="section">
            <div class="section-head">
                <span class="section-title">📋 Asignaciones del {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</span>
                <span style="color:#71717a;font-size:12px">{{ $asignaciones->count() }} registros</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Trabajador</th>
                        <th>Proyecto</th>
                        <th>Hora inicio</th>
                        <th>Hora fin</th>
                        <th>Horas</th>
                        <th>Tipo</th>
                        <th>Tarea</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asignaciones as $asignacion)
                        @php
                            $horas = $asignacion->horasCalculadas();
                            $esExtra = $horas > 8;
                        @endphp
                        <tr>
                            <td style="font-weight:700;color:#fff">{{ $asignacion->empleado->user->name }}</td>
                            <td style="color:#a1a1aa">{{ $asignacion->proyecto->nombre }}</td>
                            <td style="color:#34d399;font-weight:700">
                                {{ \Carbon\Carbon::parse($asignacion->hora_inicio)->format('H:i') }}
                            </td>
                            <td style="color:#60a5fa;font-weight:700">
                                {{ \Carbon\Carbon::parse($asignacion->hora_fin)->format('H:i') }}
                            </td>
                            <td style="color:#f59e0b;font-weight:700">
                                {{ number_format($horas, 1) }}h
                            </td>
                            <td>
                                @php
                                    $horasNormales = min($horas, 8);
                                    $horasExtras   = max(0, $horas - 8);
                                @endphp
                                <div>
                                    <span class="badge badge-verde">✅ {{ number_format($horasNormales, 1) }}h normales</span>
                                    @if($horasExtras > 0)
                                        <span class="badge badge-amarillo" style="margin-top:4px;display:block">⏰ {{ number_format($horasExtras, 1) }}h extras</span>
                                    @endif
                                </div>
                            </td>
                            <td style="color:#a1a1aa;font-size:12px">{{ $asignacion->tarea ?? '—' }}</td>
                            <td>
                                <div style="display:flex;gap:6px">
                                    <a href="{{ route('supervisor.asignaciones.editar', $asignacion->id) }}"
                                        class="btn btn-gris" style="padding:5px 10px;font-size:11px">Editar</a>
                                    <form method="POST" action="{{ route('supervisor.asignaciones.eliminar', $asignacion->id) }}"
                                        onsubmit="return confirm('¿Eliminar esta asignación?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-rojo"
                                            style="padding:5px 10px;font-size:11px">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;color:#71717a;padding:32px">
                                No hay asignaciones para esta fecha
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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

// Verificar horas cuando cambia trabajador u hora fin
function verificarHoras() {
    const empleadoId = document.querySelector('select[name="empleado_id"]').value;
    const horaFin    = document.querySelector('input[name="hora_fin"]').value;
    const fecha      = '{{ $fecha }}';

    if (!empleadoId || !horaFin) return;

    fetch(`/supervisor/verificar-horas/${empleadoId}/${fecha}`)
        .then(r => r.json())
        .then(data => {
            const div = document.getElementById('alertaHoras');
            const texto = document.getElementById('alertaHorasTexto');

            if (!data) { div.style.display = 'none'; return; }

            const horasDia    = parseFloat(data.horas_dia) || 0;
            const limiteDia   = parseFloat(data.limite_dia) || 8;
            const horasSemana = parseFloat(data.horas_semana) || 0;
            const limiteSemana= parseFloat(data.limite_semana) || 44;

            const normales = Math.min(horasDia, limiteDia);
            const extras   = Math.max(0, horasDia - limiteDia);

            let html = '';
            let esAlerta = false;

            if (horasDia > 0) {
                html += `<p style="color:#34d399;font-size:13px">✅ Horas normales hoy: <strong>${normales.toFixed(1)}h</strong> de ${limiteDia}h permitidas</p>`;
            }

            if (extras > 0) {
                html += `<p style="color:#f59e0b;font-size:13px;margin-top:4px">⏰ Horas extras hoy: <strong>${extras.toFixed(1)}h</strong></p>`;
                esAlerta = true;
            }

            if (horasSemana > limiteSemana) {
                html += `<p style="color:#f87171;font-size:13px;margin-top:4px">🚨 Supera el máximo semanal: <strong>${horasSemana.toFixed(1)}h</strong> de ${limiteSemana}h permitidas</p>`;
                esAlerta = true;
            }

            if (html) {
                texto.innerHTML = html;
                div.style.background = esAlerta ? '#451a03' : '#1c3a2b';
                div.style.borderColor = esAlerta ? '#f59e0b' : '#16a34a';
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
            }
        })
        .catch(() => {});
}

// Escuchar cambios en trabajador y hora fin
document.querySelector('select[name="empleado_id"]')?.addEventListener('change', verificarHoras);
document.querySelector('input[name="hora_fin"]')?.addEventListener('change', verificarHoras);
</script>

</body>
</html>