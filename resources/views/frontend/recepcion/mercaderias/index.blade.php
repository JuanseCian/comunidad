@extends('frontend.recepcion.layout.app')

@section('title', 'Mercadería')

@section('content')

<div class="container-fluid py-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Mercadería</h2>
            <p class="text-muted small mb-0">
                Registro y control de entregas de módulos alimentarios o asistencia mensual
            </p>
        </div>
        <a href="{{ route('recepcion.mercaderias.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2 shadow-sm fw-semibold px-3">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Nueva entrega</span>
        </a>
    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- BUSCADOR OPTIMIZADO --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('recepcion.mercaderias.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold text-secondary small mb-2">Buscar beneficiario</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" 
                                   name="search" 
                                   class="form-control border-start-0 ps-0" 
                                   placeholder="Escribí el nombre, apellido o DNI de la persona..." 
                                   value="{{ request('search') }}">
                            @if(request('search'))
                                <a href="{{ route('recepcion.mercaderias.index') }}" class="btn btn-outline-secondary border-start-0 d-inline-flex align-items-center" title="Limpiar búsqueda">
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
                            <th>Persona</th>
                            <th>Grupo Familiar</th>
                            <th width="140">Fecha Entrega</th>
                            <th width="160">Próximo Retiro</th>
                            <th width="150">Estado</th>
                            <th class="pe-4">Registrado por</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mercaderias as $m)
                            @php
                                $fechaEntrega = \Carbon\Carbon::parse($m->fecha_entrega);
                                // PLAZO DE 30 DÍAS
                                $proximoRetiro = $fechaEntrega->copy()->addDays(30);
                                $puedeRetirar = now()->greaterThanOrEqualTo($proximoRetiro);
                            @endphp
                            <tr>
                                {{-- ID --}}
                                <td class="ps-4 text-center">
                                    <span class="badge bg-light text-secondary border fw-bold px-2 py-1.5">
                                        #{{ $m->id }}
                                    </span>
                                </td>

                                {{-- PERSONA --}}
                                <td>
                                    <div class="fw-semibold text-dark mb-0">
                                        {{ $m->apellido }}, {{ $m->nombre }}
                                    </div>
                                    @if($m->dni)
                                        <small class="text-muted d-block mt-0.5">
                                            <span class="fw-medium text-secondary">DNI:</span> {{ $m->dni }}
                                        </small>
                                    @endif
                                </td>

                                {{-- FAMILIA --}}
                                <td>
                                    @if($m->familia)
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-2 py-1.5 fw-semibold">
                                            <i class="bi bi-house-heart me-1"></i> Familia #{{ $m->familia->id }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-muted border px-2 py-1.5 fw-normal fs-7">
                                            Sin grupo familiar
                                        </span>
                                    @endif
                                </td>

                                {{-- FECHA --}}
                                <td>
                                    <div class="d-flex align-items-center text-dark small">
                                        <i class="bi bi-calendar-check text-muted me-2"></i>
                                        <span>{{ $fechaEntrega->format('d/m/Y') }}</span>
                                    </div>
                                </td>

                                {{-- PRÓXIMO RETIRO --}}
                                <td>
                                    <div class="d-flex align-items-center text-dark small fw-medium">
                                        <i class="bi bi-calendar-date text-muted me-2"></i>
                                        <span>{{ $proximoRetiro->format('d/m/Y') }}</span>
                                    </div>
                                </td>

                                {{-- ESTADO (Badge semántico moderno) --}}
                                <td>
                                    @if($puedeRetirar)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1">
                                            <span class="spinner-grow spinner-grow-sm text-success" role="status" style="width: 0.5rem; height: 0.5rem;"></span>
                                            Habilitado
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-clock-history fs-7"></i>
                                            En espera
                                        </span>
                                    @endif
                                </td>

                                {{-- USUARIO --}}
                                <td class="pe-4">
                                    <span class="text-secondary d-inline-flex align-items-center gap-1.5 small">
                                        <i class="bi bi-person-circle text-muted fs-6"></i>
                                        {{ $m->usuario->username ?? 'Usuario' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center py-3">
                                        <i class="bi bi-box-seam text-muted mb-3" style="font-size: 3rem;"></i>
                                        <h5 class="fw-semibold text-secondary mb-1">No hay entregas registradas</h5>
                                        <p class="text-muted small mb-0">
                                            Las asistencias y entregas de mercadería mensuales figurarán en esta sección.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection