@extends('frontend.recepcion.layout.app')

@section('title', 'Detalle de entrega')

@section('content')

<div class="container-fluid py-4" style="max-width: 900px;">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detalle de entrega</h2>
            <p class="text-muted mb-0">Información del registro de mercadería entregada</p>
        </div>
        <div>
            <a href="{{ route('recepcion.mercaderias.edit', $mercaderia->id) }}" class="btn btn-warning px-3 fw-medium">
                <i class="bi bi-pencil-square me-1"></i> Editar
            </a>
        </div>
    </div>

    {{-- VISTA DE DATOS --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <label class="form-label fw-bold text-secondary mb-3">Datos del retiro</label>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small text-muted mb-1">DNI</label>
                    <input type="text" class="form-control bg-light" value="{{ $mercaderia->dni ?? 'S/D' }}" disabled>
                </div>

                <div class="col-md-6">
                    <label class="form-label small text-muted mb-1">Dirección</label>
                    <input type="text"
                        name="direccion"
                        id="direccionInput"
                        class="form-control"
                        value="{{ old('direccion', $mercaderia->direccion) }}"
                        placeholder="Ingrese dirección" disabled>
                </div>

                <div class="col-md-6">
                    @if($mercaderia->persona_id)
                        <label class="form-label small text-muted mb-1">ID de Persona Vinculada</label>
                        <div>
                            <span class="badge bg-success-subtle text-success fs-6 px-3 py-2 rounded-3">
                                <i class="bi bi-person-check-fill me-1"></i> Persona #{{ $mercaderia->persona_id }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <label class="form-label small text-muted mb-1">Apellido</label>
                    <input type="text" class="form-control bg-light" value="{{ $mercaderia->apellido }}" disabled>
                </div>

                <div class="col-md-6">
                    <label class="form-label small text-muted mb-1">Nombre</label>
                    <input type="text" class="form-control bg-light" value="{{ $mercaderia->nombre }}" disabled>
                </div>

                <div class="col-md-4">
                    <label class="form-label small text-muted mb-1">Fecha de entrega</label>
                    <input type="text" class="form-control bg-light" value="{{ \Carbon\Carbon::parse($mercaderia->fecha_entrega)->format('d/m/Y') }}" disabled>
                </div>

                <div class="col-md-8">
                    <label class="form-label small text-muted mb-1">Observaciones</label>
                    <textarea class="form-control bg-light" rows="1" disabled>{{ $mercaderia->observaciones ?? 'Sin observaciones.' }}</textarea>
                </div>
            </div>

            <hr class="my-4 text-muted">

            {{-- BOTONES --}}
            <div class="d-flex justify-content-end">
                <a href="{{ route('recepcion.mercaderias.index') }}" class="btn btn-light border px-4">
                    <i class="bi bi-arrow-left me-1"></i> Volver al listado
                </a>
            </div>

        </div>
    </div>

</div>

@endsection