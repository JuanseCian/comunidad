@extends('frontend.layout.front')

@section('title', 'Grupo Familiar')

@section('content')

<div class="container-fluid py-4">

    {{-- HERO --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

        <div class="card-body p-4 p-lg-5"
             style="background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);">

            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">

                <div>

                    <div class="d-flex align-items-center gap-3 mb-3">

                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:70px;height:70px;background:#4f46e5;color:white;">

                            <i class="bi bi-people-fill fs-2"></i>

                        </div>

                        <div>

                            <div class="text-muted small text-uppercase fw-semibold mb-1">
                                Grupo Familiar
                            </div>

                            <h1 class="fw-bold mb-1">
                                {{ $familia->codigo }}
                            </h1>

                            <div class="text-muted">
                                Información completa del grupo familiar
                            </div>

                        </div>

                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-3">

                        <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2 border border-primary-subtle">
                            <i class="bi bi-people me-1"></i>
                            {{ $familia->personas->count() }} integrantes
                        </span>

                        <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2 border border-success-subtle">
                            <i class="bi bi-box-seam me-1"></i>
                            {{ $familia->mercaderias->count() }} entregas
                        </span>

                    </div>

                </div>

                <div>

                    <a href="{{ route('familias.index') }}"
                       class="btn btn-light border shadow-sm px-4">

                        <i class="bi bi-arrow-left me-2"></i>
                        Volver

                    </a>

                </div>

            </div>

        </div>

    </div>

    <div class="row g-4">

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0 p-4 pb-0">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                        <div>

                            <h4 class="fw-bold mb-1">
                                Integrantes del Grupo
                            </h4>

                            <p class="text-muted mb-0">
                                Personas vinculadas al grupo familiar
                            </p>

                        </div>

                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2">
                            {{ $familia->personas->count() }} personas
                        </span>

                    </div>

                </div>

                <div class="card-body p-4">

                    <div class="row g-4">

                        @foreach($familia->personas as $persona)

                            <div class="col-12">

                                <div class="border rounded-4 p-4 bg-white h-100">

                                    {{-- CABECERA --}}
                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">

                                        <div class="d-flex align-items-center gap-3">

                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                 style="width:60px;height:60px;">

                                                <i class="bi bi-person-fill fs-3 text-secondary"></i>

                                            </div>

                                            <div>

                                                <h5 class="fw-bold mb-1">
                                                    {{ $persona->apellido }},
                                                    {{ $persona->nombre }}
                                                </h5>

                                                <div class="text-muted small">
                                                    <i class="bi bi-person-vcard me-1"></i>
                                                    DNI:
                                                    {{ $persona->dni ?? 'Sin cargar' }}
                                                </div>

                                            </div>

                                        </div>

                                        <a href="{{ route('personas.show', $persona->id) }}"
                                           class="btn btn-sm btn-outline-dark rounded-pill px-3">

                                            <i class="bi bi-eye me-1"></i>
                                            Ver perfil

                                        </a>

                                    </div>

                                    <div class="row g-3">

                                        {{-- PROGRAMAS --}}
                                        @if($persona->personaPrograma->whereNull('fecha_fin')->count() > 0)

                                            <div class="col-md-6">

                                                <div class="border rounded-4 p-3 bg-light h-100">

                                                    <div class="d-flex align-items-center gap-2 mb-3">

                                                        <i class="bi bi-diagram-3 text-primary"></i>

                                                        <div class="fw-semibold">
                                                            Programas activos
                                                        </div>

                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2">

                                                        @foreach($persona->personaPrograma as $pp)

                                                            @if(!$pp->fecha_fin && $pp->programa)

                                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">

                                                                    {{ $pp->programa->nombre }}

                                                                </span>

                                                            @endif

                                                        @endforeach

                                                    </div>

                                                </div>

                                            </div>

                                        @endif

                                        {{-- BENEFICIOS --}}
                                        @if($persona->personaBeneficio->where('activo', 1)->count() > 0)

                                            <div class="col-md-6">

                                                <div class="border rounded-4 p-3 bg-light h-100">

                                                    <div class="d-flex align-items-center gap-2 mb-3">

                                                        <i class="bi bi-award text-success"></i>

                                                        <div class="fw-semibold">
                                                            Beneficios activos
                                                        </div>

                                                    </div>

                                                    <div class="d-flex flex-wrap gap-2">

                                                        @foreach($persona->personaBeneficio as $beneficio)

                                                            @if($beneficio->activo && $beneficio->beneficio)

                                                                <span class="badge bg-success-subtle text-success border border-success-subtle">

                                                                    {{ $beneficio->beneficio->nombre }}

                                                                </span>

                                                            @endif

                                                        @endforeach

                                                    </div>

                                                </div>

                                            </div>

                                        @endif

                                    </div>

                                    {{-- FAMILIARES --}}
                                    @if($persona->grupoFamiliar && $persona->grupoFamiliar->count() > 0)

                                        @php
                                            // IDs de grupo_familiar que comparten núcleo con esta persona
                                            $nucleoIds = $persona->nucleosConvivientes?->pluck('id') ?? collect();
                                            $gfConvIds = collect();
                                            if ($nucleoIds->isNotEmpty()) {
                                                $gfConvIds = $persona->nucleosConvivientes
                                                    ->flatMap(fn($n) => $n->miembrosGrupoFamiliar->pluck('id'))
                                                    ->unique();
                                            }
                                            $convivientes = $persona->grupoFamiliar->filter(fn($f) => $gfConvIds->contains($f->id));
                                            $externos     = $persona->grupoFamiliar->reject(fn($f) => $gfConvIds->contains($f->id));
                                        @endphp

                                        <div class="mt-4 pt-4 border-top">

                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <i class="bi bi-people text-secondary"></i>
                                                <div class="fw-semibold">Familiares asociados</div>
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill">
                                                    {{ $persona->grupoFamiliar->count() }}
                                                </span>
                                            </div>

                                            {{-- CONVIVIENTES --}}
                                            @if($convivientes->isNotEmpty())
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <span class="badge rounded-pill px-3 py-1"
                                                              style="background:#e8f9f5; color:#0e8a70; border:1px solid #9fe1cb; font-size:11px; font-weight:700;">
                                                            <i class="bi bi-house-fill me-1" style="font-size:9px;"></i>
                                                            Núcleo conviviente
                                                        </span>
                                                        <span class="text-muted" style="font-size:11px;">
                                                            {{ $convivientes->count() }} {{ $convivientes->count() == 1 ? 'integrante' : 'integrantes' }}
                                                        </span>
                                                    </div>
                                                    <div class="row g-2">
                                                        @foreach($convivientes as $familiar)
                                                            <div class="col-md-6">
                                                                <div class="rounded-4 p-3 h-100"
                                                                     style="background:#f0fdf8; border:1px solid #9fe1cb;">
                                                                    <div class="fw-bold text-dark mb-1">
                                                                        {{ $familiar->nombre }}
                                                                    </div>
                                                                    <div class="small text-muted mb-1">
                                                                        <i class="bi bi-diagram-2 me-1"></i>
                                                                        {{ $familiar->relacion_titular ?? 'Sin parentesco registrado' }}
                                                                    </div>
                                                                    @if($familiar->fecha_nacimiento)
                                                                        <div class="small text-muted">
                                                                            <i class="bi bi-calendar-event me-1"></i>
                                                                            {{ \Carbon\Carbon::parse($familiar->fecha_nacimiento)->format('d/m/Y') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- EXTERNOS --}}
                                            @if($externos->isNotEmpty())
                                                <div>
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <span class="badge rounded-pill px-3 py-1"
                                                              style="background:#fffbeb; color:#b45309; border:1px solid #fcd34d; font-size:11px; font-weight:700;">
                                                            <i class="bi bi-people-fill me-1" style="font-size:9px;"></i>
                                                            Externos al domicilio
                                                        </span>
                                                        <span class="text-muted" style="font-size:11px;">
                                                            {{ $externos->count() }} {{ $externos->count() == 1 ? 'integrante' : 'integrantes' }}
                                                        </span>
                                                    </div>
                                                    <div class="row g-2">
                                                        @foreach($externos as $familiar)
                                                            <div class="col-md-6">
                                                                <div class="rounded-4 p-3 h-100"
                                                                     style="background:#fffdf5; border:1px solid #fcd34d;">
                                                                    <div class="fw-bold text-dark mb-1">
                                                                        {{ $familiar->nombre }}
                                                                    </div>
                                                                    <div class="small text-muted mb-1">
                                                                        <i class="bi bi-diagram-2 me-1"></i>
                                                                        {{ $familiar->relacion_titular ?? 'Sin parentesco registrado' }}
                                                                    </div>
                                                                    @if($familiar->fecha_nacimiento)
                                                                        <div class="small text-muted">
                                                                            <i class="bi bi-calendar-event me-1"></i>
                                                                            {{ \Carbon\Carbon::parse($familiar->fecha_nacimiento)->format('d/m/Y') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Fallback: sin núcleos cargados, muestra todos sin separación --}}
                                            @if($gfConvIds->isEmpty())
                                                <div class="row g-3">
                                                    @foreach($persona->grupoFamiliar as $familiar)
                                                        <div class="col-md-6">
                                                            <div class="border rounded-4 p-3 bg-light h-100">
                                                                <div class="fw-bold text-dark mb-1">
                                                                    {{ $familiar->nombre }}
                                                                </div>
                                                                <div class="small text-muted mb-1">
                                                                    <i class="bi bi-diagram-2 me-1"></i>
                                                                    {{ $familiar->relacion_titular ?? 'Sin parentesco registrado' }}
                                                                </div>
                                                                @if($familiar->fecha_nacimiento)
                                                                    <div class="small text-muted">
                                                                        <i class="bi bi-calendar-event me-1"></i>
                                                                        {{ \Carbon\Carbon::parse($familiar->fecha_nacimiento)->format('d/m/Y') }}
                                                                    </div>
                                                                @endif
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

        {{-- SIDEBAR --}}
        <div class="col-lg-4">

            {{-- INFORMACIÓN --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        Información general
                    </h5>

                    <div class="d-flex flex-column gap-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="small text-muted">
                                    Código familiar
                                </div>

                                <div class="fw-semibold">
                                    {{ $familia->codigo }}
                                </div>

                            </div>

                            <i class="bi bi-upc-scan fs-4 text-primary"></i>

                        </div>

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="small text-muted">
                                    Integrantes
                                </div>

                                <div class="fw-semibold">
                                    {{ $familia->personas->count() }}
                                </div>

                            </div>

                            <i class="bi bi-people fs-4 text-success"></i>

                        </div>

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="small text-muted">
                                    Entregas registradas
                                </div>

                                <div class="fw-semibold">
                                    {{ $familia->mercaderias->count() }}
                                </div>

                            </div>

                            <i class="bi bi-box-seam fs-4 text-warning"></i>

                        </div>

                    </div>

                </div>

            </div>

            {{-- HISTORIAL --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-2 mb-4">

                        <i class="bi bi-clock-history fs-5 text-primary"></i>

                        <h5 class="fw-bold mb-0">
                            Historial de mercadería
                        </h5>

                    </div>

                    @forelse($familia->mercaderias as $mercaderia)

                        <div class="border rounded-4 p-3 mb-3 bg-light">

                            <div class="d-flex justify-content-between align-items-start mb-2">

                                <div class="fw-bold">

                                    {{ \Carbon\Carbon::parse($mercaderia->fecha_entrega)->format('d/m/Y') }}

                                </div>

                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    Entregado
                                </span>

                            </div>

                            <div class="small text-muted">

                                <i class="bi bi-person-check me-1"></i>

                                Retiró:
                                {{ $mercaderia->apellido }}
                                {{ $mercaderia->nombre }}

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-4">

                            <i class="bi bi-inbox fs-1 text-muted"></i>

                            <div class="text-muted mt-2">
                                Sin entregas registradas
                            </div>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection