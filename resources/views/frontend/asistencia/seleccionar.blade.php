@extends('frontend.layout.front')

@section('title', 'Seleccionar Asistencia')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">

                    {{-- Encabezado --}}
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-light text-primary rounded-circle p-3 mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-calendar-check-fill" style="font-size: 35px;"></i>
                        </div>
                        <h2 class="h3 fw-bold text-dark mb-1">Registrar Asistencia</h2>
                        <p class="text-muted small">
                            Complete los campos para acceder al listado de asistencia.
                        </p>
                    </div>

                    {{-- Formulario --}}
                    <form method="GET" action="{{ route('asistencia.index') }}" id="asistenciaForm">
                        
                        {{-- Programa --}}
                        <div class="mb-4">
                            <label for="programaSelect" class="form-label fw-semibold text-secondary">
                                <i class="bi bi-journal-bookmark-fill me-1 text-primary"></i> Programa
                            </label>
                            <select
                                class="form-select form-select-lg border-2 shadow-sm focus-ring"
                                name="programa_id"
                                id="programaSelect"
                                required>

                                <option value="" disabled selected hidden>
                                    Seleccione un programa...
                                </option>

                                @foreach($programas as $programa)
                                    <option
                                        value="{{ $programa->id }}"
                                        data-requiere-sede="{{ in_array(strtolower($programa->nombre), ['envion','envión','udi']) ? 1 : 0 }}">
                                        {{ $programa->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Sede (Contenedor con animación) --}}
                        <div id="sedeWrapper" class="fade" style="max-height: 0; overflow: hidden; transition: all 0.4s ease-in-out; opacity: 0;">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="sedeSelect" class="form-label fw-semibold text-secondary mb-0">
                                        <i class="bi bi-geo-alt-fill me-1 text-primary"></i> Sede
                                    </label>
                                    <span id="sedeBadge" class="badge rounded-pill bg-danger-subtle text-danger small">Obligatorio</span>
                                </div>
                                <select 
                                    class="form-select form-select-lg border-2 shadow-sm" 
                                    name="sede_id" 
                                    id="sedeSelect">
                                    <option value="" disabled selected hidden>Seleccione una sede...</option>
                                    @foreach($sedes as $sede)
                                        <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text text-muted mt-2 ps-1">
                                    <i class="bi bi-info-circle-fill me-1"></i> Requerido para programas Envión y UDI.
                                </div>
                            </div>
                        </div>

                        {{-- Botón de Acción --}}
                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-lg w-100 fw-bold py-3 mt-2 shadow-sm rounded-3 d-flex align-items-center justify-content-center gap-2">
                            <span id="btnText">Continuar</span>
                            <i id="btnIcon" class="bi bi-arrow-right-circle fs-5"></i>
                            <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form           = document.getElementById('asistenciaForm');
    const programaSelect = document.getElementById('programaSelect');
    const sedeWrapper    = document.getElementById('sedeWrapper');
    const sedeSelect     = document.getElementById('sedeSelect');
    const btnSubmit      = document.getElementById('btnSubmit');
    const btnText        = document.getElementById('btnText');
    const btnIcon        = document.getElementById('btnIcon');
    const btnSpinner     = document.getElementById('btnSpinner');

    function actualizarSede() {
        const opcionSeleccionada = programaSelect.options[programaSelect.selectedIndex];

        if (!opcionSeleccionada || !opcionSeleccionada.value) {
            ocultarSede();
            return;
        }

        const requiereSede = opcionSeleccionada.dataset.requiereSede == "1";

        if (requiereSede) {
            mostrarSede();
        } else {
            ocultarSede();
        }
    }

    function mostrarSede() {
        sedeWrapper.style.maxHeight = '150px'; 
        sedeWrapper.style.opacity   = '1';
        sedeWrapper.classList.add('show');
        sedeSelect.required         = true;
    }

    function ocultarSede() {
        sedeWrapper.style.maxHeight = '0px';
        sedeWrapper.style.opacity   = '0';
        sedeWrapper.classList.remove('show');
        sedeSelect.required         = false;
        sedeSelect.value            = ''; // Resetea la selección
    }

    // Escuchar cambios en el selector de programas
    programaSelect.addEventListener('change', actualizarSede);

    // Estado de carga al enviar el formulario válido
    form.addEventListener('submit', function (e) {
        if (form.checkValidity()) {
            btnSubmit.classList.add('disabled');
            btnSubmit.setAttribute('disabled', 'true');
            btnText.textContent = 'Cargando...';
            btnIcon.classList.add('d-none');
            btnSpinner.classList.remove('d-none');
        }
    });

    // Ejecución inicial por si vuelve atrás en el navegador con datos cacheados
    actualizarSede();
});
</script>
@endpush