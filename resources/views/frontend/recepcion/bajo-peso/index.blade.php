@extends('frontend.recepcion.layout.app')

@section('title', 'Programa Bajo Peso')

@section('content')

<div class="container-fluid py-4">

    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-heart-pulse-fill text-warning me-2"></i>
                Programa Bajo Peso
            </h2>

            <p class="text-muted mb-0">
                Seguimiento y control de beneficiarios.
            </p>
        </div>

        <a href="{{ route('bajo-peso.create') }}"
           class="btn btn-warning shadow-sm">

            <i class="bi bi-plus-circle me-1"></i>
            Nuevo Beneficiario
        </a>

    </div>

    {{-- RESUMEN --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted text-uppercase">
                        Total Beneficiarios
                    </small>

                    <h3 class="fw-bold mb-0">
                        {{ $beneficiarios->total() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted text-uppercase">
                        Activos
                    </small>

                    <h3 class="fw-bold text-success mb-0">
                        {{ $beneficiarios->where('activo',1)->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted text-uppercase">
                        Inactivos
                    </small>

                    <h3 class="fw-bold text-danger mb-0">
                        {{ $beneficiarios->where('activo',0)->count() }}
                    </h3>
                </div>
            </div>
        </div>

    </div>

    {{-- TABLA --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">
            <h6 class="mb-0 fw-semibold">
                Listado de Beneficiarios
            </h6>
        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th>#</th>
                        <th>Beneficiario</th>
                        <th>Tutor Responsable</th>
                        <th>Diagnóstico</th>
                        <th>Entregas</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($beneficiarios as $item)

                        <tr>

                            <td>
                                <span class="fw-semibold">
                                    {{ $item->id }}
                                </span>
                            </td>

                            <td>

                                <div class="fw-semibold">
                                    {{ $item->persona?->apellido }},
                                    {{ $item->persona?->nombre }}
                                </div>

                                <small class="text-muted">
                                    DNI:
                                    {{ $item->persona?->dni ?? 'Sin DNI' }}
                                </small>

                            </td>

                            <td>

                                <div class="fw-semibold">
                                    {{ $item->tutor_nombre ?? '-' }}
                                </div>

                                <small class="text-muted">
                                    {{ $item->tutor_parentezco ?? '' }}
                                </small>

                            </td>

                            <td>

                                <span title="{{ $item->diagnostico }}">
                                    {{ \Illuminate\Support\Str::limit($item->diagnostico, 60) }}
                                </span>

                            </td>

                            <td>

                                <span class="badge bg-primary">
                                    {{ $item->entregas->count() }}
                                </span>

                            </td>

                            <td>

                                @if($item->activo)

                                    <span class="badge bg-success">
                                        Activo
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Inactivo
                                    </span>

                                @endif

                            </td>

                            <td>

                                <div class="d-flex justify-content-end gap-1">

                                    <a href="{{ route('bajo-peso.show', $item->id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Ver">

                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('bajo-peso.edit', $item->id) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Editar">

                                        <i class="bi bi-pencil"></i>
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center py-5">

                                <div class="text-muted">

                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                                    No existen beneficiarios registrados.

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $beneficiarios->links() }}
    </div>

</div>

@endsection