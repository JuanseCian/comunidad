@extends('frontend.recepcion.layout.app')

@section('title', 'Editar Beneficiario Bajo Peso')

@section('content')

<div class="container-fluid py-4">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-bold mb-0 text-gray-800">
                <i class="bi bi-pencil-square text-warning me-2"></i>Editar Registro: {{ $bajoPeso->persona->nombre }}
            </h2>
            <p class="text-muted mb-0 ms-4 ps-1">
                Modifique los datos médicos o la información del tutor.
            </p>
        </div>
        <a href="{{ route('bajo-peso.show', $bajoPeso->id) }}" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle me-1"></i> Cancelar
        </a>
    </div>

    {{-- Alertas de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Corregí los siguientes errores:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('bajo-peso.update', $bajoPeso->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- ── DATOS DEL BENEFICIARIO ── --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="card-title text-uppercase text-muted fw-bold mb-0">1. Datos del Beneficiario</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">DNI</label>
                                <input type="text" name="dni" class="form-control" value="{{ old('dni', $bajoPeso->persona->dni) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Apellido</label>
                                <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $bajoPeso->persona->apellido) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nombre</label>
                                <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $bajoPeso->persona->nombre) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Fecha Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $bajoPeso->persona->fecha_nacimiento ? \Carbon\Carbon::parse($bajoPeso->persona->fecha_nacimiento)->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-muted">Edad</label>
                                <input type="text" id="edad" class="form-control bg-light" value="{{ $bajoPeso->persona->edad }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-muted">Cód. Familia</label>
                                <input type="text" class="form-control bg-light" value="{{ $bajoPeso->persona->familia->codigo ?? 'N/A' }}" readonly>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="text-uppercase text-muted fw-bold mb-3">2. Información Médica</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="diagnostico" class="form-label fw-semibold">Diagnóstico Inicial</label>
                                <textarea name="diagnostico" rows="3" class="form-control">{{ old('diagnostico', $bajoPeso->diagnostico) }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="tratamiento" class="form-label fw-semibold">Tratamiento</label>
                                <textarea name="tratamiento" rows="3" class="form-control">{{ old('tratamiento', $bajoPeso->tratamiento) }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="observaciones" class="form-label fw-semibold">Observaciones</label>
                                <textarea name="observaciones" rows="2" class="form-control">{{ old('observaciones', $bajoPeso->observaciones) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── COLUMNA DERECHA ── --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white pt-4">
                        <h6 class="card-title text-uppercase text-muted fw-bold mb-0">3. Tutor Responsable</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre Tutor</label>
                            <input type="text" name="tutor_nombre" class="form-control" value="{{ old('tutor_nombre', $bajoPeso->tutor_nombre) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">DNI Tutor</label>
                            <input type="text" name="tutor_dni" class="form-control" value="{{ old('tutor_dni', $bajoPeso->tutor_dni) }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Parentesco</label>
                            <input type="text" name="tutor_responsable" class="form-control" value="{{ old('tutor_responsable', $bajoPeso->tutor_responsable) }}">
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white pt-4">
                        <h6 class="card-title text-uppercase text-muted fw-bold mb-0">4. Actualizar Documentos</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Certificado Bajo Peso</label>
                            @if($bajoPeso->certificado_bajo_peso)
                                <div class="mb-2"><small class="text-success"><i class="bi bi-check-circle-fill"></i> Ya existe un archivo.</small></div>
                            @endif
                            <input type="file" name="certificado_bajo_peso" class="form-control form-control-sm">
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold">Informe Socioambiental</label>
                            @if($bajoPeso->informe_socioambiental)
                                <div class="mb-2"><small class="text-success"><i class="bi bi-check-circle-fill"></i> Ya existe un archivo.</small></div>
                            @endif
                            <input type="file" name="informe_socioambiental" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-warning w-100 text-dark fw-bold py-2 shadow-sm">
                        <i class="bi bi-save me-2"></i>Actualizar Registro
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    // Reutilizamos el cálculo de edad del create
    document.getElementById('fecha_nacimiento').addEventListener('change', function(){
        if(!this.value) return;
        let nacimiento = new Date(this.value);
        let hoy = new Date();
        let edad = hoy.getFullYear() - nacimiento.getFullYear();
        let m = hoy.getMonth() - nacimiento.getMonth();
        if (m < 0 || (m === 0 && hoy.getDate() < nacimiento.getDate())) { edad--; }
        document.getElementById('edad').value = edad;
    });
</script>
@endpush