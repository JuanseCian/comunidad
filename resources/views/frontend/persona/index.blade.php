@extends('frontend.layout.front')

@section('title', 'Personas')

@section('content')

{{-- HEADER DE LA SECCIÓN --}}
<div class="page-header-gradient border-bottom pb-4 pt-5 mb-4">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col">
                <p class="text-uppercase fw-bold text-primary small tracking-wide mb-1">
                    <a href="{{ route('home') }}" class="text-decoration-none">Inicio</a>
                    <span class="text-muted mx-1">/</span>
                    Personas
                </p>
                <h1 class="fw-bolder text-dark mb-1 lh-sm" style="font-size: clamp(1.4rem, 3vw, 2rem);">
                    Padrón de Personas
                </h1>
                <p class="text-secondary fw-medium small mb-0">
                    {{ $personas->total() }} {{ $personas->total() === 1 ? 'persona registrada' : 'personas registradas' }}
                    
                    @php
                        // Verificamos de forma limpia si hay algún filtro aplicado
                        $hayFiltros = request()->anyFilled(['q', 'sede_id', 'barrio_id', 'programa_id', 'edad_desde', 'edad_hasta', 'sexo_id', 'trabaja']);
                    @endphp

                    @if($hayFiltros)
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill ms-2 px-2 py-1">Filtrado</span>
                    @endif
                </p>
            </div>
            <div class="col-auto">
                <a href="{{ route('personas.create') }}" class="btn btn-gradient-primary shadow-sm rounded-4 fw-bold px-4 py-2 hover-lift">
                    <i class="bi bi-person-plus-fill me-2"></i> Nueva persona
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center rounded-4 border-success-subtle mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div class="fw-semibold small">{{ session('success') }}</div>
        </div>
    @endif

    {{-- SECCIÓN DE FILTROS --}}
    <form method="GET" action="{{ route('personas.index') }}" class="mb-4">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            
            {{-- HEADER DEL FILTRO (Click para colapsar) --}}
            <div class="card-header bg-light border-bottom-0 d-flex justify-content-between align-items-center p-3 cursor-pointer" 
                 data-bs-toggle="collapse" 
                 data-bs-target="#filtrosCollapse" 
                 aria-expanded="{{ $hayFiltros ? 'true' : 'false' }}">
                
                <div>
                    <div class="fw-bolder text-dark small">
                        <i class="bi bi-funnel-fill text-primary me-1"></i> Filtros de búsqueda
                    </div>
                    <div class="text-muted" style="font-size: 12px;">Filtrá personas por sede, edad, programas y más.</div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    @if($hayFiltros)
                        <a href="{{ route('personas.index') }}" class="text-danger fw-bold small text-decoration-none z-index-2" onclick="event.stopPropagation();">
                            <i class="bi bi-x-circle"></i> Limpiar filtros
                        </a>
                    @endif
                    <i class="bi bi-chevron-down text-muted transition-transform"></i>
                </div>
            </div>

            {{-- CUERPO DEL FILTRO (Colapsable) --}}
            <div class="collapse {{ $hayFiltros ? 'show' : '' }}" id="filtrosCollapse">
                <div class="card-body bg-white border-top">
                    <div class="row g-3">
                        
                        <div class="col-lg-4">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Buscar</label>
                            <div class="position-relative">
                                <i class="bi bi-search position-absolute top-50 translate-middle-y text-muted ms-3"></i>
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Nombre, apellido o DNI" class="form-control rounded-3 ps-5">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-4">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Sede</label>
                            <select name="sede_id" class="form-select rounded-3">
                                <option value="">Todas</option>
                                @foreach($sedes as $sede)
                                    <option value="{{ $sede->id }}" @selected(request('sede_id') == $sede->id)>{{ $sede->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-4">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Programa</label>
                            <select name="programa_id" class="form-select rounded-3">
                                <option value="">Todos</option>
                                @foreach($programas as $programa)
                                    <option value="{{ $programa->id }}" @selected(request('programa_id') == $programa->id)>{{ $programa->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-4">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Sexo</label>
                            <select name="sexo_id" class="form-select rounded-3">
                                <option value="">Todos</option>
                                @foreach($sexos as $sexo)
                                    <option value="{{ $sexo->id }}" @selected(request('sexo_id') == $sexo->id)>{{ $sexo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-4">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Barrio</label>
                            <select name="barrio_id" class="form-select rounded-3">
                                <option value="">Todos</option>
                                @foreach($barrios as $barrio)
                                    <option value="{{ $barrio->id }}" @selected(request('barrio_id') == $barrio->id)>{{ $barrio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-3">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Edad desde</label>
                            <input type="number" name="edad_desde" value="{{ request('edad_desde') }}" min="0" class="form-control rounded-3">
                        </div>

                        <div class="col-lg-2 col-md-3">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Edad hasta</label>
                            <input type="number" name="edad_hasta" value="{{ request('edad_hasta') }}" min="0" class="form-control rounded-3">
                        </div>

                        <div class="col-lg-2 col-md-3">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Trabajo</label>
                            <select name="trabaja" class="form-select rounded-3">
                                <option value="">Todos</option>
                                <option value="1" @selected(request('trabaja') === '1')>Trabaja</option>
                                <option value="0" @selected(request('trabaja') === '0')>No trabaja</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-gradient-primary w-100 rounded-3 fw-bold">
                                <i class="bi bi-search me-1"></i> Aplicar
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- LISTADO DE PERSONAS --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        @if($personas->isEmpty())
            <div class="text-center py-5">
                <div class="icon-circle bg-primary-subtle text-primary mb-3 mx-auto">
                    <i class="bi bi-people fs-2"></i>
                </div>
                <h5 class="fw-bold text-dark">Sin resultados</h5>
                <p class="text-muted small mb-4">
                    {{ $hayFiltros ? 'No se encontraron personas con los filtros aplicados.' : 'Todavía no hay personas registradas en el sistema.' }}
                </p>
                <a href="{{ route('personas.create') }}" class="btn btn-primary rounded-3 fw-bold small px-4">
                    <i class="bi bi-person-plus-fill me-2"></i> Registrar primera persona
                </a>
            </div>
        @else
            {{-- Cabecera del Grid --}}
            <div class="list-grid header-grid bg-light border-bottom text-secondary fw-bold text-uppercase small px-4 py-2">
                @foreach(['Persona', 'DNI', 'Localidad / Barrio', 'Grupo familiar', 'Código GF', 'Acciones'] as $col)
                    <div>{{ $col }}</div>
                @endforeach
            </div>

            {{-- Filas --}}
            @foreach($personas as $p)
                <div class="list-grid row-grid border-bottom px-4 py-3 align-items-center">
                    
                    {{-- Persona --}}
                    <div class="d-flex align-items-center gap-3 overflow-hidden">
                        <div class="avatar-circle bg-primary-subtle text-primary fw-bold border border-primary-subtle flex-shrink-0">
                            {{ strtoupper(substr($p->nombre, 0, 1)) }}{{ strtoupper(substr($p->apellido, 0, 1)) }}
                        </div>
                        <div class="text-truncate">
                            <div class="fw-bold text-dark text-truncate">{{ $p->apellido }}, {{ $p->nombre }}</div>
                            <div class="small text-muted d-flex align-items-center gap-1">
                                @if($p->fecha_nacimiento) <span>{{ \Carbon\Carbon::parse($p->fecha_nacimiento)->age }} años</span> @endif
                                @if($p->sexo) <span class="opacity-50">·</span> <span>{{ $p->sexo->nombre }}</span> @endif
                                @if($p->trabaja) <span class="opacity-50">·</span> <span class="text-success fw-semibold">Trabaja</span> @endif
                            </div>
                        </div>
                    </div>

                    {{-- DNI --}}
                    <div>
                        <div class="fw-semibold text-dark small">{{ $p->dni ?? '—' }}</div>
                        @if($p->tipoDocumento) <div class="text-muted" style="font-size: 11px;">{{ $p->tipoDocumento->nombre }}</div> @endif
                    </div>

                    {{-- Barrio --}}
                    <div>
                        <div class="text-dark fw-medium small">{{ $p->localidad?->nombre ?? '—' }}</div>
                        @if($p->domicilio?->barrio)
                            <div class="text-muted" style="font-size: 11px;">
                                <i class="bi bi-geo-alt"></i> {{ $p->domicilio->barrio->nombre }}
                            </div>
                        @endif
                    </div>

                    {{-- Integrantes --}}
                    <div>
                        @php $total = $p->grupoFamiliar?->count() ?? 0; @endphp
                        @if($total > 0)
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                {{ $total }} {{ $total === 1 ? 'integrante' : 'integrantes' }}
                            </span>
                        @else
                            <span class="text-muted small">Sin registrar</span>
                        @endif
                    </div>

                    {{-- Código Familia --}}
                    <div>
                        @if($p->familia)
                            <span class="badge bg-purple-subtle text-purple border border-purple-subtle rounded-pill">
                                {{ $p->familia->codigo }}
                            </span>
                        @else
                            <span class="text-muted small">Sin código</span>
                        @endif
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('personas.show', $p) }}" class="btn btn-sm btn-action btn-outline-primary" title="Ver ficha">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        <a href="{{ route('personas.grupo-familiar.create', $p) }}" class="btn btn-sm btn-action btn-outline-success" title="Agregar familiar">
                            <i class="bi bi-person-plus"></i>
                        </a>
                    </div>
                </div>
            @endforeach

            {{-- Paginación Customizada --}}
            @if($personas->hasPages())
                <div class="bg-white p-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <span class="small text-muted">
                        Mostrando {{ $personas->firstItem() }}–{{ $personas->lastItem() }} de {{ $personas->total() }}
                    </span>
                    
                    {{-- Si preferís usar la paginación de Laravel nativa con Bootstrap, simplemente usá: --}}
                    {{-- {{ $personas->appends(request()->query())->links() }} --}}
                    
                    {{-- Si querés mantener tu diseño de cuadrados, acá está optimizado: --}}
                    <div class="d-flex gap-1 align-items-center pagination-custom">
                        @if($personas->onFirstPage())
                            <span class="page-box disabled"><i class="bi bi-chevron-left"></i></span>
                        @else
                            <a href="{{ $personas->previousPageUrl() }}" class="page-box"><i class="bi bi-chevron-left"></i></a>
                        @endif

                        @foreach($personas->getUrlRange(max(1, $personas->currentPage()-2), min($personas->lastPage(), $personas->currentPage()+2)) as $page => $url)
                            @if($page == $personas->currentPage())
                                <span class="page-box active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-box">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($personas->hasMorePages())
                            <a href="{{ $personas->nextPageUrl() }}" class="page-box"><i class="bi bi-chevron-right"></i></a>
                        @else
                            <span class="page-box disabled"><i class="bi bi-chevron-right"></i></span>
                        @endif
                    </div>
                </div>
            @endif

        @endif
    </div>
</div>

{{-- ESTILOS CSS EXTRAÍDOS (Podés moverlos a tu app.css) --}}
<style>
    .page-header-gradient { background: linear-gradient(135deg, #e6f5fb 0%, #e8f9f5 100%); }
    .btn-gradient-primary { background: linear-gradient(135deg, #0d92c2, #17a385); color: white; border: none; transition: all 0.2s; }
    .btn-gradient-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(13,146,194,0.3); color: white; }
    .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .cursor-pointer { cursor: pointer; }
    
    .list-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 80px; gap: 10px; }
    .row-grid { transition: background 0.15s ease; background-color: white; }
    .row-grid:hover { background-color: #f8fafc; }
    
    .avatar-circle { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
    .icon-circle { width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
    
    .btn-action { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.15s; }
    
    .bg-purple-subtle { background-color: #f3e8ff; }
    .text-purple { color: #6b21a8; }
    .border-purple-subtle { border-color: #d8b4fe !important; }

    .pagination-custom .page-box { width: 34px; height: 34px; border-radius: 8px; border: 1px solid #e2e8f0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; text-decoration: none; color: #64748b; background: white; transition: all 0.2s; }
    .pagination-custom a.page-box:hover { background: #e6f5fb; border-color: #b3e0f5; color: #0879a8; }
    .pagination-custom .page-box.active { background: linear-gradient(135deg, #0d92c2, #1aaad8); color: white; border-color: #0d92c2; font-weight: bold; }
    .pagination-custom .page-box.disabled { color: #cbd5e1; background: #f8fafc; cursor: not-allowed; }

    [data-bs-toggle="collapse"][aria-expanded="true"] .bi-chevron-down { transform: rotate(180deg); }
    .transition-transform { transition: transform 0.3s ease; }
</style>

@endsection