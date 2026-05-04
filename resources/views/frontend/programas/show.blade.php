@extends('frontend.layout.front')

@section('title', $programa->nombre)

@section('content')

{{-- Cabecera con Estilo --}}
<div style="background: linear-gradient(135deg, #e6f5fb 0%, #e8f9f5 100%); border-bottom: 1px solid #d0eee7; padding: 2rem 0 1.5rem;">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col">
                <p style="font-size:12px; font-weight:700; color:#0879a8; text-transform:uppercase; letter-spacing:1.2px; margin-bottom:4px;">
                    <a href="{{ route('dashboard') }}" style="color:#0879a8; text-decoration:none;">Inicio</a>
                    <span style="opacity:.4; margin:0 6px;">/</span>
                    Programas
                </p>
                <h1 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:clamp(1.4rem,3vw,2rem); color:#0f172a; margin:0; line-height:1.2;">
                    {{ $programa->nombre }}
                </h1>
                <p style="color:#536070; font-size:13.5px; font-weight:500; margin:4px 0 0;">
                    {{ $programa->personas->count() }} {{ $programa->personas->count() === 1 ? 'persona asignada' : 'personas asignadas' }}
                </p>
            </div>
            <div class="col-auto">
                {{-- Botón opcional para volver o realizar una acción --}}
                <a href="javascript:history.back()" style="
                    display:inline-flex; align-items:center; gap:8px;
                    background:white; color:#536070; text-decoration:none;
                    padding:10px 20px; border-radius:12px; border:1px solid #c8c4bb;
                    font-family:'Plus Jakarta Sans',sans-serif;
                    font-weight:700; font-size:14px;
                    transition: all .2s;
                " onmouseover="this.style.background='#f5f3ee'" onmouseout="this.style.background='white'">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">

    {{-- Contenedor de la Tabla/Lista --}}
    <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; overflow:hidden;">

        @if($programa->personas->isEmpty())
            <div style="text-align:center; padding:4rem 2rem;">
                <div style="width:64px; height:64px; background:#e6f5fb; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:28px; color:#0d92c2;">
                    <i class="bi bi-people"></i>
                </div>
                <p style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:16px; color:#0f172a; margin:0 0 6px;">Sin personas</p>
                <p style="font-size:13.5px; color:#536070; margin:0;">
                    No hay personas registradas en este programa actualmente.
                </p>
            </div>
        @else

            {{-- Encabezados de la Tabla --}}
            <div style="display:grid; grid-template-columns: 2fr 1fr 1fr 80px; gap:0; border-bottom:1px solid #e0ddd6; background:#f5f3ee; padding:0 20px;">
                <div style="padding:10px 8px; font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">Persona</div>
                <div style="padding:10px 8px; font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">DNI</div>
                <div style="padding:10px 8px; font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">Estado / Datos</div>
                <div style="padding:10px 8px;"></div>
            </div>

            {{-- Filas de Personas --}}
            @foreach($programa->personas as $persona)
                <div style="display:grid; grid-template-columns: 2fr 1fr 1fr 80px; gap:0; border-bottom:1px solid #f0ede8; padding:0 20px; transition:background .15s;"
                     onmouseover="this.style.background='#fafaf8'" onmouseout="this.style.background='white'">

                    {{-- Columna Nombre y Avatar --}}
                    <div style="padding:14px 8px; display:flex; align-items:center; gap:12px; min-width:0;">
                        <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#e6f5fb,#e8f9f5); border:1px solid #b3e0f5; display:flex; align-items:center; justify-content:center; font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:13px; color:#0879a8; flex-shrink:0;">
                            {{ strtoupper(substr($persona->nombre, 0, 1)) }}{{ strtoupper(substr($persona->apellido, 0, 1)) }}
                        </div>
                        <div style="min-width:0;">
                            <div style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:14px; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $persona->apellido }}, {{ $persona->nombre }}
                            </div>
                            <div style="font-size:11.5px; color:#536070; margin-top:1px; display:flex; align-items:center; gap:6px;">
                                @if($persona->fecha_nacimiento)
                                    <span>{{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->age }} años</span>
                                @else
                                    <span>Edad no registrada</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Columna DNI --}}
                    <div style="padding:14px 8px; display:flex; align-items:center;">
                        <div style="font-size:13.5px; font-weight:600; color:#0f172a;">{{ $persona->dni ?? '—' }}</div>
                    </div>

                    {{-- Columna Extra (puedes ajustarla según tus campos) --}}
                    <div style="padding:14px 8px; display:flex; align-items:center;">
                        @if($persona->sexo)
                            <span style="background:#e6f5fb; color:#0879a8; border:1px solid #b3e0f5; border-radius:20px; padding:3px 10px; font-size:11px; font-weight:700;">
                                {{ $persona->sexo->nombre }}
                            </span>
                        @else
                            <span style="font-size:12.5px; color:#94a3b4;">—</span>
                        @endif
                    </div>

                    {{-- Columna Acciones --}}
                    <div style="padding:14px 8px; display:flex; align-items:center; justify-content:flex-end;">
                        <a href="{{ route('personas.show', $persona) }}"
                           style="width:32px; height:32px; background:#e6f5fb; border:1px solid #b3e0f5; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; color:#0879a8; text-decoration:none; transition:all .15s;"
                           title="Ver ficha"
                           onmouseover="this.style.background='#0d92c2'; this.style.color='white'; this.style.borderColor='#0d92c2'"
                           onmouseout="this.style.background='#e6f5fb'; this.style.color='#0879a8'; this.style.borderColor='#b3e0f5'">
                            <i class="bi bi-eye-fill" style="font-size:13px;"></i>
                        </a>
                    </div>

                </div>
            @endforeach

        @endif
    </div>
</div>

@endsection