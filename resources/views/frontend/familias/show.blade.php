@extends('frontend.layout.front')

@section('title', 'Grupo Familiar')

@section('content')
<div class="container-fluid py-4">

    {{-- HERO SECTION --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-body p-4 p-lg-5" style="background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">
                
                {{-- Info Principal --}}
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:70px; height:70px; background:#4f46e5; color:white;">
                            <i class="bi bi-people-fill fs-2"></i>
                        </div>
                        <div>
                            <div class="text-muted small text-uppercase fw-bold tracking-wide mb-1">Grupo Familiar</div>
                            <h1 class="fw-bold mb-1 text-dark">{{ $familia->codigo }}</h1>
                            <div class="text-muted">Información completa del núcleo familiar</div>
                        </div>
                    </div>

                    {{-- Badges Resumen --}}
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2 border border-primary-subtle">
                            <i class="bi bi-people me-1"></i> {{ $familia->personas->count() }} Integrantes
                        </span>
                        <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2 border border-success-subtle">
                            <i class="bi bi-box-seam me-1"></i> {{ $familia->mercaderias->count() }} Entregas
                        </span>
                        <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2 border border-danger-subtle">
                            <i class="bi bi-heartbreak me-1"></i> {{ $familia->sepelios->count() }} Sepelios
                        </span>
                    </div>
                </div>

                {{-- Acciones --}}
                <div>
                    <a href="{{ route('familias.index') }}" class="btn btn-light border shadow-sm px-4 py-2 fw-semibold rounded-pill hover-lift">
                        <i class="bi bi-arrow-left me-2"></i> Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- COLUMNA PRINCIPAL: INTEGRANTES --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom-0 p-4 pb-2 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Integrantes del Grupo</h4>
                        <p class="text-muted small mb-0">Personas vinculadas a este código familiar</p>
                    </div>
                    <span class="badge bg-primary text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                        {{ $familia->personas->count() }}
                    </span>
                </div>

                <div class="card-body p-4 pt-2">
                    <div class="row g-4">
                        @foreach($familia->personas as $persona)
                            <div class="col-12">
                                <div class="border rounded-4 p-4 bg-white h-100 shadow-sm transition-all hover-shadow">
                                    
                                    {{-- Cabecera Persona --}}
                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4 border-bottom pb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border" style="width:60px; height:60px;">
                                                <i class="bi bi-person-fill fs-3 text-secondary"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-1 text-dark">{{ $persona->apellido }}, {{ $persona->nombre }}</h5>
                                                <div class="text-muted small">
                                                    <i class="bi bi-person-vcard me-1"></i> DNI: <span class="fw-semibold">{{ $persona->dni ?? 'Sin cargar' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('personas.show', $persona->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="bi bi-eye me-1"></i> Ver perfil
                                        </a>
                                    </div>

                                    {{-- Programas y Beneficios --}}
                                    <div class="row g-3 mb-4">
                                        @php
                                            $programasActivos = $persona->personaPrograma->whereNull('fecha_fin')->filter(fn($pp) => $pp->programa);
                                            $beneficiosActivos = $persona->personaBeneficio->where('activo', 1)->filter(fn($pb) => $pb->beneficio);
                                        @endphp

                                        @if($programasActivos->count() > 0)
                                            <div class="col-md-6">
                                                <div class="rounded-3 p-3 bg-light border h-100">
                                                    <div class="small fw-bold text-muted text-uppercase mb-2"><i class="bi bi-diagram-3 text-primary me-1"></i> Programas Activos</div>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach($programasActivos as $pp)
                                                            <span class="badge bg-white text-primary border border-primary-subtle">{{ $pp->programa->nombre }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($beneficiosActivos->count() > 0)
                                            <div class="col-md-6">
                                                <div class="rounded-3 p-3 bg-light border h-100">
                                                    <div class="small fw-bold text-muted text-uppercase mb-2"><i class="bi bi-award text-success me-1"></i> Beneficios Activos</div>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach($beneficiosActivos as $beneficio)
                                                            <span class="badge bg-white text-success border border-success-subtle">{{ $beneficio->beneficio->nombre }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Familiares Asociados --}}
                                    @if($persona->grupoFamiliar && $persona->grupoFamiliar->count() > 0)
                                        @php
                                            $nucleoIds = $persona->nucleosConvivientes?->pluck('id') ?? collect();
                                            $gfConvIds = $nucleoIds->isNotEmpty() 
                                                ? $persona->nucleosConvivientes->flatMap(fn($n) => $n->miembrosGrupoFamiliar->pluck('id'))->unique() 
                                                : collect();
                                            
                                            $convivientes = $persona->grupoFamiliar->filter(fn($f) => $gfConvIds->contains($f->id));
                                            $externos = $persona->grupoFamiliar->reject(fn($f) => $gfConvIds->contains($f->id));
                                        @endphp

                                        <div class="bg-light rounded-4 p-3 border">
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <i class="bi bi-people text-secondary"></i>
                                                <div class="fw-semibold small text-uppercase text-muted">Red Familiar Asociada</div>
                                            </div>

                                            {{-- Convivientes --}}
                                            @if($convivientes->isNotEmpty())
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                                            <i class="bi bi-house-door-fill me-1"></i> Núcleo Conviviente
                                                        </span>
                                                    </div>
                                                    <div class="row g-2">
                                                        @foreach($convivientes as $familiar)
                                                            <div class="col-md-6 col-lg-4">
                                                                <div class="bg-white border rounded p-2 h-100 shadow-sm">
                                                                    <div class="fw-bold text-dark small text-truncate" title="{{ $familiar->nombre }}">{{ $familiar->nombre }}</div>
                                                                    <div class="small text-muted" style="font-size: 0.75rem;"><i class="bi bi-diagram-2"></i> {{ $familiar->relacion_titular ?? 'Sin especificar' }}</div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Externos --}}
                                            @if($externos->isNotEmpty())
                                                <div>
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                                            <i class="bi bi-signpost-split-fill me-1"></i> Externos al domicilio
                                                        </span>
                                                    </div>
                                                    <div class="row g-2">
                                                        @foreach($externos as $familiar)
                                                            <div class="col-md-6 col-lg-4">
                                                                <div class="bg-white border rounded p-2 h-100 shadow-sm">
                                                                    <div class="fw-bold text-dark small text-truncate" title="{{ $familiar->nombre }}">{{ $familiar->nombre }}</div>
                                                                    <div class="small text-muted" style="font-size: 0.75rem;"><i class="bi bi-diagram-2"></i> {{ $familiar->relacion_titular ?? 'Sin especificar' }}</div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            {{-- Fallback: Sin clasificación --}}
                                            @if($gfConvIds->isEmpty())
                                                <div class="row g-2">
                                                    @foreach($persona->grupoFamiliar as $familiar)
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="bg-white border rounded p-2 h-100 shadow-sm">
                                                                <div class="fw-bold text-dark small text-truncate" title="{{ $familiar->nombre }}">{{ $familiar->nombre }}</div>
                                                                <div class="small text-muted" style="font-size: 0.75rem;"><i class="bi bi-diagram-2"></i> {{ $familiar->relacion_titular ?? 'Sin especificar' }}</div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA LATERAL: SIDEBAR --}}
        <div class="col-lg-4">
            
            {{-- Resumen Rápido --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">Resumen del Grupo</h5>
                    <ul class="list-group list-group-flush mb-0">
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center bg-transparent">
                            <span class="text-muted small"><i class="bi bi-upc-scan me-2"></i>Código Familiar</span>
                            <span class="fw-bold text-dark">{{ $familia->codigo }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center bg-transparent">
                            <span class="text-muted small"><i class="bi bi-people me-2"></i>Total Integrantes</span>
                            <span class="badge bg-primary rounded-pill">{{ $familia->personas->count() }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Historial de Mercadería --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-box-seam text-success"></i> Entregas
                        </h5>
                        <span class="badge bg-light text-dark border">{{ $familia->mercaderias->count() }}</span>
                    </div>

                    @if($familia->mercaderias->count() > 0)
                        <div class="border-start border-success border-2 ms-2 ps-3 relative position-relative">
                            @foreach($familia->mercaderias->sortByDesc('fecha_entrega') as $mercaderia)
                                <div class="mb-3 position-relative">
                                    <div class="position-absolute bg-success rounded-circle" style="width: 10px; height: 10px; left: -21px; top: 5px;"></div>
                                    <div class="fw-bold text-dark small">{{ \Carbon\Carbon::parse($mercaderia->fecha_entrega)->format('d M, Y') }}</div>
                                    <div class="text-muted small"><i class="bi bi-person-check me-1"></i> {{ $mercaderia->nombre }} {{ $mercaderia->apellido }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3 text-muted small bg-light rounded-3">
                            <i class="bi bi-inbox fs-3 d-block mb-1"></i> Sin entregas
                        </div>
                    @endif
                </div>
            </div>

            {{-- Historial de Sepelios --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-heartbreak text-danger"></i> Sepelios
                        </h5>
                        <span class="badge bg-light text-dark border">{{ $familia->sepelios->count() }}</span>
                    </div>

                    @if($familia->sepelios->count() > 0)
                        <div class="border-start border-danger border-2 ms-2 ps-3 relative position-relative">
                            @foreach($familia->sepelios->sortByDesc('created_at') as $sepelio)
                                <div class="mb-3 position-relative pb-2 border-bottom last-child-no-border">
                                    <div class="position-absolute bg-danger rounded-circle" style="width: 10px; height: 10px; left: -21px; top: 5px;"></div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="fw-bold text-dark small">{{ \Carbon\Carbon::parse($sepelio->created_at)->format('d/m/Y') }}</div>
                                        <span class="badge {{ $sepelio->servicio_tipo == 'cremacion' ? 'bg-secondary' : 'bg-danger' }} rounded-pill" style="font-size: 0.7rem;">
                                            {{ ucfirst($sepelio->servicio_tipo) }}
                                        </span>
                                    </div>
                                    <div class="text-dark small fw-semibold"><i class="bi bi-person-x me-1"></i> {{ $sepelio->fallecido_nombre }}</div>
                                    
                                    @if($sepelio->solicitante)
                                        <div class="text-muted small mt-1" style="font-size: 0.75rem;">Resp: {{ $sepelio->solicitante }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3 text-muted small bg-light rounded-3">
                            <i class="bi bi-heartbreak fs-3 d-block mb-1 text-black-50"></i> Sin registros
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Pequeños ajustes visuales opcionales que puedes mover a tu CSS principal */
    .hover-shadow:hover { box-shadow: 0 .5rem 1rem rgba(0,0,0,.05)!important; transform: translateY(-2px); }
    .transition-all { transition: all 0.2s ease-in-out; }
    .last-child-no-border:last-child { border-bottom: none !important; margin-bottom: 0 !important; padding-bottom: 0 !important; }
</style>
@endsection