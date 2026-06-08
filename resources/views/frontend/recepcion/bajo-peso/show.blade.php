@extends('frontend.recepcion.layout.app')

@section('title', 'Detalle de Beneficiario')

@section('content')
<div class="container-fluid py-4">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-bold mb-0 text-gray-800">
                <i class="bi bi-heart-pulse-fill text-warning me-2"></i>Ficha de Beneficiario
            </h2>
            <p class="text-muted mb-0 ms-4 ps-1">
                Expediente detallado del programa Bajo Peso.
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('bajo-peso.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
            <a href="{{ route('bajo-peso.edit', $beneficiario->id) }}" class="btn btn-warning text-dark fw-semibold">
                <i class="bi bi-pencil-square me-1"></i> Editar Ficha
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- COLUMNA IZQUIERDA: DATOS PERSONALES Y MÉDICOS --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white pt-4">
                    <h6 class="card-title text-uppercase text-muted fw-bold mb-0">1. Información del Menor</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">DNI / Documento:</div>
                        <div class="col-sm-8 fw-bold">{{ $beneficiario->persona->dni ?? 'No registrado' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">Nombre Completo:</div>
                        <div class="col-sm-8">{{ $beneficiario->persona->apellido }}, {{ $beneficiario->persona->nombre }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">Fecha de Nacimiento:</div>
                        <div class="col-sm-8">{{ \Carbon\Carbon::parse($beneficiario->persona->fecha_nacimiento)->format('d/m/Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">Edad al registro:</div>
                        <div class="col-sm-8"><span class="badge bg-info text-dark">{{ $beneficiario->persona->edad }} años</span></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-muted fw-semibold">Código de Familia:</div>
                        <div class="col-sm-8"><code>{{ $beneficiario->persona->familia->codigo ?? 'N/A' }}</code></div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white pt-4">
                    <h6 class="card-title text-uppercase text-muted fw-bold mb-0">2. Diagnóstico y Evolución</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-warning text-uppercase small">Diagnóstico Inicial</label>
                        <div class="p-3 bg-light rounded border-start border-4 border-warning">
                            {{ $beneficiario->diagnostico ?: 'Sin diagnóstico registrado.' }}
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold text-primary text-uppercase small">Tratamiento e Indicaciones</label>
                        <div class="p-3 bg-light rounded border-start border-4 border-primary">
                            {{ $beneficiario->tratamiento ?: 'Sin tratamiento registrado.' }}
                        </div>
                    </div>
                    <div>
                        <label class="form-label fw-bold text-secondary text-uppercase small">Observaciones Generales</label>
                        <p class="text-muted italic ms-2">{{ $beneficiario->observaciones ?: 'Sin observaciones.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: TUTOR Y ARCHIVOS --}}
        <div class="col-lg-4">
            {{-- CARD TUTOR --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-warning text-dark fw-bold">
                    <i class="bi bi-person-badge-fill me-2"></i>Datos del Tutor
                </div>
                <div class="card-body">
                    <h5 class="fw-bold mb-1">{{ $beneficiario->tutor_nombre }}</h5>
                    <p class="text-muted mb-3"><i class="bi bi-card-text me-2"></i>DNI: {{ $beneficiario->tutor_dni }}</p>
                    <div class="d-flex align-items-center bg-light p-2 rounded">
                        <i class="bi bi-people-fill text-warning me-2 fs-4"></i>
                        <div>
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Parentesco/Responsable</small>
                            <span class="fw-semibold">{{ $beneficiario->tutor_responsable }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CARD DOCUMENTOS --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white pt-4">
                    <h6 class="card-title text-uppercase text-muted fw-bold mb-0">Documentación Anexa</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        {{-- Certificado --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark-medical fs-3 text-danger me-3"></i>
                                <div>
                                    <span class="d-block fw-bold">Certificado Bajo Peso</span>
                                    <small class="text-muted">Documento médico oficial</small>
                                </div>
                            </div>
                            @if($beneficiario->certificado_bajo_peso)
                                <a href="{{ Storage::url($beneficiario->certificado_bajo_peso) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            @else
                                <span class="badge bg-light text-muted">No cargado</span>
                            @endif
                        </li>
                        {{-- Informe --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark-text fs-3 text-success me-3"></i>
                                <div>
                                    <span class="d-block fw-bold">Informe Socioambiental</span>
                                    <small class="text-muted">Evaluación de entorno</small>
                                </div>
                            </div>
                            @if($beneficiario->informe_socioambiental)
                                <a href="{{ Storage::url($beneficiario->informe_socioambiental) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            @else
                                <span class="badge bg-light text-muted">No cargado</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection