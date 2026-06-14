<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Smart Ingeniería — Admin</title>
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
        .main{margin-left:220px;flex:1;display:flex;flex-direction:column}
        .topbar{background:#111113;border-bottom:1px solid #27272a;padding:0 24px;height:54px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
        .content{padding:24px;flex:1}
        .cards-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:24px}
        .card{background:#18181b;border:1px solid #27272a;border-radius:12px;padding:20px}
        .card-label{font-size:11px;color:#71717a;text-transform:uppercase;letter-spacing:.04em;margin-bottom:8px}
        .card-value{font-size:32px;font-weight:900;color:#fff;line-height:1}
        .card-sub{font-size:12px;color:#52525b;margin-top:6px}
        .card.amarillo .card-value{color:#f59e0b}
        .card.verde .card-value{color:#34d399}
        .card.rojo .card-value{color:#f87171}
        .section{background:#18181b;border:1px solid #27272a;border-radius:12px;overflow:hidden;margin-bottom:24px}
        .section-head{padding:16px 20px;border-bottom:1px solid #27272a;display:flex;align-items:center;justify-content:space-between}
        .section-title{font-size:14px;font-weight:700;color:#fff}
        table{width:100%;border-collapse:collapse}
        th{padding:10px 16px;text-align:left;font-size:11px;color:#71717a;text-transform:uppercase;letter-spacing:.04em;background:#111113;font-weight:600}
        td{padding:12px 16px;font-size:13px;color:#d4d4d8;border-bottom:1px solid #27272a}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#1c1c1e}
        .badge{display:inline-block;padding:3px 8px;border-radius:4px;font-size:11px;font-weight:700}
        .badge-verde{background:#14532d;color:#34d399}
        .badge-amarillo{background:#451a03;color:#f59e0b}
        .badge-rojo{background:#7f1d1d;color:#f87171}
        .badge-azul{background:#1e3a5f;color:#60a5fa}
        .badge-gris{background:#27272a;color:#71717a}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;font-family:inherit;transition:all .15s}
        .btn-amarillo{background:#f59e0b;color:#000}
        .btn-amarillo:hover{background:#fbbf24}
        .btn-gris{background:#27272a;color:#fff}
        .btn-gris:hover{background:#3f3f46}
        .btn-rojo{background:#7f1d1d;color:#f87171;border:1px solid #dc2626}
        .btn-rojo:hover{background:#991b1b}
        .alert-ok{background:#14532d;border:1px solid #16a34a;border-radius:8px;padding:12px 16px;color:#86efac;font-size:13px;margin-bottom:16px}
        .alerta-item{padding:12px 16px;border-bottom:1px solid #27272a;display:flex;align-items:center;gap:12px}
        .alerta-item:last-child{border-bottom:none}
        .alerta-rojo{border-left:3px solid #dc2626}
        .alerta-amarillo{border-left:3px solid #f59e0b}
        .progress-bar{height:6px;background:#27272a;border-radius:3px;overflow:hidden;margin-top:6px}
        .progress-fill{height:100%;border-radius:3px;transition:width .3s}
    </style>
</head>
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
        <a href="{{ route('admin.trabajadores.crear') }}" class="nav-item">
            <span class="nav-icon">👷</span> Nuevo Trabajador
        </a>
    </nav>
</aside>

{{-- MAIN --}}
<div class="main">
    <div class="topbar">
        <div>
            <p style="color:#fff;font-weight:700;font-size:15px">Dashboard</p>
            <p style="color:#52525b;font-size:12px">{{ now()->format('l, d \d\e F \d\e Y') }}</p>
        </div>
        <div style="display:flex;align-items:center;gap:8px">
            <div style="width:32px;height:32px;border-radius:50%;background:#27272a;border:1px solid #3f3f46;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#f59e0b">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div>
                <p style="color:#fff;font-size:12px;font-weight:700">{{ auth()->user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:#71717a;font-size:11px;cursor:pointer;padding:0;font-family:inherit">
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

        {{-- Métricas --}}
        <div class="cards-grid">
            <div class="card amarillo">
                <div class="card-label">Total proyectos</div>
                <div class="card-value">{{ $totalProyectos }}</div>
                <div class="card-sub">{{ $proyectosActivos }} activos</div>
            </div>
            <div class="card verde">
                <div class="card-label">Empleados activos</div>
                <div class="card-value">{{ $totalEmpleados }}</div>
                <div class="card-sub">en nómina</div>
            </div>
            <div class="card rojo">
                <div class="card-label">Novedades pendientes</div>
                <div class="card-value">{{ $novedadesPendientes }}</div>
                <div class="card-sub">por gestionar</div>
            </div>
            <div class="card">
                <div class="card-label">Alertas activas</div>
                <div class="card-value" style="color:{{ count($alertas) > 0 ? '#f87171' : '#34d399' }}">
                    {{ count($alertas) }}
                </div>
                <div class="card-sub">{{ count($alertas) > 0 ? 'requieren atención' : 'todo en orden' }}</div>
            </div>
        </div>

        {{-- Alertas del sistema --}}
        @if(count($alertas) > 0)
        <div class="section" style="margin-bottom:24px">
            <div class="section-head">
                <span class="section-title">🚨 Alertas del sistema</span>
                <span style="color:#f87171;font-size:12px;font-weight:700">{{ count($alertas) }} alertas activas</span>
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

        {{-- Lista de proyectos --}}
        <div class="section">
            <div class="section-head">
                <span class="section-title">🏗️ Proyectos</span>
                <a href="{{ route('admin.proyectos.crear') }}" class="btn btn-amarillo">+ Nuevo proyecto</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Presupuesto</th>
                        <th>Costo actual</th>
                        <th>Avance</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proyectos as $proyecto)
                        @php
                            $porcentaje = $proyecto->presupuesto > 0
                                ? min(100, ($proyecto->costo_fabricacion / $proyecto->presupuesto) * 100)
                                : 0;
                            $colorBarra = $porcentaje >= 100 ? '#f87171' : ($porcentaje >= 80 ? '#f59e0b' : '#34d399');
                        @endphp
                        <tr>
                            <td>
                                <p style="color:#fff;font-weight:700">{{ $proyecto->nombre }}</p>
                                @if($proyecto->es_platano)
                                    <span class="badge badge-azul" style="margin-top:4px">Plátano</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($proyecto->fecha_inicio)->format('d/m/Y') }}</td>
                            <td>{{ $proyecto->fecha_fin ? \Carbon\Carbon::parse($proyecto->fecha_fin)->format('d/m/Y') : '—' }}</td>
                            <td style="color:#f59e0b;font-weight:700">
                                ${{ number_format($proyecto->presupuesto, 0, ',', '.') }}
                            </td>
                            <td style="color:{{ $proyecto->costo_fabricacion > $proyecto->presupuesto ? '#f87171' : '#d4d4d8' }};font-weight:700">
                                ${{ number_format($proyecto->costo_fabricacion, 0, ',', '.') }}
                            </td>
                            <td style="min-width:100px">
                                <p style="font-size:11px;color:#71717a;margin-bottom:4px">{{ number_format($porcentaje, 0) }}%</p>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width:{{ $porcentaje }}%;background:{{ $colorBarra }}"></div>
                                </div>
                            </td>
                            <td>
                                @if($proyecto->estado === 'activo')
                                    <span class="badge badge-verde">Activo</span>
                                @elseif($proyecto->estado === 'pendiente')
                                    <span class="badge badge-amarillo">Pendiente</span>
                                @elseif($proyecto->estado === 'pausado')
                                    <span class="badge badge-gris">Pausado</span>
                                @else
                                    <span class="badge badge-azul">Finalizado</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.proyectos.editar', $proyecto->id) }}" class="btn btn-gris">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;color:#52525b;padding:32px">
                                No hay proyectos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Lista de trabajadores --}}
        <div class="section">
            <div class="section-head">
                <span class="section-title">👷 Trabajadores activos</span>
                <a href="{{ route('admin.trabajadores.crear') }}" class="btn btn-amarillo">+ Nuevo trabajador</a>
            </div>
            <table>
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
                                    <div style="width:34px;height:34px;border-radius:50%;background:#27272a;border:1px solid #3f3f46;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#f59e0b">
                                        {{ strtoupper(substr($empleado->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p style="color:#fff;font-weight:700;font-size:13px">{{ $empleado->user->name }}</p>
                                        <p style="color:#52525b;font-size:11px">{{ $empleado->user->email }}</p>
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
                            <td><span class="badge badge-verde">Activo</span></td>
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
                            <td colspan="8" style="text-align:center;color:#52525b;padding:32px">
                                No hay trabajadores activos registrados
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