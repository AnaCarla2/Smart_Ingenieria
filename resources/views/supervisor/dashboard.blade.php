<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Smart Ingeniería — Supervisor</title>
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
        .section{background:#18181b;border:1px solid #27272a;border-radius:12px;overflow:hidden;margin-bottom:24px}
        .section-head{padding:16px 20px;border-bottom:1px solid #27272a;display:flex;align-items:center;justify-content:space-between}
        .section-title{font-size:14px;font-weight:700;color:#fff}
        table{width:100%;border-collapse:collapse}
        th{padding:10px 16px;text-align:left;font-size:11px;color:#a1a1aa;text-transform:uppercase;letter-spacing:.04em;background:#111113;font-weight:600}
        td{padding:12px 16px;font-size:13px;color:#d4d4d8;border-bottom:1px solid #27272a}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#1c1c1e}
        .badge{display:inline-block;padding:3px 8px;border-radius:4px;font-size:11px;font-weight:700}
        .badge-verde{background:#14532d;color:#34d399}
        .badge-amarillo{background:#451a03;color:#f59e0b}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;font-family:inherit;transition:all .15s}
        .btn-amarillo{background:#f59e0b;color:#000}
        .btn-amarillo:hover{background:#fbbf24}
        .btn-gris{background:#27272a;color:#e4e4e7}
        .btn-gris:hover{background:#3f3f46}
        .alert-ok{background:#14532d;border:1px solid #16a34a;border-radius:8px;padding:12px 16px;color:#86efac;font-size:13px;margin-bottom:16px}
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
        <a href="{{ route('supervisor.dashboard') }}" class="nav-item active">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="{{ route('supervisor.asignaciones') }}" class="nav-item">
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
            <p style="color:#fff;font-weight:700;font-size:15px">Dashboard</p>
            <p style="color:#71717a;font-size:12px">{{ now()->format('l, d \d\e F \d\e Y') }}</p>
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

        @if(session('success'))
            <div class="alert-ok">{{ session('success') }}</div>
        @endif

        {{-- Métricas --}}
        <div class="cards-grid">
            <div class="card verde">
                <div class="card-label">Asistencia hoy</div>
                <div class="card-value">{{ $presentes->count() }}</div>
                <div class="card-sub">de {{ $totalEmpleados }} empleados</div>
            </div>
            <div class="card amarillo">
                <div class="card-label">Proyectos activos</div>
                <div class="card-value">{{ $proyectos->count() }}</div>
                <div class="card-sub">en ejecución</div>
            </div>
            <div class="card rojo">
                <div class="card-label">Novedades pendientes</div>
                <div class="card-value">{{ $novedadesPendientes->count() }}</div>
                <div class="card-sub">por gestionar</div>
            </div>
            <div class="card">
                <div class="card-label">Ausentes hoy</div>
                <div class="card-value">{{ $totalEmpleados - $presentes->count() }}</div>
                <div class="card-sub">sin registro hoy</div>
            </div>
        </div>

        {{-- Asistencia hoy --}}
        <div class="section">
            <div class="section-head">
                <span class="section-title">🕐 Asistencia — {{ now()->format('d/m/Y') }}</span>
                <a href="{{ route('supervisor.asignaciones') }}" class="btn btn-amarillo">
                    + Registrar asignaciones
                </a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Trabajador</th>
                        <th>Cargo</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presentes as $asistencia)
                        <tr>
                            <td style="font-weight:700;color:#fff">{{ $asistencia->empleado->user->name }}</td>
                            <td style="color:#a1a1aa">{{ $asistencia->empleado->cargo }}</td>
                            <td style="color:#34d399;font-weight:700">
                                {{ \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') }}
                            </td>
                            <td style="color:#60a5fa;font-weight:700">
                                {{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : '--:--' }}
                            </td>
                            <td><span class="badge badge-verde">Presente</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;color:#71717a;padding:32px">
                                No hay trabajadores con asistencia registrada hoy
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Novedades pendientes --}}
        @if($novedadesPendientes->count() > 0)
        <div class="section">
            <div class="section-head">
                <span class="section-title">📌 Novedades pendientes</span>
                <a href="{{ route('supervisor.novedades') }}" class="btn btn-gris">Ver todas</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Trabajador</th>
                        <th>Tipo</th>
                        <th>Fecha inicio</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($novedadesPendientes as $novedad)
                        <tr>
                            <td style="font-weight:700;color:#fff">{{ $novedad->empleado->user->name }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $novedad->tipo)) }}</td>
                            <td>{{ \Carbon\Carbon::parse($novedad->fecha_inicio)->format('d/m/Y') }}</td>
                            <td><span class="badge badge-amarillo">Pendiente</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

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