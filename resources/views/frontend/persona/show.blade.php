@extends('frontend.layout.front')

@section('title', $persona->apellido . ', ' . $persona->nombre . ' — Perfil')

@section('content')

@php
    $alerta = $persona->alertaPrograma();
@endphp

@if($alerta)
    <div id="modalSugerenciaPrograma" 
         style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.6); z-index:2000; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
        
        <div class="sp-anim" style="background:white; border-radius:24px; width:90%; max-width:450px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); overflow:hidden;">
            
            <div style="background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); padding: 30px 24px; text-align: center; border-bottom: 1px solid #fed7aa;">
                <div style="width: 60px; height: 60px; background: #fb923c; color: white; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 28px; box-shadow: 0 10px 15px -3px rgba(251, 146, 60, 0.4);">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <h2 style="margin:0; font-size: 18px; font-weight: 800; color: #9a3412; font-family: var(--sans);">Cambio de Programa Sugerido</h2>
            </div>

            <div style="padding: 24px; text-align: center;">
                <p style="font-size: 14.5px; color: #7c2d12; line-height: 1.6; margin-bottom: 20px;">
                    {{ $alerta['mensaje'] }}
                </p>

                @if($alerta['siguiente'])
                    <div style="background: var(--blue-lt); border: 1px dashed var(--blue); padding: 15px; border-radius: 16px; margin-bottom: 24px;">
                        <span style="display:block; font-size: 11px; text-transform: uppercase; font-weight: 800; color: var(--blue); letter-spacing: 1px; margin-bottom: 4px;">Nuevo programa recomendado</span>
                        <span style="font-size: 17px; font-weight: 800; color: var(--ink);">{{ $alerta['programa'] }}</span>
                    </div>
                @endif

                <div style="display: grid; grid-template-columns: 1fr; gap: 10px;">
                    <button onclick="abrirAsignacionDesdeSugerencia()" class="sp-btn-primary" style="justify-content: center; height: 48px; font-size: 14px;">
                        <i class="bi bi-check2-circle"></i> Realizar cambio ahora
                    </button>
                    <button onclick="document.getElementById('modalSugerenciaPrograma').style.display='none'" 
                            class="sp-btn-ghost" style="justify-content: center; border: none;">
                        Revisar más tarde
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.getElementById('modalSugerenciaPrograma').style.display = 'flex';
            }, 500);
        });

        function abrirAsignacionDesdeSugerencia() {
            document.getElementById('modalSugerenciaPrograma').style.display = 'none';
            document.getElementById('modalPrograma').style.display = 'flex';
        }
    </script>
