@extends('frontend.recepcion.layout.app')

@section('title', 'Nueva organización')

@section('content')

<div class="container-fluid py-4" style="max-width: 700px;">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Nueva organización</h2>
        <p class="text-muted mb-0">Registrar entidad que retira mercadería para repartir</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger rounded-3 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('recepcion.organizaciones.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label small text-muted mb-1">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">CUIT / DNI</label>
                        <input type="text" name="cuit_dni" class="form-control" value="{{ old('cuit_dni') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted mb-1">Responsable</label>
                        <input type="text" name="responsable" class="form-control" value="{{ old('responsable') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted mb-1">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                    </div>

                    <div class="col-md-8">
                        <label class="form-label small text-muted mb-1">Dirección</label>
                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Cupo mensual de bolsones</label>
                        <input type="number" name="cupo_mensual" min="1" class="form-control" value="{{ old('cupo_mensual') }}" placeholder="Sin límite">
                    </div>
                </div>

                <hr class="my-4 text-muted">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('recepcion.organizaciones.index') }}" class="btn btn-light border px-4">Cancelar</a>
                    <button type="submit" class="btn btn-success px-4 fw-medium">
                        <i class="bi bi-check2-circle me-1"></i> Guardar organización
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
