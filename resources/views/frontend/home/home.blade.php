@extends('frontend.layout.front')

@section('title', 'Panel Principal')

@section('content')

@if(session('success'))
    <div class="sp-alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
@endif


{{-- ── HERO ── --}}
<section style="background: linear-gradient(135deg, #e6f5fb 0%, #e8f9f5 100%); border-bottom: 1px solid #d0eee7; padding: 2.5rem 0 2rem;">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p style="display:inline-flex; align-items:center; gap:6px; background:white; border:1px solid #b3e0f5; border-radius:40px; padding:5px 14px; font-size:12.5px; font-weight:700; color:#0879a8; margin-bottom:1rem; box-shadow: 0 1px 6px rgba(13,146,194,0.1);">
                    <i class="bi bi-circle-fill" style="font-size:7px; color:#17a385;"></i>
                    Sistema activo · {{ now()->isoFormat('dddd D [de] MMMM, YYYY') }}
                </p>
                <h1 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:clamp(1.6rem,4vw,2.4rem); color:#0f172a; margin-bottom:0.5rem; line-height:1.2;">
                    Bienvenido, <span style="background:linear-gradient(135deg,#0d92c2,#17a385); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">{{ auth()->user()->nombre }}</span>&nbsp;
                </h1>
                <p style="color:#536070; font-size:1rem; font-weight:500; margin:0; max-width:520px;">
                    Gestión integrada de programas sociales y atención ciudadana territorial.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="row g-3">
                    <div class="col-4">
                        <div style="background:white; border-radius:14px; padding:16px 12px; text-align:center; box-shadow:0 2px 12px rgba(13,146,194,0.1); border:1px solid #c2eee3;">
                            <p style="font-family:'Plus Jakarta Sans',sans-serif; font-size:1.8rem; font-weight:800; color:#0d92c2; margin:0; line-height:1;">12</p>
                            <p style="font-size:11px; color:#536070; font-weight:600; margin:0; margin-top:3px;">Casos hoy</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div style="background:white; border-radius:14px; padding:16px 12px; text-align:center; box-shadow:0 2px 12px rgba(23,163,133,0.1); border:1px solid #c2eee3;">
                            <p style="font-family:'Plus Jakarta Sans',sans-serif; font-size:1.8rem; font-weight:800; color:#17a385; margin:0; line-height:1;">4</p>
                            <p style="font-size:11px; color:#536070; font-weight:600; margin:0; margin-top:3px;">Programas</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div style="background:white; border-radius:14px; padding:16px 12px; text-align:center; box-shadow:0 2px 12px rgba(13,146,194,0.1); border:1px solid #c2eee3;">
                            <p style="font-family:'Plus Jakarta Sans',sans-serif; font-size:1.8rem; font-weight:800; color:#0879a8; margin:0; line-height:1;">87%</p>
                            <p style="font-size:11px; color:#536070; font-weight:600; margin:0; margin-top:3px;">Cobertura</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ── CONTENIDO PRINCIPAL ── --}}
