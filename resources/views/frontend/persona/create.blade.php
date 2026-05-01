@extends('frontend.layout.front')

@section('title', 'Nueva Persona')

@section('content')


<div style="background: linear-gradient(135deg, #e6f5fb 0%, #e8f9f5 100%); border-bottom: 1px solid #d0eee7; padding: 2rem 0 1.5rem;">
    <div class="container">
        <p style="font-size:12px; font-weight:700; color:#0879a8; text-transform:uppercase; letter-spacing:1.2px; margin-bottom:4px;">
            <a href="{{ route('dashboard') }}" style="color:#0879a8; text-decoration:none;">Inicio</a>
            <span style="opacity:.4; margin:0 6px;">/</span>
            <a href="{{ route('personas.index') }}" style="color:#0879a8; text-decoration:none;">Personas</a>
            <span style="opacity:.4; margin:0 6px;">/</span>
            Nueva persona
        </p>
        <h1 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:clamp(1.4rem,3vw,2rem); color:#0f172a; margin:0 0 4px; line-height:1.2;">
            Nueva Persona
        </h1>
        <p style="color:#536070; font-size:13.5px; font-weight:500; margin:0;">
            Completá los datos del titular para registrarlo en el sistema.
        </p>
    </div>
</div>

<div class="container py-4">
<div style="max-width:760px; margin:0 auto;">

    {{-- ── Alerts ── --}}
    @if(session('success'))
    <div style="background:#e8f9f5; border:1px solid #9fe1cb; border-radius:12px; padding:13px 18px; margin-bottom:1.25rem; color:#0e8a70; font-size:13.5px; font-weight:600; display:flex; align-items:center; gap:10px;">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div style="background:#fff5f5; border:1px solid #fca5a5; border-radius:12px; padding:13px 18px; margin-bottom:1.25rem; color:#b91c1c; font-size:13.5px;">
        <div style="display:flex; align-items:center; gap:8px; font-weight:700; margin-bottom:6px;">
            <i class="bi bi-exclamation-circle-fill"></i> Corregí los siguientes errores:
        </div>
        <ul style="margin:0; padding-left:1.4rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('personas.store') }}">
    @csrf


    <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; margin-bottom:1.25rem; overflow:hidden;">
        <div style="padding:14px 22px 12px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; gap:12px;">
            <div style="width:26px; height:26px; border-radius:50%; background:linear-gradient(135deg,#0d92c2,#1aaad8); display:flex; align-items:center; justify-content:center; color:white; font-size:11px; font-weight:800; flex-shrink:0;">1</div>
            <span style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:14px; color:#0f172a;">Datos personales</span>
            <span style="font-size:12px; color:#94a3b4; margin-left:auto;">Información básica del titular</span>
        </div>
        <div style="padding:22px;">
            <div class="row g-3">

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Tipo de documento</label>
                    <select name="documento_id"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($tipos_doc as $item)
                            <option value="{{ $item->id }}" {{ old('documento_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">DNI <span style="color:#e53e3e;">*</span></label>
                    <input type="text" name="dni" value="{{ old('dni') }}"
                           placeholder="Ej: 30123456"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>
                
                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Apellido <span style="color:#e53e3e;">*</span></label>
                    <input type="text" name="apellido" value="{{ old('apellido') }}"
                           placeholder="Ej: García"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Nombre <span style="color:#e53e3e;">*</span></label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                           placeholder="Ej: María José"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>


                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">CUIL</label>
                    <input type="text" name="cuil" value="{{ old('cuil') }}"
                           placeholder="Ej: 20-30123456-4"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Sexo</label>
                    <select name="sexo_id"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($sexos as $item)
                            <option value="{{ $item->id }}" {{ old('sexo_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Estado civil</label>
                    <select name="estado_civil_id"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($estados_civiles as $item)
                            <option value="{{ $item->id }}" {{ old('estado_civil_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Grupo sanguíneo</label>
                    <select name="grupo_sanguineo"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-','NS/NR'] as $gs)
                            <option value="{{ $gs }}" {{ old('grupo_sanguineo') == $gs ? 'selected' : '' }}>{{ $gs }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Nivel de estudio</label>
                    <select name="nivel_estudio_id"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($niveles as $item)
                            <option value="{{ $item->id }}" {{ old('nivel_estudio_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 16px; background:#f8fffe; border:1px solid #d0eee7; border-radius:10px;">
                        <div>
                            <div style="font-size:14px; font-weight:600; color:#0f172a;">Trabaja actualmente</div>
                            <div style="font-size:12px; color:#536070; margin-top:1px;">Indicar si el titular tiene actividad laboral</div>
                        </div>
                        <label style="position:relative; display:inline-block; width:42px; height:24px; margin:0; cursor:pointer;">
                            <input type="checkbox" name="trabaja" value="1" {{ old('trabaja') ? 'checked' : '' }}
                                   style="opacity:0; width:0; height:0; position:absolute;"
                                   onchange="toggleSlider(this)">
                            <span class="toggle-slider" style="position:absolute; inset:0; background:#c8c4bb; border-radius:24px; transition:background .2s;">
                                <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block;"></span>
                            </span>
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; margin-bottom:1.25rem; overflow:hidden;">
        <div style="padding:14px 22px 12px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; gap:12px;">
            <div style="width:26px; height:26px; border-radius:50%; background:linear-gradient(135deg,#0d92c2,#1aaad8); display:flex; align-items:center; justify-content:center; color:white; font-size:11px; font-weight:800; flex-shrink:0;">2</div>
            <span style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:14px; color:#0f172a;">Contacto</span>
            <span style="font-size:12px; color:#94a3b4; margin-left:auto;">Teléfono y correo electrónico</span>
        </div>
        <div style="padding:22px;">
            <div class="row g-3">

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Teléfono</label>
                    <input type="tel" name="telefono" value="{{ old('telefono') }}"
                           placeholder="Ej: 336 4123456"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>

                <div class="col-md-6">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Correo electrónico</label>
                    <input type="email" name="correo" value="{{ old('correo') }}"
                           placeholder="Ej: nombre@email.com"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>

            </div>
        </div>
    </div>


    <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; margin-bottom:1.25rem; overflow:hidden;">
        <div style="padding:14px 22px 12px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; gap:12px;">
            <div style="width:26px; height:26px; border-radius:50%; background:linear-gradient(135deg,#0d92c2,#1aaad8); display:flex; align-items:center; justify-content:center; color:white; font-size:11px; font-weight:800; flex-shrink:0;">3</div>
            <span style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:14px; color:#0f172a;">Domicilio</span>
            <span style="font-size:12px; color:#94a3b4; margin-left:auto;">Dirección actual de residencia</span>
        </div>
        <div style="padding:22px;">
            <div class="row g-3">

                <div class="col-12">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Provincia</label>
                    <select name="provincia_id"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($provincias as $item)
                            <option value="{{ $item->id }}" {{ old('provincia_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Localidad</label>
                    <select name="localidad_id"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($localidades as $item)
                            <option value="{{ $item->id }}" {{ old('localidad_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Barrio</label>
                    <select name="barrio_id"
                            style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                            onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                        <option value="">— Seleccionar —</option>
                        @foreach($barrios as $item)
                            <option value="{{ $item->id }}" {{ old('barrio_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Calle</label>
                    <input type="text" name="calle" value="{{ old('calle') }}"
                           placeholder="Nombre de la calle"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>

                <div class="col-md-4">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Número</label>
                    <input type="text" name="numero" value="{{ old('numero') }}"
                           placeholder="Ej: 1234"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>

                <div class="col-md-4">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Piso</label>
                    <input type="text" name="piso" value="{{ old('piso') }}"
                           placeholder="Ej: 2"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>

                <div class="col-md-4">
                    <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Dpto</label>
                    <input type="text" name="dpto" value="{{ old('dpto') }}"
                           placeholder="Ej: A"
                           style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                           onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                           onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                </div>

            </div>
        </div>
    </div>


    <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; margin-bottom:1.25rem; overflow:hidden;">
        <div style="padding:14px 22px 12px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; gap:12px;">
            <div style="width:26px; height:26px; border-radius:50%; background:linear-gradient(135deg,#0d92c2,#1aaad8); display:flex; align-items:center; justify-content:center; color:white; font-size:11px; font-weight:800; flex-shrink:0;">4</div>
            <span style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:14px; color:#0f172a;">Salud</span>
            <span style="font-size:12px; color:#94a3b4; margin-left:auto;">Discapacidad, enfermedades y embarazo</span>
        </div>
        <div style="padding:22px;">
            <div style="display:flex; flex-direction:column; gap:0;">


                <div style="display:flex; align-items:center; justify-content:space-between; padding:13px 0; border-bottom:1px solid #f0ede8;">
                    <div style="flex:1; padding-right:16px;">
                        <div style="font-size:14px; color:#0f172a; font-weight:500; margin-bottom:6px;">Cobertura médica</div>
                        <select name="cobertura_id"
                                style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                                onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                            <option value="">— Seleccionar —</option>
                            @foreach($catalogos['coberturas'] as $c)
                                <option value="{{ $c->id }}" {{ old('cobertura_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                
                <div style="display:flex; align-items:center; justify-content:space-between; padding:13px 0; border-bottom:1px solid #f0ede8;">
                    <div>
                        <div style="font-size:14px; color:#0f172a; font-weight:500;">Tiene discapacidad</div>
                        <div style="font-size:11.5px; color:#94a3b4; margin-top:2px; font-style:italic;">Activá para completar el tipo y detalle</div>
                    </div>
                    <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                        <input type="checkbox" name="_tiene_discapacidad" value="1" id="chk-discapacidad"
                               {{ old('discapacidad_id') || old('_tiene_discapacidad') ? 'checked' : '' }}
                               style="opacity:0; width:0; height:0; position:absolute;"
                               onchange="toggleBlock('blk-discapacidad', this)">
                        <span class="toggle-slider" style="position:absolute; inset:0; background:#c8c4bb; border-radius:24px; transition:background .2s;">
                            <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block;"></span>
                        </span>
                    </label>
                </div>
                <div id="blk-discapacidad"
                     style="display:{{ old('discapacidad_id') || old('_tiene_discapacidad') ? 'block' : 'none' }}; margin:0; padding:16px; background:#f8fafe; border-radius:10px; border:1px solid #e0ddd6; margin-top:8px; margin-bottom:8px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Tipo de discapacidad</label>
                            <select name="discapacidad_id"
                                    style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                                    onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                                <option value="">— Seleccionar —</option>
                                @foreach($catalogos['discapacidades'] as $d)
                                    <option value="{{ $d->id }}" {{ old('discapacidad_id') == $d->id ? 'selected' : '' }}>{{ $d->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Carátula / expediente</label>
                            <input type="text" name="caratula" value="{{ old('caratula') }}" placeholder="Número o referencia"
                                   style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                                   onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                                   onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                        </div>
                        <div class="col-md-6">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">
                                N° CUD
                                <span style="font-size:10px; font-weight:400; text-transform:none; color:#94a3b4; letter-spacing:0;">(Certificado Único de Discapacidad)</span>
                            </label>
                            <input type="text" name="cud_numero" value="{{ old('cud_numero') }}" placeholder="Ej: 12345678"
                                   style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                                   onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                                   onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                        </div>
                        <div class="col-md-3">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Emisión CUD</label>
                            <input type="date" name="cud_fecha_emision" value="{{ old('cud_fecha_emision') }}"
                                   style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                                   onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                                   onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                        </div>
                        <div class="col-md-3">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Vencimiento CUD</label>
                            <input type="date" name="cud_vencimiento" value="{{ old('cud_vencimiento') }}"
                                   style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                                   onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                                   onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                        </div>
                        <div class="col-12">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Observaciones CUD</label>
                            <input type="text" name="cud_observaciones" value="{{ old('cud_observaciones') }}" placeholder="Opcional"
                                   style="width:100%; height:40px; padding:0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a;"
                                   onfocus="this.style.borderColor='#0d92c2'; this.style.boxShadow='0 0 0 3px rgba(13,146,194,.1)'"
                                   onblur="this.style.borderColor='#c8c4bb'; this.style.boxShadow='none'">
                        </div>
                    </div>
                   
                    <div style="display:flex; flex-direction:column; gap:0; margin-top:12px; border-top:1px solid #e0ddd6; padding-top:4px;">
                        <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 0;">
                            <div style="font-size:13.5px; color:#0f172a;">Es permanente</div>
                            <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                                <input type="checkbox" name="discapacidad_permanente" value="1"
                                       {{ old('discapacidad_permanente') ? 'checked' : '' }}
                                       style="opacity:0; width:0; height:0; position:absolute;"
                                       onchange="toggleSlider(this)">
                                <span class="toggle-slider" style="position:absolute; inset:0; background:#c8c4bb; border-radius:24px; transition:background .2s;">
                                    <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block;"></span>
                                </span>
                            </label>
                        </div>
                        <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 0;">
                            <div style="font-size:13.5px; color:#0f172a;">Recibe tratamiento por discapacidad</div>
                            <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                                <input type="checkbox" name="discapacidad_tratamiento" value="1"
                                       {{ old('discapacidad_tratamiento') ? 'checked' : '' }}
                                       style="opacity:0; width:0; height:0; position:absolute;"
                                       onchange="toggleSlider(this)">
                                <span class="toggle-slider" style="position:absolute; inset:0; background:#c8c4bb; border-radius:24px; transition:background .2s;">
                                    <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block;"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                
                <div style="display:flex; align-items:center; justify-content:space-between; padding:13px 0; border-bottom:1px solid #f0ede8;">
                    <div>
                        <div style="font-size:14px; color:#0f172a; font-weight:500;">Tiene enfermedad crónica o relevante</div>
                        <div style="font-size:11.5px; color:#94a3b4; margin-top:2px; font-style:italic;">Activá para seleccionar el tipo y tratamiento</div>
                    </div>
                    <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                        <input type="checkbox" name="_tiene_enfermedad" value="1" id="chk-enfermedad"
                               {{ old('enfermedad_id') ? 'checked' : '' }}
                               style="opacity:0; width:0; height:0; position:absolute;"
                               onchange="toggleBlock('blk-enfermedad', this)">
                        <span class="toggle-slider" style="position:absolute; inset:0; background:#c8c4bb; border-radius:24px; transition:background .2s;">
                            <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block;"></span>
                        </span>
                    </label>
                </div>
                <div id="blk-enfermedad"
                     style="display:{{ old('enfermedad_id') ? 'block' : 'none' }}; margin:0; padding:16px; background:#f8fafe; border-radius:10px; border:1px solid #e0ddd6; margin-top:8px; margin-bottom:8px;">
                    <div class="row g-3">
                        <div class="col-12">
                            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Tipo de enfermedad</label>
                            <select name="enfermedad_id"
                                    style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                                    onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                                <option value="">— Seleccionar —</option>
                                @foreach($catalogos['enfermedades'] as $e)
                                    <option value="{{ $e->id }}" {{ old('enfermedad_id') == $e->id ? 'selected' : '' }}>{{ $e->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 0 0; margin-top:12px; border-top:1px solid #e0ddd6;">
                        <div style="font-size:13.5px; color:#0f172a;">Recibe tratamiento por la enfermedad</div>
                        <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                            <input type="checkbox" name="enfermedad_tratamiento" value="1"
                                   {{ old('enfermedad_tratamiento') ? 'checked' : '' }}
                                   style="opacity:0; width:0; height:0; position:absolute;"
                                   onchange="toggleSlider(this)">
                            <span class="toggle-slider" style="position:absolute; inset:0; background:#c8c4bb; border-radius:24px; transition:background .2s;">
                                <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block;"></span>
                            </span>
                        </label>
                    </div>
                </div>

               
                <div style="display:flex; align-items:center; justify-content:space-between; padding:13px 0; border-bottom:1px solid #f0ede8;">
                    <div>
                        <div style="font-size:14px; color:#0f172a; font-weight:500;">Está embarazada</div>
                        <div style="font-size:11.5px; color:#94a3b4; margin-top:2px; font-style:italic;">Solo aplicar si corresponde</div>
                    </div>
                    <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                        <input type="checkbox" name="embarazo" value="1" id="chk-embarazo"
                               {{ old('embarazo') ? 'checked' : '' }}
                               style="opacity:0; width:0; height:0; position:absolute;"
                               onchange="toggleBlock('blk-embarazo', this)">
                        <span class="toggle-slider" style="position:absolute; inset:0; background:#c8c4bb; border-radius:24px; transition:background .2s;">
                            <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block;"></span>
                        </span>
                    </label>
                </div>
                <div id="blk-embarazo"
                     style="display:{{ old('embarazo') ? 'block' : 'none' }}; padding:14px 16px; background:#f8fafe; border-radius:10px; border:1px solid #e0ddd6; margin-top:8px; margin-bottom:8px;">
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <div style="font-size:13.5px; color:#0f172a;">Realiza controles de embarazo</div>
                        <label style="position:relative; display:inline-block; width:42px; height:24px; flex-shrink:0; cursor:pointer; margin:0;">
                            <input type="checkbox" name="control_embarazo" value="1"
                                   {{ old('control_embarazo') ? 'checked' : '' }}
                                   style="opacity:0; width:0; height:0; position:absolute;"
                                   onchange="toggleSlider(this)">
                            <span class="toggle-slider" style="position:absolute; inset:0; background:#c8c4bb; border-radius:24px; transition:background .2s;">
                                <span style="position:absolute; top:3px; left:3px; width:18px; height:18px; background:white; border-radius:50%; transition:transform .2s; box-shadow:0 1px 3px rgba(0,0,0,.15); display:block;"></span>
                            </span>
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; margin-bottom:1.25rem; overflow:hidden;">
        <div style="padding:14px 22px 12px; border-bottom:1px solid #e0ddd6; display:flex; align-items:center; gap:12px;">
            <div style="width:26px; height:26px; border-radius:50%; background:linear-gradient(135deg,#0d92c2,#1aaad8); display:flex; align-items:center; justify-content:center; color:white; font-size:11px; font-weight:800; flex-shrink:0;">5</div>
            <span style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:14px; color:#0f172a;">Sistema</span>
            <span style="font-size:12px; color:#94a3b4; margin-left:auto;">Datos administrativos internos</span>
        </div>
        <div style="padding:22px;">
            <label style="font-size:11px; font-weight:700; color:#536070; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:5px;">Sede de origen</label>
            <select name="sede_origen_id"
                    style="width:100%; height:40px; padding:0 30px 0 12px; border:1px solid #c8c4bb; border-radius:10px; font-size:14px; font-family:inherit; outline:none; color:#0f172a; background:white url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E\") no-repeat right 10px center; -webkit-appearance:none;"
                    onfocus="this.style.borderColor='#0d92c2'" onblur="this.style.borderColor='#c8c4bb'">
                <option value="">— Seleccionar —</option>
                @foreach($sedes as $item)
                    <option value="{{ $item->id }}" {{ old('sede_origen_id') == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                @endforeach
            </select>
            <p style="font-size:11.5px; color:#94a3b4; margin-top:5px; margin-bottom:0;">Sede desde donde se registra esta persona.</p>
        </div>
    </div>


    <div style="display:flex; align-items:center; justify-content:space-between; padding-top:1rem; border-top:1px solid #e0ddd6; margin-top:.5rem;">
        <a href="{{ route('personas.index') }}" style="height:42px; padding:0 20px; background:white; color:#536070; border:1px solid #c8c4bb; border-radius:10px; font-family:inherit; font-size:14px; font-weight:600; display:inline-flex; align-items:center; gap:7px; text-decoration:none; transition:background .15s;" onmouseover="this.style.background='#f5f3ee'" onmouseout="this.style.background='white'">
            <i class="bi bi-arrow-left" style="font-size:13px;"></i> Cancelar
        </a>
        <button type="submit" style="height:42px; padding:0 28px; background:linear-gradient(135deg,#0d92c2,#1aaad8); color:white; border:none; border-radius:10px; font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:8px; transition:opacity .2s; box-shadow:0 4px 14px rgba(13,146,194,.3);" onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
            <i class="bi bi-person-check-fill"></i> Guardar persona
        </button>
    </div>

    </form>
</div>
</div>


<script>
    
    function toggleSlider(chk) {
        const track = chk.nextElementSibling;
        const thumb = track.querySelector('span');
        track.style.background = chk.checked ? '#0d92c2' : '#c8c4bb';
        thumb.style.transform  = chk.checked ? 'translateX(18px)' : 'translateX(0)';
    }


    function toggleBlock(blockId, chk) {
        toggleSlider(chk);
        const block = document.getElementById(blockId);
        if (block) block.style.display = chk.checked ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('input[type="checkbox"].toggle-init, input[type="checkbox"][onchange]').forEach(function(chk) {
            toggleSlider(chk);
        });


        document.querySelectorAll('input[type="checkbox"]').forEach(function(chk) {
            const track = chk.nextElementSibling;
            if (track && track.classList.contains('toggle-slider')) {
                toggleSlider(chk);
            }
        });
    });
</script>

@endsection