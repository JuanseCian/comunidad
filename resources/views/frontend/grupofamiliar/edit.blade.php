@extends('frontend.layout.front')

@section('title', 'Editar integrante — ' . $integrante->nombre)

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --blue:      #0d92c2;
        --blue-dk:   #0879a8;
        --blue-lt:   #e6f5fb;
        --blue-brd:  #b3e0f5;
        --teal:      #17a385;
        --teal-lt:   #e8f9f5;
        --teal-brd:  #9fe1cb;
        --teal-dk:   #0e8a70;
        --slate:     #536070;
        --ink:       #0f172a;
        --muted:     #94a3b4;
        --border:    #e0ddd6;
        --border-sm: #f0ede8;
        --bg:        #f8fafe;
        --white:     #ffffff;
        --amber:     #d97706;
        --amber-lt:  #fef9ee;
        --amber-brd: #fcd98a;
        --red:       #dc2626;
        --red-lt:    #fef2f2;
        --red-brd:   #fecaca;
        --radius:    16px;
        --sans:      'Plus Jakarta Sans', system-ui, sans-serif;
        --shadow-sm: 0 2px 12px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 20px rgba(13,146,194,0.10);
    }

    .sp-page { font-family: var(--sans); color: var(--ink); }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .sp-anim   { animation: fadeUp .35s ease both; }
    .sp-anim-1 { animation-delay: .00s; }
    .sp-anim-2 { animation-delay: .05s; }
    .sp-anim-3 { animation-delay: .10s; }
    .sp-anim-4 { animation-delay: .15s; }
    .sp-anim-5 { animation-delay: .20s; }

    /* Breadcrumb */
    .sp-breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; color: var(--muted);
        margin-bottom: 1.5rem; flex-wrap: wrap;
    }
    .sp-breadcrumb a { color: var(--muted); text-decoration: none; transition: color .15s; }
    .sp-breadcrumb a:hover { color: var(--blue); }
    .sp-breadcrumb span { opacity: .5; }

    /* Botones */
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

    /* Card */
    .sp-card {
        background: var(--white); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .sp-card-header {
        padding: 14px 22px 13px; border-bottom: 1px solid var(--border-sm);
        display: flex; align-items: center; gap: 10px;
        background: var(--bg);
    }
    .sp-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
    .sp-card-title {
        font-size: 11px; font-weight: 800; color: var(--slate);
        text-transform: uppercase; letter-spacing: .07em; margin: 0;
    }
    .sp-card-body { padding: 22px 24px; }

    /* Form */
    .sp-field-group { display: flex; flex-direction: column; gap: 5px; }
    .sp-label {
        font-size: 11px; font-weight: 700; color: var(--slate);
        text-transform: uppercase; letter-spacing: .08em;
    }
    .sp-label .req { color: var(--red); margin-left: 2px; }
    .sp-input, .sp-select, .sp-textarea {
        width: 100%; height: 40px; padding: 0 12px;
        border: 1px solid var(--border); border-radius: 10px;
        font-size: 14px; font-family: var(--sans); color: var(--ink);
        background: white; transition: border-color .15s, box-shadow .15s;
        -webkit-appearance: none;
    }
    .sp-textarea { height: auto; padding: 10px 12px; resize: vertical; }
    .sp-input:focus, .sp-select:focus, .sp-textarea:focus {
        outline: none; border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(13,146,194,.12);
    }
    .sp-input::placeholder, .sp-textarea::placeholder { color: var(--muted); }
    .sp-select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b4' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }

    /* Section divider */
    .sp-section-title {
        font-size: 10.5px; font-weight: 800; color: var(--slate);
        text-transform: uppercase; letter-spacing: .08em;
        padding-bottom: 10px; border-bottom: 1px solid var(--border-sm);
        margin-bottom: 16px; display: flex; align-items: center; gap: 8px;
    }
    .sp-section-title i { color: var(--blue); font-size: 13px; }

    /* Toggle checkbox */
    .sp-toggle-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 14px; border: 1px solid var(--border);
        border-radius: 10px; background: var(--bg); cursor: pointer;
        transition: border-color .15s, background .15s;
    }
    .sp-toggle-row:hover { border-color: var(--blue-brd); background: var(--blue-lt); }
    .sp-toggle-row input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--blue); cursor: pointer; }
    .sp-toggle-label { font-size: 13.5px; font-weight: 600; color: var(--ink); }
    .sp-toggle-sub   { font-size: 11.5px; color: var(--muted); margin-top: 1px; }

    /* Error / alert */
    .sp-alert-error {
        display: flex; align-items: flex-start; gap: 10px;
        background: var(--red-lt); border: 1px solid var(--red-brd); color: var(--red);
        padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 600;
        margin-bottom: 1.25rem;
    }
    .sp-field-error { font-size: 11.5px; color: var(--red); font-weight: 600; margin-top: 3px; }

    /* Avatar badge */
    .sp-avatar-sm {
        width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, var(--blue), var(--teal));
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: .9rem; color: white;
        box-shadow: 0 3px 10px rgba(13,146,194,.28);
    }

    /* Conditional fields */
    .sp-conditional { display: none; }
    .sp-conditional.visible { display: contents; }
