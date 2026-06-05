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
            <a href="{{ route('recepcion.mercaderias.imprimir', request()->all()) }}"
               target="_blank"
               class="btn btn-outline-primary d-inline-flex align-items-center gap-2">
                <i class="bi bi-printer"></i>
                <span>Imprimir listado</span>
            </a>
            @if(empty($readonly))
                <a href="{{ route('recepcion.mercaderias.create') }}"
                   class="btn btn-success d-inline-flex align-items-center gap-2 shadow-sm fw-semibold">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Nueva entrega</span>
                </a>
            @endif
        </div>
    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                <div class="row g-3">
                    {{-- Buscador Principal --}}
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
                            @if(request('search') || request('tipo_filtro') || request('mes') || request('anio'))
                                <a href="{{ $actionRoute }}"
                                   class="btn btn-outline-secondary border-start-0 d-inline-flex align-items-center"
                                   title="Limpiar filtros">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                            <button class="btn btn-primary px-4 fw-semibold" type="submit">Buscar</button>
                        </div>
                    </div>

                    {{-- Selects de Filtros Avanzados (Se envían al cambiar o al dar Buscar) --}}
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-medium">Período</label>
                        <select name="tipo_filtro" class="form-select select-filter">
                            <option value="">Todos</option>
                            <option value="mes" {{ request('tipo_filtro') == 'mes' ? 'selected' : '' }}>Mes</option>
                            <option value="semana" {{ request('tipo_filtro') == 'semana' ? 'selected' : '' }}>Semana actual</option>
                            <option value="anio" {{ request('tipo_filtro') == 'anio' ? 'selected' : '' }}>Año</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-medium">Mes</label>
                        <select name="mes" class="form-select select-filter">
                            <option value="">Seleccionar mes...</option>
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}>
                                    {{ Str::ucfirst(\Carbon\Carbon::create()->month($i)->locale('es')->monthName) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-medium">Año</label>
                        <select name="anio" class="form-select select-filter">
                            @for($i = now()->year; $i >= 2023; $i--)
                                <option value="{{ $i }}" {{ request('anio', now()->year) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">

                        <button type="submit"
                                class="btn btn-primary w-100">
                            <i class="bi bi-funnel-fill me-1"></i>
                            Aplicar
                        </button>

                        <a href="{{ route(empty($readonly)
                                    ? 'recepcion.mercaderias.index'
                                    : 'panel.mercaderias.index') }}"
                        class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>

                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- RECUENTO TOTAL --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-secondary small">
            <strong>Total entregas encontradas:</strong> 
            <span class="badge bg-info text-dark px-2 py-1 fs-6 ms-1">{{ $mercaderias->total() ?? $mercaderias->count() }}</span>
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
                            <th width="180">Habilitado desde</th>
                            <th width="150">Estado</th>
                            <th class="pe-4">Registrado por</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mercaderias as $m)
                            {{-- NOTA: Lo ideal es pasar estas variables calculadas desde el Controlador --}}
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
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
            
            {{-- PAGINACIÓN (Si se usa paginate() en el controlador) --}}
            @if(method_exists($mercaderias, 'links'))
                <div class="card-footer bg-white border-0 py-3 structure-pagination">
                    {{ $mercaderias->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

@endsection

{{-- SCRIPT OPCIONAL PARA AUTO-ENVIAR AL CAMBIAR LOS SELECTS --}}
@section('scripts')
<script>
    document.querySelectorAll('.select-filter').forEach(select => {
        select.addEventListener('change', () => {
            document.getElementById('filter-form').submit();
        });
    });
</script>
@endsection