<div class="container py-4">

    {{-- SECCIÓN: Gestión de Personas --}}
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:1.2rem; margin-top:0.5rem;">
        <div style="width:4px; height:22px; background:linear-gradient(180deg,#0879a8,#0d92c2); border-radius:4px; flex-shrink:0;"></div>
        <p style="font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1.5px; color:#0879a8; margin:0;">Gestión de Personas</p>
        <div style="flex:1; height:1px; background:linear-gradient(90deg,#b3e0f5,transparent);"></div>
    </div>

    <div class="row g-3 mb-4">
        {{-- Nueva persona --}}
        <div class="col-md-6">
            <a href="{{ route('personas.create') }}" style="text-decoration:none; display:block;">
                <div style="
                    background: white;
                    border-radius: 18px;
                    padding: 24px;
                    border: 1px solid #b3e0f5;
                    border-top: 4px solid #0d92c2;
                    box-shadow: 0 4px 20px rgba(13,146,194,0.08);
                    transition: transform 0.25s, box-shadow 0.25s;
                    position: relative;
                    overflow: hidden;
                    height: 100%;
                " onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 32px rgba(13,146,194,0.16)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(13,146,194,0.08)'">
                    <div style="position:absolute; top:-20px; right:-20px; width:100px; height:100px; background:radial-gradient(circle, rgba(13,146,194,0.06) 0%, transparent 70%); border-radius:50%;"></div>
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                        <div style="width:48px; height:48px; background:linear-gradient(135deg,#0d92c2,#1aaad8); border-radius:14px; display:flex; align-items:center; justify-content:center; color:white; font-size:22px; box-shadow:0 4px 12px rgba(13,146,194,0.3);">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <span style="background:#e6f5fb; color:#0879a8; border:1px solid #b3e0f5; border-radius:40px; padding:4px 12px; font-size:11.5px; font-weight:700;">Registro</span>
                    </div>
                    <h3 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:1.25rem; color:#0f172a; margin-bottom:6px;">Nueva Persona</h3>
                    <p style="color:#536070; font-size:13.5px; font-weight:500; margin:0 0 16px;">Registrá un nuevo titular en el sistema con sus datos personales, domicilio y grupo familiar.</p>
                    <div style="display:flex; align-items:center; gap:6px; color:#0d92c2; font-weight:700; font-size:13.5px;">
                        Iniciar registro <i class="bi bi-arrow-right-circle-fill" style="font-size:16px;"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- Listado de personas --}}
        <div class="col-md-6">
            <a href="{{ route('personas.index') }}" style="text-decoration:none; display:block;">
                <div style="
                    background: white;
                    border-radius: 18px;
                    padding: 24px;
                    border: 1px solid #9fe1cb;
                    border-top: 4px solid #17a385;
                    box-shadow: 0 4px 20px rgba(23,163,133,0.08);
                    transition: transform 0.25s, box-shadow 0.25s;
                    position: relative;
                    overflow: hidden;
                    height: 100%;
                " onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 32px rgba(23,163,133,0.16)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(23,163,133,0.08)'">
                    <div style="position:absolute; top:-20px; right:-20px; width:100px; height:100px; background:radial-gradient(circle, rgba(23,163,133,0.06) 0%, transparent 70%); border-radius:50%;"></div>
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                        <div style="width:48px; height:48px; background:linear-gradient(135deg,#17a385,#2db896); border-radius:14px; display:flex; align-items:center; justify-content:center; color:white; font-size:22px; box-shadow:0 4px 12px rgba(23,163,133,0.3);">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <span style="background:#e8f9f5; color:#0e8a70; border:1px solid #9fe1cb; border-radius:40px; padding:4px 12px; font-size:11.5px; font-weight:700;">Padrón</span>
                    </div>
                    <h3 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:1.25rem; color:#0f172a; margin-bottom:6px;">Ver Personas</h3>
                    <p style="color:#536070; font-size:13.5px; font-weight:500; margin:0 0 16px;">Consultá, buscá y gestioná todas las personas registradas en el sistema.</p>
                    <div style="display:flex; align-items:center; gap:6px; color:#17a385; font-weight:700; font-size:13.5px;">
                        Ver listado <i class="bi bi-arrow-right-circle-fill" style="font-size:16px;"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- SECCIÓN: Programas --}}
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:1.2rem; margin-top:0.5rem;">
        <div style="width:4px; height:22px; background:linear-gradient(180deg,#17a385,#5dc9a8); border-radius:4px; flex-shrink:0;"></div>
        <p style="font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1.5px; color:#0e8a70; margin:0;">Programas de Acompañamiento</p>
        <div style="flex:1; height:1px; background:linear-gradient(90deg,#9fe1cb,transparent);"></div>
    </div>

    <div class="row g-3 mb-4">

        @php
        $programas = [
            [
                'icon'     => 'bi-mortarboard',
                'titulo'   => 'Envión',
                'rango'    => '12 a 21 años',
                'desc'     => 'Gestión de becas, tutores e intervenciones socioeducativas.',
                'color'    => '#0d92c2',
                'colorBg'  => '#e6f5fb',
                'colorBor' => '#b3e0f5',
                'tag'      => 'Jóvenes',
            ],
            [
                'icon'     => 'bi-egg-fried',
                'titulo'   => 'UDI & Más Vida',
                'rango'    => '0 a 11 años',
                'desc'     => 'Guarderías y Plan Más Vida. Nutrición y desarrollo temprano.',
                'color'    => '#17a385',
                'colorBg'  => '#e8f9f5',
                'colorBor' => '#9fe1cb',
                'tag'      => 'Infancia',
            ],
            [
                'icon'     => 'bi-heart-pulse',
                'titulo'   => 'Bajo Peso',
                'rango'    => 'Salud Infantil',
                'desc'     => 'Seguimiento clínico-social territorial. Alerta temprana.',
                'color'    => '#0879a8',
                'colorBg'  => '#e6f5fb',
                'colorBor' => '#b3e0f5',
                'tag'      => 'Salud',
            ],
            [
                'icon'     => 'bi-building-up',
                'titulo'   => 'Multiespacio',
                'rango'    => 'Integración',
                'desc'     => 'Área de desarrollo compartido para UDI y Envión.',
                'color'    => '#0e8a70',
                'colorBg'  => '#e8f9f5',
                'colorBor' => '#9fe1cb',
                'tag'      => 'Espacio',
            ],
        ];
        @endphp

        @foreach($programas as $p)
        <div class="col-sm-6 col-lg-3">
            <a href="#" style="text-decoration:none; display:block; height:100%;">
                <div style="
                    background: white;
                    border-radius: 16px;
                    padding: 20px 16px;
                    border: 1px solid {{ $p['colorBor'] }};
                    border-top: 3px solid {{ $p['color'] }};
                    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
                    transition: transform 0.22s, box-shadow 0.22s;
                    height: 100%;
                " onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.10)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 12px rgba(0,0,0,0.05)'">

                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                        <div style="width:42px; height:42px; background:{{ $p['colorBg'] }}; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; color:{{ $p['color'] }};">
                            <i class="bi {{ $p['icon'] }}"></i>
                        </div>
                        <span style="background:{{ $p['colorBg'] }}; color:{{ $p['color'] }}; border:1px solid {{ $p['colorBor'] }}; border-radius:40px; padding:3px 10px; font-size:11px; font-weight:700;">{{ $p['tag'] }}</span>
                    </div>

                    <h6 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:14.5px; color:#0f172a; margin:0 0 3px;">{{ $p['titulo'] }}</h6>
                    <p style="font-size:11.5px; font-weight:600; color:{{ $p['color'] }}; margin:0 0 8px;">{{ $p['rango'] }}</p>
                    <p style="font-size:12.5px; color:#536070; font-weight:500; margin:0; line-height:1.5;">{{ $p['desc'] }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>


    {{-- SECCIÓN: Otros servicios --}}
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:1.2rem;">
        <div style="width:4px; height:22px; background:linear-gradient(180deg,#1aaad8,#4dbde8); border-radius:4px; flex-shrink:0;"></div>
        <p style="font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1.5px; color:#0879a8; margin:0;">Otros Servicios</p>
        <div style="flex:1; height:1px; background:linear-gradient(90deg,#b3e0f5,transparent);"></div>
    </div>

    <div class="row g-3 mb-2">

        @php
        $servicios = [
            [
                'icon'    => 'bi-box-seam',
                'titulo'  => 'Entrega de Mercadería',
                'desc'    => 'Logística de insumos alimentarios del barrio.',
                'color'   => '#0d92c2',
                'colorBg' => '#e6f5fb',
                'colorBo' => '#b3e0f5',
            ],
            [
                'icon'    => 'bi-journal-medical',
                'titulo'  => 'Asistencia de Sepelio',
                'desc'    => 'Servicio de contención y asistencia social.',
                'color'   => '#17a385',
                'colorBg' => '#e8f9f5',
                'colorBo' => '#9fe1cb',
            ],
        ];
        @endphp

        @foreach($servicios as $s)
        <div class="col-md-6">
            <a href="#" style="text-decoration:none; display:block;">
                <div style="
                    background: white;
                    border-radius: 14px;
                    padding: 18px 20px;
                    border: 1px solid {{ $s['colorBo'] }};
                    display: flex;
                    align-items: center;
                    gap: 16px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
                    transition: transform 0.2s, box-shadow 0.2s;
                " onmouseover="this.style.transform='translateX(4px)'; this.style.boxShadow='0 4px 18px rgba(0,0,0,0.09)'"
                   onmouseout="this.style.transform='translateX(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.04)'">
                    <div style="width:46px; height:46px; background:{{ $s['colorBg'] }}; border-radius:13px; display:flex; align-items:center; justify-content:center; font-size:22px; color:{{ $s['color'] }}; flex-shrink:0;">
                        <i class="bi {{ $s['icon'] }}"></i>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <h6 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:14px; color:#0f172a; margin:0 0 3px;">{{ $s['titulo'] }}</h6>
                        <p style="font-size:12.5px; color:#536070; font-weight:500; margin:0;">{{ $s['desc'] }}</p>
                    </div>
                    <i class="bi bi-chevron-right" style="color:#94a3b4; font-size:16px; flex-shrink:0;"></i>
                </div>
            </a>
        </div>
        @endforeach

    </div>

</div>

@endsection