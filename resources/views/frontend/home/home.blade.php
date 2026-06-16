@extends('frontend.layout.front')

@section('title', 'Panel Principal')

@section('content')

@if(session('success'))
    <div class="sp-alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
@endif

{{-- ESTILOS PARA FIGURAS FLOTANTES Y DELICADAS --}}
<style>
    .floating-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 0; /* Queda por detrás del texto */
        pointer-events: none; /* Para que no interfiera con los clics */
    }

    .floating-shape {
        position: absolute;
        bottom: -50px;
        color: #0d92c2; /* Color base, luego lo variamos */
        opacity: 0;
        animation: floatUp 8s ease-in-out infinite;
    }

    /* Animación: sube, aparece y luego se desvanece */
    @keyframes floatUp {
        0% {
            transform: translateY(0) rotate(0deg) scale(0.8);
            opacity: 0;
        }
        20% {
            opacity: 0.15; /* Muy transparente y delicado */
        }
        80% {
            opacity: 0.15;
        }
        100% {
            transform: translateY(-250px) rotate(45deg) scale(1.2);
            opacity: 0;
        }
    }

    /* Posiciones, tamaños, colores y tiempos diferentes para que parezca natural */
    .shape-1 { left: 10%; font-size: 2rem; animation-delay: 0s; color: #17a385; }      /* Mercadería */
    .shape-2 { left: 85%; font-size: 3rem; animation-delay: 1.5s; color: #0d92c2; }    /* Cuidado/Niños */
    .shape-3 { left: 45%; font-size: 1.5rem; animation-delay: 3s; color: #d97706; }    /* Estrellas */
    .shape-4 { left: 70%; font-size: 2.5rem; animation-delay: 0.5s; color: #7c3aed; }  /* Familia */
    .shape-5 { left: 25%; font-size: 2rem; animation-delay: 4.5s; color: #0879a8; }    /* Mercadería 2 */
</style>

{{-- HERO --}}
{{-- Le agregamos position: relative y overflow: hidden al section para contener las figuras --}}
<section style="position: relative; overflow: hidden; background: linear-gradient(135deg, #e6f5fb 0%, #e8f9f5 100%); border-bottom: 1px solid #d0eee7; padding: 2.5rem 0 2rem;">
    
    {{-- CONTENEDOR DE FIGURAS ANIMADAS --}}
    <div class="floating-container">
        <i class="bi bi-box-seam floating-shape shape-1"></i>
        <i class="bi bi-balloon-heart floating-shape shape-2"></i>
        <i class="bi bi-stars floating-shape shape-3"></i>
        <i class="bi bi-house-heart floating-shape shape-4"></i>
        <i class="bi bi-bag-heart floating-shape shape-5"></i>
    </div>

    {{-- El div container ahora necesita position: relative y z-index para estar por encima de las figuras --}}
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <p style="display:inline-flex; align-items:center; gap:6px; background:white; border:1px solid #b3e0f5; border-radius:40px; padding:5px 14px; font-size:12px; font-weight:700; color:#0879a8; margin-bottom:1rem; box-shadow: 0 4px 10px rgba(8,121,168,0.05);">
                    <span style="width:7px; height:7px; border-radius:50%; background:#17a385; display:inline-block; flex-shrink:0;"></span>
                    Sistema activo · {{ now()->locale('es')->isoFormat('dddd D [de] MMMM, YYYY') }}
                </p>
                <h1 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:clamp(1.6rem,4vw,2.3rem); color:#0f172a; margin-bottom:0.5rem; line-height:1.2;">
                    Bienvenido,
                    <span style="background:linear-gradient(135deg,#0d92c2,#17a385); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">
                        @auth {{ auth()->user()->nombre }} @else Invitado @endauth
                    </span>
                </h1>
                <p style="color:#536070; font-size:1rem; font-weight:500; margin:0; max-width:520px;">
                    Gestión integrada de programas sociales y atención ciudadana territorial.
                </p>
            </div>

            @if(auth()->user()?->rol_id == 3)
            <div class="col-lg-4 mt-4 mt-lg-0">
                <a href="{{ route('personas.solicitudes') }}" style="text-decoration:none; display:block;">
                    <div style="background:white; border-radius:14px; padding:18px 20px; box-shadow:0 2px 12px rgba(245,158,11,0.12); border:1px solid #fde68a; display:flex; align-items:center; gap:14px; transition:transform 0.2s;"
                        onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="width:44px; height:44px; background:#fef3c7; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; color:#d97706; flex-shrink:0;">
                            <i class="bi bi-bell-fill"></i>
                        </div>
                        <div>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif; font-size:1.5rem; font-weight:800; color:#d97706; margin:0; line-height:1;">{{ $solicitudesPendientes ?? 0 }}</p>
                            <p style="font-size:12px; color:#536070; font-weight:600; margin:0;">Solicitudes pendientes</p>
                        </div>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

<div class="container py-4">

    {{-- ── DESTINATARIOS ────────────────────────────── --}}
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:1.2rem;">
        <div style="width:4px; height:22px; background:linear-gradient(180deg,#0879a8,#0d92c2); border-radius:4px; flex-shrink:0;"></div>
        <p style="font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1.5px; color:#0879a8; margin:0;">Gestión de Destinatarios</p>
        <div style="flex:1; height:1px; background:linear-gradient(90deg,#b3e0f5,transparent);"></div>
    </div>

    <div class="row g-3 mb-4">

        @if(auth()->user()?->rol_id != 1)
        <div class="col-md-6">
            <a href="{{ route('personas.create') }}" style="text-decoration:none; display:block; height:100%;">
                <div style="background:white; border-radius:18px; padding:22px; border:1px solid #b3e0f5; border-top:3px solid #0d92c2; box-shadow:0 4px 20px rgba(13,146,194,0.07); transition:transform 0.25s,box-shadow 0.25s; height:100%;"
                    onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 32px rgba(13,146,194,0.14)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(13,146,194,0.07)'">
                    <div style="width:44px; height:44px; background:linear-gradient(135deg,#0d92c2,#1aaad8); border-radius:13px; display:flex; align-items:center; justify-content:center; color:white; font-size:20px; margin-bottom:10px; box-shadow:0 4px 10px rgba(13,146,194,0.25);">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <span style="background:#e6f5fb; color:#0879a8; border:1px solid #b3e0f5; border-radius:40px; padding:3px 11px; font-size:11px; font-weight:700; display:inline-block; margin-bottom:8px;">Registro</span>
                    <h3 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:1.1rem; color:#0f172a; margin-bottom:6px;">Nuevo Destinatario</h3>
                    <p style="color:#536070; font-size:13px; font-weight:500; margin:0 0 14px; line-height:1.5;">Registrá un nuevo titular con sus datos personales, domicilio y grupo familiar.</p>
                    <div style="display:flex; align-items:center; gap:6px; color:#0d92c2; font-weight:700; font-size:13px;">
                        Iniciar registro <i class="bi bi-arrow-right-circle-fill"></i>
                    </div>
                </div>
            </a>
        </div>
        @endif

        <div class="{{ auth()->user()?->rol_id != 1 ? 'col-md-6' : 'col-md-6' }}">
            <a href="{{ route('personas.index') }}" style="text-decoration:none; display:block; height:100%;">
                <div style="background:white; border-radius:18px; padding:22px; border:1px solid #9fe1cb; border-top:3px solid #17a385; box-shadow:0 4px 20px rgba(23,163,133,0.07); transition:transform 0.25s,box-shadow 0.25s; height:100%;"
                    onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 32px rgba(23,163,133,0.14)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(23,163,133,0.07)'">
                    <div style="width:44px; height:44px; background:linear-gradient(135deg,#17a385,#2db896); border-radius:13px; display:flex; align-items:center; justify-content:center; color:white; font-size:20px; margin-bottom:10px; box-shadow:0 4px 10px rgba(23,163,133,0.25);">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <span style="background:#e8f9f5; color:#0e8a70; border:1px solid #9fe1cb; border-radius:40px; padding:3px 11px; font-size:11px; font-weight:700; display:inline-block; margin-bottom:8px;">Padrón</span>
                    <h3 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:1.1rem; color:#0f172a; margin-bottom:6px;">Ver Destinatarios</h3>
                    <p style="color:#536070; font-size:13px; font-weight:500; margin:0 0 14px; line-height:1.5;">Consultá, buscá y gestioná todos los destinatarios registrados en el sistema.</p>
                    <div style="display:flex; align-items:center; gap:6px; color:#17a385; font-weight:700; font-size:13px;">
                        Ver listado <i class="bi bi-arrow-right-circle-fill"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12">
            <a href="{{ route('familias.index') }}" style="text-decoration:none; display:block;">
                <div style="background:white; border-radius:18px; padding:22px; border:1px solid #ddd6fe; border-top:3px solid #7c3aed; box-shadow:0 4px 20px rgba(124,58,237,0.07); transition:transform 0.25s,box-shadow 0.25s;"
                    onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 28px rgba(124,58,237,0.13)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(124,58,237,0.07)'">
                    <div style="display:flex; align-items:center; gap:16px;">
                        <div style="width:44px; height:44px; background:linear-gradient(135deg,#7c3aed,#8b5cf6); border-radius:13px; display:flex; align-items:center; justify-content:center; color:white; font-size:20px; flex-shrink:0; box-shadow:0 4px 10px rgba(124,58,237,0.25);">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <span style="background:#f3e8ff; color:#6d28d9; border:1px solid #d8b4fe; border-radius:40px; padding:3px 11px; font-size:11px; font-weight:700; display:inline-block; margin-bottom:5px;">Familias</span>
                            <h3 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:1.05rem; color:#0f172a; margin-bottom:3px;">Grupos Familiares</h3>
                            <p style="color:#536070; font-size:13px; font-weight:500; margin:0; line-height:1.4;">Consultá grupos familiares, integrantes y códigos de referencia.</p>
                        </div>
                        <div style="display:flex; align-items:center; gap:6px; color:#7c3aed; font-weight:700; font-size:13px; flex-shrink:0;">
                            Ver grupos <i class="bi bi-arrow-right-circle-fill"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

    {{-- ── PROGRAMAS ─────────────────────────────────── --}}
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:1.2rem;">
        <div style="width:4px; height:22px; background:linear-gradient(180deg,#17a385,#5dc9a8); border-radius:4px; flex-shrink:0;"></div>
        <p style="font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1.5px; color:#0e8a70; margin:0;">Programas de Acompañamiento</p>
        <div style="flex:1; height:1px; background:linear-gradient(90deg,#9fe1cb,transparent);"></div>
    </div>

    <div class="row g-3 mb-4">
        @foreach($programas as $p)
        <div class="col-sm-6 col-lg-3">
            <a href="{{ route('frontend.programas.show', $p->id) }}" style="text-decoration:none; display:block; height:100%;">
                <div style="background:white; border-radius:16px; padding:18px 16px; border:1px solid #dbeafe; border-top:3px solid #0d92c2; box-shadow:0 2px 10px rgba(0,0,0,0.04); transition:transform 0.22s,box-shadow 0.22s; height:100%;"
                    onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 22px rgba(0,0,0,0.09)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.04)'">
                    <div style="width:38px; height:38px; background:#e6f5fb; border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:18px; color:#0d92c2; margin-bottom:10px;">
                        <i class="bi bi-folder-fill"></i>
                    </div>
                    <span style="background:#e6f5fb; color:#0d92c2; border:1px solid #b3e0f5; border-radius:40px; padding:2px 9px; font-size:10.5px; font-weight:700; display:inline-block; margin-bottom:7px;">Programa</span>
                    <h6 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:13.5px; color:#0f172a; margin:0 0 4px;">{{ $p->nombre }}</h6>
                    <p style="font-size:12px; color:#536070; font-weight:500; margin:0; line-height:1.4;">Ver destinatarios asociados.</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- ── OTROS SERVICIOS ──────────────────────────── --}}
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:1.2rem;">
        <div style="width:4px; height:22px; background:linear-gradient(180deg,#1aaad8,#4dbde8); border-radius:4px; flex-shrink:0;"></div>
        <p style="font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1.5px; color:#0879a8; margin:0;">Otros Servicios</p>
        <div style="flex:1; height:1px; background:linear-gradient(90deg,#b3e0f5,transparent);"></div>
    </div>

    <div class="row g-3">
        @php
            $user = auth()->user();
            $routeMercaderia = '#';
            if ($user) {

                if ($user->rol_id == 6) {
                    $routeMercaderia = route('recepcion.mercaderias.index');
                } elseif (in_array($user->rol_id, [2,3])) {
                    $routeMercaderia = route('panel.mercaderias.index');
                }
            }

            $servicios = [
                [
                    'icon'    => 'bi-box-seam',
                    'titulo'  => 'Entrega de Mercadería',
                    'desc'    => 'Logística de insumos alimentarios del barrio.',
                    'color'   => '#0d92c2',
                    'colorBg' => '#e6f5fb',
                    'colorBo' => '#b3e0f5',
                    'route'   => $routeMercaderia
                ],

                [
                    'icon'    => 'bi-journal-medical',
                    'titulo'  => 'Asistencia de Sepelio',
                    'desc'    => 'Servicio de contención y asistencia social.',
                    'color'   => '#17a385',
                    'colorBg' => '#e8f9f5',
                    'colorBo' => '#9fe1cb',
                    'route'   => '#'
                ],
            ];
            @endphp
        @foreach($servicios as $s)
        <div class="col-md-6">
            <a href="{{ $s['route'] }}" style="text-decoration:none; display:block;">
                <div style="background:white; border-radius:14px; padding:16px 18px; border:1px solid {{ $s['colorBo'] }}; display:flex; align-items:center; gap:14px; box-shadow:0 2px 8px rgba(0,0,0,0.04); transition:transform 0.2s,box-shadow 0.2s;"
                    onmouseover="this.style.transform='translateX(4px)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.08)'"
                    onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'">
                    <div style="width:44px; height:44px; background:{{ $s['colorBg'] }}; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; color:{{ $s['color'] }}; flex-shrink:0;">
                        <i class="bi {{ $s['icon'] }}"></i>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <h6 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:13.5px; color:#0f172a; margin:0 0 2px;">{{ $s['titulo'] }}</h6>
                        <p style="font-size:12px; color:#536070; font-weight:500; margin:0;">{{ $s['desc'] }}</p>
                    </div>
                    <i class="bi bi-chevron-right" style="color:#94a3b8; font-size:15px; flex-shrink:0;"></i>
                </div>
            </a>
        </div>
        @endforeach
    </div>

</div>

@endsection