</style>

<div class="sp-page">

    {{-- Hero --}}
    <section style="background:linear-gradient(135deg, var(--blue-lt) 0%, var(--teal-lt) 100%); border-bottom:1px solid #d0eee7; padding:2rem 0 1.75rem;">
        <div class="container">
            {{-- Breadcrumb --}}
            <nav class="sp-breadcrumb sp-anim sp-anim-1">
                <a href="{{ route('personas.index') }}">Personas</a>
                <span>/</span>
                <a href="{{ route('personas.show', $persona) }}">{{ $persona->apellido }}, {{ $persona->nombre }}</a>
                <span>/</span>
                <strong style="color:var(--ink);">Editar integrante</strong>
            </nav>

            {{-- Título --}}
            <div class="sp-anim sp-anim-2" style="display:flex; align-items:center; gap:14px;">
                <div class="sp-avatar-sm">
                    {{ strtoupper(substr($integrante->nombre, 0, 1)) }}
                </div>
                <div>
                    <h1 style="font-size:clamp(1.2rem,3vw,1.55rem); font-weight:800; color:var(--ink); margin:0 0 4px;">
                        {{ $integrante->nombre }}
                    </h1>
                    <div style="font-size:12.5px; color:var(--slate); font-weight:600;">
                        <i class="bi bi-people-fill" style="color:var(--blue); margin-right:5px;"></i>
                        Grupo familiar de {{ $persona->nombre }} {{ $persona->apellido }}
                        @if($integrante->relacion_titular)
                            &nbsp;·&nbsp; <span style="color:var(--teal-dk);">{{ $integrante->relacion_titular }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container" style="padding-top:2rem; padding-bottom:3rem;">

        {{-- Errores globales --}}
        @if($errors->any())
            <div class="sp-alert-error sp-anim sp-anim-1">
                <i class="bi bi-exclamation-circle-fill" style="font-size:16px; margin-top:1px; flex-shrink:0;"></i>
                <div>
                    <div style="margin-bottom:4px;">Por favor corregí los siguientes errores:</div>
                    <ul style="margin:0; padding-left:16px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('grupo-familiar.update', $integrante) }}">
            @csrf
            @method('PUT')

            <div style="display:flex; flex-direction:column; gap:1.25rem;">

                {{-- ── DATOS PERSONALES ── --}}
                <div class="sp-card sp-anim sp-anim-2">
                    <div class="sp-card-header">
                        <div class="sp-dot" style="background:var(--blue);"></div>
                        <span class="sp-card-title"><i class="bi bi-person-fill" style="color:var(--blue);"></i> Datos personales</span>
                    </div>
                    <div class="sp-card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="sp-field-group">
                                    <label class="sp-label">Nombre completo <span class="req">*</span></label>
                                    <input type="text" name="nombre" class="sp-input"
                                           value="{{ old('nombre', $integrante->nombre) }}"
                                           placeholder="Apellido y nombre" required>
                                    @error('nombre')<div class="sp-field-error">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="sp-field-group">
                                    <label class="sp-label">Sexo</label>
                                    <select name="sexo_id" class="sp-select">
                                        <option value="">— Seleccionar —</option>
                                        @foreach($catalogos['sexos'] as $s)
                                            <option value="{{ $s->id }}" {{ old('sexo_id', $integrante->sexo_id) == $s->id ? 'selected' : '' }}>{{ $s->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="sp-field-group">
                                    <label class="sp-label">Estado civil</label>
                                    <select name="estado_civil_id" class="sp-select">
                                        <option value="">— Seleccionar —</option>
                                        @foreach($catalogos['estados_civiles'] as $e)
                                            <option value="{{ $e->id }}" {{ old('estado_civil_id', $integrante->estado_civil_id) == $e->id ? 'selected' : '' }}>{{ $e->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="sp-field-group">
                                    <label class="sp-label">Relación con el titular</label>
                                    <input type="text" name="relacion_titular" class="sp-input"
                                           value="{{ old('relacion_titular', $integrante->relacion_titular) }}"
                                           placeholder="Ej: Hijo/a, Cónyuge...">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="sp-field-group">
                                    <label class="sp-label">Tipo de documento</label>
                                    <select name="documento_id" class="sp-select">
                                        <option value="">— Seleccionar —</option>
                                        @foreach($catalogos['tipos_documento'] as $td)
                                            <option value="{{ $td->id }}" {{ old('documento_id', $integrante->documento_id) == $td->id ? 'selected' : '' }}>{{ $td->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="sp-field-group">
                                    <label class="sp-label">N° de documento</label>
                                    <input type="text" name="numero_documento" class="sp-input"
                                           value="{{ old('numero_documento', $integrante->numero_documento) }}"
                                           placeholder="Ej: 12345678">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="sp-field-group">
                                    <label class="sp-label">Fecha de nacimiento</label>
                                    <input type="date" name="fecha_nacimiento" class="sp-input"
                                           value="{{ old('fecha_nacimiento', $integrante->fecha_nacimiento?->format('Y-m-d')) }}">
                                    @error('fecha_nacimiento')<div class="sp-field-error">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="sp-field-group">
                                    <label class="sp-label">Dirección</label>
                                    <input type="text" name="direccion" class="sp-input"
                                           value="{{ old('direccion', $integrante->direccion) }}"
                                           placeholder="Calle, número, piso, dpto...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── COBERTURA Y SITUACIÓN LABORAL ── --}}
                <div class="sp-card sp-anim sp-anim-3">
                    <div class="sp-card-header">
                        <div class="sp-dot" style="background:var(--teal);"></div>
                        <span class="sp-card-title"><i class="bi bi-briefcase-fill" style="color:var(--teal);"></i> Cobertura y situación laboral</span>
                    </div>
                    <div class="sp-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="sp-field-group">
                                    <label class="sp-label">Cobertura médica</label>
                                    <select name="cobertura_id" class="sp-select">
                                        <option value="">— Sin cobertura —</option>
                                        @foreach($catalogos['coberturas'] as $c)
                                            <option value="{{ $c->id }}" {{ old('cobertura_id', $integrante->cobertura_id) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="sp-field-group">
                                    <label class="sp-label">Situación ocupacional</label>
                                    <select name="situacion_ocupacional_id" id="sel_situacion" class="sp-select"
                                            onchange="toggleCondicionInactividad()">
                                        <option value="">— Seleccionar —</option>
                                        @foreach($catalogos['situaciones_ocupacional'] as $s)
                                            <option value="{{ $s->id }}" {{ old('situacion_ocupacional_id', $integrante->situacion_ocupacional_id) == $s->id ? 'selected' : '' }}>{{ $s->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6" id="wrap_condicion_inactividad" style="display:none;">
                                <div class="sp-field-group">
                                    <label class="sp-label">Condición de inactividad</label>
                                    <select name="condicion_inactividad_id" class="sp-select">
                                        <option value="">— Seleccionar —</option>
                                        @foreach($catalogos['condiciones_inactividad'] as $ci)
                                            <option value="{{ $ci->id }}" {{ old('condicion_inactividad_id', $integrante->condicion_inactividad_id) == $ci->id ? 'selected' : '' }}>{{ $ci->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="sp-field-group">
                                    <label class="sp-label">Categoría ocupacional</label>
                                    <select name="categoria_ocupacional_id" class="sp-select">
                                        <option value="">— Seleccionar —</option>
                                        @foreach($catalogos['categorias_ocupacional'] as $co)
                                            <option value="{{ $co->id }}" {{ old('categoria_ocupacional_id', $integrante->categoria_ocupacional_id) == $co->id ? 'selected' : '' }}>{{ $co->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="sp-field-group">
                                    <label class="sp-label">Ingresos mensuales ($)</label>
                                    <input type="number" name="ingresos" class="sp-input" min="0" step="1"
                                           value="{{ old('ingresos', $integrante->ingresos) }}"
                                           placeholder="0">
                                    @error('ingresos')<div class="sp-field-error">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── SALUD ── --}}
                <div class="sp-card sp-anim sp-anim-4">
                    <div class="sp-card-header">
                        <div class="sp-dot" style="background:var(--amber);"></div>
                        <span class="sp-card-title"><i class="bi bi-heart-pulse-fill" style="color:var(--amber);"></i> Salud</span>
                    </div>
                    <div class="sp-card-body">
                        <div class="row g-3">

                            {{-- Discapacidad --}}
                            <div class="col-12">
                                <div class="sp-section-title"><i class="bi bi-accessibility"></i> Discapacidad</div>
                            </div>

                            <div class="col-md-6">
                                <label class="sp-toggle-row" for="check_discapacidad">
                                    <div>
                                        <div class="sp-toggle-label">Discapacidad permanente</div>
                                        <div class="sp-toggle-sub">¿Tiene certificado de discapacidad?</div>
                                    </div>
                                    <input type="checkbox" id="check_discapacidad" name="discapacidad_permanente" value="1"
                                           onchange="toggleDiscapacidad()"
                                           {{ old('discapacidad_permanente', $integrante->discapacidad_permanente) ? 'checked' : '' }}>
                                </label>
                            </div>

                            <div class="col-md-6" id="wrap_discapacidad_tratamiento">
                                <label class="sp-toggle-row" for="check_disc_trat">
                                    <div>
                                        <div class="sp-toggle-label">En tratamiento</div>
                                        <div class="sp-toggle-sub">¿Recibe atención por discapacidad?</div>
                                    </div>
                                    <input type="checkbox" id="check_disc_trat" name="discapacidad_tratamiento" value="1"
                                           {{ old('discapacidad_tratamiento', $integrante->discapacidad_tratamiento) ? 'checked' : '' }}>
                                </label>
                            </div>

                            <div class="col-md-6" id="wrap_discapacidad_tipo">
                                <div class="sp-field-group">
                                    <label class="sp-label">Tipo de discapacidad</label>
                                    <select name="discapacidad_id" class="sp-select">
                                        <option value="">— Seleccionar —</option>
                                        @foreach($catalogos['discapacidades'] as $d)
                                            <option value="{{ $d->id }}" {{ old('discapacidad_id', $integrante->discapacidad_id) == $d->id ? 'selected' : '' }}>{{ $d->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6" id="wrap_caratula">
                                <div class="sp-field-group">
                                    <label class="sp-label">Carátula / N° de expediente</label>
                                    <input type="text" name="caratula" class="sp-input"
                                           value="{{ old('caratula', $integrante->caratula) }}"
                                           placeholder="Ej: EXP-2024-00123">
                                </div>
                            </div>

                            {{-- Enfermedad --}}
                            <div class="col-12" style="margin-top:4px;">
                                <div class="sp-section-title"><i class="bi bi-capsule"></i> Enfermedad crónica</div>
                            </div>

                            <div class="col-md-6">
                                <div class="sp-field-group">
                                    <label class="sp-label">Enfermedad</label>
                                    <select name="enfermedad_id" class="sp-select">
                                        <option value="">— Sin diagnóstico —</option>
                                        @foreach($catalogos['enfermedades'] as $en)
                                            <option value="{{ $en->id }}" {{ old('enfermedad_id', $integrante->enfermedad_id) == $en->id ? 'selected' : '' }}>{{ $en->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="sp-toggle-row" for="check_enf_trat">
                                    <div>
                                        <div class="sp-toggle-label">En tratamiento</div>
                                        <div class="sp-toggle-sub">¿Recibe tratamiento por enfermedad?</div>
                                    </div>
                                    <input type="checkbox" id="check_enf_trat" name="enfermedad_tratamiento" value="1"
                                           {{ old('enfermedad_tratamiento', $integrante->enfermedad_tratamiento) ? 'checked' : '' }}>
                                </label>
                            </div>

                            {{-- Embarazo --}}
                            <div class="col-12" style="margin-top:4px;">
                                <div class="sp-section-title"><i class="bi bi-gender-female"></i> Embarazo y vacunación</div>
                            </div>

                            <div class="col-md-4">
                                <label class="sp-toggle-row" for="check_embarazo">
                                    <div>
                                        <div class="sp-toggle-label">Embarazo actual</div>
                                    </div>
                                    <input type="checkbox" id="check_embarazo" name="embarazo" value="1"
                                           {{ old('embarazo', $integrante->embarazo) ? 'checked' : '' }}>
                                </label>
                            </div>

                            <div class="col-md-4">
                                <label class="sp-toggle-row" for="check_control">
                                    <div>
                                        <div class="sp-toggle-label">Control de embarazo</div>
                                    </div>
                                    <input type="checkbox" id="check_control" name="control_embarazo" value="1"
                                           {{ old('control_embarazo', $integrante->control_embarazo) ? 'checked' : '' }}>
                                </label>
                            </div>

                            <div class="col-md-4">
                                <label class="sp-toggle-row" for="check_vacunacion">
                                    <div>
                                        <div class="sp-toggle-label">Esquema de vacunación</div>
                                        <div class="sp-toggle-sub">¿Al día?</div>
                                    </div>
                                    <input type="checkbox" id="check_vacunacion" name="esquema_vacunacion" value="1"
                                           {{ old('esquema_vacunacion', $integrante->esquema_vacunacion) ? 'checked' : '' }}>
                                </label>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── ACCIONES ── --}}
                <div class="sp-anim sp-anim-5" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; padding-bottom:1rem;">
                    <a href="{{ route('personas.show', $persona) }}" class="sp-btn-ghost">
                        <i class="bi bi-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="sp-btn-primary" style="height:44px; font-size:14px; padding:0 24px;">
                        <i class="bi bi-check-circle-fill"></i> Guardar cambios
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
function toggleDiscapacidad() {
    const checked = document.getElementById('check_discapacidad').checked;
    const ids = ['wrap_discapacidad_tratamiento', 'wrap_discapacidad_tipo', 'wrap_caratula'];
    ids.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = checked ? '' : 'none';
    });
}

function toggleCondicionInactividad() {
    const sel = document.getElementById('sel_situacion');
    const texto = sel.options[sel.selectedIndex]?.text?.toLowerCase() ?? '';
    const inactivo = texto.includes('inactiv') || texto.includes('desocup') || texto.includes('sin trabajo');
    const wrap = document.getElementById('wrap_condicion_inactividad');
    if (wrap) wrap.style.display = inactivo ? '' : 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    toggleDiscapacidad();
    toggleCondicionInactividad();
});
</script>

@endsection
