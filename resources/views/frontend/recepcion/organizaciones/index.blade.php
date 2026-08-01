@extends('frontend.recepcion.layout.app')

@section('title', 'Organizaciones')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-1">Organizaciones</h2>
            <p class="text-muted mb-0">Entidades que retiran mercadería para repartir</p>
        </div>
        <a href="{{ route('recepcion.organizaciones.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Nueva organización
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-body">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o CUIT/DNI..." value="{{ request('search') }}">
                <button class="btn btn-outline-primary">Buscar</button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>CUIT/DNI</th>
                        <th>Responsable</th>
                        <th>Teléfono</th>
                        <th>Cupo mensual</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($organizaciones as $org)
                        <tr>
                            <td class="fw-medium">{{ $org->nombre }}</td>
                            <td>{{ $org->cuit_dni ?? '-' }}</td>
                            <td>{{ $org->responsable ?? '-' }}</td>
                            <td>{{ $org->telefono ?? '-' }}</td>
                            <td>{{ $org->cupo_mensual ?? 'Sin límite' }}</td>
                            <td>
                                @if($org->activo)
                                    <span class="badge bg-success-subtle text-success">Activa</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Inactiva</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('recepcion.organizaciones.edit', $org->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No hay organizaciones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $organizaciones->links() }}
    </div>

</div>

@endsection
