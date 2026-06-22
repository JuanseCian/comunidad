@extends('frontend.layout.front')

@section('title', 'Seleccionar Asistencia')

@section('content')
    <style>
    .card {
        backdrop-filter: blur(10px);
    }

    .form-select {
        border: 1px solid #e5e7eb;
        min-height: 54px;
    }

    .form-select:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 .15rem rgba(var(--bs-primary-rgb), .15);
    }

    .btn-primary {
        transition: .2s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
    }
</style>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                {{-- Línea superior --}}
                <div style="height: 4px; background: var(--bs-primary);"></div>

                <div class="card-body p-5">

                    {{-- Encabezado --}}
                    <div class="text-center mb-5">
                        <i class="bi bi-calendar-check text-primary fs-1"></i>

                        <h2 class="fw-semibold mt-3 mb-2">
                            Registrar asistencia
                        </h2>

                        <p class="text-muted mb-0">
                            Seleccione el programa para continuar.
                        </p>
                    </div>

                    <form method="GET"
                          action="{{ route('asistencia.index') }}"
                          id="asistenciaForm">

                        {{-- Programa --}}
                        <div class="mb-4">
                            <label for="programaSelect"
                                   class="form-label small text-muted mb-2">
                                Programa
                            </label>

                            <select
                                class="form-select form-select-lg rounded-3"
                                name="programa_id"
                                id="programaSelect"
                                required>

                                <option value="" selected disabled>
                                    Seleccionar programa
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

                        {{-- Sede --}}
                        <div id="sedeWrapper"
                             style="max-height:0;overflow:hidden;opacity:0;transition:.35s ease;">

                            <div class="mb-4">
                                <label for="sedeSelect"
                                       class="form-label small text-muted mb-2">
                                    Sede
                                </label>

                                <select
                                    class="form-select form-select-lg rounded-3"
                                    name="sede_id"
                                    id="sedeSelect">

                                    <option value="" selected disabled>
                                        Seleccionar sede
                                    </option>

                                    @foreach($sedes as $sede)
                                        <option value="{{ $sede->id }}">
                                            {{ $sede->nombre }}
                                        </option>
                                    @endforeach
                                </select>

                                <small class="text-muted d-block mt-2">
                                    Solo requerido para Envión y UDI.
                                </small>
                            </div>

                        </div>

                        {{-- Botón --}}
                        <button
                            type="submit"
                            id="btnSubmit"
                            class="btn btn-primary w-100 py-3 rounded-3 fw-medium">

                            <span id="btnText">
                                Continuar
                            </span>

                            <span id="btnSpinner"
                                  class="spinner-border spinner-border-sm ms-2 d-none">
                            </span>

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