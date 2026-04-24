@extends('frontend.layout.front')

@section('title', $persona->apellido . ', ' . $persona->nombre)

@section('content')

@if(session('abrirProgramaModal'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('modalPrograma').style.display = 'flex';
});
</script>
@endif

{{-- ── HEADER ── --}}
<div style="background: linear-gradient(135deg, #e6f5fb 0%, #e8f9f5 100%); border-bottom: 1px solid #d0eee7; padding: 2rem 0 1.5rem;">
    <div class="container">
        <p style="font-size:12px; font-weight:700; color:#0879a8; text-transform:uppercase; letter-spacing:1.2px; margin-bottom:4px;">
            <a href="{{ route('dashboard') }}" style="color:#0879a8; text-decoration:none;">Inicio</a>
            <span style="opacity:.4; margin:0 6px;">/</span>
            <a href="{{ route('personas.index') }}" style="color:#0879a8; text-decoration:none;">Personas</a>
            <span style="opacity:.4; margin:0 6px;">/</span>
            {{ $persona->apellido }}, {{ $persona->nombre }}
        </p>

        {{-- Hero --}}
        <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:20px; flex-wrap:wrap; margin-top:8px;">
            <div style="display:flex; align-items:center; gap:16px;">
                {{-- Avatar --}}
                <div style="width:56px; height:56px; border-radius:50%; background:linear-gradient(135deg,#0d92c2,#17a385); display:flex; align-items:center; justify-content:center; font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:1.3rem; color:white; flex-shrink:0; box-shadow:0 4px 14px rgba(13,146,194,.25);">
                    {{ strtoupper(substr($persona->nombre, 0, 1)) }}{{ strtoupper(substr($persona->apellido, 0, 1)) }}
                </div>
                <div>
                    <h1 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:clamp(1.3rem,3vw,1.8rem); color:#0f172a; margin:0 0 8px; line-height:1.2;">
                        {{ $persona->apellido }}, {{ $persona->nombre }}
                    </h1>
                    <div style="display:flex; flex-wrap:wrap; gap:6px;">
                        @if($persona->tipoDocumento)
                            <span style="background:white; border:1px solid #c8c4bb; color:#536070; border-radius:20px; padding:3px 10px; font-size:11.5px; font-weight:600;">{{ $persona->tipoDocumento->nombre }} {{ $persona->dni }}</span>
                        @endif
                        @if($persona->sexo)
                            <span style="background:white; border:1px solid #c8c4bb; color:#536070; border-radius:20px; padding:3px 10px; font-size:11.5px; font-weight:600;">{{ $persona->sexo->nombre }}</span>
                        @endif
                        @if($persona->fecha_nacimiento)
                            <span style="background:white; border:1px solid #c8c4bb; color:#536070; border-radius:20px; padding:3px 10px; font-size:11.5px; font-weight:600;">{{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->age }} años</span>
                        @endif
                        @if($persona->sedeOrigen)
                            <span style="background:#e6f5fb; border:1px solid #b3e0f5; color:#0879a8; border-radius:20px; padding:3px 10px; font-size:11.5px; font-weight:700;">{{ $persona->sedeOrigen->nombre }}</span>
                        @endif
                        @if($persona->trabaja)
                            <span style="background:#e6f5fb; border:1px solid #b3e0f5; color:#0879a8; border-radius:20px; padding:3px 10px; font-size:11.5px; font-weight:700;">Trabaja</span>
                        @endif
                    </div>
                </div>
            </div>
            <div style="display:flex; gap:8px; flex-shrink:0;">
                <a href="{{ route('personas.grupo-familiar.create', $persona) }}" style="height:38px; padding:0 16px; background:linear-gradient(135deg,#0d92c2,#1aaad8); color:white; text-decoration:none; border-radius:10px; font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13px; display:inline-flex; align-items:center; gap:7px; box-shadow:0 4px 12px rgba(13,146,194,.25); transition:opacity .2s;" onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                    <i class="bi bi-person-plus-fill"></i> Agregar integrante
                </a>
                <a href="{{ route('personas.create') }}" style="height:38px; padding:0 16px; background:white; color:#536070; text-decoration:none; border-radius:10px; font-family:'Plus Jakarta Sans',sans-serif; font-weight:600; font-size:13px; display:inline-flex; align-items:center; gap:7px; border:1px solid #c8c4bb; transition:background .15s;" onmouseover="this.style.background='#f5f3ee'" onmouseout="this.style.background='white'">
                    <i class="bi bi-person-plus"></i> Nueva persona
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">

    {{-- Flash --}}
    @if(session('success'))
        <div style="background:#e8f9f5; border:1px solid #9fe1cb; border-radius:12px; padding:13px 18px; margin-bottom:1.25rem; color:#0e8a70; font-size:13.5px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-3">

        {{-- ── Datos personales ── --}}
        <div class="col-md-6">
            <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; overflow:hidden; height:100%;">
                <div style="padding:13px 20px 11px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; gap:10px;">
                    <div style="width:6px; height:6px; border-radius:50%; background:#0d92c2; flex-shrink:0;"></div>
                    <span style="font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">Datos personales</span>
                </div>
                <div style="padding:18px 20px;">
                    @foreach([
                        ['Correo',           $persona->correo ?? null],
                        ['Teléfono',         $persona->telefono ?? null],
                        ['Fecha de nac.',    $persona->fecha_nacimiento ? \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/Y') : null],
                        ['CUIL',             $persona->cuil ?? null],
                        ['Grupo sanguíneo',  $persona->grupo_sanguineo ?? null],
                        ['Nivel de estudio', $persona->nivelEstudio?->nombre ?? null],
                    ] as [$label, $val])
                    <div style="display:flex; justify-content:space-between; align-items:baseline; gap:12px; padding:9px 0; border-bottom:1px solid #f0ede8; font-size:13.5px;">
                        <span style="color:#94a3b4; font-size:12.5px; flex-shrink:0;">{{ $label }}</span>
                        <span style="{{ !$val ? 'color:#c8c4bb; font-style:italic;' : 'color:#0f172a; font-weight:500; text-align:right;' }}">{{ $val ?? '—' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Domicilio ── --}}
        <div class="col-md-6">
            <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; overflow:hidden; height:100%;">
                <div style="padding:13px 20px 11px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; gap:10px;">
                    <div style="width:6px; height:6px; border-radius:50%; background:#17a385; flex-shrink:0;"></div>
                    <span style="font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">Domicilio</span>
                </div>
                <div style="padding:18px 20px;">
                    <div style="display:flex; justify-content:space-between; align-items:baseline; gap:12px; padding:9px 0; border-bottom:1px solid #f0ede8; font-size:13.5px;">
                        <span style="color:#94a3b4; font-size:12.5px;">Provincia</span>
                        <span style="{{ !$persona->provincia ? 'color:#c8c4bb; font-style:italic;' : 'color:#0f172a; font-weight:500;' }}">{{ $persona->provincia?->nombre ?? '—' }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:baseline; gap:12px; padding:9px 0; border-bottom:1px solid #f0ede8; font-size:13.5px;">
                        <span style="color:#94a3b4; font-size:12.5px;">Localidad</span>
                        <span style="{{ !$persona->localidad ? 'color:#c8c4bb; font-style:italic;' : 'color:#0f172a; font-weight:500;' }}">{{ $persona->localidad?->nombre ?? '—' }}</span>
                    </div>
                    @if($persona->domicilio)
                        <div style="display:flex; justify-content:space-between; align-items:baseline; gap:12px; padding:9px 0; border-bottom:1px solid #f0ede8; font-size:13.5px;">
                            <span style="color:#94a3b4; font-size:12.5px;">Barrio</span>
                            <span style="{{ !$persona->domicilio->barrio ? 'color:#c8c4bb; font-style:italic;' : 'color:#0f172a; font-weight:500;' }}">{{ $persona->domicilio->barrio?->nombre ?? '—' }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:baseline; gap:12px; padding:9px 0; border-bottom:1px solid #f0ede8; font-size:13.5px;">
                            <span style="color:#94a3b4; font-size:12.5px;">Calle</span>
                            <span style="{{ !$persona->domicilio->calle ? 'color:#c8c4bb; font-style:italic;' : 'color:#0f172a; font-weight:500;' }}">
                                {{ $persona->domicilio->calle ? $persona->domicilio->calle . ' ' . ($persona->domicilio->numero ?? '') : '—' }}
                            </span>
                        </div>
                        @if($persona->domicilio->piso || $persona->domicilio->dpto)
                            <div style="display:flex; justify-content:space-between; align-items:baseline; gap:12px; padding:9px 0; font-size:13.5px;">
                                <span style="color:#94a3b4; font-size:12.5px;">Piso / Dpto</span>
                                <span style="color:#0f172a; font-weight:500;">{{ $persona->domicilio->piso }} {{ $persona->domicilio->dpto }}</span>
                            </div>
                        @endif
                    @else
                        <div style="display:flex; justify-content:space-between; align-items:baseline; gap:12px; padding:9px 0; font-size:13.5px;">
                            <span style="color:#94a3b4; font-size:12.5px;">Dirección</span>
                            <span style="color:#c8c4bb; font-style:italic;">Sin domicilio registrado</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── CUD ── --}}
        <div class="col-md-6">
            <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; overflow:hidden; height:100%;">
                <div style="padding:13px 20px 11px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; gap:10px;">
                    <div style="width:6px; height:6px; border-radius:50%; background:#f59e0b; flex-shrink:0;"></div>
                    <span style="font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">CUD — Discapacidad</span>
                </div>
                <div style="padding:18px 20px;">
                    @if($persona->cud)
                        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; padding:9px 0; border-bottom:1px solid #f0ede8; font-size:13.5px;">
                            <span style="color:#94a3b4; font-size:12.5px;">Tiene CUD</span>
                            @if($persona->cud->tiene_cud)
                                <span style="background:#e8f9f5; border:1px solid #9fe1cb; color:#0e8a70; border-radius:20px; padding:3px 10px; font-size:11.5px; font-weight:700;">Sí</span>
                            @else
                                <span style="background:#f5f3ee; border:1px solid #c8c4bb; color:#536070; border-radius:20px; padding:3px 10px; font-size:11.5px; font-weight:600;">No</span>
                            @endif
                        </div>
                        @if($persona->cud->tiene_cud)
                            <div style="display:flex; justify-content:space-between; gap:12px; padding:9px 0; border-bottom:1px solid #f0ede8; font-size:13.5px;">
                                <span style="color:#94a3b4; font-size:12.5px;">Número</span>
                                <span style="color:#0f172a; font-weight:500;">{{ $persona->cud->numero_cud ?? '—' }}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; gap:12px; padding:9px 0; border-bottom:1px solid #f0ede8; font-size:13.5px;">
                                <span style="color:#94a3b4; font-size:12.5px;">Emisión</span>
                                <span style="color:#0f172a; font-weight:500;">{{ $persona->cud->fecha_emision ? \Carbon\Carbon::parse($persona->cud->fecha_emision)->format('d/m/Y') : '—' }}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; gap:12px; padding:9px 0; font-size:13.5px;">
                                <span style="color:#94a3b4; font-size:12.5px;">Vencimiento</span>
                                <span style="color:#0f172a; font-weight:500;">{{ $persona->cud->fecha_vencimiento ? \Carbon\Carbon::parse($persona->cud->fecha_vencimiento)->format('d/m/Y') : '—' }}</span>
                            </div>
                        @endif
                    @else
                        <div style="text-align:center; padding:24px 0; color:#94a3b4; font-size:13.5px;">Sin registro de CUD</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Programas ── --}}
        <div class="col-md-6">
            <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; overflow:hidden; height:100%;">
                <div style="padding:13px 20px 11px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; justify-content:space-between;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div style="width:6px; height:6px; border-radius:50%; background:#0d92c2; flex-shrink:0;"></div>
                        <span style="font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">Programas de asistencia</span>
                    </div>
                    <button onclick="document.getElementById('modalPrograma').style.display='flex'"
                            style="background:#e6f5fb; border:1px solid #b3e0f5; color:#0879a8; border-radius:8px; padding:4px 10px; font-size:12px; font-weight:700; cursor:pointer; font-family:inherit; transition:background .15s;"
                            onmouseover="this.style.background='#0d92c2'; this.style.color='white'; this.style.borderColor='#0d92c2'"
                            onmouseout="this.style.background='#e6f5fb'; this.style.color='#0879a8'; this.style.borderColor='#b3e0f5'">
                        + Asignar
                    </button>
                </div>
                <div style="padding:18px 20px;">
                    @if($persona->personaPrograma && $persona->personaPrograma->count())
                        <div style="display:flex; flex-wrap:wrap; gap:8px;">
                            @foreach($persona->personaPrograma as $pp)
                                <span style="background:#e6f5fb; border:1px solid #b3e0f5; color:#0879a8; border-radius:20px; padding:4px 12px; font-size:12.5px; font-weight:700;">{{ $pp->programa->nombre }}</span>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align:center; padding:24px 0; color:#94a3b4; font-size:13.5px;">Sin programas asignados</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Beneficios ── --}}
        <div class="col-md-6">
            <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; overflow:hidden; height:100%;">
                <div style="padding:13px 20px 11px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; gap:10px;">
                    <div style="width:6px; height:6px; border-radius:50%; background:#17a385; flex-shrink:0;"></div>
                    <span style="font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">Beneficios</span>
                </div>
                <div style="padding:18px 20px;">
                    @if($persona->personaBeneficio && $persona->personaBeneficio->count())
                        <div style="display:flex; flex-wrap:wrap; gap:8px;">
                            @foreach($persona->personaBeneficio as $pb)
                                <span style="background:#e8f9f5; border:1px solid #9fe1cb; color:#0e8a70; border-radius:20px; padding:4px 12px; font-size:12.5px; font-weight:700;">{{ $pb->beneficio->nombre }}</span>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align:center; padding:24px 0; color:#94a3b4; font-size:13.5px;">Sin beneficios asignados</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Grupo familiar ── --}}
        <div class="col-12">
            <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; overflow:hidden;">
                <div style="padding:13px 20px 11px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; justify-content:space-between;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div style="width:6px; height:6px; border-radius:50%; background:#0d92c2; flex-shrink:0;"></div>
                        <span style="font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">
                            Grupo familiar
                            @if($persona->grupoFamiliar && $persona->grupoFamiliar->count())
                                <span style="background:#e6f5fb; border:1px solid #b3e0f5; color:#0879a8; border-radius:20px; padding:1px 8px; font-size:11px; margin-left:6px;">{{ $persona->grupoFamiliar->count() }}</span>
                            @endif
                        </span>
                    </div>
                    <a href="{{ route('personas.grupo-familiar.create', $persona) }}"
                       style="background:#e6f5fb; border:1px solid #b3e0f5; color:#0879a8; border-radius:8px; padding:4px 10px; font-size:12px; font-weight:700; text-decoration:none; transition:background .15s;"
                       onmouseover="this.style.background='#0d92c2'; this.style.color='white'; this.style.borderColor='#0d92c2'"
                       onmouseout="this.style.background='#e6f5fb'; this.style.color='#0879a8'; this.style.borderColor='#b3e0f5'">
                        + Agregar integrante
                    </a>
                </div>
                @if($persona->grupoFamiliar && $persona->grupoFamiliar->count())
                    <div style="overflow-x:auto;">
                        <table style="width:100%; border-collapse:collapse; font-size:13px;">
                            <thead>
                                <tr style="background:#f8fafe;">
                                    <th style="font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.06em; padding:10px 16px; text-align:left; border-bottom:1px solid #e0ddd6; white-space:nowrap;">Nombre</th>
                                    <th style="font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.06em; padding:10px 16px; text-align:left; border-bottom:1px solid #e0ddd6; white-space:nowrap;">Documento</th>
                                    <th style="font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.06em; padding:10px 16px; text-align:left; border-bottom:1px solid #e0ddd6; white-space:nowrap;">Nacimiento</th>
                                    <th style="font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.06em; padding:10px 16px; text-align:left; border-bottom:1px solid #e0ddd6; white-space:nowrap;">Cobertura</th>
                                    <th style="font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.06em; padding:10px 16px; text-align:left; border-bottom:1px solid #e0ddd6; white-space:nowrap;">Situación</th>
                                    <th style="font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.06em; padding:10px 16px; text-align:left; border-bottom:1px solid #e0ddd6; white-space:nowrap;">Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($persona->grupoFamiliar as $m)
                                    <tr style="border-bottom:1px solid #f0ede8; transition:background .15s;"
                                        onmouseover="this.style.background='#fafaf8'" onmouseout="this.style.background='white'">
                                        <td style="padding:12px 16px;">
                                            <div style="font-weight:700; color:#0f172a; font-size:13.5px;">{{ $m->nombre }}</div>
                                            <div style="font-size:11px; color:#94a3b4; margin-top:2px;">{{ $m->relacion_titular ?? '—' }}</div>
                                        </td>
                                        <td style="padding:12px 16px; color:#536070;">
                                            {{ $m->tipo_documento?->nombre?->nombre ?? '' }}
                                            {{ $m->numero_documento ?? '—' }}
                                        </td>
                                        <td style="padding:12px 16px; color:#536070;">
                                            {{ $m->fecha_nacimiento ? \Carbon\Carbon::parse($m->fecha_nacimiento)->format('d/m/Y') : '—' }}
                                        </td>
                                        <td style="padding:12px 16px;">
                                            @if($m->cobertura?->nombre)
                                                <span style="background:#e6f5fb; border:1px solid #b3e0f5; color:#0879a8; border-radius:20px; padding:2px 9px; font-size:11.5px; font-weight:600;">{{ $m->cobertura->nombre }}</span>
                                            @else
                                                <span style="color:#94a3b4;">—</span>
                                            @endif
                                        </td>
                                        <td style="padding:12px 16px; color:#536070;">{{ $m->situacion_ocupacional?->nombre ?? '—' }}</td>
                                        <td style="padding:12px 16px; font-weight:600; color:#0f172a;">
                                            {{ $m->ingresos ? '$' . number_format($m->ingresos, 0, ',', '.') : '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align:center; padding:32px 20px;">
                        <div style="width:44px; height:44px; background:#e6f5fb; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px; font-size:20px; color:#0d92c2;">
                            <i class="bi bi-people"></i>
                        </div>
                        <p style="color:#536070; font-size:13.5px; margin:0 0 12px;">Sin integrantes registrados.</p>
                        <a href="{{ route('personas.grupo-familiar.create', $persona) }}"
                           style="display:inline-flex; align-items:center; gap:6px; background:#0d92c2; color:white; text-decoration:none; padding:8px 16px; border-radius:10px; font-weight:700; font-size:13px;">
                            <i class="bi bi-person-plus-fill"></i> Agregar el primero
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Últimas atenciones ── --}}
        <div class="col-12">
            <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; overflow:hidden;">
                <div style="padding:13px 20px 11px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; gap:10px;">
                    <div style="width:6px; height:6px; border-radius:50%; background:#17a385; flex-shrink:0;"></div>
                    <span style="font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">Últimas atenciones</span>
                </div>
                <div style="padding:18px 20px;">
                    @if($persona->atenciones && $persona->atenciones->count())
                        @foreach($persona->atenciones as $a)
                            <div style="padding:12px 0; border-bottom:1px solid #f0ede8; display:flex; gap:14px; align-items:flex-start;">
                                <div style="width:8px; height:8px; border-radius:50%; background:linear-gradient(135deg,#0d92c2,#17a385); margin-top:6px; flex-shrink:0;"></div>
                                <div style="flex:1;">
                                    <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                                        <span style="background:#e6f5fb; border:1px solid #b3e0f5; color:#0879a8; border-radius:20px; padding:2px 10px; font-size:11.5px; font-weight:700; text-transform:capitalize;">
                                            {{ str_replace('_', ' ', $a->tipo) }}
                                        </span>
                                        <span style="font-size:11.5px; color:#94a3b4; margin-left:auto;">
                                            {{ \Carbon\Carbon::parse($a->fecha_atencion)->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                    @if($a->descripcion)
                                        <div style="font-size:13px; color:#0f172a; margin-top:6px; line-height:1.5;">{{ $a->descripcion }}</div>
                                    @endif
                                    @if($a->usuario)
                                        <div style="font-size:11.5px; color:#94a3b4; margin-top:4px;">
                                            <i class="bi bi-person" style="font-size:10px;"></i>
                                            Registrado por {{ $a->usuario->nombre }} {{ $a->usuario->apellido }}
                                        </div>
                                    @endif
                                    @if($a->proxima_atencion)
                                        <div style="font-size:11.5px; color:#d97706; margin-top:4px; font-weight:600;">
                                            <i class="bi bi-calendar-event" style="font-size:10px;"></i>
                                            Próxima: {{ \Carbon\Carbon::parse($a->proxima_atencion)->format('d/m/Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="text-align:center; padding:24px 0; color:#94a3b4; font-size:13.5px;">Sin atenciones registradas.</div>
                    @endif
                </div>
            </div>
        </div>

    </div>{{-- /row --}}
</div>

{{-- ══════════════════════════════════════
     MODAL: Asignar programa
══════════════════════════════════════ --}}
<div id="modalPrograma" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,.45); align-items:center; justify-content:center; z-index:9999; padding:1rem;">
    <div style="background:white; width:100%; max-width:480px; border-radius:18px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.2);">

        {{-- Header modal --}}
        <div style="padding:18px 22px 16px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:32px; height:32px; background:linear-gradient(135deg,#0d92c2,#1aaad8); border-radius:8px; display:flex; align-items:center; justify-content:center; color:white; font-size:15px;">
                    <i class="bi bi-clipboard2-plus"></i>
                </div>
                <span style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:15px; color:#0f172a;">Asignar a programa</span>
            </div>
            <button onclick="document.getElementById('modalPrograma').style.display='none'"
                    style="width:32px; height:32px; background:#f5f3ee; border:1px solid #e0ddd6; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#536070; font-size:16px; transition:background .15s;"
                    onmouseover="this.style.background='#e0ddd6'" onmouseout="this.style.background='#f5f3ee'">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        {{-- Body modal --}}
        <div style="padding:22px;">
            <form method="POST" action="{{ route('persona-programa.store') }}">
                @csrf
                <input type="hidden" name="persona_id" value="{{ $persona->id }}">

                <div style="margin-bottom:16px;">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Programa</label>
                    <select name="programa_id" style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        @foreach($programas as $prog)
                            <option value="{{ $prog->id }}">{{ $prog->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom:16px;">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Fecha inicio</label>
                    <input type="date" name="fecha_inicio" style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>

                <div style="margin-bottom:20px;">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Observaciones</label>
                    <textarea name="observaciones" rows="3" style="width:100%; padding:10px 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; resize:vertical;"
                              onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                              onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'"></textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:8px;">
                    <button type="button" onclick="document.getElementById('modalPrograma').style.display='none'"
                            style="height:40px; padding:0 18px; background:white; color:#536070; border:1px solid #c8c4bb; border-radius:10px; font-family:inherit; font-size:14px; font-weight:600; cursor:pointer; transition:background .15s;"
                            onmouseover="this.style.background='#f5f3ee'" onmouseout="this.style.background='white'">
                        Cancelar
                    </button>
                    <button type="submit"
                            style="height:40px; padding:0 22px; background:linear-gradient(135deg,#0d92c2,#1aaad8); color:white; border:none; border-radius:10px; font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; font-weight:700; cursor:pointer; transition:opacity .2s;"
                            onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
