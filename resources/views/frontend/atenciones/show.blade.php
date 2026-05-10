@extends('frontend.layout.front')

@section('title', 'Detalle de Intervención')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">

            {{-- Encabezado --}}
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">

                <div>
                    <h2 class="fw-bold mb-1 text-dark">
                        <i class="fas fa-eye me-2 text-primary"></i>
                        Detalle de intervención
                    </h2>

                    <p class="text-muted mb-0">
                        Visualización completa de la intervención registrada.
                    </p>
                </div>

                <div class="d-flex gap-2">

                    <a href="{{ route('personas.show', $atencion->persona_id) }}"
                       class="btn btn-light border rounded-pill px-3">

                        <i class="fas fa-arrow-left me-1"></i>
                        Volver

                    </a>

                    @if(Auth::user()->puedeEditar())

                        <a href="{{ route('atenciones.edit', $atencion) }}"
                           class="btn btn-primary rounded-pill px-3 shadow-sm">

                            <i class="fas fa-pen me-1"></i>
                            Editar

                        </a>

                    @endif

                </div>

            </div>

            {{-- Card principal --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                {{-- Header --}}
                <div class="card-header bg-white border-0 py-4 px-4">

                    <div class="d-flex align-items-center">

                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width:50px; height:50px;">

                            <i class="fas fa-notes-medical text-primary"></i>

                        </div>

                        <div class="ms-3">

                            <h5 class="mb-1 fw-semibold">
                                Información de la intervención
                            </h5>

                            <small class="text-muted">
                                Datos registrados de la intervención seleccionada.
                            </small>

                        </div>

                    </div>

                </div>

                {{-- Body --}}
                <div class="card-body p-4">

                    <div class="row g-4">

                        {{-- Tipo --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold text-dark">
                                Tipo de intervención
                            </label>

                            <div class="form-control rounded-3 bg-light shadow-sm py-3">

                                {{ ucfirst(str_replace('_', ' ', $atencion->tipo ?? 'Sin tipo')) }}

                            </div>

                        </div>

                        {{-- Fecha --}}
                        <div class="col-md-6">

                            <label class="form-label fw-semibold text-dark">
                                Fecha
                            </label>

                            <div class="form-control rounded-3 bg-light shadow-sm py-3">

                                {{ $atencion->fecha_atencion
                                    ? \Carbon\Carbon::parse($atencion->fecha_atencion)->format('d/m/Y')
                                    : 'Sin fecha registrada'
                                }}

                            </div>

                        </div>

                        {{-- Usuario --}}
                        <div class="col-12">

                            <label class="form-label fw-semibold text-dark">
                                Registrado por
                            </label>

                            <div class="form-control rounded-3 bg-light shadow-sm py-3">

                                {{ $atencion->users->nombre ?? 'Sistema' }}

                            </div>

                        </div>

                        {{-- Descripción --}}
                        <div class="col-12">

                            <label class="form-label fw-semibold text-dark">
                                Descripción
                            </label>

                            <div class="form-control rounded-3 bg-light shadow-sm"
                                 style="min-height:180px; white-space:pre-line; line-height:1.8;">

                                {{ $atencion->descripcion ?? 'Sin descripción registrada.' }}

                            </div>

                            <div class="form-text mt-2">
                                Información registrada durante la intervención.
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection