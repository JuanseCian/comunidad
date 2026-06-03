@extends('frontend.recepcion.layout.app')

@section('title', 'Listado de Sepelios')

@section('content')

<div class="container-fluid py-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Sepelios</h2>
            <p class="text-muted small mb-0">
                Registro y control de asistencia funeraria, solicitudes de sepelio y cremaciones
            </p>
        </div>
        @if(empty($readonly))
            <a href="{{ route('recepcion.sepelios.create') }}"
               class="btn btn-success d-inline-flex align-items-center gap-2 shadow-sm fw-semibold px-3">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Nuevo trámite</span>
            </a>
        @endif
    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- BUSCADOR --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ empty($readonly) ? route('recepcion.sepelios.index') : route('panel.sepelios.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold text-secondary small mb-2">Buscar registro</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text"
                                   name="search"
                                   class="form-control border-start-0 ps-0"
                                   placeholder="Escribí el nombre/DNI del solicitante o de la persona fallecida..."
                                   value="{{ request('search') }}">
                            @if(request('search'))
                                <a href="{{ route('recepcion.sepelios.index') }}" class="btn btn-outline-secondary border-start-0 d-inline-flex align-items-center">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                            <button class="btn btn-primary px-4 fw-semibold" type="submit">Buscar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLA --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase fs-7 text-muted border-bottom">
                        <tr>
                            <th width="90" class="ps-4 text-center">ID</th>
                            <th>Solicitante</th>
                            <th>Fallecido</th>
                            <th>Origen Cobertura</th>
                            <th>Servicio Prestado</th>
                            <th>Costo</th>
                            <th class="pe-4">Registrado por</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sepelios as $s)
                            <tr>
                                <td class="ps-4 text-center">
                                    <span class="badge bg-light text-secondary border fw-bold px-2 py-1">
                                        #{{ $s->id }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $s->apellido }}, {{ $s->nombre }}</div>
                                    @if($s->dni)
                                        <small class="text-muted"><span class="fw-medium">DNI:</span> {{ $s->dni }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $s->fallecido_nombre }}</div>
                                    @if($s->fallecido_dni)
                                        <small class="text-muted"><span class="fw-medium">DNI:</span> {{ $s->fallecido_dni }}</small>
                                    @endif
                                </td>
                                <td class="text-capitalize">
                                    <span class="badge {{ $s->tipo_sepelio === 'municipal' ? 'bg-info-subtle text-info-emphasis border-info-subtle' : 'bg-dark-subtle text-dark-emphasis border-dark-subtle' }} border px-2 py-1 fw-semibold">
                                        {{ $s->tipo_sepelio }}
                                    </span>
                                </td>
                                <td>
                                    @if($s->categoria_servicio === 'cremacion')
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1 fw-semibold">
                                            <i class="bi bi-fire me-1"></i> Cremación
                                        </span>
                                    @else
                                        <span class="badge bg-primary-subtle text-primary-emphasis border border-primary-subtle px-2 py-1 fw-semibold text-capitalize">
                                            {{ str_replace('_', ' ', $s->categoria_servicio ?? 'Sepelio') }}
                                        </span>
                                        @if($s->mantenimiento)
                                            <small class="d-block text-success mt-1"><i class="bi bi-check-circle-fill me-1"></i>Mantenimiento</small>
                                        @endif
                                    @endif
                                </td>
                                <td class="fw-bold text-dark">
                                    {{ $s->costo ? '$' . number_format($s->costo, 2, ',', '.') : 'S/C' }}
                                </td>
                                <td class="pe-4">
                                    <span class="text-secondary d-inline-flex align-items-center gap-1 small">
                                        <i class="bi bi-person-circle text-muted fs-6"></i>
                                        {{ $s->usuario->username ?? 'Sistema' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center py-3">
                                        <i class="bi bi-journal-x text-muted mb-3" style="font-size:3rem;"></i>
                                        <h5 class="fw-semibold text-secondary mb-1">No hay trámites de sepelio</h5>
                                        <p class="text-muted small">Las solicitudes cargadas figurarán en esta sección.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-3">
        {{ $sepelios->appends(request()->query())->links() }}
    </div>
</div>

@endsection