@extends('frontend.recepcion.layout.app')

@section('title', 'Editar entrega')

@section('content')

<div class="container-fluid py-4" style="max-width: 900px;">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-1">Editar entrega</h2>
            <p class="text-muted mb-0">Modificar los datos del registro de la entrega mensual</p>
        </div>
    </div>

    {{-- ALERTAS --}}
    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center rounded-3 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- FORMULARIO --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('recepcion.mercaderias.update', $mercaderia->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="persona_id" id="personaId" value="{{ old('persona_id', $mercaderia->persona_id) }}">

                {{-- SECCIÓN: DATOS DE LA ENTREGA --}}
                <label class="form-label fw-bold text-secondary mb-3">Datos del retiro</label>
                
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label small text-muted mb-2">DNI</label>
                        <input type="text"
                            name="dni"
                            id="dniInput"
                            class="form-control"
                            value="{{ old('dni') }}"
                            placeholder="Ingrese DNI">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label small text-muted mb-1">Dirección</label>
                        <input type="text"
                            name="direccion"
                            id="direccionInput"
                            class="form-control"
                            value="{{ old('direccion', $mercaderia->direccion) }}"
                            placeholder="Ingrese dirección">
                    </div>
                </div>

                    <div class="col-md-6"></div> {{-- Espaciador --}}

                    <div class="col-md-6">
                        <label class="form-label small text-muted mb-1">Apellido</label>
                        <input type="text" name="apellido" id="apellidoInput" class="form-control" value="{{ old('apellido', $mercaderia->apellido) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted mb-1">Nombre</label>
                        <input type="text" name="nombre" id="nombreInput" class="form-control" value="{{ old('nombre', $mercaderia->nombre) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Fecha de entrega</label>
                        <input type="date" name="fecha_entrega" class="form-control" value="{{ old('fecha_entrega', $mercaderia->fecha_entrega ? \Carbon\Carbon::parse($mercaderia->fecha_entrega)->format('Y-m-d') : date('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label small text-muted mb-1">Observaciones</label>
                        <input type="text" name="observaciones" class="form-control" placeholder="Aclaraciones opcionales..." value="{{ old('observaciones', $mercaderia->observaciones) }}">
                    </div>
                </div>

                <hr class="my-4 text-muted">

                {{-- BOTONES --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('recepcion.mercaderias.index') }}" class="btn btn-light border px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-4 fw-medium">
                        <i class="bi bi-save me-1"></i> Guardar cambios
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection