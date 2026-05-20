@extends('frontend.layout.front')

@section('title', 'Personas')

@section('content')

<div style="background: linear-gradient(135deg, #e6f5fb 0%, #e8f9f5 100%); border-bottom: 1px solid #d0eee7; padding: 2rem 0 1.5rem;">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col">
                <p style="font-size:12px; font-weight:700; color:#0879a8; text-transform:uppercase; letter-spacing:1.2px; margin-bottom:4px;">
                    <a href="{{ route('dashboard') }}" style="color:#0879a8; text-decoration:none;">Inicio</a>
                    <span style="opacity:.4; margin:0 6px;">/</span>
                    Personas
                </p>
                <h1 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:clamp(1.4rem,3vw,2rem); color:#0f172a; margin:0; line-height:1.2;">
                    Padrón de Personas
                </h1>
                <p style="color:#536070; font-size:13.5px; font-weight:500; margin:4px 0 0;">
                    {{ $personas->total() }} {{ $personas->total() === 1 ? 'persona registrada' : 'personas registradas' }}
                    @if(request('q') || request('sede_id') || request('barrio_id'))
                        <span style="background:#e6f5fb; color:#0879a8; border:1px solid #b3e0f5; border-radius:20px; padding:2px 10px; font-size:11.5px; font-weight:700; margin-left:6px;">Filtrado</span>
                    @endif
                </p>
            </div>
            <div class="col-auto">
                <a href="{{ route('personas.create') }}" style="
                    display:inline-flex; align-items:center; gap:8px;
                    background:linear-gradient(135deg,#0d92c2,#17a385);
                    color:white; text-decoration:none;
                    padding:10px 20px; border-radius:12px;
                    font-family:'Plus Jakarta Sans',sans-serif;
                    font-weight:700; font-size:14px;
                    box-shadow:0 4px 14px rgba(13,146,194,0.3);
                    transition: transform .2s, box-shadow .2s;
                " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 22px rgba(13,146,194,0.4)'"
                   onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 14px rgba(13,146,194,0.3)'">
                    <i class="bi bi-person-plus-fill"></i> Nueva persona
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">


    <form method="GET" action="{{ route('personas.index') }}">

        <div style="
            background:white;
            border:1px solid #e0ddd6;
            border-radius:18px;
            overflow:hidden;
            margin-bottom:1.4rem;
            box-shadow:0 2px 10px rgba(15,23,42,.03);
        ">

            {{-- HEADER --}}
            <div style="
                padding:14px 20px;
                border-bottom:1px solid #f1efe9;
                background:#fcfcfb;
                display:flex;
                justify-content:space-between;
                align-items:center;
                flex-wrap:wrap;
                gap:10px;
            ">

                <div>
                    <div style="
                        font-size:13px;
                        font-weight:800;
                        color:#0f172a;
                        font-family:'Plus Jakarta Sans',sans-serif;
                    ">
                        Filtros de búsqueda
                    </div>

                    <div style="
                        font-size:12px;
                        color:#64748b;
                        margin-top:2px;
                    ">
                        Filtrá personas por sede, edad, programas y más.
                    </div>
                </div>

                @php
                    $hayFiltros =
                        request('q') ||
                        request('sede_id') ||
                        request('barrio_id') ||
                        request('programa_id') ||
                        request('edad_desde') ||
                        request('edad_hasta') ||
                        request('sexo_id');
                @endphp

                @if($hayFiltros)
                    <a href="{{ route('personas.index') }}"
                    style="
                            font-size:12px;
                            font-weight:700;
                            color:#dc2626;
                            text-decoration:none;
                            display:flex;
                            align-items:center;
                            gap:5px;
                    ">
                        <i class="bi bi-x-circle"></i>
                        Limpiar filtros
                    </a>
                @endif
            </div>

            {{-- BODY --}}
            <div style="padding:20px;">

                <div class="row g-3">

                    {{-- BUSCADOR --}}
                    <div class="col-lg-4">
                        <label class="form-label small fw-bold text-uppercase text-secondary">
                            Buscar
                        </label>

                        <div style="position:relative;">
                            <i class="bi bi-search"
                            style="
                                    position:absolute;
                                    left:12px;
                                    top:50%;
                                    transform:translateY(-50%);
                                    color:#94a3b8;
                            "></i>

                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Nombre, apellido o DNI"
                                class="form-control"
                                style="
                                    height:42px;
                                    border-radius:12px;
                                    padding-left:38px;
                                    border:1px solid #d6d3cd;
                                ">
                        </div>
                    </div>

                    {{-- SEDE --}}
                    <div class="col-lg-2 col-md-4">
                        <label class="form-label small fw-bold text-uppercase text-secondary">
                            Sede
                        </label>

                        <select name="sede_id"
                                class="form-select"
                                style="height:42px; border-radius:12px;">
                            <option value="">Todas</option>

                            @foreach($sedes as $sede)
                                <option value="{{ $sede->id }}"
                                    {{ request('sede_id') == $sede->id ? 'selected' : '' }}>
                                    {{ $sede->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- PROGRAMA --}}
                    <div class="col-lg-2 col-md-4">
                        <label class="form-label small fw-bold text-uppercase text-secondary">
                            Programa
                        </label>

                        <select name="programa_id"
                                class="form-select"
                                style="height:42px; border-radius:12px;">
                            <option value="">Todos</option>

                            @foreach($programas as $programa)
                                <option value="{{ $programa->id }}"
                                    {{ request('programa_id') == $programa->id ? 'selected' : '' }}>
                                    {{ $programa->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- SEXO --}}
                    <div class="col-lg-2 col-md-4">
                        <label class="form-label small fw-bold text-uppercase text-secondary">
                            Sexo
                        </label>

                        <select name="sexo_id"
                                class="form-select"
                                style="height:42px; border-radius:12px;">
                            <option value="">Todos</option>

                            @foreach($sexos as $sexo)
                                <option value="{{ $sexo->id }}"
                                    {{ request('sexo_id') == $sexo->id ? 'selected' : '' }}>
                                    {{ $sexo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- BARRIO --}}
                    <div class="col-lg-2 col-md-4">
                        <label class="form-label small fw-bold text-uppercase text-secondary">
                            Barrio
                        </label>

                        <select name="barrio_id"
                                class="form-select"
                                style="height:42px; border-radius:12px;">
                            <option value="">Todos</option>

                            @foreach($barrios as $barrio)
                                <option value="{{ $barrio->id }}"
                                    {{ request('barrio_id') == $barrio->id ? 'selected' : '' }}>
                                    {{ $barrio->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- EDAD DESDE --}}
                    <div class="col-lg-2 col-md-3">
                        <label class="form-label small fw-bold text-uppercase text-secondary">
                            Edad desde
                        </label>

                        <input type="number"
                            name="edad_desde"
                            value="{{ request('edad_desde') }}"
                            min="0"
                            class="form-control"
                            style="height:42px; border-radius:12px;">
                    </div>
                    {{-- EDAD HASTA --}}
                    <div class="col-lg-2 col-md-3">
                        <label class="form-label small fw-bold text-uppercase text-secondary">
                            Edad hasta
                        </label>
                        <input type="number"
                            name="edad_hasta"
                            value="{{ request('edad_hasta') }}"
                            min="0"
                            class="form-control"
                            style="height:42px; border-radius:12px;">
                    </div>
                    {{-- TRABAJA --}}
                    <div class="col-lg-2 col-md-3">
                        <label class="form-label small fw-bold text-uppercase text-secondary">
                            Trabajo
                        </label>

                        <select name="trabaja"
                                class="form-select"
                                style="height:42px; border-radius:12px;">
                            <option value="">Todos</option>
                            <option value="1" {{ request('trabaja') === '1' ? 'selected' : '' }}>
                                Trabaja
                            </option>
                            <option value="0" {{ request('trabaja') === '0' ? 'selected' : '' }}>
                                No trabaja
                            </option>
                        </select>
                    </div>

                    {{-- BOTONES --}}
                    <div class="col-lg-2 col-md-3 d-flex align-items-end">
                        <button type="submit"
                                class="btn w-100"
                                style="
                                    height:42px;
                                    border-radius:12px;
                                    background:linear-gradient(135deg,#0d92c2,#17a385);
                                    color:white;
                                    font-weight:700;
                                    border:none;
                                ">
                            <i class="bi bi-funnel-fill"></i>
                            Filtrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

  
    @if(session('success'))
        <div style="background:#e8f9f5; border:1px solid #9fe1cb; border-radius:12px; padding:12px 18px; margin-bottom:1.25rem; color:#0e8a70; font-size:13.5px; font-weight:600; display:flex; align-items:center; gap:10px;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif


    <div style="background:white; border:1px solid #e0ddd6; border-radius:16px; overflow:hidden;">

        @if($personas->isEmpty())
            <div style="text-align:center; padding:4rem 2rem;">
                <div style="width:64px; height:64px; background:#e6f5fb; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:28px; color:#0d92c2;">
                    <i class="bi bi-people"></i>
                </div>
                <p style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:16px; color:#0f172a; margin:0 0 6px;">Sin resultados</p>
                <p style="font-size:13.5px; color:#536070; margin:0 0 20px;">
                    @if(request('q') || request('sede_id') || request('barrio_id'))
                        No se encontraron personas con los filtros aplicados.
                    @else
                        Todavía no hay personas registradas en el sistema.
                    @endif
                </p>
                <a href="{{ route('personas.create') }}" style="display:inline-flex; align-items:center; gap:6px; background:#0d92c2; color:white; text-decoration:none; padding:9px 18px; border-radius:10px; font-weight:700; font-size:13.5px;">
                    <i class="bi bi-person-plus-fill"></i> Registrar primera persona
                </a>
            </div>

        @else


            <div style="display:grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 80px; gap:0; border-bottom:1px solid #e0ddd6; background:#f5f3ee; padding:0 20px;">
                    @foreach(['Persona', 'DNI', 'Localidad / Barrio', 'Grupo familiar', 'Código GF', ''] as $col)
                    <div style="padding:10px 8px; font-size:11px; font-weight:800; color:#536070; text-transform:uppercase; letter-spacing:.08em;">{{ $col }}</div>
                @endforeach
            </div>


            @foreach($personas as $p)
                <div style="display:grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 80px; gap:0; border-bottom:1px solid #f0ede8; padding:0 20px; transition:background .15s;"
                     onmouseover="this.style.background='#fafaf8'" onmouseout="this.style.background='white'">


                    <div style="padding:14px 8px; display:flex; align-items:center; gap:12px; min-width:0;">
                        <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#e6f5fb,#e8f9f5); border:1px solid #b3e0f5; display:flex; align-items:center; justify-content:center; font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:13px; color:#0879a8; flex-shrink:0;">
                            {{ strtoupper(substr($p->nombre, 0, 1)) }}{{ strtoupper(substr($p->apellido, 0, 1)) }}
                        </div>
                        <div style="min-width:0;">
                            <div style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:14px; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $p->apellido }}, {{ $p->nombre }}
                            </div>
                            <div style="font-size:11.5px; color:#536070; margin-top:1px; display:flex; align-items:center; gap:6px;">
                                @if($p->fecha_nacimiento)
                                    <span>{{ \Carbon\Carbon::parse($p->fecha_nacimiento)->age }} años</span>
                                @endif
                                @if($p->sexo)
                                    <span style="opacity:.4;">·</span>
                                    <span>{{ $p->sexo->nombre }}</span>
                                @endif
                                @if($p->trabaja)
                                    <span style="opacity:.4;">·</span>
                                    <span style="color:#17a385; font-weight:600;">Trabaja</span>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div style="padding:14px 8px; display:flex; align-items:center;">
                        <div>
                            <div style="font-size:13.5px; font-weight:600; color:#0f172a;">{{ $p->dni ?? '—' }}</div>
                            @if($p->tipoDocumento)
                                <div style="font-size:11px; color:#94a3b4; margin-top:1px;">{{ $p->tipoDocumento->nombre }}</div>
                            @endif
                        </div>
                    </div>


                    <div style="padding:14px 8px; display:flex; align-items:center;">
                        <div>
                            <div style="font-size:13px; color:#0f172a; font-weight:500;">
                                {{ $p->localidad?->nombre ?? '—' }}
                            </div>
                            @if($p->domicilio?->barrio)
                                <div style="font-size:11.5px; color:#536070; margin-top:1px;">
                                    <i class="bi bi-geo-alt" style="font-size:10px;"></i>
                                    {{ $p->domicilio->barrio->nombre }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div style="padding:14px 8px; display:flex; align-items:center;">
                        @php $total = $p->grupoFamiliar?->count() ?? 0; @endphp
                        @if($total > 0)
                            <span style="background:#e8f9f5; color:#0e8a70; border:1px solid #9fe1cb; border-radius:20px; padding:3px 10px; font-size:12px; font-weight:700;">
                                {{ $total }} {{ $total === 1 ? 'integrante' : 'integrantes' }}
                            </span>
                        @else
                            <span style="font-size:12.5px; color:#94a3b4;">Sin registrar</span>
                        @endif
                    </div>

                    <div style="padding:14px 8px; display:flex; align-items:center;">
                        @if($p->familia)
                            <span style="
                                background:#f5f3ff;
                                color:#6d28d9;
                                border:1px solid #d8b4fe;
                                border-radius:20px;
                                padding:3px 10px;
                                font-size:12px;
                                font-weight:700;
                                white-space:nowrap;
                            ">
                                {{ $p->familia->codigo }}
                            </span>
                        @else
                            <span style="font-size:12.5px; color:#94a3b4;">
                                Sin código
                            </span>
                        @endif
                    </div>

                    <div style="padding:14px 8px; display:flex; align-items:center; justify-content:flex-end; gap:6px;">
                        <a href="{{ route('personas.show', $p) }}"
                           style="width:32px; height:32px; background:#e6f5fb; border:1px solid #b3e0f5; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; color:#0879a8; text-decoration:none; transition:background .15s;"
                           title="Ver ficha"
                           onmouseover="this.style.background='#0d92c2'; this.style.color='white'; this.style.borderColor='#0d92c2'"
                           onmouseout="this.style.background='#e6f5fb'; this.style.color='#0879a8'; this.style.borderColor='#b3e0f5'">
                            <i class="bi bi-eye-fill" style="font-size:13px;"></i>
                        </a>
                        <a href="{{ route('personas.grupo-familiar.create', $p) }}"
                           style="width:32px; height:32px; background:#e8f9f5; border:1px solid #9fe1cb; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; color:#0e8a70; text-decoration:none; transition:background .15s;"
                           title="Agregar familiar"
                           onmouseover="this.style.background='#17a385'; this.style.color='white'; this.style.borderColor='#17a385'"
                           onmouseout="this.style.background='#e8f9f5'; this.style.color='#0e8a70'; this.style.borderColor='#9fe1cb'">
                            <i class="bi bi-person-plus" style="font-size:13px;"></i>
                        </a>
                    </div>

                </div>
            @endforeach

            @if($personas->hasPages())
                <div style="padding:16px 20px; border-top:1px solid #e0ddd6; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                    <span style="font-size:13px; color:#536070;">
                        Mostrando {{ $personas->firstItem() }}–{{ $personas->lastItem() }} de {{ $personas->total() }}
                    </span>
                    <div style="display:flex; gap:4px; align-items:center;">

                        @if($personas->onFirstPage())
                            <span style="width:34px; height:34px; border:1px solid #e0ddd6; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; color:#c8c4bb; font-size:13px;">
                                <i class="bi bi-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $personas->previousPageUrl() }}" style="width:34px; height:34px; border:1px solid #c8c4bb; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; color:#536070; text-decoration:none; transition:all .15s;" onmouseover="this.style.background='#0d92c2'; this.style.color='white'; this.style.borderColor='#0d92c2'" onmouseout="this.style.background='white'; this.style.color='#536070'; this.style.borderColor='#c8c4bb'">
                                <i class="bi bi-chevron-left" style="font-size:13px;"></i>
                            </a>
                        @endif


                        @foreach($personas->getUrlRange(max(1, $personas->currentPage()-2), min($personas->lastPage(), $personas->currentPage()+2)) as $page => $url)
                            @if($page == $personas->currentPage())
                                <span style="width:34px; height:34px; background:linear-gradient(135deg,#0d92c2,#1aaad8); color:white; border:1px solid #0d92c2; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; font-size:13px; font-weight:700;">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" style="width:34px; height:34px; border:1px solid #c8c4bb; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; color:#536070; text-decoration:none; font-size:13px; transition:all .15s;" onmouseover="this.style.background='#e6f5fb'; this.style.borderColor='#b3e0f5'" onmouseout="this.style.background='white'; this.style.borderColor='#c8c4bb'">{{ $page }}</a>
                            @endif
                        @endforeach


                        @if($personas->hasMorePages())
                            <a href="{{ $personas->nextPageUrl() }}" style="width:34px; height:34px; border:1px solid #c8c4bb; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; color:#536070; text-decoration:none; transition:all .15s;" onmouseover="this.style.background='#0d92c2'; this.style.color='white'; this.style.borderColor='#0d92c2'" onmouseout="this.style.background='white'; this.style.color='#536070'; this.style.borderColor='#c8c4bb'">
                                <i class="bi bi-chevron-right" style="font-size:13px;"></i>
                            </a>
                        @else
                            <span style="width:34px; height:34px; border:1px solid #e0ddd6; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; color:#c8c4bb; font-size:13px;">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            @endif

        @endif
    </div>
</div>

@endsection
