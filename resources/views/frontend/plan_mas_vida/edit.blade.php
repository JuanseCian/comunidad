@extends('frontend.layout.front')

@section('title', 'Editar Ficha Plan Más Vida')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1 text-gray-800 fw-bold">
                <i class="bi bi-pencil-square text-warning me-2"></i>Modificar Ficha Social
            </h2>
            <div class="text-muted small">
                Editando registro de la familia cod: <span class="fw-bold text-dark">{{ $ficha->beneficio->persona->familia->codigo }}</span>
            </div>
        </div>
        <div>
            <a href="{{ route('personas.show', $ficha->beneficio->persona_id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Volver al Perfil
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('plan-mas-vida.update', $ficha->id) }}">
        @csrf
        @method('PUT')

        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-warning-subtle text-warning rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-card-list fs-5"></i>
                    </div>
                    <h5 class="mb-0 fw-bold text-dark opacity-85">Actualización de Datos de Cabecera</h5>
                </div>
            </div>
            <div class="card-body bg-light-subtle rounded-bottom-3 border-top border-light">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-uppercase text-muted fw-bold small">Fecha de Ficha</label>
                        <input type="date" name="fecha" class="form-control border-light-subtle shadow-sm" value="{{ optional($ficha->fecha)->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-uppercase text-muted fw-bold small">Código Familia</label>
                        <input type="text" class="form-control bg-light border-light-subtle text-dark fw-semibold" readonly value="{{ $ficha->beneficio->persona->familia->codigo }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-uppercase text-muted fw-bold small">Teléfono</label>
                        <input type="text" class="form-control bg-light border-light-subtle" readonly value="{{ $ficha->beneficio->persona->telefono }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-uppercase text-muted fw-bold small">Barrio</label>
                        <input type="text" class="form-control bg-light border-light-subtle" readonly value="{{ optional($ficha->beneficio->persona->domicilio?->barrio)->nombre }}">
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
                    <h5 class="mb-0 fw-bold text-dark opacity-85">Composición del Grupo Familiar</h5>
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
                        @foreach($ficha->integrantes as $integrante)
                        <tr>
                            <td class="ps-4">
                                <input type="text" class="form-control form-control-sm border-light-subtle bg-light text-dark fw-medium" readonly value="{{ $integrante->apellido_nombre }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-light-subtle bg-light text-dark" readonly value="{{ $integrante->vinculo }}">
                            </td>
                            <td>
                                <input type="date" class="form-control form-control-sm border-light-subtle bg-light text-muted" readonly value="{{ $integrante->fecha_nacimiento }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-light-subtle bg-light text-muted" readonly value="{{ $integrante->cuil_dni }}">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input border-secondary-subtle" name="integrantes[{{ $integrante->id }}][vacunas]" value="1" @checked($integrante->vacunas)>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input border-secondary-subtle" name="integrantes[{{ $integrante->id }}][embarazo]" value="1" @checked($integrante->embarazo)>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-light-subtle shadow-sm" name="integrantes[{{ $integrante->id }}][discapacidad]" value="{{ $integrante->discapacidad }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-light-subtle shadow-sm" name="integrantes[{{ $integrante->id }}][enfermedades]" value="{{ $integrante->enfermedades }}">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input border-secondary-subtle" name="integrantes[{{ $integrante->id }}][asiste]" value="1" @checked($integrante->asiste)>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-light-subtle shadow-sm" name="integrantes[{{ $integrante->id }}][nivel_alcanzado]" value="{{ $integrante->nivel_alcanzado }}">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-light-subtle shadow-sm" name="integrantes[{{ $integrante->id }}][escuela]" value="{{ $integrante->escuela }}">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" class="form-check-input border-secondary-subtle" name="integrantes[{{ $integrante->id }}][auh]" value="1" @checked($integrante->auh)>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <div class="col-12">
                <h5 class="fw-bold text-dark opacity-85 mb-0"><i class="bi bi-pencil-square text-info me-2"></i>Edición de Dimensiones Sociales</h5>
            </div>

            @php
                $camposEdicion = [
                    ['name' => 'observaciones', 'label' => 'Observaciones Generales', 'icon' => 'bi-chat-left-text', 'rows' => 4, 'value' => $ficha->observaciones],
                    ['name' => 'situacion_vivienda', 'label' => 'Situación Habitacional / Vivienda', 'icon' => 'bi-house', 'rows' => 4, 'value' => $ficha->situacion_vivienda],
                    ['name' => 'familia_numerosa', 'label' => 'Análisis de Familia Numerosa', 'icon' => 'bi-people-fill', 'rows' => 4, 'value' => $ficha->familia_numerosa],
                    ['name' => 'casos_judiciales', 'label' => 'Problemáticas o Casos Judiciales', 'icon' => 'bi-balance-scale', 'rows' => 4, 'value' => $ficha->casos_judiciales],
                    ['name' => 'violencia_familiar', 'label' => 'Indicadores de Violencia Familiar', 'icon' => 'bi-exclamation-triangle', 'rows' => 4, 'value' => $ficha->violencia_familiar],
                    ['name' => 'desnutricion', 'label' => 'Seguimiento de Desnutrición o Riesgo Alim.', 'icon' => 'bi-heart-pulse', 'rows' => 4, 'value' => $ficha->desnutricion],
                    ['name' => 'situacion_salud', 'label' => 'Informe de Salud del Cuadro Familiar', 'icon' => 'bi-capsule', 'rows' => 6, 'value' => $ficha->situacion_salud],
                    ['name' => 'situacion_laboral', 'label' => 'Situación Laboral e Ingresos', 'icon' => 'bi-briefcase', 'rows' => 6, 'value' => $ficha->situacion_laboral],
                ];
            @endphp

            @foreach($camposEdicion as $campo)
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="{{ $campo['icon'] }} text-secondary me-2 small"></i>
                            <label class="form-label text-dark fw-semibold mb-0 small text-uppercase">{{ $campo['label'] }}</label>
                        </div>
                        <textarea name="{{ $campo['name'] }}" rows="{{ $campo['rows'] }}" class="form-control border-light-subtle shadow-sm">{{ $campo['value'] }}</textarea>
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
                            <i class="bi bi-person-badge text-warning me-3 fs-3"></i>
                            <div>
                                <h6 class="mb-1 text-uppercase text-warning fw-bold small">Trabajador Social Firmante</h6>
                                <p class="mb-0 text-white-50 small">Modifique si cambia el agente a cargo de la edición.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="trabajador_social" class="form-control bg-secondary-subtle border-0 text-dark fw-semibold" value="{{ $ficha->trabajador_social }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-5">
            <a href="{{ route('personas.show', $ficha->beneficio->persona_id) }}" class="btn btn-light border rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Cancelar y Volver
            </a>
            <button type="submit" class="btn btn-warning rounded-pill px-4 shadow-sm fw-semibold">
                <i class="bi bi-save me-1"></i> Actualizar Ficha Completa
            </button>
        </div>
    </form>
</div>
@endsection