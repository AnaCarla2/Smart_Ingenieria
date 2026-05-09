<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Smart Ingeniería — Registro de Asistencia</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{background:#09090b;color:#fff;font-family:system-ui,sans-serif;min-height:100vh;display:flex;flex-direction:column}
        .header{background:rgba(9,9,11,.95);border-bottom:1px solid #27272a;padding:0 20px;height:54px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
        .logo{display:flex;align-items:center;gap:10px}
        .logo-ic{width:32px;height:32px;background:#f59e0b;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:900;color:#000}
        main{flex:1;display:flex;align-items:center;justify-content:center;padding:24px 16px}
        .card{background:#18181b;border:1px solid #27272a;border-radius:14px;width:100%;max-width:420px;overflow:hidden}
        .card-head{padding:18px 20px;border-bottom:1px solid #27272a}
        .card-body{padding:20px}
        .field{display:flex;flex-direction:column;gap:5px;margin-bottom:14px}
        .field label{font-size:11px;color:#71717a;text-transform:uppercase;letter-spacing:.04em;font-weight:600}
        .field input{background:#27272a;border:1px solid #3f3f46;border-radius:8px;padding:11px 14px;color:#fff;font-size:15px;font-family:inherit;outline:none;transition:border-color .2s;width:100%;letter-spacing:.1em}
        .field input:focus{border-color:#f59e0b}
        .btn-primary{width:100%;background:#f59e0b;border:none;border-radius:8px;padding:12px;color:#000;font-size:15px;font-weight:700;cursor:pointer;transition:background .15s;font-family:inherit}
        .btn-primary:hover{background:#fbbf24}
        .btn-entrada{width:100%;background:#16a34a;border:none;border-radius:8px;padding:14px;color:#fff;font-size:15px;font-weight:700;cursor:pointer;font-family:inherit;transition:background .15s}
        .btn-entrada:hover{background:#15803d}
        .btn-salida{width:100%;background:#2563eb;border:none;border-radius:8px;padding:14px;color:#fff;font-size:15px;font-weight:700;cursor:pointer;font-family:inherit;transition:background .15s}
        .btn-salida:hover{background:#1d4ed8}
        .alert-ok{background:#14532d;border:1px solid #16a34a;border-radius:8px;padding:12px 16px;color:#86efac;font-size:13px;margin-bottom:16px}
        .alert-err{background:#7f1d1d;border:1px solid #dc2626;border-radius:8px;padding:12px 16px;color:#fca5a5;font-size:13px;margin-bottom:16px}
        .reloj{font-size:28px;font-weight:900;color:#f59e0b;letter-spacing:.04em;text-align:center;margin-bottom:4px}
        .fecha-txt{font-size:12px;color:#52525b;text-align:center;margin-bottom:16px}
        .empleado-card{background:#27272a;border-radius:10px;padding:14px;margin-bottom:14px}
        .avatar{width:48px;height:48px;border-radius:50%;background:#3f3f46;border:2px solid #f59e0b;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#f59e0b;flex-shrink:0}
        video{width:100%;border-radius:8px;background:#000;display:block}
        canvas{display:none}
        .sin-camara{font-size:11px;color:#52525b;text-align:center;margin-top:10px;cursor:pointer;text-decoration:underline}
    </style>
</head>
<body>
<header class="header">
    <div class="logo">
        <div class="logo-ic">⚙</div>
        <div>
            <p style="color:#fff;font-weight:900;font-size:14px;line-height:1.2">SMART INGENIERÍA</p>
            <p style="color:#3f3f46;font-size:11px;line-height:1.2">Control de Personal</p>
        </div>
    </div>
    <a href="{{ route('login') }}" style="color:#71717a;font-size:12px;text-decoration:none">Acceso administrativo →</a>
</header>

<main>
    <div class="card">
        <div class="card-head">
            <p style="color:#fff;font-weight:700;font-size:16px">Registro de Asistencia</p>
            <p style="color:#71717a;font-size:12px;margin-top:3px">Ingresa tu cédula para registrar tu entrada o salida</p>
        </div>
        <div class="card-body">

            <div class="reloj" id="reloj">00:00:00</div>
            <div class="fecha-txt" id="fecha-txt"></div>

            @if(session('success'))
                <div class="alert-ok">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-err">{{ session('error') }}</div>
            @endif

            @if(!isset($empleado))
                <form method="POST" action="{{ route('asistencia.buscar') }}">
                    @csrf
                    @if($errors->any())
                        <div class="alert-err">{{ $errors->first() }}</div>
                    @endif
                    <div class="field">
                        <label>Número de cédula</label>
                        <input type="number" name="cedula" placeholder="Ej: 1023456789" autofocus required/>
                    </div>
                    <button type="submit" class="btn-primary">Buscar →</button>
                </form>

            @elseif(isset($accion) && $accion === 'completo')
                <div class="empleado-card">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div class="avatar">{{ strtoupper(substr($empleado->user->name, 0, 2)) }}</div>
                        <div>
                            <p style="color:#fff;font-weight:700;font-size:15px">{{ $empleado->user->name }}</p>
                            <p style="color:#71717a;font-size:12px">{{ $empleado->cargo }}</p>
                        </div>
                    </div>
                </div>
                <div style="text-align:center;padding:16px 0">
                    <p style="color:#34d399;font-size:14px;font-weight:700">✅ Jornada completa registrada hoy</p>
                    <p style="color:#52525b;font-size:12px;margin-top:6px">
                        Entrada: {{ \Carbon\Carbon::parse($asistenciaHoy->hora_entrada)->format('H:i') }} —
                        Salida: {{ \Carbon\Carbon::parse($asistenciaHoy->hora_salida)->format('H:i') }}
                    </p>
                </div>
                <a href="{{ route('asistencia.publica') }}" style="display:block;text-align:center;color:#71717a;font-size:12px;margin-top:8px">← Volver</a>

            @else
                <div class="empleado-card">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px">
                        <div class="avatar">{{ strtoupper(substr($empleado->user->name, 0, 2)) }}</div>
                        <div>
                            <p style="color:#fff;font-weight:700;font-size:15px">{{ $empleado->user->name }}</p>
                            <p style="color:#71717a;font-size:12px">{{ $empleado->cargo }} · Céd. {{ $empleado->cedula }}</p>
                        </div>
                    </div>
                    <div id="camara-container">
                        <video id="video" autoplay playsinline></video>
                        <canvas id="canvas"></canvas>
                        <p class="sin-camara" onclick="sinCamara()">No tengo cámara o no funciona</p>
                    </div>
                    <div id="sin-camara-msg" style="display:none;text-align:center;padding:10px;background:#27272a;border-radius:8px;margin-top:8px">
                        <p style="color:#71717a;font-size:12px">Registro sin foto — solo cédula</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('asistencia.registrar') }}" id="form-registro">
                    @csrf
                    <input type="hidden" name="empleado_id" value="{{ $empleado->id }}"/>
                    <input type="hidden" name="accion" value="{{ $accion }}"/>
                    <input type="hidden" name="foto_base64" id="foto_base64"/>
                    @if($accion === 'entrada')
                        <button type="submit" class="btn-entrada" onclick="capturarFoto()">Registrar Entrada</button>
                    @else
                        <button type="submit" class="btn-salida" onclick="capturarFoto()">Registrar Salida</button>
                    @endif
                </form>
                <a href="{{ route('asistencia.publica') }}" style="display:block;text-align:center;color:#71717a;font-size:12px;margin-top:12px">← Volver</a>
            @endif

        </div>
    </div>
</main>

<script>
function actualizarReloj() {
    const ahora = new Date();
    const h = String(ahora.getHours()).padStart(2,'0');
    const m = String(ahora.getMinutes()).padStart(2,'0');
    const s = String(ahora.getSeconds()).padStart(2,'0');
    document.getElementById('reloj').textContent = h+':'+m+':'+s;
    const dias = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];
    const meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
    document.getElementById('fecha-txt').textContent = dias[ahora.getDay()]+' '+ahora.getDate()+' de '+meses[ahora.getMonth()]+' de '+ahora.getFullYear();
}
setInterval(actualizarReloj, 1000);
actualizarReloj();

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
let camaraActiva = false;

if(video){
    navigator.mediaDevices.getUserMedia({video:{facingMode:'user'}})
        .then(stream => { video.srcObject = stream; camaraActiva = true; })
        .catch(() => sinCamara());
}

function capturarFoto(){
    if(!camaraActiva || !canvas) return;
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video,0,0);
    document.getElementById('foto_base64').value = canvas.toDataURL('image/jpeg',0.7);
}

function sinCamara(){
    if(video) video.style.display='none';
    const p = document.querySelector('.sin-camara');
    if(p) p.style.display='none';
    const msg = document.getElementById('sin-camara-msg');
    if(msg) msg.style.display='block';
    camaraActiva = false;
}
</script>
</body>
</html>