@extends('frontend.layout.front')

@section('title', 'Plan Más Vida - Nueva Ficha')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1 text-gray-800 fw-bold">
                <i class="bi bi-file-earmark-medical text-primary me-2"></i>Nueva Ficha Social
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Comunidad</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Plan Más Vida</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Crear Ficha</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('personas.show', $personaBeneficio->persona_id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Volver al Perfil
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('plan-mas-vida.store', $personaBeneficio->id) }}">
        @csrf

        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-primary-subtle text-primary rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-person-vcard fs-5"></i>
                    </div>
                    <h5 class="mb-0 fw-bold text-dark opacity-85">Datos Generales del Beneficiario</h5>
                </div>
            </div>
            <div class="card-body bg-light-subtle rounded-bottom-3 border-top border-light">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-uppercase text-muted fw-bold small">Fecha de Registro</label>
                        <input type="date" name="fecha" class="form-control border-light-subtle shadow-sm" value="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-uppercase text-muted fw-bold small">Código Familia</label>
                        <input type="text" class="form-control bg-light border-light-subtle text-dark fw-semibold"  value="{{ $personaBeneficio->persona->familia->codigo }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-uppercase text-muted fw-bold small">Teléfono de Contacto</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light border-light-subtle text-muted"><i class="bi bi-telephone"></i></span>
                            <input type="text" class="form-control bg-light border-light-subtle"  value="{{ $personaBeneficio->persona->telefono ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-uppercase text-muted fw-bold small">Barrio asignado</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light border-light-subtle text-muted"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" class="form-control bg-light border-light-subtle"  value="{{ optional($personaBeneficio->persona->domicilio?->barrio)->nombre ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-uppercase text-muted fw-bold small">Domicilio Declarado</label>
                        <input type="text" class="form-control bg-light border-light-subtle"  value="{{ $personaBeneficio->persona->domicilio?->calle }} {{ $personaBeneficio->persona->domicilio?->numero }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-success-subtle text-success rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-people fs-5"></i>
                    </div>
                    <h5 class="mb-0 fw-bold text-dark opacity-85">Relevamiento del Grupo Familiar</h5>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 border-top border-light" style="min-width: 1200px;">
                    <thead class="table-light border-bottom text-secondary small text-uppercase">
                        <tr>
                            <th style="width: 220px;" class="ps-4">Apellido y Nombre</th>
                            <th style="width: 130px;">Vínculo</th>
                            <th style="width: 130px;">Nacimiento</th>
                            <th style="width: 130px;">CUIL/DNI</th>
                            <th class="text-center" style="width: 70px;">Vacunas</th>
                            <th class="text-center" style="width: 70px;">Embarazo</th>
                            <th>Discapacidad</th>
                            <th>Enfermedades</th>
                            <th class="text-center" style="width: 70px;">Asiste</th>
                            <th style="width: 120px;">Nivel Ed.</th>
                            <th style="width: 150px;">Escuela</th>
                            <th class="text-center" style="width: 70px;">AUH</th>
                        </tr>
                    </thead>
                    <tbody class="border-0">
                        @foreach($personaBeneficio->persona->familia->personas as $i => $familiar)
                        <tr>
                            <td class="ps-4">
                                <input type="text" class="form-control form-control-sm border-light-subtle bg-light fw-medium" name="integrantes[{{ $i }}][apellido_nombre]" value="{{ $familiar->apellido }} {{ $familiar->nombre }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-light-subtle shadow-sm" name="integrantes[{{ $i }}][vinculo]" placeholder="Ej: Hijo/a" >
                            </td>
                            <td>
                                <input type="date" class="form-control form-control-sm border-light-subtle bg-light text-muted" name="integrantes[{{ $i }}][fecha_nacimiento]" value="{{ $familiar->fecha_nacimiento }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-light-subtle bg-light text-muted" name="integrantes[{{ $i }}][cuil_dni]" value="{{ $familiar->dni }}" readonly>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input border-secondary-subtle" name="integrantes[{{ $i }}][vacunas]" value="1">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input" name="integrantes[{{ $i }}][embarazo]" value="1" {{ $familiar->embarazo ? 'checked' : '' }}>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-light-subtle bg-light" name="integrantes[{{ $i }}][discapacidad]" value="{{ optional($familiar->discapacidad)->nombre ?? 'Ninguna' }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-light-subtle bg-light" name="integrantes[{{ $i }}][enfermedades]" value="{{ optional($familiar->enfermedad)->nombre ?? 'Ninguna' }}" readonly>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input border-secondary-subtle" name="integrantes[{{ $i }}][asiste]" value="1">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-light-subtle bg-light" name="integrantes[{{ $i }}][nivel_alcanzado]" value="{{ optional($familiar->nivelEstudio)->nombre }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-light-subtle shadow-sm" name="integrantes[{{ $i }}][escuela]" placeholder="Nro de Escuela">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input border-secondary-subtle" name="integrantes[{{ $i }}][auh]" value="1">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <h5 class="fw-bold text-dark opacity-85 mt-2 mb-1"><i class="bi bi-journal-text text-info me-2"></i>Dimensiones Críticas e Informe Social</h5>
                <p class="text-muted small mb-0">Complete detalladamente cada bloque conforme a la entrevista domiciliaria efectuada.</p>
            </div>

            @php
                $campos = [
                    ['name' => 'observaciones', 'label' => 'Observaciones Generales', 'icon' => 'bi-chat-left-text', 'rows' => 4],
                    ['name' => 'situacion_vivienda', 'label' => 'Situación Habitacional / Vivienda', 'icon' => 'bi-house', 'rows' => 4],
                    ['name' => 'familia_numerosa', 'label' => 'Análisis de Familia Numerosa', 'icon' => 'bi-people-fill', 'rows' => 4],
                    ['name' => 'casos_judiciales', 'label' => 'Problemáticas o Casos Judiciales', 'icon' => 'bi-balance-scale', 'rows' => 4],
                    ['name' => 'violencia_familiar', 'label' => 'Indicadores de Violencia Familiar', 'icon' => 'bi-exclamation-triangle', 'rows' => 4],
                    ['name' => 'desnutricion', 'label' => 'Seguimiento de Desnutrición o Riesgo Alim.', 'icon' => 'bi-heart-pulse', 'rows' => 4],
                    ['name' => 'situacion_salud', 'label' => 'Informe de Salud del Cuadro Familiar', 'icon' => 'bi-capsule', 'rows' => 5],
                    ['name' => 'situacion_laboral', 'label' => 'Situación Laboral e Ingresos', 'icon' => 'bi-briefcase', 'rows' => 5],
                ];
            @endphp

            @foreach($campos as $campo)
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="{{ $campo['icon'] }} text-secondary me-2 small"></i>
                            <label class="form-label text-dark fw-semibold mb-0 small text-uppercase">{{ $campo['label'] }}</label>
                        </div>
                        <textarea name="{{ $campo['name'] }}" rows="{{ $campo['rows'] }}" class="form-control border-light-subtle shadow-sm" placeholder="Ingrese información relevada..."></textarea>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="card shadow-sm border-0 rounded-3 my-4">
            <div class="card-body p-4 bg-dark text-white rounded-3">
                <div class="row align-items-center g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-pen-fill text-warning me-3 fs-3"></i>
                            <div>
                                <h6 class="mb-1 text-uppercase text-warning fw-bold small tracking-wider">Firma de Responsabilidad</h6>
                                <p class="mb-0 text-white-50 small">Especifique el Profesional a cargo del diagnóstico social.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-secondary border-0 text-white-50"><i class="bi bi-person-badge"></i></span>
                            <input type="text" name="trabajador_social" class="form-control bg-secondary-subtle border-0 text-dark fw-semibold" placeholder="Nombre completo del Trabajador Social" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mb-5">
            <a href="{{ route('personas.show', $personaBeneficio->persona_id) }}" class="btn btn-light border rounded-pill px-4">
                Cancelar
            </a>
            <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="bi bi-check2-circle me-1"></i> Guardar Ficha e Instanciar
            </button>
        </div>
    </form>
</div>
@endsection