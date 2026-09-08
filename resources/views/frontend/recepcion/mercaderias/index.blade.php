@extends('frontend.recepcion.layout.app')

@section('title', 'Mercadería')

@section('content')

<div class="container-fluid py-4">

    {{-- CABECERA --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Mercadería</h2>
            <p class="text-muted small mb-0">
                Registro y control de entregas de módulos alimentarios o asistencia mensual
            </p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('recepcion.mercaderias.imprimir', request()->only(['search', 'tipo_filtro', 'mes', 'anio'])) }}"
               target="_blank"
               class="btn btn-outline-primary d-inline-flex align-items-center gap-2">
                <i class="bi bi-printer"></i>
                <span>Imprimir listado</span>
            </a>
            @if(empty($readonly))
                <a href="{{ route('recepcion.organizaciones.index') }}"
                   class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                    <i class="bi bi-building"></i>
                    <span>Organizaciones</span>
                </a>
                <a href="{{ route('recepcion.mercaderias.create') }}"
                   class="btn btn-success d-inline-flex align-items-center gap-2 shadow-sm fw-semibold">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Nueva entrega</span>
                </a>
            @endif
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- FORMULARIO DE BÚSQUEDA Y FILTROS UNIFICADOS --}}
    @php
        $actionRoute = empty($readonly) ? route('recepcion.mercaderias.index') : route('panel.mercaderias.index');
    @endphp

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ $actionRoute }}" id="filter-form">
                @php
                    $tipoFiltroActual = $tipoFiltro ?? request('tipo_filtro');
                    $mesActual = $mes ?? request('mes');
                    $anioActual = $anio ?? request('anio');
                    $hayFiltros = request()->filled('search') || in_array($tipoFiltroActual, ['mes', 'semana', 'anio'], true);
                @endphp
                <div class="row g-3 align-items-end">
                    {{-- Buscador Principal --}}
                    <div class="col-12">
                        <label for="search" class="form-label fw-semibold text-secondary small mb-2">Buscar por persona o DNI</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text"
                                   name="search"
                                   id="search"
                                   class="form-control border-start-0 ps-0"
                                   placeholder="Nombre, apellido o DNI..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    {{-- Filtros de fecha --}}
                    <div class="col-lg-4">
                        <label for="tipo_filtro" class="form-label text-secondary small fw-semibold">Filtrar por período</label>
                        <select name="tipo_filtro" id="tipo_filtro" class="form-select">
                            <option value="">Todas las fechas</option>
                            <option value="mes" {{ $tipoFiltroActual === 'mes' ? 'selected' : '' }}>Un mes específico</option>
                            <option value="semana" {{ $tipoFiltroActual === 'semana' ? 'selected' : '' }}>Semana actual</option>
                            <option value="anio" {{ $tipoFiltroActual === 'anio' ? 'selected' : '' }}>Un año específico</option>
                        </select>
                    </div>

                    <div class="col-lg-3 period-field" data-periods="mes">
                        <label for="mes" class="form-label text-secondary small fw-semibold">Mes</label>
                        <select name="mes" id="mes" class="form-select">
                            <option value="">Elegí un mes</option>
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ $i }}" {{ $mesActual == $i ? 'selected' : '' }}>
                                    {{ Str::ucfirst(\Carbon\Carbon::create()->month($i)->locale('es')->monthName) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-lg-3 period-field" data-periods="mes,anio">
                        <label for="anio" class="form-label text-secondary small fw-semibold">Año</label>
                        <select name="anio" id="anio" class="form-select">
                            <option value="">Elegí un año</option>
                            @for($i = now()->year; $i >= 2023; $i--)
                                <option value="{{ $i }}" {{ ($anioActual ?: now()->year) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-lg-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1 fw-semibold">
                            <i class="bi bi-funnel-fill me-1"></i>
                            Aplicar filtros
                        </button>
                    </div>
                </div>
            </form>
            @if($hayFiltros)
                <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-3 border-top">
                    <span class="small text-muted fw-semibold">Filtros activos:</span>
                    @if(request('search'))
                        <span class="badge rounded-pill bg-light text-dark border">Búsqueda: {{ request('search') }}</span>
                    @endif
                    @if($tipoFiltroActual === 'mes' && $mesActual)
                        <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis border border-primary-subtle">
                            {{ Str::ucfirst(\Carbon\Carbon::create()->month($mesActual)->locale('es')->monthName) }} {{ $anioActual ?: now()->year }}
                        </span>
                    @elseif($tipoFiltroActual === 'anio')
                        <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis border border-primary-subtle">Año {{ $anioActual ?: now()->year }}</span>
                    @elseif($tipoFiltroActual === 'semana')
                        <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis border border-primary-subtle">Semana actual</span>
                    @endif
                    <a href="{{ $actionRoute }}" class="small text-decoration-none ms-1">Limpiar filtros</a>
                </div>
            @endif
        </div>
    </div>

    {{-- TABLA --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 px-4 py-3 border-bottom">
                <span class="small text-muted">Ordenado por fecha de entrega, más recientes primero</span>
                @if($mercaderias->total() > 0)
                    <span class="badge bg-light text-secondary border">{{ $mercaderias->total() }} {{ $mercaderias->total() === 1 ? 'entrega' : 'entregas' }}</span>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase fs-7 text-muted border-bottom">
                        <tr>
                            <th width="90" class="ps-4 text-center">ID</th>
                            <th>Persona</th>
                            <th>Grupo Familiar</th>
                            <th width="140">Fecha Entrega</th>
                            <th width="180">Habilitado desde</th>
                            <th width="150">Estado</th>
                            <th class="pe-4">Registrado por</th>
                            <th width="120" class="text-center pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mercaderias as $m)
                            @php
                                $fechaEntrega = \Carbon\Carbon::parse($m->fecha_entrega);
                                $habilitadoDesde = $fechaEntrega->copy()->addMonthNoOverflow()->startOfMonth();
                                $puedeRetirar = now()->greaterThanOrEqualTo($habilitadoDesde);
                            @endphp
                            <tr>
                                {{-- ID --}}
                                <td class="ps-4 text-center">
                                    <span class="badge bg-light text-secondary border fw-bold px-2 py-1">
                                        #{{ $m->id }}
                                    </span>
                                </td>

                                {{-- PERSONA --}}
                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ $m->apellido }}, {{ $m->nombre }}
                                    </div>
                                    @if($m->dni)
                                        <small class="text-muted block">
                                            <span class="fw-medium text-secondary">DNI:</span> {{ $m->dni }}
                                        </small>
                                    @endif
                                </td>

                                {{-- FAMILIA --}}
                                <td>
                                    @if($m->familia)
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-2 py-1 fw-semibold">
                                            <i class="bi bi-house-heart me-1"></i>Familia #{{ $m->familia->id }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-muted border px-2 py-1 fw-normal">
                                            Sin grupo familiar
                                        </span>
                                    @endif
                                </td>

                                {{-- FECHA ENTREGA --}}
                                <td>
                                    <div class="d-flex align-items-center text-dark small">
                                        <i class="bi bi-calendar-check text-muted me-2"></i>
                                        {{ $fechaEntrega->format('d/m/Y') }}
                                    </div>
                                </td>

                                {{-- HABILITADO DESDE --}}
                                <td>
                                    <div class="d-flex align-items-center text-dark small fw-medium">
                                        <i class="bi bi-calendar-date text-muted me-2"></i>
                                        {{ $habilitadoDesde->format('d/m/Y') }}
                                    </div>
                                </td>

                                {{-- ESTADO --}}
                                <td>
                                    @if($puedeRetirar)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fw-semibold d-inline-flex align-items-center gap-1">
                                            <span class="spinner-grow spinner-grow-sm text-success" role="status" style="width:.5rem;height:.5rem;"></span>
                                            Habilitado
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fw-semibold d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-clock-history"></i>
                                            En espera
                                        </span>
                                    @endif
                                </td>

                                {{-- USUARIO --}}
                                <td class="pe-4">
                                    <span class="text-secondary d-inline-flex align-items-center gap-1 small">
                                        <i class="bi bi-person-circle text-muted fs-6"></i>
                                        {{ $m->usuario->username ?? 'Usuario' }}
                                    </span>
                                </td>

                                {{-- ACCIONES --}}
                                <td class="text-center pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('recepcion.mercaderias.show', $m) }}"
                                           class="btn btn-outline-primary"
                                           title="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('recepcion.mercaderias.edit', $m) }}"
                                           class="btn btn-outline-warning"
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center py-3">
                                        <i class="bi bi-box-seam text-muted mb-3" style="font-size:3rem;"></i>
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

        {{-- PIE DE TABLA CON PAGINACIÓN --}}
        @if(method_exists($mercaderias, 'links') && $mercaderias->total() > 0)
            <div class="card-footer bg-white border-top py-3 px-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div class="text-muted small text-center text-md-start">
                        Mostrando <strong>{{ $mercaderias->firstItem() }}</strong> a <strong>{{ $mercaderias->lastItem() }}</strong> de <strong>{{ $mercaderias->total() }}</strong> entregas
                    </div>
                    <div class="pagination-container">
                        {{ $mercaderias->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

</div>

<style>
    /* Estilos limpios para la paginación Bootstrap */
    .pagination-container .pagination {
        margin-bottom: 0 !important;
        gap: 3px;
    }
    .pagination-container .page-item .page-link {
        border-radius: 6px !important;
        font-size: 0.85rem;
        padding: 0.35rem 0.75rem;
        color: #4b5563;
        border: 1px solid #dee2e6;
        box-shadow: none !important;
    }
    .pagination-container .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
    }
    .pagination-container .page-item.disabled .page-link {
        background-color: #f8f9fa;
        color: #adb5bd;
    }

    /* Ocultamos el bloque de texto duplicado nativo que inserta el template de Bootstrap de Laravel */
    .pagination-container nav > div:first-child {
        display: none !important;
    }
</style>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const periodSelect = document.getElementById('tipo_filtro');
        const monthSelect = document.getElementById('mes');
        const yearSelect = document.getElementById('anio');

        function updatePeriodFields() {
            const period = periodSelect.value;

            document.querySelectorAll('.period-field').forEach(field => {
                const visible = field.dataset.periods.split(',').includes(period);
                field.classList.toggle('d-none', !visible);
            });

            monthSelect.disabled = period !== 'mes';
            yearSelect.disabled = !['mes', 'anio'].includes(period);
            monthSelect.required = period === 'mes';
            yearSelect.required = ['mes', 'anio'].includes(period);
        }

        periodSelect.addEventListener('change', updatePeriodFields);
        updatePeriodFields();
    });
</script>
@endpush
