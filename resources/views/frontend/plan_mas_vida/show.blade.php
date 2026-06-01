@extends('frontend.layout.front')

@section('title', 'Ficha Plan Más Vida')

@section('content')
<div class="container-fluid py-4">
    
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-md-7">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-subtle text-primary rounded-3 p-3 me-3">
                            <i class="bi bi-file-earmark-text fs-3"></i>
                        </div>
                        <div>
                            <span class="badge bg-primary text-uppercase px-3 py-1 rounded-pill mb-1 small fw-semibold">Ficha Social Activa</span>
                            <h2 class="h3 mb-0 text-dark fw-bold">Plan Más Vida</h2>
                            <div class="text-muted small">
                                Titular: <span class="fw-semibold text-dark">{{ $ficha->beneficio->persona->apellido }}, {{ $ficha->beneficio->persona->nombre }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-md-end">
                    <div class="d-flex gap-2 justify-content-md-end flex-wrap">
                        <a href="{{ route('plan-mas-vida.pdf', $ficha->id) }}" target="_blank" class="btn btn-danger rounded-pill px-3 shadow-sm btn-sm">
                            <i class="bi bi-file-earmark-pdf me-1"></i> Exportar PDF
                        </a>
                        <a href="{{ route('plan-mas-vida.edit', $ficha->id) }}" class="btn btn-warning rounded-pill px-3 shadow-sm btn-sm text-dark fw-semibold">
                            <i class="bi bi-pencil me-1"></i> Editar Registro
                        </a>
                        <a href="{{ route('personas.show', $ficha->beneficio->persona_id) }}" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Volver al Perfil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h6 class="mb-0 fw-bold text-secondary text-uppercase tracking-wider small"><i class="bi bi-info-circle me-2"></i>Información General de Relevamiento</h6>
        </div>
        <div class="card-body bg-light-subtle border-top border-light rounded-bottom-3">
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <span class="text-muted small text-uppercase fw-bold d-block">Fecha de Emisión</span>
                    <span class="text-dark fw-semibold fs-6"><i class="bi bi-calendar-event me-2 text-muted"></i>{{ optional($ficha->fecha)->format('d/m/Y') }}</span>
                </div>
                <div class="col-md-3 col-6">
                    <span class="text-muted small text-uppercase fw-bold d-block">Código de Grupo Familiar</span>
                    <span class="badge bg-secondary-subtle text-secondary rounded p-2 px-3 fw-bold mt-1 fs-6">{{ $ficha->beneficio->persona->familia->codigo ?? '-' }}</span>
                </div>
                <div class="col-md-3 col-6">
                    <span class="text-muted small text-uppercase fw-bold d-block">Teléfono Vinculado</span>
                    <span class="text-dark fw-semibold fs-6"><i class="bi bi-telephone me-2 text-muted"></i>{{ $ficha->beneficio->persona->telefono ?? 'No informado' }}</span>
                </div>
                <div class="col-md-3 col-6">
                    <span class="text-muted small text-uppercase fw-bold d-block">Barrio / Sector</span>
                    <span class="text-dark fw-semibold fs-6"><i class="bi bi-geo-alt me-2 text-muted"></i>{{ optional($ficha->beneficio->persona->domicilio?->barrio)->nombre ?? 'No especificado' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h6 class="mb-0 fw-bold text-secondary text-uppercase tracking-wider small"><i class="bi bi-people me-2"></i>Integrantes del Grupo Familiar Registrados</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 border-top border-light" style="min-width: 1200px;">
                <thead class="table-light border-bottom text-secondary small text-uppercase">
                    <tr>
                        <th class="ps-4">Apellido y Nombre</th>
                        <th>Vínculo</th>
                        <th>Fecha Nac.</th>
                        <th>DNI/CUIL</th>
                        <th class="text-center">Vacunas</th>
                        <th class="text-center">Embarazo</th>
                        <th>Discapacidad</th>
                        <th>Enfermedades</th>
                        <th class="text-center">Asiste Esc.</th>
                        <th>Nivel Educativo</th>
                        <th>Escuela N°</th>
                        <th class="text-center">AUH</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ficha->integrantes as $integrante)
                    <tr>
                        <td class="ps-4 fw-semibold text-dark">{{ $integrante->apellido_nombre }}</td>
                        <td><span class="badge bg-light text-dark border px-2 py-1">{{ $integrante->vinculo }}</span></td>
                        <td>{{ $integrante->fecha_nacimiento ? \Carbon\Carbon::parse($integrante->fecha_nacimiento)->format('d/m/Y') : '-' }}</td>
                        <td class="text-muted font-monospace">{{ $integrante->cuil_dni }}</td>
                        <td class="text-center">
                            @if($integrante->vacunas)
                                <span class="badge bg-success-subtle text-success rounded-pill px-2"><i class="bi bi-check-lg"></i> Al día</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger rounded-pill px-2"><i class="bi bi-x-lg"></i> Incompleto</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($integrante->embarazo)
                                <span class="badge bg-info-subtle text-info rounded-pill px-2"><i class="bi bi-heart-pulse-fill"></i> Sí</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>{{ $integrante->discapacidad ?: 'Ninguna' }}</td>
                        <td>{{ $integrante->enfermedades ?: 'Ninguna' }}</td>
                        <td class="text-center">
                            @if($integrante->asiste)
                                <span class="badge bg-success-subtle text-success rounded-pill px-2">Sí</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2">No</span>
                            @endif
                        </td>
                        <td>{{ $integrante->nivel_alcanzado ?: '-' }}</td>
                        <td>{{ $integrante->escuela ?: '-' }}</td>
                        <td class="text-center">
                            @if($integrante->auh)
                                <span class="badge bg-success-subtle text-success rounded-pill px-2"><i class="bi bi-check"></i> Activo</span>
                            @else
                                <span class="text-muted small">No</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center py-4 text-muted">
                            <i class="bi bi-info-circle d-block fs-4 mb-2"></i> No existen integrantes registrados en esta ficha.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <h5 class="fw-bold text-dark opacity-85 mt-4 mb-3"><i class="bi bi-journal-text text-primary me-2"></i>Dimensiones e Informes de Vulnerabilidad</h5>
    
    <div class="row g-4">
        @php
            $informes = [
                ['title' => 'Observaciones Generales', 'content' => $ficha->observaciones, 'icon' => 'bi-chat-left-quote-fill'],
                ['title' => 'Situación de la Vivienda / Hábitat', 'content' => $ficha->situacion_vivienda, 'icon' => 'bi-house-door-fill'],
                ['title' => 'Familia Numerosa / Hacinamiento', 'content' => $ficha->familia_numerosa, 'icon' => 'bi-people-fill'],
                ['title' => 'Casos Judiciales Activos', 'content' => $ficha->casos_judiciales, 'icon' => 'bi-balance-scale-right'],
                ['title' => 'Violencia Familiar / Problemática Intrafamiliar', 'content' => $ficha->violencia_familiar, 'icon' => 'bi-shield-exclamation'],
                ['title' => 'Desnutrición o Alertas Alimentarias', 'content' => $ficha->desnutricion, 'icon' => 'bi-activity'],
                ['title' => 'Situación Integral de Salud', 'content' => $ficha->situacion_salud, 'icon' => 'bi-heart-pulse-fill'],
                ['title' => 'Situación Laboral / Sustento Económico', 'content' => $ficha->situacion_laboral, 'icon' => 'bi-briefcase-fill']
            ];
        @endphp

        @foreach($informes as $info)
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2 border-bottom border-light pb-2">
                        <i class="{{ $info['icon'] }} text-primary-subtle fs-5 me-2"></i>
                        <h6 class="mb-0 fw-bold text-dark opacity-75 small text-uppercase tracking-wider">{{ $info['title'] }}</h6>
                    </div>
                    <div class="p-3 bg-light-subtle rounded border-start border-3 border-primary-subtle text-secondary small style-scroll" style="max-height: 200px; overflow-y: auto; white-space: pre-wrap;">
                        {!! $info['content'] ? nl2br(e($info['content'])) : '<em class="text-muted">No se cargaron datos en este apartado.</em>' !!}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card shadow-sm border-0 rounded-3 my-4 bg-dark text-white">
        <div class="card-body p-3 px-4 d-flex justify-content-between align-items-center flex-wrap g-3">
            <div class="d-flex align-items-center">
                <i class="bi bi-person-badge-fill text-warning fs-3 me-3"></i>
                <div>
                    <span class="text-white-50 small d-block text-uppercase">Trabajador Social Responsable</span>
                    <h5 class="mb-0 fw-bold text-warning">{{ $ficha->trabajador_social ?: 'No informado oficialmente' }}</h5>
                </div>
            </div>
            <div class="text-white-50 small font-monospace">
                Comunidad PMV System v11
            </div>
        </div>
    </div>
</div>
@endsection