@endif

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --blue:     #0d92c2;
        --blue-dk:  #0879a8;
        --blue-lt:  #e6f5fb;
        --blue-brd: #b3e0f5;
        --teal:     #17a385;
        --teal-lt:  #e8f9f5;
        --teal-brd: #9fe1cb;
        --teal-dk:  #0e8a70;
        --slate:    #536070;
        --ink:      #0f172a;
        --muted:    #94a3b4;
        --border:   #e0ddd6;
        --border-sm:#f0ede8;
        --bg:       #f8fafe;
        --white:    #ffffff;
        --amber:    #d97706;
        --amber-lt: #fef9ee;
        --amber-brd:#fcd98a;
        --radius:   16px;
        --sans:     'Plus Jakarta Sans', system-ui, sans-serif;
        --shadow-sm: 0 2px 12px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 20px rgba(13,146,194,0.10);
    }

    .sp-page { font-family: var(--sans); color: var(--ink); }

    #modalSugerenciaPrograma {
        transition: all 0.3s ease-in-out;
    }

    #modalSugerenciaPrograma .sp-btn-primary {
        transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    #modalSugerenciaPrograma .sp-btn-primary:hover {
        transform: scale(1.02);
    }

    .sp-breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; color: var(--muted); margin-bottom: 1.5rem; flex-wrap: wrap;
    }
    .sp-breadcrumb a { color: var(--muted); text-decoration: none; transition: color .15s; }
    .sp-breadcrumb a:hover { color: var(--blue); }
    .sp-breadcrumb span { opacity: .5; }

    .sp-alert {
        display: flex; align-items: center; gap: 10px;
        background: var(--teal-lt); border: 1px solid var(--teal-brd); color: var(--teal-dk);
        padding: 12px 18px; border-radius: 12px; font-size: 13.5px; font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .sp-hero {
        background: linear-gradient(135deg, var(--blue-lt) 0%, var(--teal-lt) 100%);
        border: 1px solid var(--blue-brd);
        border-radius: 20px;
        padding: 28px 28px 24px;
        margin-bottom: 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        gap: 20px; flex-wrap: wrap;
        position: relative; overflow: hidden;
    }
    .sp-hero::before {
        content: '';
        position: absolute; top: -40px; right: -40px;
        width: 180px; height: 180px;
        background: radial-gradient(circle, rgba(13,146,194,.10) 0%, transparent 70%);
        border-radius: 50%;
    }
    .sp-avatar {
        width: 62px; height: 62px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, var(--blue), var(--teal));
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1.4rem; color: white;
        box-shadow: 0 4px 16px rgba(13,146,194,.30);
    }
    .sp-hero-name {
        font-size: clamp(1.25rem, 3vw, 1.7rem);
        font-weight: 800; color: var(--ink); line-height: 1.15; margin: 0 0 10px;
    }

    .sp-pill {
        display: inline-flex; align-items: center;
        border-radius: 40px; padding: 3px 11px;
        font-size: 11.5px; font-weight: 700; border: 1px solid;
    }
    .sp-pill-gray   { background: white; border-color: var(--border); color: var(--slate); }
    .sp-pill-blue   { background: var(--blue-lt); border-color: var(--blue-brd); color: var(--blue-dk); }
    .sp-pill-teal   { background: var(--teal-lt); border-color: var(--teal-brd); color: var(--teal-dk); }
    .sp-pill-amber  { background: var(--amber-lt); border-color: var(--amber-brd); color: var(--amber); }

    .sp-btn-primary {
        display: inline-flex; align-items: center; gap: 7px;
        height: 40px; padding: 0 18px; border-radius: 12px;
        background: linear-gradient(135deg, var(--blue), #1aaad8);
        color: white; font-family: var(--sans); font-size: 13px; font-weight: 700;
        text-decoration: none; border: none; cursor: pointer;
        box-shadow: 0 4px 14px rgba(13,146,194,.28);
        transition: opacity .2s, transform .15s;
    }
    .sp-btn-primary:hover { opacity: .88; transform: translateY(-1px); color: white; }

    .sp-btn-ghost {
        display: inline-flex; align-items: center; gap: 7px;
        height: 40px; padding: 0 18px; border-radius: 12px;
        background: white; color: var(--slate);
        font-family: var(--sans); font-size: 13px; font-weight: 600;
        text-decoration: none; border: 1px solid var(--border);
        transition: background .15s, color .15s;
    }
    .sp-btn-ghost:hover { background: var(--bg); color: var(--ink); }

    .sp-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        height: 100%;
        box-shadow: var(--shadow-sm);
    }
    .sp-card-header {
        padding: 13px 20px 12px;
        border-bottom: 1px solid var(--border-sm);
        display: flex; align-items: center; justify-content: space-between;
        background: var(--bg);
    }
    .sp-card-header-left { display: flex; align-items: center; gap: 10px; }
    .sp-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
    .sp-card-title {
        font-size: 11px; font-weight: 800; color: var(--slate);
        text-transform: uppercase; letter-spacing: .07em; margin: 0;
    }
    .sp-card-action {
        font-size: 12px; font-weight: 700; color: var(--blue);
        text-decoration: none; background: var(--blue-lt);
        border: 1px solid var(--blue-brd); border-radius: 8px;
        padding: 3px 10px; transition: background .15s, color .15s;
    }
    .sp-card-action:hover { background: var(--blue); color: white; }
    .sp-card-body { padding: 18px 20px; }

    .sp-data-row {
        display: flex; justify-content: space-between; align-items: baseline;
        gap: 12px; padding: 9px 0; border-bottom: 1px solid var(--border-sm);
        font-size: 13.5px;
    }
    .sp-data-row:last-child { border-bottom: none; }
    .sp-label { color: var(--muted); font-size: 12.5px; flex-shrink: 0; font-weight: 500; }
    .sp-val { color: var(--ink); font-weight: 600; text-align: right; }
    .sp-val-empty { color: #c8c4bb; font-style: italic; font-weight: 400; text-align: right; }

    .sp-count {
        background: var(--blue-lt); border: 1px solid var(--blue-brd);
        color: var(--blue-dk); border-radius: 20px;
        padding: 1px 8px; font-size: 11px; font-weight: 700; margin-left: 6px;
    }

    .sp-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .sp-table thead tr { background: var(--bg); }
    .sp-table th {
        font-size: 10.5px; font-weight: 800; color: var(--slate);
        text-transform: uppercase; letter-spacing: .06em;
        padding: 10px 16px; text-align: left;
        border-bottom: 1px solid var(--border); white-space: nowrap;
    }
    .sp-table td { padding: 12px 16px; border-bottom: 1px solid var(--border-sm); vertical-align: middle; }
    .sp-table tbody tr:last-child td { border-bottom: none; }
    .sp-table tbody tr { transition: background .12s; }
    .sp-table tbody tr:hover td { background: var(--bg); }

    .sp-badge-yes { background: var(--teal-lt); border: 1px solid var(--teal-brd); color: var(--teal-dk); border-radius: 20px; padding: 3px 10px; font-size: 11.5px; font-weight: 700; }
    .sp-badge-no  { background: var(--bg); border: 1px solid var(--border); color: var(--slate); border-radius: 20px; padding: 3px 10px; font-size: 11.5px; font-weight: 600; }

    .sp-tag-green { background: var(--teal-lt); border: 1px solid var(--teal-brd); color: var(--teal-dk); border-radius: 20px; padding: 4px 13px; font-size: 12.5px; font-weight: 700; }
    .sp-tag-blue  { background: var(--blue-lt); border: 1px solid var(--blue-brd); color: var(--blue-dk); border-radius: 20px; padding: 4px 13px; font-size: 12.5px; font-weight: 700; }

    .sp-att-row {
        display: flex; gap: 14px; align-items: flex-start;
        padding: 14px 0; border-bottom: 1px solid var(--border-sm);
    }
    .sp-att-row:last-child { border-bottom: none; }
    .sp-att-dot { width: 9px; height: 9px; border-radius: 50%; background: var(--teal); margin-top: 5px; flex-shrink: 0; }

    .sp-empty { text-align: center; padding: 30px 20px; color: var(--muted); font-size: 13.5px; }
    .sp-empty-icon {
        width: 46px; height: 46px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 12px; font-size: 20px;
    }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .sp-anim { animation: fadeUp .35s ease both; }
    .sp-anim-1 { animation-delay: .00s; }
    .sp-anim-2 { animation-delay: .05s; }
    .sp-anim-3 { animation-delay: .10s; }
    .sp-anim-4 { animation-delay: .15s; }
    .sp-anim-5 { animation-delay: .20s; }
    .sp-anim-6 { animation-delay: .25s; }
</style>

@if(session('abrirProgramaModal'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('modalPrograma').style.display = 'flex';
    });
</script>
@endif

<div class="sp-page">

    <section style="background: linear-gradient(135deg, var(--blue-lt, #e6f5fb) 0%, var(--teal-lt, #e8f9f5) 100%); border-bottom: 1px solid #d0eee7; padding: 2rem 0 1.75rem;">
        <div class="container">

            <nav class="sp-breadcrumb sp-anim sp-anim-1">
                <a href="{{ route('home') }}">Inicio</a>
                <span>/</span>
                <a href="{{ route('personas.index') }}">Personas</a>
                <span>/</span>
                <span style="color: #536070; font-weight: 600;">{{ $persona->apellido }}, {{ $persona->nombre }}</span>
            </nav>

            @if(session('success'))
                <div class="sp-alert sp-anim sp-anim-1">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif

            <div class="sp-anim sp-anim-2" style="display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap;">

                <div style="display:flex; align-items:center; gap:18px;">
                    <div class="sp-avatar">
                        {{ strtoupper(substr($persona->nombre, 0, 1)) }}{{ strtoupper(substr($persona->apellido, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="sp-hero-name">{{ $persona->apellido }}, {{ $persona->nombre }}</h1>
                        <div style="display:flex; flex-wrap:wrap; gap:6px;">
                            @if($persona->tipoDocumento)
                                <span class="sp-pill sp-pill-gray">{{ $persona->tipoDocumento->nombre }} {{ $persona->dni }}</span>
                            @endif
                            @if($persona->sexo)
                                <span class="sp-pill sp-pill-gray">{{ $persona->sexo->nombre }}</span>
                            @endif
                            @if($persona->fecha_nacimiento)
                                <span class="sp-pill sp-pill-gray">{{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->age }} años</span>
                            @endif
                            @if($persona->sedeOrigen)
                                <span class="sp-pill sp-pill-blue"><i class="bi bi-geo-alt-fill" style="font-size:10px; margin-right:3px;"></i>{{ $persona->sedeOrigen->nombre }}</span>
                            @endif
                            @if($persona->trabaja)
                                <span class="sp-pill sp-pill-teal"><i class="bi bi-briefcase-fill" style="font-size:10px; margin-right:3px;"></i>Trabaja</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div style="display:flex; gap:8px; flex-shrink:0; flex-wrap:wrap;">
                    <a href="{{ route('personas.grupo-familiar.create', $persona) }}" class="sp-btn-primary">
                        <i class="bi bi-person-plus-fill"></i> Agregar integrante
                    </a>
                    <a href="{{ route('personas.create') }}" class="sp-btn-ghost">
                        <i class="bi bi-person-plus"></i> Nueva persona
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-4">

        <div class="row g-3 mb-3">

            <div class="col-md-6 sp-anim sp-anim-3">
                <div class="sp-card">

                    <div class="sp-card-header">
                        <div class="sp-card-header-left">
                            <div class="sp-dot" style="background: var(--blue);"></div>
                            <span class="sp-card-title">Datos personales</span>
                        </div>

                        @if(in_array(auth()->user()->rol_id, [2,3,5]))
                            <button type="button" onclick="toggleEdit('datos')" class="sp-card-action">
                                Editar
                            </button>
                        @endif
                    </div>

                    <div class="sp-card-body">
                        <form action="{{ route('personas.updateDatos', $persona->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="sp-data-row">
                                <span class="sp-label"><i class="bi bi-envelope"></i> Correo</span>

                                <span class="sp-val view-datos">{{ $persona->correo ?? '—' }}</span>

                                <input type="email" name="correo" value="{{ $persona->correo }}"
                                    class="edit-datos" style="display:none;">
                            </div>

                            <div class="sp-data-row">
                                <span class="sp-label"><i class="bi bi-phone"></i> Teléfono</span>

                                <span class="sp-val view-datos">{{ $persona->telefono ?? '—' }}</span>

                                <input type="text" name="telefono" value="{{ $persona->telefono }}"
                                    class="edit-datos" style="display:none;">
                            </div>

                            <div class="sp-data-row">
                                <span class="sp-label"><i class="bi bi-calendar3"></i> Fecha de nac.</span>

                                    <span class="sp-val view-datos">
                                        {{ $persona->fecha_nacimiento ? \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/Y') : '—' }}
                                    </span>

                                    <input type="date" name="fecha_nacimiento"
                                        value="{{ $persona->fecha_nacimiento ? $persona->fecha_nacimiento->format('Y-m-d') : '' }}"
                                        class="edit-datos" style="display:none;">
                                </div>

                                <div class="sp-data-row">
                                    <span class="sp-label"><i class="bi bi-fingerprint"></i> CUIL</span>

                                    <span class="sp-val view-datos">{{ $persona->cuil ?? '—' }}</span>

                                    <input type="text" name="cuil" value="{{ $persona->cuil }}"
                                        class="edit-datos" style="display:none;">
                                </div>

                                <div class="sp-data-row">
                                    <span class="sp-label"><i class="bi bi-heart-pulse"></i> Grupo sanguíneo</span>

                                    <span class="sp-val view-datos">{{ $persona->grupo_sanguineo ?? '—' }}</span>

                                    <input type="text" name="grupo_sanguineo" value="{{ $persona->grupo_sanguineo }}"
                                        class="edit-datos" style="display:none;">
                                </div>

                                <div class="sp-data-row">
                                    <span class="sp-label"><i class="bi bi-mortarboard"></i> Nivel de estudio</span>

                                    <span class="sp-val view-datos">{{ $persona->nivelEstudio?->nombre ?? '—' }}</span>

                                    <select name="nivel_estudio_id" class="edit-datos" style="display:none;">
                                        <option value="">Seleccionar</option>
                                        @foreach($niveles as $n)
                                            <option value="{{ $n->id }}" @selected($persona->nivel_estudio_id == $n->id)>
                                                {{ $n->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="sp-btn-primary edit-datos" style="display:none; margin-top:10px;">
                                    Guardar cambios
                                </button>

                            </form>
                        </div>
                    </div>
                </div>

            <div class="col-md-6 sp-anim sp-anim-3">
            <div class="sp-card">

                <div class="sp-card-header">
                    <div class="sp-card-header-left">
                        <div class="sp-dot" style="background: var(--teal);"></div>
                        <span class="sp-card-title">Domicilio</span>
                    </div>

                    @if(in_array(auth()->user()->rol_id, [2,3,5]))
                        <button type="button" onclick="toggleEdit('domicilio')" class="sp-card-action">
                            Editar
                        </button>
                    @endif
                </div>

                <div class="sp-card-body">
                    <form action="{{ route('personas.updateDomicilio', $persona->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="sp-data-row">
                            <span class="sp-label">Provincia</span>
                            <span class="sp-val view-domicilio">{{ $persona->provincia->nombre ?? '—' }}</span>

                            <select name="provincia_id" class="edit-domicilio" style="display:none;">
                                <option value="" @selected(is_null($persona->provincia_id))>— Seleccionar Provincia —</option>
                                @foreach($provincias as $p)
                                    <option value="{{ $p->id }}" @selected($persona->provincia_id == $p->id)>
                                        {{ $p->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sp-data-row">
                            <span class="sp-label">Localidad</span>
                            <span class="sp-val view-domicilio">{{ $persona->localidad->nombre ?? '—' }}</span>

                            <select name="localidad_id" class="edit-domicilio" style="display:none;">
                                <option value="" @selected(is_null($persona->localidad_id))>— Seleccionar Localidad —</option>
                                @foreach($localidades as $l)
                                    <option value="{{ $l->id }}" @selected($persona->localidad_id == $l->id)>
                                        {{ $l->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sp-data-row">
                            <span class="sp-label">Barrio</span>
                            <span class="sp-val view-domicilio">{{ $persona->domicilio->barrio->nombre ?? '—' }}</span>

                            <select name="barrio_id" class="edit-domicilio" style="display:none;">
                                <option value="" @selected(is_null(optional($persona->domicilio)->barrio_id))>— Seleccionar Barrio —</option>
                                @foreach($barrios as $b)
                                    <option value="{{ $b->id }}" @selected(optional($persona->domicilio)->barrio_id == $b->id)>
                                        {{ $b->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sp-data-row">
                            <span class="sp-label">Calle</span>

                            <span class="sp-val view-domicilio">
                                {{ $persona->domicilio->calle ?? '—' }} {{ $persona->domicilio->numero ?? '' }}
                            </span>

                            <input type="text" name="calle" value="{{ $persona->domicilio->calle ?? '' }}"
                                class="edit-domicilio" style="display:none;">

                            <input type="text" name="numero" value="{{ $persona->domicilio->numero ?? '' }}"
                                class="edit-domicilio" style="display:none; width:80px;">
                        </div>

                        <div class="sp-data-row">
                            <span class="sp-label">Piso / Dpto</span>

                            <span class="sp-val view-domicilio">
                                {{ $persona->domicilio->piso ?? '' }} {{ $persona->domicilio->dpto ?? '' }}
                            </span>

                            <input type="text" name="piso" value="{{ $persona->domicilio->piso ?? '' }}"
                                class="edit-domicilio" style="display:none; width:60px;">

                            <input type="text" name="dpto" value="{{ $persona->domicilio->dpto ?? '' }}"
                                class="edit-domicilio" style="display:none; width:60px;">
                        </div>

                        <button type="submit" class="sp-btn-primary edit-domicilio" style="display:none; margin-top:10px;">
                            Guardar cambios
                        </button>

                    </form>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">

            <div class="col-md-6 sp-anim sp-anim-4">
                <div class="sp-card">
                    <div class="sp-card-header">
                        <div class="sp-card-header-left">
                            <div class="sp-dot" style="background: var(--amber);"></div>
                            <span class="sp-card-title">CUD — Discapacidad</span>
                        </div>
                    </div>
                    <div class="sp-card-body">

                        {{-- Discapacidad --}}
                        <div class="sp-data-row">
                            <span class="sp-label"><i class="bi bi-person-wheelchair" style="margin-right:5px; font-size:12px;"></i>Discapacidad</span>
                            @if($persona->discapacidad)
                                <span class="sp-val">{{ $persona->discapacidad->nombre }}</span>
                            @else
                                <span class="sp-val">—</span>
                            @endif
                        </div>
                        <div class="sp-data-row">
                            <span class="sp-label"><i class="bi bi-infinity" style="margin-right:5px; font-size:12px;"></i>Permanente</span>
                            @if($persona->discapacidad_permanente)
                                <span class="sp-badge-yes">Sí</span>
                            @else
                                <span class="sp-badge-no">No</span>
                            @endif
                        </div>
                        <div class="sp-data-row">
                            <span class="sp-label"><i class="bi bi-heart-pulse" style="margin-right:5px; font-size:12px;"></i>En tratamiento</span>
                            @if($persona->discapacidad_tratamiento)
                                <span class="sp-badge-yes">Sí</span>
                            @elseif(is_null($persona->discapacidad_tratamiento))
                                <span class="sp-val">—</span>
                            @else
                                <span class="sp-badge-no">No</span>
                            @endif
                        </div>
                        @if($persona->caratula)
                        <div class="sp-data-row">
                            <span class="sp-label"><i class="bi bi-folder2" style="margin-right:5px; font-size:12px;"></i>Carátula</span>
                            <span class="sp-val">{{ $persona->caratula }}</span>
                        </div>
                        @endif

                        {{-- CUD --}}
                        <div class="sp-data-row" style="margin-top:8px; padding-top:12px; border-top:1px solid var(--border-sm);">
                            <span class="sp-label"><i class="bi bi-patch-check" style="margin-right:5px; font-size:12px;"></i>N° CUD</span>
                            <span class="sp-val">{{ $persona->cud->numero_cud ?? '—' }}</span>
                        </div>
                        <div class="sp-data-row">
                            <span class="sp-label"><i class="bi bi-calendar-check" style="margin-right:5px; font-size:12px;"></i>Emisión CUD</span>
                            <span class="sp-val">{{ $persona->cud?->fecha_emision ? $persona->cud->fecha_emision->format('d/m/Y') : '—' }}</span>
                        </div>
                        <div class="sp-data-row" style="border-bottom:none;">
                            <span class="sp-label"><i class="bi bi-calendar-x" style="margin-right:5px; font-size:12px;"></i>Vencimiento CUD</span>
                            @if($persona->cud?->fecha_vencimiento)
                                @php $venc = $persona->cud->fecha_vencimiento @endphp
                                <span class="sp-val" style="color: {{ $venc->isPast() ? '#b91c1c' : ($venc->diffInDays(now()) <= 60 ? '#d97706' : 'inherit') }};">
                                    {{ $venc->format('d/m/Y') }}
                                    @if($venc->isPast())
                                        <span class="sp-pill" style="background:#fef2f2; color:#b91c1c; border-color:#fecaca; font-size:10px; margin-left:4px;">Vencido</span>
                                    @elseif($venc->diffInDays(now()) <= 60)
                                        <span class="sp-pill" style="background:#fffbeb; color:#d97706; border-color:#fde68a; font-size:10px; margin-left:4px;">Por vencer</span>
                                    @endif
                                </span>
                            @else
                                <span class="sp-val">—</span>
                            @endif
                        </div>
                        @if($persona->cud?->observaciones)
                        <div class="sp-data-row" style="border-bottom:none; margin-top:4px;">
                            <span class="sp-label"><i class="bi bi-chat-left-text" style="margin-right:5px; font-size:12px;"></i>Observaciones</span>
                            <span class="sp-val" style="font-style:italic;">{{ $persona->cud->observaciones }}</span>
                        </div>
                        @endif

                        @if(!$persona->discapacidad && !$persona->cud)
                        <div class="sp-empty" style="padding:14px 0 4px;">
                            <div class="sp-empty-icon" style="background: var(--amber-lt); color: var(--amber);">
                                <i class="bi bi-patch-question"></i>
                            </div>
                            Sin registro de discapacidad ni CUD
                        </div>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-md-6 sp-anim sp-anim-4">
                <div class="sp-card">
                    <div class="sp-card-header">
                        <div class="sp-card-header-left">
                            <div class="sp-dot" style="background: var(--teal-dk);"></div>
                            <span class="sp-card-title">Programas de asistencia</span>
                        </div>
                        <button onclick="document.getElementById('modalPrograma').style.display='flex'" class="sp-card-action" style="cursor:pointer; font-family: var(--sans);">
                            + Asignar
                        </button>
                    </div>
                    <div class="sp-card-body">
                        @if($persona->personaPrograma && $persona->personaPrograma->count())

                            @foreach($persona->personaPrograma as $pp)

                                <div style="border:1px solid var(--border); border-radius:12px; margin-bottom:10px; overflow:hidden;">


                                    <div onclick="togglePrograma({{ $pp->id }})"
                                        style="padding:12px 14px; cursor:pointer; display:flex; justify-content:space-between; align-items:center; background:var(--bg);">

                                        <div style="display:flex; flex-direction:column; gap:2px;">
    
                                            <span style="font-weight:700;">
                                                {{ $pp->programa->nombre }}
                                            </span>

                                            <div style="display:flex; align-items:center; gap:6px;">

                                                <i class="bi bi-geo-alt-fill"
                                                style="font-size:11px; color:var(--teal-dk);"></i>

                                                <span style="
                                                    font-size:11px;
                                                    color:var(--muted);
                                                    font-weight:600;
                                                ">
                                                    {{ $pp->sede->nombre ?? 'Sede única' }}
                                                </span>

                                            </div>

                                        </div>

                                        @if($pp->fecha_inicio && !$pp->fecha_fin)
                                            <span style="background:#e8f9f5; color:#0e8a70; border:1px solid #9fe1cb; padding:2px 8px; border-radius:20px; font-size:11px; font-weight:700;">
                                                Activo
                                            </span>
                                        @elseif($pp->fecha_fin)
                                            <span style="background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; padding:2px 8px; border-radius:20px; font-size:11px; font-weight:700;">
                                                Finalizado
                                            </span>
                                        @endif

                                        <i class="bi bi-chevron-down" id="icon-{{ $pp->id }}"></i>
                                    </div>


                                    <div id="prog-{{ $pp->id }}" style="display:none; padding:14px;">

                                        <form method="POST" action="{{ route('persona-programa.update', $pp->id) }}">
                                            @csrf
                                            @method('PUT')

                                            <div style="margin-bottom:10px;">
                                                <label>Rol</label>
                                                <select name="rol" class="form-control">
                                                    <option value="destinatario" @selected($pp->rol == 'destinatario')>Destinatario</option>
                                                    <option value="tutor" @selected($pp->rol == 'tutor')>Tutor</option>
                                                </select>
                                            </div>

                                        <div style="margin-bottom:10px;">
                                            <label>Fecha inicio</label>
                                            <input type="date" name="fecha_inicio"
                                                value="{{ $pp->fecha_inicio ? \Carbon\Carbon::parse($pp->fecha_inicio)->format('Y-m-d') : '' }}"
                                                class="form-control">
                                        </div>

                                        <div style="margin-bottom:10px;">
                                            <label>Fecha fin</label>
                                            <input type="date" name="fecha_fin"
                                                value="{{ $pp->fecha_fin ? \Carbon\Carbon::parse($pp->fecha_fin)->format('Y-m-d') : '' }}"
                                                class="form-control">
                                                
                                        </div>
                                        <div style="margin-top:10px; padding-top:10px; border-top:1px solid var(--border-sm);">
                                            <div class="form-check">
                                                <input type="checkbox" name="en_adaptacion" value="1" @checked($pp->en_adaptacion) class="form-check-input">
                                                <label class="form-check-label" style="font-size:13px;">En periodo de adaptación</label>
                                            </div>
                                            @if($pp->en_adaptacion)
                                                <div style="margin-top:5px;">
                                                    <label style="font-size:12px; color:var(--muted);">Fecha límite:</label>
                                                    <input type="date" name="fecha_limite_adaptacion" 
                                                        value="{{ $pp->fecha_limite_adaptacion ? \Carbon\Carbon::parse($pp->fecha_limite_adaptacion)->format('Y-m-d') : '' }}" 
                                                        class="form-control form-control-sm">
                                                </div>
                                            @endif
                                        </div>

                                        <button class="sp-btn-primary">Guardar</button>
                                    </form>

                                </div>
                            </div>

                        @endforeach

                    @else
                        <div class="sp-empty">
                            Sin programas asignados
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-12 sp-anim sp-anim-4">

                <div class="sp-card">

                    {{-- HEADER --}}
                    <div class="sp-card-header">
                        <div class="sp-card-header-left">
                            <div class="sp-dot" style="background: var(--blue);"></div>
                            <span class="sp-card-title">Beneficios</span>
                        </div>

                        {{-- FORM AGREGAR --}}
                        <form method="POST"
                            action="{{ route('personas.beneficios.store', $persona->id) }}"
                            style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">

                            @csrf

                            <select name="beneficio_id"
                                    class="form-select"
                                    style="
                                        min-width:220px;
                                        border-radius:12px;
                                        height:40px;
                                        font-size:13px;
                                    ">

                                <option value="">
                                    Seleccionar beneficio
                                </option>

                                @foreach($beneficios as $beneficio)
                                    <option value="{{ $beneficio->id }}">
                                        {{ $beneficio->nombre }}
                                    </option>
                                @endforeach

                            </select>

                            <button type="submit"
                                    class="sp-btn-primary"
                                    style="
                                        height:40px;
                                        border:none;
                                        border-radius:12px;
                                        padding:0 16px;
                                        font-size:13px;
                                        font-weight:700;
                                    ">
                                <i class="bi bi-plus-lg"></i>
                                Asignar
                            </button>

                        </form>
                    </div>

                    {{-- BODY --}}
                    <div class="sp-card-body">

                        @if($persona->personaBeneficio && $persona->personaBeneficio->count())

                            <div class="row g-3">

                                @foreach($persona->personaBeneficio as $pb)

                                    <div class="col-xl-4 col-md-6">

                                        <div style="
                                            border:1px solid #e2e8f0;
                                            border-radius:18px;
                                            padding:16px;
                                            background:white;
                                            height:100%;
                                        ">

                                            {{-- TOP --}}
                                            <div class="d-flex justify-content-between align-items-start mb-3">

                                                <div>
                                                    <div style="
                                                        font-weight:800;
                                                        font-size:15px;
                                                        color:#0f172a;
                                                        margin-bottom:4px;
                                                    ">
                                                        {{ $pb->beneficio->nombre }}
                                                    </div>

                                                    @if($pb->fecha_otorgamiento)
                                                        <div style="
                                                            font-size:12px;
                                                            color:#64748b;
                                                        ">
                                                            Otorgado:
                                                            {{ \Carbon\Carbon::parse($pb->fecha_otorgamiento)->format('d/m/Y') }}
                                                        </div>
                                                    @endif
                                                </div>

                                                @if($pb->activo)
                                                    <span style="
                                                        background:#dcfce7;
                                                        color:#166534;
                                                        border:1px solid #86efac;
                                                        padding:4px 10px;
                                                        border-radius:999px;
                                                        font-size:11px;
                                                        font-weight:700;
                                                    ">
                                                        Activo
                                                    </span>
                                                @else
                                                    <span style="
                                                        background:#fee2e2;
                                                        color:#991b1b;
                                                        border:1px solid #fca5a5;
                                                        padding:4px 10px;
                                                        border-radius:999px;
                                                        font-size:11px;
                                                        font-weight:700;
                                                    ">
                                                        Inactivo
                                                    </span>
                                                @endif

                                            </div>

                                            {{-- INFO --}}
                                            <div style="
                                                display:flex;
                                                flex-direction:column;
                                                gap:10px;
                                                font-size:13px;
                                            ">

                                                @if($pb->monto)
                                                    <div>
                                                        <span style="color:#64748b;">Monto:</span>
                                                        <strong>
                                                            ${{ number_format($pb->monto, 0, ',', '.') }}
                                                        </strong>
                                                    </div>
                                                @endif

                                                @if($pb->fecha_vencimiento)
                                                    <div>
                                                        <span style="color:#64748b;">Vence:</span>

                                                        <strong>
                                                            {{ \Carbon\Carbon::parse($pb->fecha_vencimiento)->format('d/m/Y') }}
                                                        </strong>
                                                    </div>
                                                @endif

                                                @if($pb->observaciones)
                                                    <div>
                                                        <span style="color:#64748b;">
                                                            Observaciones:
                                                        </span>

                                                        <div style="
                                                            margin-top:4px;
                                                            color:#334155;
                                                            line-height:1.4;
                                                        ">
                                                            {{ $pb->observaciones }}
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>

                                            {{-- FOOTER --}}
                                            <div class="mt-4 d-flex justify-content-end">

                                                <form method="POST"
                                                    action="{{ route('persona-beneficios.destroy', $pb->id) }}"
                                                    onsubmit="return confirm('¿Quitar beneficio?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            style="
                                                                border:none;
                                                                background:#fee2e2;
                                                                color:#b91c1c;
                                                                width:34px;
                                                                height:34px;
                                                                border-radius:10px;
                                                            ">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="sp-empty" style="padding:40px 20px;">

                                <div style="
                                    width:64px;
                                    height:64px;
                                    margin:0 auto 14px;
                                    border-radius:50%;
                                    background:#eef8ff;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    color:#0d92c2;
                                    font-size:28px;
                                ">
                                    <i class="bi bi-gift"></i>
                                </div>

                                <div style="
                                    font-weight:700;
                                    color:#334155;
                                    margin-bottom:4px;
                                ">
                                    Sin beneficios asignados
                                </div>

                                <div style="
                                    color:#64748b;
                                    font-size:13px;
                                ">
                                    Esta persona todavía no posee beneficios registrados.
                                </div>

                            </div>

                        @endif

                    </div>
                </div>
            </div>
        </div>

        {{-- ══ CARD: Código de grupo familiar ══ --}}
        <div class="row g-3 mb-3">
            <div class="col-12 sp-anim sp-anim-5">
                <div class="sp-card">

                    {{-- Header --}}
                    <div class="sp-card-header">
                        <div class="sp-card-header-left">
                            <div class="sp-dot" style="background: var(--blue);"></div>
                            <span class="sp-card-title">Código de grupo familiar</span>
                        </div>
                        {{-- Código visible a la derecha --}}
                        @if($persona->familia)
                        <div style="display:flex; align-items:center; gap:8px;">
                            <a href="{{ route('familias.show', $persona->familia->id) }}"
                            id="codigo-familia"
                            style="
                                    font-family:monospace;
                                    font-size:15px;
                                    font-weight:800;
                                    color:var(--blue);
                                    letter-spacing:2px;
                                    text-decoration:none;
                                    display:inline-flex;
                                    align-items:center;
                                    gap:6px;
                                    transition:all .15s;
                            "
                            onmouseover="this.style.opacity='0.8'"
                            onmouseout="this.style.opacity='1'">

                                {{ $persona->familia->codigo_formateado }}

                                <i class="bi bi-box-arrow-up-right"
                                style="font-size:12px;"></i>
                            </a>
                            <button type="button" onclick="copiarCodigo()" title="Copiar código"
                                    style="width:28px; height:28px; border-radius:7px; border:1px solid var(--border); background:white; cursor:pointer; display:flex; align-items:center; justify-content:center; color:var(--slate); transition:all .15s;"
                                    onmouseover="this.style.borderColor='var(--blue)'; this.style.color='var(--blue)'"
                                    onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--slate)'">
                                <i class="bi bi-clipboard" id="icon-copiar" style="font-size:12px;"></i>
                            </button>
                        </div>
                        @endif
                        
                        @if($persona->familia)

                        <div style="
                            border-top:1px solid var(--border-sm);
                            padding-top:16px;
                            margin-top:16px;
                        ">

                            <a href="{{ route('familias.show', $persona->familia->id) }}"
                            class="sp-btn-primary"
                            style="
                                    text-decoration:none;
                                    display:inline-flex;
                                    align-items:center;
                                    gap:8px;
                            ">

                                <i class="bi bi-people-fill"></i>
                                Ver grupo familiar completo

                            </a>

                        </div>

                        @endif
                    </div>

                    <div class="sp-card-body">

                        {{-- Flash messages --}}
                        @if(session('familia_success'))
                        <div class="sp-alert" style="margin-bottom:16px;">
                            <i class="bi bi-check-circle-fill"></i> {{ session('familia_success') }}
                        </div>
                        @endif
                        @if(session('familia_error'))
                        <div class="sp-alert" style="background:#fff5f5; border-color:#fca5a5; color:#b91c1c; margin-bottom:16px;">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ session('familia_error') }}
                        </div>
                        @endif

                        {{-- Integrantes del grupo --}}
                        @if($persona->familia && $persona->familia->personas->count() > 1)
                            <div style="font-size:10.5px; font-weight:800; color:var(--slate); text-transform:uppercase; letter-spacing:.07em; margin-bottom:10px;">
                                Integrantes del grupo
                                <span class="sp-count">{{ $persona->familia->personas->count() }}</span>
                            </div>
                            <div style="display:flex; flex-direction:column; gap:6px; margin-bottom:18px;">
                                @foreach($persona->familia->personas as $integrante)
                                <div style="display:flex; align-items:center; gap:10px; padding:9px 13px; background:{{ $integrante->id === $persona->id ? 'var(--blue-lt)' : 'var(--bg)' }}; border-radius:10px; border:1px solid {{ $integrante->id === $persona->id ? 'var(--blue-brd)' : 'var(--border)' }};">
                                    <div style="width:32px; height:32px; border-radius:50%; background:{{ $integrante->id === $persona->id ? 'linear-gradient(135deg,var(--blue),var(--teal))' : 'var(--border)' }}; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <span style="font-size:12px; font-weight:800; color:{{ $integrante->id === $persona->id ? 'white' : 'var(--slate)' }};">
                                            {{ strtoupper(substr($integrante->nombre, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div style="flex:1; min-width:0;">
                                        <div style="font-size:13px; font-weight:700; color:var(--ink);">
                                            {{ $integrante->apellido }}, {{ $integrante->nombre }}
                                            @if($integrante->id === $persona->id)
                                                <span class="sp-pill sp-pill-blue" style="margin-left:5px; font-size:10px;">Este perfil</span>
                                            @endif
                                        </div>
                                        <div style="font-size:11.5px; color:var(--muted);">DNI {{ $integrante->dni }}</div>
                                    </div>
                                    @if($integrante->id !== $persona->id)
                                        <a href="{{ route('personas.show', $integrante->id) }}" class="sp-card-action" style="font-size:11px;">
                                            Ver →
                                        </a>
                                        @if(in_array(auth()->user()->rol_id, [2,3,5]))
                                        <form method="POST" action="{{ route('personas.familia.desvincular', $integrante->id) }}"
                                              onsubmit="return confirm('¿Desvincular a {{ $integrante->nombre }} del grupo?')">
                                            @csrf @method('PATCH')
                                            <button type="submit" title="Desvincular"
                                                    style="width:26px; height:26px; border-radius:6px; border:1px solid #fca5a5; background:#fff5f5; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#b91c1c; transition:background .15s;"
                                                    onmouseover="this.style.background='#fecaca'"
                                                    onmouseout="this.style.background='#fff5f5'">
                                                <i class="bi bi-x-lg" style="font-size:10px;"></i>
                                            </button>
                                        </form>
                                        @endif
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="sp-empty" style="padding:16px 0 10px;">
                                <div class="sp-empty-icon" style="background:var(--blue-lt); color:var(--blue);">
                                    <i class="bi bi-people"></i>
                                </div>
                                Sin personas vinculadas a este grupo aún.
                            </div>
                        @endif

                        {{-- Vincular a grupo existente --}}
                        @if(in_array(auth()->user()->rol_id, [2,3,5]))
                        <div style="border-top:1px solid var(--border-sm); padding-top:16px;">
                            <div style="font-size:10.5px; font-weight:800; color:var(--slate); text-transform:uppercase; letter-spacing:.07em; margin-bottom:8px;">
                                Vincular a un grupo existente
                            </div>
                            <p style="font-size:12.5px; color:var(--muted); margin:0 0 10px; line-height:1.5;">
                                Ingresá el código de otro grupo para unir a esta persona.
                            </p>
                            <form method="POST" action="{{ route('personas.familia.vincular', $persona->id) }}">
                                @csrf @method('PATCH')
                                <div style="display:flex; gap:8px; align-items:flex-start;">
                                    <div style="flex:1;">
                                        <input type="text"
                                               name="codigo"
                                               placeholder="Ej: KAR-482-XTQ"
                                               maxlength="11"
                                               autocomplete="off"
                                               oninput="this.value = this.value.toUpperCase()"
                                               style="width:100%; height:38px; padding:0 12px; border:1px solid {{ $errors->has('codigo') ? '#fca5a5' : 'var(--border)' }}; border-radius:10px; font-size:13.5px; font-family:monospace; letter-spacing:1px; outline:none; color:var(--ink); transition:border-color .15s;"
                                               onfocus="this.style.borderColor='var(--blue)'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                                               onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'"
                                               value="{{ old('codigo') }}">
                                        @error('codigo')
                                            <div style="font-size:12px; color:#b91c1c; margin-top:4px;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="sp-btn-primary" style="height:38px; white-space:nowrap;">
                                        <i class="bi bi-link-45deg"></i> Vincular
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
 @php
            $trabajoActual    = $persona->trabajos->firstWhere('fecha_fin', null);
            $historialLaboral = $persona->trabajos->filter(fn($t) => !is_null($t->fecha_fin));
        @endphp

        <div class="col-12 sp-anim">
            <div class="sp-card">

                <div class="sp-card-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div style="width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,#0d92c2,#1aaad8); display:flex; align-items:center; justify-content:center; color:white; font-size:14px; flex-shrink:0;">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        <div>
                            <div style="font-weight:700; font-size:14px; color:var(--ink);">Situación laboral</div>
                            <div style="font-size:12px; color:var(--muted);">Trabajo actual e historial</div>
                        </div>
                    </div>
                    @if(Auth::user()->puedeEditar())
                        <button type="button"
                                onclick="document.getElementById('modalNuevoTrabajo').style.display='flex'"
                                style="display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:8px; border:none; background:var(--blue); color:white; font-size:12.5px; font-weight:700; cursor:pointer;">
                            <i class="bi bi-plus-circle-fill"></i>
                            {{ $trabajoActual ? 'Actualizar trabajo' : 'Registrar trabajo' }}
                        </button>
                    @endif
                </div>

                @if($trabajoActual)
                    <div style="padding:16px 20px; background:#f0fdf8; border-bottom:1px solid var(--border);">
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:12px;">
                            <span style="font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:.07em; color:#0d6b4f; background:#bbf7d0; padding:2px 9px; border-radius:20px;">● Actual</span>
                            @if($trabajoActual->fecha_inicio)
                                <span style="font-size:12px; color:var(--muted);">desde {{ $trabajoActual->fecha_inicio->format('d/m/Y') }}</span>
                            @endif
                        </div>
                        <div class="row g-2" style="font-size:13px;">
                            <div class="col-md-4">
                                <div style="color:var(--muted); font-size:11px; font-weight:700; text-transform:uppercase; margin-bottom:2px;">Rubro / Tipo</div>
                                <div style="font-weight:700; color:var(--ink);">{{ $trabajoActual->descripcion ?? '—' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div style="color:var(--muted); font-size:11px; font-weight:700; text-transform:uppercase; margin-bottom:2px;">Empleador</div>
                                <div style="color:var(--slate);">{{ $trabajoActual->empleador ?? '—' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div style="color:var(--muted); font-size:11px; font-weight:700; text-transform:uppercase; margin-bottom:2px;">Cargo</div>
                                <div style="color:var(--slate);">{{ $trabajoActual->cargo ?? '—' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div style="color:var(--muted); font-size:11px; font-weight:700; text-transform:uppercase; margin-bottom:2px;">Situación</div>
                                <div style="color:var(--slate);">{{ $trabajoActual->situacionOcupacional?->nombre ?? '—' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div style="color:var(--muted); font-size:11px; font-weight:700; text-transform:uppercase; margin-bottom:2px;">Categoría</div>
                                <div style="color:var(--slate);">{{ $trabajoActual->categoriaOcupacional?->nombre ?? '—' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div style="color:var(--muted); font-size:11px; font-weight:700; text-transform:uppercase; margin-bottom:2px;">Ingresos</div>
                                <div style="font-weight:800; color:var(--ink);">{{ $trabajoActual->ingresos_formateado }}</div>
                            </div>
                            @if($trabajoActual->observaciones)
                                <div class="col-12">
                                    <div style="color:var(--muted); font-size:11px; font-weight:700; text-transform:uppercase; margin-bottom:2px;">Observaciones</div>
                                    <div style="color:var(--slate);">{{ $trabajoActual->observaciones }}</div>
                                </div>
                            @endif
                        </div>
                        @if(Auth::user()->puedeEditar())
                            <form method="POST" action="{{ route('personas.trabajo.finalizar', $persona) }}"
                                  onsubmit="return confirm('¿Confirmás que esta persona dejó de trabajar? El registro pasará al historial.')"
                                  style="margin-top:12px;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="display:inline-flex; align-items:center; gap:5px; padding:5px 13px; border-radius:8px; border:1px solid #fca5a5; background:#fff5f5; color:#dc2626; font-size:12px; font-weight:700; cursor:pointer;">
                                    <i class="bi bi-x-circle"></i> Marcar como finalizado
                                </button>
                            </form>
                        @endif
                    </div>
                @else
                    <div class="sp-empty" style="padding:28px;">
                        <div class="sp-empty-icon" style="background:#f0fdf8; color:#0d92c2;"><i class="bi bi-briefcase"></i></div>
                        <p style="margin:0 0 10px; font-size:13.5px; color:var(--muted);">Sin trabajo registrado actualmente.</p>
                        @if(Auth::user()->puedeEditar())
                            <button type="button"
                                    onclick="document.getElementById('modalNuevoTrabajo').style.display='flex'"
                                    style="display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:8px; border:none; background:var(--blue); color:white; font-size:12.5px; font-weight:700; cursor:pointer;">
                                <i class="bi bi-plus-circle-fill"></i> Registrar trabajo
                            </button>
                        @endif
                    </div>
                @endif

                @if($historialLaboral->isNotEmpty())
                    <div style="padding:14px 20px 6px;">
                        <button type="button"
                                onclick="const h=document.getElementById('historialLaboral'); h.style.display=h.style.display==='none'?'block':'none';"
                                style="background:none; border:none; font-size:12.5px; font-weight:700; color:var(--blue-dk); cursor:pointer; padding:0; display:flex; align-items:center; gap:5px;">
                            <i class="bi bi-clock-history"></i>
                            Historial laboral ({{ $historialLaboral->count() }} registro{{ $historialLaboral->count() != 1 ? 's' : '' }})
                            <i class="bi bi-chevron-down" style="font-size:10px;"></i>
                        </button>
                    </div>
                    <div id="historialLaboral" style="display:none;">
                        <div style="overflow-x:auto;">
                            <table class="sp-table">
                                <thead>
                                    <tr>
                                        <th>Rubro / Tipo</th>
                                        <th>Empleador</th>
                                        <th>Cargo</th>
                                        <th>Situación</th>
                                        <th>Ingresos</th>
                                        <th>Desde</th>
                                        <th>Hasta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historialLaboral as $t)
                                        <tr>
                                            <td style="font-weight:600; color:var(--ink);">{{ $t->descripcion ?? '—' }}</td>
                                            <td style="color:var(--slate);">{{ $t->empleador ?? '—' }}</td>
                                            <td style="color:var(--slate);">{{ $t->cargo ?? '—' }}</td>
                                            <td>
                                                @if($t->situacionOcupacional)
                                                    <span class="sp-tag-blue" style="font-size:11px; padding:2px 8px;">{{ $t->situacionOcupacional->nombre }}</span>
                                                @else
                                                    <span style="color:var(--muted);">—</span>
                                                @endif
                                            </td>
                                            <td style="font-weight:700; color:var(--ink);">{{ $t->ingresos_formateado }}</td>
                                            <td style="color:var(--slate);">{{ $t->fecha_inicio ? $t->fecha_inicio->format('d/m/Y') : '—' }}</td>
                                            <td style="color:var(--slate);">{{ $t->fecha_fin ? $t->fecha_fin->format('d/m/Y') : '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{-- ══ MODAL nuevo trabajo ══ --}}
        @if(Auth::user()->puedeEditar())
        <div id="modalNuevoTrabajo"
             style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:1050; align-items:center; justify-content:center; padding:16px;">
            <div style="background:white; border-radius:16px; width:100%; max-width:580px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,.25);">
                <div style="padding:18px 22px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; justify-content:space-between;">
                    <div style="font-weight:700; font-size:15px; color:var(--ink);">
                        <i class="bi bi-briefcase-fill me-2 text-primary"></i>
                        {{ $trabajoActual ? 'Actualizar trabajo' : 'Registrar trabajo' }}
                    </div>
                    <button type="button" onclick="document.getElementById('modalNuevoTrabajo').style.display='none'"
                            style="background:none; border:none; font-size:20px; color:var(--muted); cursor:pointer; line-height:1;">&times;</button>
                </div>
                <form method="POST" action="{{ route('personas.trabajo.store', $persona) }}" style="padding:20px 22px;">
                    @csrf
                    @if($trabajoActual)
                        <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:10px; padding:10px 14px; font-size:12.5px; color:#92400e; margin-bottom:16px;">
                            <i class="bi bi-info-circle me-1"></i> El trabajo actual pasará al historial y se registrará el nuevo.
                        </div>
                    @endif
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Situación ocupacional</label>
                            <select name="situacion_ocupacional_id" style="width:100%; height:40px; padding:0 10px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; background:white; color:#0f172a;">
                                <option value="">— Seleccionar —</option>
                                @foreach($situaciones_ocup as $s)
                                    <option value="{{ $s->id }}" {{ old('situacion_ocupacional_id', $trabajoActual?->situacion_ocupacional_id) == $s->id ? 'selected' : '' }}>{{ $s->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Categoría ocupacional</label>
                            <select name="categoria_ocupacional_id" style="width:100%; height:40px; padding:0 10px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; background:white; color:#0f172a;">
                                <option value="">— Seleccionar —</option>
                                @foreach($categorias_ocup as $c)
                                    <option value="{{ $c->id }}" {{ old('categoria_ocupacional_id', $trabajoActual?->categoria_ocupacional_id) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Rubro / Tipo <span style="color:#e74c3c;">*</span></label>
                            <input type="text" name="descripcion" value="{{ old('descripcion', $trabajoActual?->descripcion) }}"
                                   placeholder="Ej: Albañilería, Docencia..."
                                   style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; color:#0f172a;" required>
                        </div>
                        <div class="col-md-6">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Empleador</label>
                            <input type="text" name="empleador" value="{{ old('empleador', $trabajoActual?->empleador) }}"
                                   placeholder="Nombre del empleador"
                                   style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; color:#0f172a;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Cargo</label>
                            <input type="text" name="cargo" value="{{ old('cargo', $trabajoActual?->cargo) }}"
                                   placeholder="Ej: Operario, Encargado..."
                                   style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; color:#0f172a;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Ingresos mensuales ($)</label>
                            <input type="number" name="ingresos" min="0" step="0.01"
                                   value="{{ old('ingresos', $trabajoActual?->ingresos) }}" placeholder="0.00"
                                   style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; color:#0f172a;">
                        </div>
                        <div class="col-md-6">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Fecha de inicio</label>
                            <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', now()->format('Y-m-d')) }}"
                                   style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; color:#0f172a;">
                        </div>
                        <div class="col-12">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Observaciones</label>
                            <textarea name="observaciones" rows="2" placeholder="Información adicional..."
                                      style="width:100%; padding:8px 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; color:#0f172a; resize:vertical;">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>
                    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px; padding-top:16px; border-top:1px solid #e0ddd6;">
                        <button type="button" onclick="document.getElementById('modalNuevoTrabajo').style.display='none'"
                                style="padding:8px 18px; border-radius:10px; border:1px solid #c8c4bb; background:white; font-size:13.5px; font-weight:600; cursor:pointer;">Cancelar</button>
                        <button type="submit" style="padding:8px 20px; border-radius:10px; border:none; background:var(--blue); color:white; font-size:13.5px; font-weight:700; cursor:pointer;">
                            <i class="bi bi-check-circle me-1"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        {{-- ══ CARD: Integrantes convivientes (grupo_familiar) ══ --}}
        <div class="row g-3 mb-3">
            <div class="col-12 sp-anim sp-anim-5">
                <div class="sp-card">
                    <div class="sp-card-header">
                        <div class="sp-card-header-left">
                            <div class="sp-dot" style="background: var(--blue);"></div>
                            <span class="sp-card-title">
                                Grupo familiar
                                @if($persona->grupoFamiliar && $persona->grupoFamiliar->count())
                                    <span class="sp-count">{{ $persona->grupoFamiliar->count() }}</span>
                                @endif
                            </span>
                        </div>
    
        {{-- ══ Situación laboral ══ --}}
       
                    <a href="{{ route('personas.grupo-familiar.create', $persona) }}"
                           class="sp-card-action">
                            + Agregar integrante
                        </a>
                    </div>

                    @if($persona->grupoFamiliar && $persona->grupoFamiliar->count())
                        <div style="overflow-x:auto;">
                            <table class="sp-table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th>Nacimiento</th>
                                        <th>Cobertura</th>
                                        <th>Situación</th>
                                        <th>Ingresos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($persona->grupoFamiliar as $m)
                                        <tr>
                                            <td>
                                                <div style="font-weight:700; color: var(--ink);">{{ $m->nombre }}</div>
                                                <div style="font-size:11.5px; color: var(--muted); margin-top:2px;">{{ $m->relacion_titular ?? '—' }}</div>
                                            </td>
                                            <td style="color: var(--slate);">
                                                {{ $m->tipo_documento?->nombre?->nombre ?? '' }}
                                                {{ $m->numero_documento ?? '—' }}
                                            </td>
                                            <td style="color: var(--slate);">
                                                {{ $m->fecha_nacimiento ? \Carbon\Carbon::parse($m->fecha_nacimiento)->format('d/m/Y') : '—' }}
                                            </td>
                                            <td>
                                                @if($m->cobertura?->nombre)
                                                    <span class="sp-tag-blue" style="font-size:11.5px; padding:2px 9px;">{{ $m->cobertura->nombre }}</span>
                                                @else
                                                    <span style="color: var(--muted);">—</span>
                                                @endif
                                            </td>
                                            <td style="color: var(--slate);">{{ $m->situacion_ocupacional?->nombre ?? '—' }}</td>
                                            <td style="font-weight:700; color: var(--ink);">
                                                {{ $m->ingresos ? '$' . number_format($m->ingresos, 0, ',', '.') : '—' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="sp-empty">
                            <div class="sp-empty-icon" style="background: var(--blue-lt); color: var(--blue);">
                                <i class="bi bi-people"></i>
                            </div>
                            <p style="margin: 0 0 14px;">Sin integrantes registrados.</p>
                            <a href="{{ route('personas.grupo-familiar.create', $persona) }}" class="sp-btn-primary" style="display:inline-flex; font-size:13px;">
                                <i class="bi bi-person-plus-fill"></i> Agregar el primero
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row g-3">
    
    <div class="col-12 sp-anim sp-anim-6">
        
        <div class="sp-card">

            <div class="sp-card-header">

                <div class="sp-card-header-left">
                    <div class="sp-dot" style="background: var(--teal);"></div>

                    <span class="sp-card-title">
                        Intervenciones
                    </span>

                    @if($persona->atenciones)
                        <span class="sp-count">
                            {{ $persona->atenciones->count() }}
                        </span>
                    @endif
                </div>

                <div style="display:flex; gap:10px;">
                    @if(Auth::user()->puedeEditar())
                        <a href="{{ route('atenciones.create', $persona) }}"
                        class="sp-btn-primary">
                            <i class="bi bi-plus-lg"></i>
                            Nueva intervención
                        </a>
                    @endif
                </div>
            </div>

            <div class="sp-card-body">

                @if($persona->atenciones && $persona->atenciones->count())

                    @foreach($persona->atenciones as $a)

                        <div class="sp-att-row">

                            <div class="sp-att-dot"></div>

                            <div style="flex-grow:1;">

                                <div style="display:flex; justify-content:space-between; gap:15px; flex-wrap:wrap;">

                                    <div style="flex:1; min-width:260px;">

                                        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">

                                            <span class="sp-pill sp-pill-teal">
                                                {{ ucfirst(str_replace('_', ' ', $a->tipo ?? 'Intervención')) }}
                                            </span>

                                            <span style="font-size:11.5px; color: var(--muted);">
                                                <i class="bi bi-calendar3"></i>

                                                {{ $a->fecha_atencion
                                                    ? \Carbon\Carbon::parse($a->fecha_atencion)->format('d/m/Y')
                                                    : 'Sin fecha'
                                                }}
                                            </span>

                                        </div>

                                        <div style="font-size:13.5px; color: var(--ink); margin-top:10px; line-height:1.7;">
                                            {{ $a->descripcion ?? 'Sin detalles registrados.' }}
                                        </div>

                                        <div style="display:flex; gap:15px; flex-wrap:wrap; margin-top:10px;">

                                            <div style="font-size:11.5px; color: var(--muted);">
                                                <i class="bi bi-person"></i>
                                                {{ $a->users->nombre ?? 'Sistema' }}
                                            </div>

                                        </div>

                                    </div>

                                   {{-- Panel de adjuntos desplegable --}}
                                   @if($a->adjuntos && $a->adjuntos->count())
                                       <div id="adjuntos-{{ $a->id }}"
                                            style="display:none; margin-top:10px; border:1px solid var(--border); border-radius:10px; overflow:hidden;">
                                           @foreach($a->adjuntos as $adj)
                                               <div style="display:flex; align-items:center; justify-content:space-between; padding:9px 13px; border-bottom:1px solid var(--border-sm); font-size:12.5px;">
                                                   <div style="display:flex; align-items:center; gap:8px;">
                                                       <i class="bi {{ str_contains($adj->tipo_mime ?? '', 'pdf') ? 'bi-file-earmark-pdf text-danger' : 'bi-file-earmark-image' }}"
                                                          style="font-size:15px;"></i>
                                                       <span style="color:var(--ink); font-weight:600;">{{ $adj->nombre_original }}</span>
                                                       <span style="color:var(--muted);">{{ $adj->tamaño_formateado }}</span>
                                                   </div>
                                                   <a href="{{ route('adjuntos.download', $adj) }}"
                                                      style="display:inline-flex; align-items:center; gap:5px; padding:4px 11px; border-radius:8px; border:1px solid var(--blue-brd); background:var(--blue-lt); color:var(--blue-dk); font-size:12px; font-weight:700; text-decoration:none; transition:background .15s;"
                                                      onmouseover="this.style.background='var(--blue)'; this.style.color='white';"
                                                      onmouseout="this.style.background='var(--blue-lt)'; this.style.color='var(--blue-dk)';">
                                                       <i class="bi bi-download"></i> Descargar
                                                   </a>
                                               </div>
                                           @endforeach
                                       </div>
                                   @endif

                                   <div style="display:flex; align-items:start; gap:8px;">

                                        {{-- VER --}}
                                        @if(Auth::user()->puedeVerAtenciones())

                                            <a href="{{ route('atenciones.show', $a) }}"
                                            class="sp-btn-ghost">

                                                <i class="bi bi-eye"></i>

                                            </a>

                                        @endif

                                        {{-- ADJUNTOS --}}
                                        @if($a->adjuntos && $a->adjuntos->count())

                                            <button type="button"
                                                    class="sp-btn-ghost"
                                                    title="{{ $a->adjuntos->count() }} archivo(s) adjunto(s)"
                                                    onclick="toggleAdjuntos({{ $a->id }})">

                                                <i class="bi bi-paperclip"></i>

                                                <span style="font-size:11px; font-weight:700;">
                                                    {{ $a->adjuntos->count() }}
                                                </span>

                                            </button>

                                        @endif

                                        {{-- EDITAR / ELIMINAR --}}
                                        @if(Auth::user()->puedeEditar())

                                            <a href="{{ route('atenciones.edit', $a) }}"
                                            class="sp-btn-ghost">

                                                <i class="bi bi-pencil-square"></i>

                                            </a>

                                            <form method="POST"
                                                action="{{ route('atenciones.destroy', $a) }}">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="sp-btn-ghost sp-btn-delete"
                                                        onclick="return confirm('¿Eliminar intervención?')">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                @else

                    <div class="sp-empty">

                        <div class="sp-empty-icon"
                             style="background: var(--teal-lt); color: var(--teal);">

                            <i class="bi bi-clipboard2-pulse"></i>

                        </div>

                        <div>
                            Sin intervenciones registradas
                        </div>

                    @if(Auth::user()->puedeEditar())

                        <a href="{{ route('atenciones.create', $persona) }}"
                        class="sp-btn-primary"
                        style="margin-top:15px;">

                            Crear primera intervención

                        </a>

                    @endif

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

<div id="modalPrograma"
     style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.45); z-index:1050; align-items:center; justify-content:center; backdrop-filter:blur(3px);">
    <div style="background:white; border-radius:20px; width:90%; max-width:460px; box-shadow:0 20px 60px rgba(0,0,0,0.18); overflow:hidden; animation:fadeUp .28s ease;">

        <div style="padding:18px 24px 16px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; background: linear-gradient(135deg, var(--blue-lt) 0%, var(--teal-lt) 100%);">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,var(--blue),var(--teal)); display:flex; align-items:center; justify-content:center; color:white; font-size:16px;">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                </div>
                <h3 style="margin:0; font-size:15px; font-weight:800; color: var(--ink); font-family: var(--sans);">Asignar Programa</h3>
            </div>
            <button type="button"
                    onclick="document.getElementById('modalPrograma').style.display='none'"
                    style="background:white; border:1px solid var(--border); border-radius:8px; width:32px; height:32px; display:flex; align-items:center; justify-content:center; color: var(--muted); cursor:pointer; font-size:18px; line-height:1; transition:background .15s;"
                    onmouseover="this.style.background='#f0f0f0'" onmouseout="this.style.background='white'">&times;</button>
        </div>

        @php
            $edad = \Carbon\Carbon::parse($persona->fecha_nacimiento)->age;
        @endphp
        <div style="padding:24px;">
            <form action="{{ route('persona-programa.store') }}" method="POST">
                @csrf
                <p style="font-size:13.5px; color: var(--slate); margin-bottom:20px; line-height:1.6;">
                    Seleccioná el programa de asistencia para asignar a
                    <strong style="color: var(--ink);">{{ $persona->nombre }} {{ $persona->apellido }}</strong>.
                </p>
    
                <div style="margin-bottom:20px;">
                    <label style="display:block; font-size:12px; font-weight:800; color: var(--slate); margin-bottom:8px; text-transform:uppercase; letter-spacing:.06em;">
                        Programa disponible
                    </label>
                    <select name="programa_id" id="programa_select"
                            style="width:100%; padding:11px 14px; border-radius:12px; border:1.5px solid var(--border); font-size:13.5px; color: var(--ink); font-family: var(--sans); background:white; transition:border-color .15s; outline:none;"
                            onfocus="this.style.borderColor='var(--blue)'" onblur="this.style.borderColor='var(--border)'"
                            required>
                        <option value="" disabled selected>Seleccionar programa...</option>
                        @foreach($programas as $p)

                            @if($p->nombre == 'Guarderia' && $edad <= 5)
                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                            @endif

                            @if($p->nombre == 'UDI' && $edad >= 6 && $edad <= 11)
                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                            @endif

                            @if($p->nombre == 'Envion' && $edad >= 12)
                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                            @endif

                            @if($p->nombre == 'Multiespacio' && $edad >= 12)
                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                            @endif

                        @endforeach
                    </select>
                    <div id="wrapper_sede" style="margin-top:16px; margin-bottom:20px;">
                        <label style="display:block; font-size:12px; font-weight:800; color: var(--slate); margin-bottom:8px; text-transform:uppercase; letter-spacing:.06em;">
                            Sede
                        </label>

                        <select name="sede_id"
                                id="select_sede"
                                style="width:100%; padding:11px 14px; border-radius:12px; border:1.5px solid var(--border); font-size:13.5px; color: var(--ink); background:white;">

                            <option value="" selected disabled>
                                Seleccionar sede...
                            </option>

                            @foreach($sedes as $sede)
                                <option value="{{ $sede->id }}">
                                    {{ $sede->nombre }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div style="margin-bottom:20px;">
                        <label style="display:block; font-size:12px; font-weight:800; color: var(--slate); margin-bottom:8px; text-transform:uppercase;">
                            Rol en el programa
                        </label>

                        <select name="rol" required
                            style="width:100%; padding:11px 14px; border-radius:12px; border:1.5px solid var(--border);">

                            <option value="destinatario">Destinatario</option>

                            @if($edad >= 18 && $edad <= 25)
                                <option value="tutor">Tutor</option>
                            @endif

                        </select>
                    
                        <div style="margin-bottom:12px;">
                            <label style="display:block; font-size:12px; font-weight:800; color: var(--slate); margin-bottom:6px;">
                                Fecha inicio
                            </label>
                            <input type="date" name="fecha_inicio"
                                value="{{ now()->format('Y-m-d') }}"
                                style="width:100%; padding:10px; border-radius:10px; border:1px solid var(--border);">
                        </div>

                   
                        <div style="margin-bottom:12px;">
                            <label style="display:block; font-size:12px; font-weight:800; color: var(--slate); margin-bottom:6px;">
                                Fecha fin
                            </label>
                            <input type="date" name="fecha_fin"
                                style="width:100%; padding:10px; border-radius:10px; border:1px solid var(--border);">
                        </div>
                    </div>
                </div>

                <div style="margin-top: 20px; padding: 15px; background: var(--blue-lt); border-radius: 12px; border: 1px solid var(--blue-brd);">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                        <input type="checkbox" name="en_adaptacion" id="check_adaptacion" value="1" 
                            style="width: 18px; height: 18px; cursor: pointer;">
                        <label for="check_adaptacion" style="font-size: 13px; font-weight: 700; color: var(--blue-dk); cursor: pointer; margin: 0;">
                            ¿Requiere periodo de adaptación?
                        </label>
                    </div>

                    <div id="wrapper_fecha_adaptacion" style="display: none; animation: fadeUp .3s ease;">
                        <label style="display:block; font-size:12px; font-weight:800; color: var(--slate); margin-bottom:6px; text-transform:uppercase;">
                            Fecha límite de adaptación
                        </label>
                        <input type="date" name="fecha_limite_adaptacion" id="input_fecha_adaptacion"
                            style="width:100%; padding:10px; border-radius:10px; border:1.5px solid var(--blue-brd); font-family: var(--sans);">
                        <small style="display:block; margin-top:5px; color: var(--slate); font-size: 11px; line-height: 1.3;">
                            <i class="bi bi-info-circle"></i> Al finalizar esta fecha, si no se cancela, la persona ingresará al programa automáticamente.
                        </small>
                    </div>
                </div>

                <input type="hidden" name="persona_id" value="{{ $persona->id }}">

                <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
                    <button type="button"
                            onclick="document.getElementById('modalPrograma').style.display='none'"
                            class="sp-btn-ghost">
                        Cancelar
                    </button>
                    <button type="submit" class="sp-btn-primary">
                        <i class="bi bi-check-lg"></i> Asignar programa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalEditarPrograma"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1050; align-items:center; justify-content:center;">

    <div style="background:white; padding:20px; border-radius:12px; width:300px;">

        <h4>Editar fechas</h4>

        <form id="formEditarPrograma" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" id="edit_id">

            <div style="margin-bottom:10px;">
                <label>Fecha inicio</label>
                <input type="date" name="fecha_inicio" id="edit_inicio" class="form-control">
            </div>

            <div style="margin-bottom:10px;">
                <label>Fecha fin</label>
                <input type="date" name="fecha_fin" id="edit_fin" class="form-control">
            </div>

            <button type="submit" class="sp-btn-primary">Guardar</button>
            <button type="button"
                    onclick="cerrarModalEditar()"
                    class="sp-btn-ghost">Cancelar</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const programaSelect = document.querySelector('select[name="programa_id"]');
    const rolSelect = document.querySelector('select[name="rol"]');

    programaSelect.addEventListener('change', function () {
        const texto = this.options[this.selectedIndex].text;

    
        if (texto !== 'Envion') {
            [...rolSelect.options].forEach(o => {
                if (o.value === 'tutor') o.style.display = 'none';
            });
            rolSelect.value = 'destinatario';
        } else {
            [...rolSelect.options].forEach(o => o.style.display = 'block');
        }
    });

});
</script>

<script>
function toggleEdit(section) {
    const views = document.querySelectorAll('.view-' + section);
    const edits = document.querySelectorAll('.edit-' + section);

    const isEditing = edits[0].style.display === 'inline-block';

    if (isEditing) {
        views.forEach(e => e.style.display = 'inline');
        edits.forEach(e => e.style.display = 'none');
    } else {
        views.forEach(e => e.style.display = 'none');
        edits.forEach(e => e.style.display = 'inline-block');
    }
}
</script>

<script>
function togglePrograma(id) {
    const div = document.getElementById('prog-' + id);
    const icon = document.getElementById('icon-' + id);

    if (div.style.display === 'none') {
        div.style.display = 'block';
        icon.classList.remove('bi-chevron-down');
        icon.classList.add('bi-chevron-up');
    } else {
        div.style.display = 'none';
        icon.classList.remove('bi-chevron-up');
        icon.classList.add('bi-chevron-down');
    }
}
</script>

<script>
function abrirModalEditar(id, inicio, fin) {
    document.getElementById('modalEditarPrograma').style.display = 'flex';

    document.getElementById('edit_id').value = id;
    document.getElementById('edit_inicio').value = inicio;
    document.getElementById('edit_fin').value = fin;

    document.getElementById('formEditarPrograma').action = '/persona-programa/' + id;
}

function cerrarModalEditar() {
    document.getElementById('modalEditarPrograma').style.display = 'none';
}
</script>
<script>
function copiarCodigo() {
    const codigo = document.getElementById('codigo-familia').innerText.trim();
    navigator.clipboard.writeText(codigo).then(() => {
        const icon = document.getElementById('icon-copiar');
        icon.className = 'bi bi-clipboard-check';
        icon.style.color = 'var(--teal-dk)';
        setTimeout(() => {
            icon.className = 'bi bi-clipboard';
            icon.style.color = '';
        }, 2000);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const checkAdaptacion = document.getElementById('check_adaptacion');
    const wrapperFecha = document.getElementById('wrapper_fecha_adaptacion');
    const inputFecha = document.getElementById('input_fecha_adaptacion');

    checkAdaptacion.addEventListener('change', function() {
        if (this.checked) {
            wrapperFecha.style.display = 'block';
            inputFecha.required = true;
        } else {
            wrapperFecha.style.display = 'none';
            inputFecha.required = false;
            inputFecha.value = '';
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const programaSelect = document.getElementById('programa_select');
    const sedeWrapper = document.getElementById('wrapper_sede');
    const sedeSelect = document.getElementById('select_sede');

    function toggleSede() {

        const texto =
            programaSelect.options[programaSelect.selectedIndex]?.text?.trim();

        if (texto === 'Multiespacio') {

            sedeWrapper.style.display = 'none';
            sedeSelect.value = '';

        } else {

            sedeWrapper.style.display = 'block';

        }
    }

    programaSelect.addEventListener('change', toggleSede);

    toggleSede();
});
</script>

<script>
function toggleAdjuntos(id) {
    const panel = document.getElementById('adjuntos-' + id);
    panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
}
</script>


<script>
// Cerrar modal trabajo con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const m = document.getElementById('modalNuevoTrabajo');
        if (m) m.style.display = 'none';
    }
});
</script>

@endsection