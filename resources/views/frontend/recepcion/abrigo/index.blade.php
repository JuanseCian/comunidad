@extends('frontend.recepcion.layout.app')

@section('title', 'Colchones y frazadas')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Colchones y frazadas</h2>
            <p class="text-muted small mb-0">Registro y control de entregas de abrigo.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('recepcion.abrigo.imprimir', request()->query()) }}" target="_blank" class="btn btn-outline-primary">
                <i class="bi bi-printer me-1"></i> Imprimir
            </a>
            <a href="{{ route('recepcion.abrigo.create') }}" class="btn btn-success fw-semibold">
                <i class="bi bi-plus-circle me-1"></i> Nueva entrega
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('recepcion.abrigo.index') }}" class="row g-3 align-items-end">
                <div class="col-lg-4">
                    <label class="form-label small text-muted fw-semibold">Buscar persona o DNI</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Nombre, apellido o DNI...">
                </div>
                <div class="col-sm-3 col-lg-2">
                    <label class="form-label small text-muted fw-semibold">Producto</label>
                    <select name="producto" class="form-select">
                        <option value="">Todos</option>
                        <option value="colchones" @selected(request('producto') === 'colchones')>Colchones</option>
                        <option value="frazadas" @selected(request('producto') === 'frazadas')>Frazadas</option>
                    </select>
                </div>
                <div class="col-sm-3 col-lg-2">
                    <label class="form-label small text-muted fw-semibold">Desde</label>
                    <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                </div>
                <div class="col-sm-3 col-lg-2">
                    <label class="form-label small text-muted fw-semibold">Hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                </div>
                <div class="col-sm-3 col-lg-2 d-flex gap-2">
                    <button class="btn btn-primary flex-grow-1"><i class="bi bi-funnel me-1"></i> Filtrar</button>
                    <a href="{{ route('recepcion.abrigo.index') }}" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-arrow-counterclockwise"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Persona</th>
                        <th>Familia</th>
                        <th class="text-center">Colchones</th>
                        <th class="text-center">Frazadas</th>
                        <th>Fecha</th>
                        <th>Registrado por</th>
                        <th class="text-center pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entregas as $entrega)
                        <tr>
                            <td class="ps-4"><span class="badge bg-light text-secondary border">#{{ $entrega->id }}</span></td>
                            <td>
                                <div class="fw-semibold">{{ $entrega->apellido }}, {{ $entrega->nombre }}</div>
                                @if($entrega->dni)<small class="text-muted">DNI: {{ $entrega->dni }}</small>@endif
                            </td>
                            <td>
                                @if($entrega->familia)
                                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">Familia #{{ $entrega->familia->id }}</span>
                                @else
                                    <span class="text-muted small">Sin familia</span>
                                @endif
                            </td>
                            <td class="text-center"><span class="badge bg-info-subtle text-info-emphasis">{{ $entrega->colchones }}</span></td>
                            <td class="text-center"><span class="badge bg-warning-subtle text-warning-emphasis">{{ $entrega->frazadas }}</span></td>
                            <td>{{ $entrega->fecha_entrega->format('d/m/Y') }}</td>
                            <td class="small text-muted">{{ $entrega->usuario->username ?? 'Sistema' }}</td>
                            <td class="text-center pe-4">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('recepcion.abrigo.show', $entrega) }}" class="btn btn-outline-primary" title="Ver"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('recepcion.abrigo.edit', $entrega) }}" class="btn btn-outline-warning" title="Editar"><i class="bi bi-pencil"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-5">No hay entregas de abrigo registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($entregas->total() > 0)
            <div class="card-footer bg-white border-top d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <small class="text-muted">Mostrando {{ $entregas->firstItem() }} a {{ $entregas->lastItem() }} de {{ $entregas->total() }}</small>
                {{ $entregas->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
