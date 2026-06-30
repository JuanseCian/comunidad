@extends('frontend.layout.front')

@section('title', $programa->nombre)

@section('content')

{{-- ── ESTILOS RESPONSIVOS ── --}}
<style>
    /* Efectos hover limpios sin JavaScript inline */
    .btn-back:hover { background: #f5f3ee !important; }
    .btn-action:hover { background: #0d92c2 !important; color: white !important; border-color: #0d92c2 !important; }
    .list-row { transition: background 0.15s ease; position: relative; }
    .list-row:hover { background: #fafaf8; }

    /* Comportamiento Móvil (Por defecto) */
    .table-header { display: none; }
    .list-row {
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 16px 20px;
        border-bottom: 1px solid #f0ede8;
    }
    .col-dni, .col-tags, .col-status {
        padding: 0 8px;
    }
    .mobile-label {
        font-size: 11px;
        font-weight: 800;
        color: #9baabf;
        text-transform: uppercase;
        margin-right: 8px;
        display: inline-block;
    }
    .col-actions {
        position: absolute;
        top: 16px;
        right: 20px;
    }

    /* Comportamiento Escritorio (>992px) */
    @media (min-width: 992px) {
        .table-header {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 120px 80px;
            gap: 0;
            border-bottom: 1px solid #e0ddd6;
            background: #f5f3ee;
            padding: 0 20px;
        }
        .list-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 120px 80px;
            gap: 0;
            padding: 0 20px;
            align-items: center;
        }
        .col-dni, .col-tags, .col-status, .col-actions {
            padding: 14px 8px;
        }
        .mobile-label { display: none; }
        .col-actions {
            position: static;
            display: flex;
            justify-content: flex-end;
        }
    }
</style>

{{-- ── CABECERA ── --}}
<div style="background: linear-gradient(135deg, #e6f5fb 0%, #e8f9f5 100%); border-bottom: 1px solid #d0eee7; padding: 2rem 0 1.5rem;">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col-12 col-md">
                <p style="font-size:12px; font-weight:700; color:#0879a8; text-transform:uppercase; letter-spacing:1.2px; margin-bottom:4px;">
                    <a href="{{ route('dashboard') }}" style="color:#0879a8; text-decoration:none;">Inicio</a>
                    <span style="opacity:.4; margin:0 6px;">/</span>
                    Programas
                </p>
                <h1 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:clamp(1.4rem,3vw,2rem); color:#0f172a; margin:0; line-height:1.2;">
                    {{ $programa->nombre }}
                </h1>
                <p style="color:#536070; font-size:13.5px; font-weight:500; margin:4px 0 0;">
                   {{ $personas->total() }} {{ $programa->personas->count() === 1 ? 'persona asignada' : 'personas asignadas' }}
                </p>
            </div>
            <div class="col-12 col-md-auto text-md-end text-start">
                <a href="javascript:history.back()" class="btn-back" style="
                    display:inline-flex; align-items:center; gap:8px;
                    background:white; color:#536070; text-decoration:none;
                    padding:10px 20px; border-radius:12px; border:1px solid #c8c4bb;
                    font-family:'Plus Jakarta Sans',sans-serif;
                    font-weight:700; font-size:14px; transition: all .2s;">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    
    {{-- ── FILTROS (BOOTSTRAP GRID) ── --}}
    <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; padding:16px; margin-bottom:18px;">
        <form method="GET" class="row g-3 align-items-end">
            
            {{-- BUSCADOR --}}
            <div class="col-12 col-md-4 col-lg-3">
                <label style="display:block; font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; margin-bottom:6px;">Buscar persona</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Nombre, apellido o DNI..." 
                       style="width:100%; border:1px solid #d6d3d1; border-radius:12px; padding:11px 14px; font-size:13px;">
            </div>

            {{-- SEDE --}}
            <div class="col-12 col-md-4 col-lg-3">
                <label style="display:block; font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; margin-bottom:6px;">Sede</label>
                <select name="sede_id" style="width:100%; border:1px solid #d6d3d1; border-radius:12px; padding:11px 14px; font-size:13px;">
                    <option value="">Todas las sedes</option>
                    @foreach($sedes as $sede)
                        <option value="{{ $sede->id }}" @selected(request('sede_id') == $sede->id)>
                            {{ $sede->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ESTADO --}}
            <div class="col-12 col-md-4 col-lg-3">
                <label style="display:block; font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; margin-bottom:6px;">Estado</label>
                <select name="estado_programa" style="width:100%; border:1px solid #d6d3d1; border-radius:12px; padding:11px 14px; font-size:13px;">
                    <option value="">Todos</option>
                    <option value="activo" @selected(request('estado_programa') == 'activo')>Activos</option>
                    <option value="finalizado" @selected(request('estado_programa') == 'finalizado')>Finalizados</option>
                </select>
            </div>

            {{-- BOTONES --}}
            <div class="col-12 col-lg-auto d-flex gap-2 ms-lg-auto mt-3 mt-lg-0">
                <a href="{{ route('frontend.programas.show', $programa->id) }}" style="height:44px; display:flex; align-items:center; justify-content:center; padding:0 16px; border-radius:12px; border:1px solid #d6d3d1; text-decoration:none; color:#536070; font-weight:700; background:white; flex-grow:1;">
                    Limpiar
                </a>
                <button type="submit" style="height:44px; border:none; border-radius:12px; background:#0d92c2; color:white; padding:0 24px; font-weight:700; flex-grow:1;">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>

    {{-- ── TABLA / LISTA ── --}}
    <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; overflow:hidden;">

        @if($personas->isEmpty())
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

            {{-- ENCABEZADOS (Solo Desktop) --}}
            <div class="table-header">
                <div style="padding:12px 8px; font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">Persona</div>
                <div style="padding:12px 8px; font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">DNI</div>
                <div style="padding:12px 8px; font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">Sexo / Sede</div>
                <div style="padding:12px 8px; font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">Estado</div>
                <div style="padding:12px 8px;"></div>
            </div>

            {{-- FILAS DE PERSONAS --}}
            @foreach($personas as $persona)
                <div class="list-row">

                    {{-- Nombre y Avatar --}}
                    <div style="padding:14px 8px 0 8px; display:flex; align-items:center; gap:12px; min-width:0;">
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

                    {{-- DNI --}}
                    <div class="col-dni">
                        <span class="mobile-label">DNI:</span>
                        <span style="font-size:13.5px; font-weight:600; color:#0f172a;">{{ $persona->dni ?? '—' }}</span>
                    </div>

                    {{-- Tags (Sexo y Sede) --}}
                    <div class="col-tags" style="display:flex; align-items:center; flex-wrap:wrap; gap:6px;">
                        @if($persona->sexo)
                            <span style="background:#e6f5fb; color:#0879a8; border:1px solid #b3e0f5; border-radius:20px; padding:3px 10px; font-size:11px; font-weight:700;">
                                {{ $persona->sexo->nombre }}
                            </span>
                        @endif

                        @php
                            $pp = $persona->personaPrograma->where('programa_id', $programa->id)->first();
                        @endphp
                        @if($pp?->sede)
                            <span style="background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; border-radius:20px; padding:3px 10px; font-size:11px; font-weight:700;">
                                <i class="bi bi-geo-alt-fill"></i> {{ $pp->sede->nombre }}
                            </span>
                        @endif
                    </div>

                    {{-- Estado Programa --}}
                    <div class="col-status">
                        @php
                            $registroPrograma = $persona->personaPrograma->where('programa_id', $programa->id)->sortByDesc('created_at')->first();
                        @endphp

                        @if($registroPrograma && is_null($registroPrograma->fecha_fin))
                            <span style="background:#ecfdf5; color:#047857; border:1px solid #a7f3d0; border-radius:20px; padding:4px 10px; font-size:11px; font-weight:700;">
                                Activo
                            </span>
                        @else
                            <span style="background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; border-radius:20px; padding:4px 10px; font-size:11px; font-weight:700;">
                                Finalizado
                            </span>
                        @endif
                    </div>
                    
                    {{-- Acciones --}}
                    <div class="col-actions">
                        <a href="{{ route('personas.show', $persona) }}" class="btn-action"
                           style="width:32px; height:32px; background:#e6f5fb; border:1px solid #b3e0f5; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; color:#0879a8; text-decoration:none; transition:all .15s;"
                           title="Ver ficha">
                            <i class="bi bi-eye-fill" style="font-size:13px;"></i>
                        </a>
                    </div>

                </div>
            @endforeach

        @endif
    </div>
    
    {{-- PAGINACIÓN --}}
    @if($personas->hasPages())
        <div style="padding:16px; border-top:1px solid #ece8df; background:#fafaf8; border-radius: 0 0 16px 16px;">
            {{ $personas->links() }}
        </div>
    @endif
</div>

@endsection 