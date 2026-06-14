<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Smart Ingeniería — Admin</title>
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
        .cards-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:24px}
        .card{background:#18181b;border:1px solid #27272a;border-radius:12px;padding:20px}
        .card-label{font-size:11px;color:#a1a1aa;text-transform:uppercase;letter-spacing:.04em;margin-bottom:8px}
        .card-value{font-size:32px;font-weight:900;color:#fff;line-height:1}
        .card-sub{font-size:12px;color:#71717a;margin-top:6px}
        .card.amarillo .card-value{color:#f59e0b}
        .card.verde .card-value{color:#34d399}
        .card.rojo .card-value{color:#f87171}
        .card.azul .card-value{color:#60a5fa}
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
        .badge-azul{background:#1e3a5f;color:#60a5fa}
        .badge-gris{background:#27272a;color:#a1a1aa}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;font-family:inherit;transition:all .15s}
        .btn-amarillo{background:#f59e0b;color:#000}
        .btn-amarillo:hover{background:#fbbf24}
        .btn-gris{background:#27272a;color:#e4e4e7}
        .btn-gris:hover{background:#3f3f46}
        .alert-ok{background:#14532d;border:1px solid #16a34a;border-radius:8px;padding:12px 16px;color:#86efac;font-size:13px;margin-bottom:16px}
        .alerta-item{padding:12px 16px;border-bottom:1px solid #27272a;display:flex;align-items:center;gap:12px}
        .alerta-item:last-child{border-bottom:none}
        .alerta-rojo{border-left:3px solid #dc2626}
        .alerta-amarillo{border-left:3px solid #f59e0b}
        .filtro{display:flex;align-items:center;gap:8px}
        .filtro input{background:#27272a;border:1px solid #3f3f46;border-radius:8px;padding:6px 12px;color:#e4e4e7;font-size:12px;outline:none}
        .filtro input:focus{border-color:#f59e0b}
    </style>
</head>
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
        <a href="{{ route('admin.dashboard') }}" class="nav-item active">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="{{ route('admin.proyectos.crear') }}" class="nav-item">
            <span class="nav-icon">🏗️</span> Proyectos
        </a>
        <a href="{{ route('admin.trabajadores.crear') }}" class="nav-item">
            <span class="nav-icon">👷</span> Trabajadores
        </a>
    </nav>
</aside>

<div class="main">
    <div class="topbar">
        <div>
            <p style="color:#fff;font-weight:700;font-size:15px">Dashboard</p>
            <p style="color:#71717a;font-size:12px">{{ \Carbon\Carbon::parse($hoy)->format('l, d \d\e F \d\e Y') }}</p>
        </div>
        <div style="display:flex;align-items:center;gap:8px">
            <div style="width:32px;height:32px;border-radius:50%;background:#27272a;border:1px solid #3f3f46;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#f59e0b">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div>
                <p style="color:#fff;font-size:12px;font-weight:700">{{ auth()->user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:#a1a1aa;font-size:11px;cursor:pointer;padding:0;font-family:inherit">
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

        {{-- Filtro de fecha --}}
        <form method="GET" action="{{ route('admin.dashboard') }}" style="margin-bottom:20px">
            <div class="filtro">
                <label style="color:#a1a1aa;font-size:12px;font-weight:600">📅 Fecha:</label>
                <input type="date" name="fecha" value="{{ $hoy }}"/>
                <button type="submit" class="btn btn-gris">Filtrar</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-gris">Hoy</a>
            </div>
        </form>

        {{-- Métricas del día --}}
        <div class="cards-grid">
            <div class="card verde">
                <div class="card-label">Activos hoy</div>
                <div class="card-value">{{ $activosHoy }}</div>
                <div class="card-sub">de {{ $totalEmpleados }} empleados</div>
            </div>
            <div class="card rojo">
                <div class="card-label">Inactivos hoy</div>
                <div class="card-value">{{ $inactivosHoy }}</div>
                <div class="card-sub">sin registro hoy</div>
            </div>
            <div class="card amarillo">
                <div class="card-label">Novedades hoy</div>
                <div class="card-value">{{ $novedadesHoy }}</div>
                <div class="card-sub">registradas hoy</div>
            </div>
            <div class="card azul">
                <div class="card-label">Proyectos activos</div>
                <div class="card-value">{{ $proyectosActivos }}</div>
                <div class="card-sub">en ejecución</div>
            </div>
        </div>

        {{-- Alertas --}}
        @if(count($alertas) > 0)
        <div class="section" style="margin-bottom:24px">
            <div class="section-head">
                <span class="section-title">🚨 Alertas del sistema</span>
                <span style="color:#f87171;font-size:12px;font-weight:700">{{ count($alertas) }} alertas</span>
            </div>
            @foreach($alertas as $alerta)
                <div class="alerta-item alerta-{{ $alerta['color'] }}">
                    <p style="color:{{ $alerta['color'] === 'rojo' ? '#f87171' : '#f59e0b' }};font-size:13px">
                        {{ $alerta['mensaje'] }}
                    </p>
                </div>
            @endforeach
        </div>
        @endif

        {{-- Asistencia del día --}}
        <div class="section">
            <div class="section-head">
                <span class="section-title">🕐 Asistencia — {{ \Carbon\Carbon::parse($hoy)->format('d/m/Y') }}</span>
                <span style="color:#71717a;font-size:12px">{{ $asistencias->count() }} registros</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Trabajador</th>
                        <th>Cargo</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Horas</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asistencias as $a)
                        @php
                            $horas = 0;
                            if($a->hora_entrada && $a->hora_salida){
                                $horas = max(0, (strtotime($a->hora_salida) - strtotime($a->hora_entrada)) / 3600);
                            }
                        @endphp
                        <tr>
                            <td style="color:#fff;font-weight:700">{{ $a->empleado->user->name }}</td>
                            <td style="color:#a1a1aa">{{ $a->empleado->cargo }}</td>
                            <td style="color:#34d399;font-weight:700">
                                {{ \Carbon\Carbon::parse($a->hora_entrada)->format('H:i') }}
                            </td>
                            <td style="color:#60a5fa;font-weight:700">
                                {{ $a->hora_salida ? \Carbon\Carbon::parse($a->hora_salida)->format('H:i') : '--:--' }}
                            </td>
                            <td style="color:#f59e0b;font-weight:700">
                                {{ $a->hora_salida ? number_format($horas, 1).'h' : '—' }}
                            </td>
                            <td>
                                @if($a->estado === 'presente')
                                    <span class="badge badge-verde">Presente</span>
                                @elseif($a->estado === 'ausente')
                                    <span class="badge badge-rojo">Ausente</span>
                                @else
                                    <span class="badge badge-amarillo">{{ ucfirst($a->estado) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;color:#71717a;padding:32px">
                                No hay registros de asistencia para esta fecha
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Asignaciones del día --}}
        <div class="section">
            <div class="section-head">
                <span class="section-title">📋 Asignaciones — {{ \Carbon\Carbon::parse($hoy)->format('d/m/Y') }}</span>
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
                        <th>Tarea</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asignaciones as $asignacion)
                        <tr>
                            <td style="color:#fff;font-weight:700">{{ $asignacion->empleado->user->name }}</td>
                            <td style="color:#a1a1aa">{{ $asignacion->proyecto->nombre }}</td>
                            <td style="color:#34d399;font-weight:700">
                                {{ \Carbon\Carbon::parse($asignacion->hora_inicio)->format('H:i') }}
                            </td>
                            <td style="color:#60a5fa;font-weight:700">
                                {{ \Carbon\Carbon::parse($asignacion->hora_fin)->format('H:i') }}
                            </td>
                            <td style="color:#f59e0b;font-weight:700">
                                {{ number_format($asignacion->horasCalculadas(), 1) }}h
                            </td>
                            <td style="color:#a1a1aa;font-size:12px">{{ $asignacion->tarea ?? '—' }}</td>
                            <td>
                                @if($asignacion->es_hora_extra)
                                    <span class="badge badge-amarillo">Extra</span>
                                @else
                                    <span class="badge badge-verde">Normal</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;color:#71717a;padding:32px">
                                No hay asignaciones para esta fecha
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>