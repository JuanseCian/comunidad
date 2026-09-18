@extends('frontend.recepcion.layout.app')

@section('title', 'Detalle de entrega de abrigo')

@section('content')
<div class="container-fluid py-4" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detalle de entrega de abrigo</h2>
            <p class="text-muted mb-0">Registro #{{ $abrigo->id }}</p>
        </div>
        <a href="{{ route('recepcion.abrigo.edit', $abrigo) }}" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Editar</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6"><small class="text-muted d-block">Persona</small><strong>{{ $abrigo->apellido }}, {{ $abrigo->nombre }}</strong></div>
                <div class="col-md-6"><small class="text-muted d-block">DNI</small><span>{{ $abrigo->dni ?: 'S/D' }}</span></div>
                <div class="col-md-6"><small class="text-muted d-block">Dirección</small><span>{{ $abrigo->direccion ?: 'Sin informar' }}</span></div>
                <div class="col-md-6"><small class="text-muted d-block">Familia</small><span>{{ $abrigo->familia ? '#'.$abrigo->familia->id : 'Sin familia' }}</span></div>
                <div class="col-md-4"><small class="text-muted d-block">Colchones</small><strong class="fs-4">{{ $abrigo->colchones }}</strong></div>
                <div class="col-md-4"><small class="text-muted d-block">Frazadas</small><strong class="fs-4">{{ $abrigo->frazadas }}</strong></div>
                <div class="col-md-4"><small class="text-muted d-block">Fecha de entrega</small><span>{{ $abrigo->fecha_entrega->format('d/m/Y') }}</span></div>
                <div class="col-12"><small class="text-muted d-block">Observaciones</small><span>{{ $abrigo->observaciones ?: 'Sin observaciones.' }}</span></div>
            </div>
            <hr class="my-4">
            <div class="d-flex justify-content-end"><a href="{{ route('recepcion.abrigo.index') }}" class="btn btn-light border"><i class="bi bi-arrow-left me-1"></i> Volver al listado</a></div>
        </div>
    </div>
</div>
@endsection
