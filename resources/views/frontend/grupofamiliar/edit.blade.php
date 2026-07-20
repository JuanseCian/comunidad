@extends('frontend.layout.front')

@section('title', 'Editar integrante — ' . $integrante->nombre)

@section('content')

<div style="background: linear-gradient(135deg, #e6f5fb 0%, #e8f9f5 100%); border-bottom: 1px solid #d0eee7; padding: 2rem 0 1.5rem;">
    <div class="container">
        <p style="font-size:12px; font-weight:700; color:#0879a8; text-transform:uppercase; letter-spacing:1.2px; margin-bottom:4px;">
            <a href="{{ route('dashboard') }}" style="color:#0879a8; text-decoration:none;">Inicio</a>
            <span style="opacity:.4; margin:0 6px;">/</span>
            <a href="{{ route('personas.show', $persona) }}" style="color:#0879a8; text-decoration:none;">{{ $persona->apellido }}, {{ $persona->nombre }}</a>
            <span style="opacity:.4; margin:0 6px;">/</span>
            Editar integrante
        </p>
        <h1 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:clamp(1.4rem,3vw,2rem); color:#0f172a; margin:0 0 10px; line-height:1.2;">
            Editar integrante
        </h1>
        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            <div style="display:inline-flex; align-items:center; gap:8px; background:white; border:1px solid #b3e0f5; color:#0879a8; border-radius:20px; padding:5px 14px; font-size:12.5px; font-weight:700;">
                <i class="bi bi-person-fill" style="font-size:12px;"></i>
                {{ $integrante->nombre }}
            </div>
            <div style="display:inline-flex; align-items:center; gap:8px; background:white; border:1px solid #9fe1cb; color:#0e8a70; border-radius:20px; padding:5px 14px; font-size:12.5px; font-weight:700;">
                <i class="bi bi-people-fill" style="font-size:12px;"></i>
                Titular: {{ $persona->apellido }}, {{ $persona->nombre }}
                @if($integrante->relacion_titular)
                    <span style="opacity:.5; font-weight:400;">· {{ $integrante->relacion_titular }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
<div style="max-width:780px; margin:0 auto;">

    @if ($errors->any())
        <div style="background:#fff5f5; border:1px solid #fca5a5; border-radius:12px; padding:13px 18px; margin-bottom:1.25rem; color:#b91c1c; font-size:13.5px;">
            <div style="display:flex; align-items:center; gap:8px; font-weight:700; margin-bottom:6px;">
                <i class="bi bi-exclamation-circle-fill"></i> Corregí los siguientes errores:
            </div>
            <ul style="margin:0; padding-left:1.4rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('grupo-familiar.update', $integrante) }}" novalidate>
    @csrf
    @method('PUT')

    {{-- 1. DATOS PERSONALES --}}
    <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; margin-bottom:1.25rem; overflow:hidden;">
        <div style="padding:14px 22px 12px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; gap:12px;">
            <div style="width:26px; height:26px; border-radius:50%; background:linear-gradient(135deg,#0d92c2,#1aaad8); display:flex; align-items:center; justify-content:center; color:white; font-size:11px; font-weight:800; flex-shrink:0;">1</div>
            <span style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:14px; color:#0f172a;">Datos personales</span>
            <span style="font-size:12px; color:#94a3b4; margin-left:auto;">Información básica del integrante</span>
        </div>
        <div style="padding:22px;">
            <div class="row g-3">

                <div class="col-12">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Nombre completo <span style="color:#e53e3e;">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre', $integrante->nombre) }}"
                           placeholder="Nombre y apellido del integrante"
                           class="{{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid {{ $errors->has('nombre') ? '#fca5a5' : '#c8c4bb' }}; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='{{ $errors->has('nombre') ? '#fca5a5' : '#c8c4bb' }}'; this.style.boxShadow='none'">
                    @error('nombre')<span style="font-size:11.5px; color:#b91c1c;">{{ $message }}</span>@enderror
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Tipo de documento</label>
                    <select name="documento_id" class="{{ $errors->has('documento_id') ? 'is-invalid' : '' }}"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($catalogos['tipos_documento'] as $td)
                            <option value="{{ $td->id }}" {{ old('documento_id', $integrante->documento_id) == $td->id ? 'selected' : '' }}>{{ $td->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Número de documento</label>
                    <input type="text" name="numero_documento" value="{{ old('numero_documento', $integrante->numero_documento) }}"
                           placeholder="Ej: 30123456"
                           class="{{ $errors->has('numero_documento') ? 'is-invalid' : '' }}"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                    @error('numero_documento')<span style="font-size:11.5px; color:#b91c1c;">{{ $message }}</span>@enderror
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Sexo</label>
                    <select name="sexo_id" class="{{ $errors->has('sexo_id') ? 'is-invalid' : '' }}"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($catalogos['sexos'] as $s)
                            <option value="{{ $s->id }}" {{ old('sexo_id', $integrante->sexo_id) == $s->id ? 'selected' : '' }}>{{ $s->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $integrante->fecha_nacimiento?->format('Y-m-d')) }}"
                           class="{{ $errors->has('fecha_nacimiento') ? 'is-invalid' : '' }}"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                    @error('fecha_nacimiento')<span style="font-size:11.5px; color:#b91c1c;">{{ $message }}</span>@enderror
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Relación con el titular</label>
                    <input type="text" name="relacion_titular" value="{{ old('relacion_titular', $integrante->relacion_titular) }}"
                           placeholder="Ej: Hijo/a, Cónyuge/Pareja..."
                           class="{{ $errors->has('relacion_titular') ? 'is-invalid' : '' }}"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Estado civil</label>
                    <select name="estado_civil_id" class="{{ $errors->has('estado_civil_id') ? 'is-invalid' : '' }}"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($catalogos['estados_civiles'] as $ec)
                            <option value="{{ $ec->id }}" {{ old('estado_civil_id', $integrante->estado_civil_id) == $ec->id ? 'selected' : '' }}>{{ $ec->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Nivel de estudio</label>
                    <select name="nivel_estudio_id" class="{{ $errors->has('nivel_estudio_id') ? 'is-invalid' : '' }}"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($catalogos['niveles_estudio'] as $nivel)
                            <option value="{{ $nivel->id }}" {{ old('nivel_estudio_id', $integrante->nivel_estudio_id) == $nivel->id ? 'selected' : '' }}>{{ $nivel->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion', $integrante->direccion) }}"
                           placeholder="Calle, número, piso, dpto..."
                           class="{{ $errors->has('direccion') ? 'is-invalid' : '' }}"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>

            </div>
        </div>
    </div>

    {{-- 2. SALUD --}}
    <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; margin-bottom:1.25rem; overflow:hidden;">
        <div style="padding:14px 22px 12px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; gap:12px;">
            <div style="width:26px; height:26px; border-radius:50%; background:linear-gradient(135deg,#0d92c2,#1aaad8); display:flex; align-items:center; justify-content:center; color:white; font-size:11px; font-weight:800; flex-shrink:0;">2</div>
            <span style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:14px; color:#0f172a;">Salud</span>
            <span style="font-size:12px; color:#94a3b4; margin-left:auto;">Cobertura, discapacidad y enfermedades</span>
        </div>
        <div style="padding:22px;">

            <div style="margin-bottom:18px;">
                <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Cobertura médica</label>
                <select name="cobertura_id" class="{{ $errors->has('cobertura_id') ? 'is-invalid' : '' }}"
                        style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                        onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                    <option value="">— Sin cobertura / No especificada —</option>
                    @foreach($catalogos['coberturas'] as $c)
                        <option value="{{ $c->id }}" {{ old('cobertura_id', $integrante->cobertura_id) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div style="height:1px; background:#e0ddd6; margin-bottom:18px;"></div>

            <div style="display:flex; flex-direction:column; gap:0;">

                {{-- Discapacidad --}}
                <div style="display:flex; align-items:center; justify-content:space-between; padding:13px 0; border-bottom:1px solid #f0ede8;">
                    <div>
                        <div style="font-size:14px; color:#0f172a; font-weight:500;">Tiene discapacidad permanente</div>
                        <div style="font-size:11.5px; color:#94a3b4; margin-top:2px; font-style:italic;">Activá para completar el tipo y tratamiento</div>
                    </div>
                    <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                        <input type="checkbox" name="discapacidad_permanente" value="1" id="chk-discapacidad"
                               {{ old('discapacidad_permanente', $integrante->discapacidad_permanente) ? 'checked' : '' }}
                               style="opacity:0; width:0; height:0; position:absolute;">
                        <span class="toggle-slider" style="position:absolute; inset:0; background:{{ old('discapacidad_permanente', $integrante->discapacidad_permanente) ? '#0d92c2' : '#c8c4bb' }}; border-radius:24px; transition:background .2s;">
                            <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block; transform:{{ old('discapacidad_permanente', $integrante->discapacidad_permanente) ? 'translateX(18px)' : 'translateX(0)' }};"></span>
                        </span>
                    </label>
                </div>
                <div class="cond-block {{ old('discapacidad_permanente', $integrante->discapacidad_permanente) ? 'visible' : '' }}" id="blk-discapacidad"
                     style="display:{{ old('discapacidad_permanente', $integrante->discapacidad_permanente) ? 'block' : 'none' }}; margin:0; padding:16px; background:#f8fafe; border-radius:10px; border:1px solid #e0ddd6; margin-top:8px; margin-bottom:8px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Tipo de discapacidad</label>
                            <select name="discapacidad_id"
                                    style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                                    onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                                <option value="">— Seleccionar —</option>
                                @foreach($catalogos['discapacidades'] as $d)
                                    <option value="{{ $d->id }}" {{ old('discapacidad_id', $integrante->discapacidad_id) == $d->id ? 'selected' : '' }}>{{ $d->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Carátula / expediente</label>
                            <input type="text" name="caratula" value="{{ old('caratula', $integrante->caratula) }}" placeholder="Número o referencia"
                                   style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                                   onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                                   onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 0 0; margin-top:12px; border-top:1px solid #e0ddd6;">
                        <div style="font-size:13.5px; color:#0f172a;">Recibe tratamiento por discapacidad</div>
                        <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                            <input type="checkbox" name="discapacidad_tratamiento" value="1"
                                   {{ old('discapacidad_tratamiento', $integrante->discapacidad_tratamiento) ? 'checked' : '' }}
                                   style="opacity:0; width:0; height:0; position:absolute;">
                            <span class="toggle-slider" style="position:absolute; inset:0; background:{{ old('discapacidad_tratamiento', $integrante->discapacidad_tratamiento) ? '#0d92c2' : '#c8c4bb' }}; border-radius:24px; transition:background .2s;">
                                <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block; transform:{{ old('discapacidad_tratamiento', $integrante->discapacidad_tratamiento) ? 'translateX(18px)' : 'translateX(0)' }};"></span>
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Enfermedad --}}
                <div style="display:flex; align-items:center; justify-content:space-between; padding:13px 0; border-bottom:1px solid #f0ede8;">
                    <div>
                        <div style="font-size:14px; color:#0f172a; font-weight:500;">Tiene enfermedad crónica o relevante</div>
                        <div style="font-size:11.5px; color:#94a3b4; margin-top:2px; font-style:italic;">Activá para seleccionar el tipo y tratamiento</div>
                    </div>
                    <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                        <input type="checkbox" name="_tiene_enfermedad" value="1" id="chk-enfermedad"
                               {{ old('enfermedad_id', $integrante->enfermedad_id) ? 'checked' : '' }}
                               style="opacity:0; width:0; height:0; position:absolute;">
                        <span class="toggle-slider" style="position:absolute; inset:0; background:{{ old('enfermedad_id', $integrante->enfermedad_id) ? '#0d92c2' : '#c8c4bb' }}; border-radius:24px; transition:background .2s;">
                            <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block; transform:{{ old('enfermedad_id', $integrante->enfermedad_id) ? 'translateX(18px)' : 'translateX(0)' }};"></span>
                        </span>
                    </label>
                </div>
                <div class="cond-block {{ old('enfermedad_id', $integrante->enfermedad_id) ? 'visible' : '' }}" id="blk-enfermedad"
                     style="display:{{ old('enfermedad_id', $integrante->enfermedad_id) ? 'block' : 'none' }}; margin:0; padding:16px; background:#f8fafe; border-radius:10px; border:1px solid #e0ddd6; margin-top:8px; margin-bottom:8px;">
                    <div class="row g-3">
                        <div class="col-12">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Tipo de enfermedad</label>
                            <select name="enfermedad_id"
                                    style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                                    onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                                <option value="">— Seleccionar —</option>
                                @foreach($catalogos['enfermedades'] as $e)
                                    <option value="{{ $e->id }}" {{ old('enfermedad_id', $integrante->enfermedad_id) == $e->id ? 'selected' : '' }}>{{ $e->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 0 0; margin-top:12px; border-top:1px solid #e0ddd6;">
                        <div style="font-size:13.5px; color:#0f172a;">Recibe tratamiento por la enfermedad</div>
                        <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                            <input type="checkbox" name="enfermedad_tratamiento" value="1"
                                   {{ old('enfermedad_tratamiento', $integrante->enfermedad_tratamiento) ? 'checked' : '' }}
                                   style="opacity:0; width:0; height:0; position:absolute;">
                            <span class="toggle-slider" style="position:absolute; inset:0; background:{{ old('enfermedad_tratamiento', $integrante->enfermedad_tratamiento) ? '#0d92c2' : '#c8c4bb' }}; border-radius:24px; transition:background .2s;">
                                <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block; transform:{{ old('enfermedad_tratamiento', $integrante->enfermedad_tratamiento) ? 'translateX(18px)' : 'translateX(0)' }};"></span>
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Embarazo --}}
                <div style="display:flex; align-items:center; justify-content:space-between; padding:13px 0; border-bottom:1px solid #f0ede8;">
                    <div>
                        <div style="font-size:14px; color:#0f172a; font-weight:500;">Está embarazada</div>
                        <div style="font-size:11.5px; color:#94a3b4; margin-top:2px; font-style:italic;">Solo aplicar si corresponde</div>
                    </div>
                    <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                        <input type="checkbox" name="embarazo" value="1" id="chk-embarazo"
                               {{ old('embarazo', $integrante->embarazo) ? 'checked' : '' }}
                               style="opacity:0; width:0; height:0; position:absolute;">
                        <span class="toggle-slider" style="position:absolute; inset:0; background:{{ old('embarazo', $integrante->embarazo) ? '#0d92c2' : '#c8c4bb' }}; border-radius:24px; transition:background .2s;">
                            <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block; transform:{{ old('embarazo', $integrante->embarazo) ? 'translateX(18px)' : 'translateX(0)' }};"></span>
                        </span>
                    </label>
                </div>
                <div class="cond-block {{ old('embarazo', $integrante->embarazo) ? 'visible' : '' }}" id="blk-embarazo"
                     style="display:{{ old('embarazo', $integrante->embarazo) ? 'block' : 'none' }}; padding:14px 16px; background:#f8fafe; border-radius:10px; border:1px solid #e0ddd6; margin-top:8px; margin-bottom:8px;">
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <div style="font-size:13.5px; color:#0f172a;">Realiza controles de embarazo</div>
                        <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                            <input type="checkbox" name="control_embarazo" value="1"
                                   {{ old('control_embarazo', $integrante->control_embarazo) ? 'checked' : '' }}
                                   style="opacity:0; width:0; height:0; position:absolute;">
                            <span class="toggle-slider" style="position:absolute; inset:0; background:{{ old('control_embarazo', $integrante->control_embarazo) ? '#0d92c2' : '#c8c4bb' }}; border-radius:24px; transition:background .2s;">
                                <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block; transform:{{ old('control_embarazo', $integrante->control_embarazo) ? 'translateX(18px)' : 'translateX(0)' }};"></span>
                            </span>
                        </label>
                    </div>
                </div>

                {{-- Vacunación --}}
                <div style="display:flex; align-items:center; justify-content:space-between; padding:13px 0;">
                    <div>
                        <div style="font-size:14px; color:#0f172a; font-weight:500;">Esquema de vacunación completo</div>
                        <div style="font-size:11.5px; color:#94a3b4; margin-top:2px; font-style:italic;">Según edad y calendario nacional</div>
                    </div>
                    <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                        <input type="checkbox" name="esquema_vacunacion" value="1"
                               {{ old('esquema_vacunacion', $integrante->esquema_vacunacion) ? 'checked' : '' }}
                               style="opacity:0; width:0; height:0; position:absolute;">
                        <span class="toggle-slider" style="position:absolute; inset:0; background:{{ old('esquema_vacunacion', $integrante->esquema_vacunacion) ? '#0d92c2' : '#c8c4bb' }}; border-radius:24px; transition:background .2s;">
                            <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block; transform:{{ old('esquema_vacunacion', $integrante->esquema_vacunacion) ? 'translateX(18px)' : 'translateX(0)' }};"></span>
                        </span>
                    </label>
                </div>

            </div>
        </div>
    </div>

    {{-- 3. SITUACIÓN LABORAL --}}
    <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; margin-bottom:1.25rem; overflow:hidden;">
        <div style="padding:14px 22px 12px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; gap:12px;">
            <div style="width:26px; height:26px; border-radius:50%; background:linear-gradient(135deg,#0d92c2,#1aaad8); display:flex; align-items:center; justify-content:center; color:white; font-size:11px; font-weight:800; flex-shrink:0;">3</div>
            <span style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:14px; color:#0f172a;">Situación laboral</span>
            <span style="font-size:12px; color:#94a3b4; margin-left:auto;">Ocupación e ingresos</span>
        </div>
        <div style="padding:22px;">
            <div class="row g-3">

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Situación ocupacional</label>
                    <select name="situacion_ocupacional_id" id="sel-situacion"
                            class="{{ $errors->has('situacion_ocupacional_id') ? 'is-invalid' : '' }}"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($catalogos['situaciones_ocupacional'] as $so)
                            <option value="{{ $so->id }}"
                                data-inactivo="{{ preg_match('/inactiv|desocup|sin\s*trabajo/i', $so->nombre) ? '1' : '0' }}"
                                {{ old('situacion_ocupacional_id', $integrante->situacion_ocupacional_id) == $so->id ? 'selected' : '' }}>{{ $so->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6" id="blk-inactividad" style="display:none">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Condición de inactividad</label>
                    <select name="condicion_inactividad_id"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($catalogos['condiciones_inactividad'] as $ci)
                            <option value="{{ $ci->id }}" {{ old('condicion_inactividad_id', $integrante->condicion_inactividad_id) == $ci->id ? 'selected' : '' }}>{{ $ci->nombre }}</option>
                        @endforeach
                    </select>
                    <span style="font-size:11.5px; color:#94a3b4; display:block; margin-top:4px;">Completar si está inactivo.</span>
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Categoría ocupacional</label>
                    <select name="categoria_ocupacional_id"
                            class="{{ $errors->has('categoria_ocupacional_id') ? 'is-invalid' : '' }}"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($catalogos['categorias_ocupacional'] as $co)
                            <option value="{{ $co->id }}" {{ old('categoria_ocupacional_id', $integrante->categoria_ocupacional_id) == $co->id ? 'selected' : '' }}>{{ $co->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Ingresos mensuales (ARS)</label>
                    <input type="number" name="ingresos" value="{{ old('ingresos', $integrante->ingresos) }}"
                           placeholder="0.00" min="0" step="0.01"
                           class="{{ $errors->has('ingresos') ? 'is-invalid' : '' }}"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                    @error('ingresos')<span style="font-size:11.5px; color:#b91c1c;">{{ $message }}</span>@enderror
                </div>

            </div>
        </div>
    </div>

    <div style="display:flex; align-items:center; justify-content:space-between; padding-top:1rem; border-top:1px solid #e0ddd6; margin-top:.5rem;">
        <a href="{{ route('personas.show', $persona) }}"
           style="height:42px; padding:0 20px; background:white; color:#536070; border:1px solid #c8c4bb; border-radius:10px; font-family:inherit; font-size:14px; font-weight:600; display:inline-flex; align-items:center; gap:7px; text-decoration:none; transition:background .15s;"
           onmouseover="this.style.background='#f5f3ee'" onmouseout="this.style.background='white'">
            <i class="bi bi-arrow-left" style="font-size:13px;"></i> Cancelar
        </a>
        <button type="submit"
                style="height:42px; padding:0 28px; background:linear-gradient(135deg,#0d92c2,#1aaad8); color:white; border:none; border-radius:10px; font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:8px; transition:opacity .2s; box-shadow:0 4px 14px rgba(13,146,194,.3);"
                onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
            <i class="bi bi-check-circle-fill"></i> Guardar cambios
        </button>
    </div>

    </form>
</div>
</div>

<script>

[
  ['chk-discapacidad', 'blk-discapacidad'],
  ['chk-enfermedad',   'blk-enfermedad'],
  ['chk-embarazo',     'blk-embarazo'],
].forEach(function([chkId, blkId]) {
  const chk = document.getElementById(chkId);
  const blk = document.getElementById(blkId);
  if (!chk || !blk) return;
  chk.addEventListener('change', function() {
    blk.style.display = chk.checked ? 'block' : 'none';
    const track = chk.closest('label').querySelector('.toggle-slider');
    const thumb = track.querySelector('span');
    track.style.background = chk.checked ? '#0d92c2' : '#c8c4bb';
    thumb.style.transform   = chk.checked ? 'translateX(18px)' : 'translateX(0)';
    if (!chk.checked) {
      blk.querySelectorAll('select').forEach(function(s) { s.value = ''; });
      blk.querySelectorAll('input[type="checkbox"]').forEach(function(c) {
        c.checked = false;
        const t = c.closest('label').querySelector('.toggle-slider');
        const th = t.querySelector('span');
        t.style.background = '#c8c4bb';
        th.style.transform = 'translateX(0)';
      });
    }
  });
});

document.querySelectorAll('input[type="checkbox"]').forEach(function(chk) {
  if (['chk-discapacidad','chk-enfermedad','chk-embarazo'].includes(chk.id)) return;
  chk.addEventListener('change', function() {
    const track = chk.closest('label').querySelector('.toggle-slider');
    if (!track) return;
    const thumb = track.querySelector('span');
    track.style.background = chk.checked ? '#0d92c2' : '#c8c4bb';
    thumb.style.transform   = chk.checked ? 'translateX(18px)' : 'translateX(0)';
  });
});

document.getElementById('sel-situacion').addEventListener('change', function() {
  const opt = this.options[this.selectedIndex];
  const inactivo = opt?.dataset?.inactivo === '1';
  const blk = document.getElementById('blk-inactividad');
  blk.style.display = inactivo ? '' : 'none';
  if (!inactivo) {
    blk.querySelector('select').value = '';
  }
});

// Inicializar al cargar (restaurar estado con old() / valores actuales)
(function() {
  const sel = document.getElementById('sel-situacion');
  if (!sel) return;
  const opt = sel.options[sel.selectedIndex];
  const inactivo = opt?.dataset?.inactivo === '1';
  const blk = document.getElementById('blk-inactividad');
  if (blk) blk.style.display = inactivo ? '' : 'none';
})();

document.querySelector('form').addEventListener('submit', function(e) {
  const nombre = document.querySelector('[name="nombre"]');
  if (!nombre.value.trim()) {
    nombre.style.borderColor = '#fca5a5';
    nombre.scrollIntoView({ behavior: 'smooth', block: 'center' });
    e.preventDefault();
  }
});
</script>

@endsection