@extends('frontend.recepcion.layout.app')

@section('title', 'Editar Ingreso')

@push('styles')
<style>
    .search-results-container {
        top: 100%;
        left: 0;
        z-index: 1050;
        display: none;
        max-height: 280px;
        overflow-y: auto;
        padding: 0.5rem 0;
        margin-top: 2px;
        background-color: #fff;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 0.375rem;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175);
    }

    .list-group-item-action {
        border: none;
        padding: 0.5rem 1.25rem;
    }

    .list-group-item-action:hover,
    .list-group-item-action:focus {
        background-color: #f8f9fa;
        color: #198754;
    }

    #seccionMenor {
        background-color: #fffcf5;
        border: 1px solid #ffeeba;
        border-radius: 0.375rem;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .form-label i {
        margin-right: 0.5rem;
        color: #6c757d;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-bold mb-0 text-gray-800">
                <i class="bi bi-pencil-square text-primary me-2"></i>Editar Ingreso #{{ $ingreso->id }}
            </h2>
            <p class="text-muted mb-0 ms-4 ps-1">
                Modifique los datos registrados para este ingreso.
            </p>
        </div>
        <a href="{{ route('recepcion.ingresos.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Volver al listado
        </a>
    </div>

    {{-- ERRORES --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4">
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

    <form action="{{ route('recepcion.ingresos.update', $ingreso->id) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        {{-- PERSONA PRINCIPAL --}}
        <input type="hidden" name="persona_id" id="personaId" value="{{ old('persona_id', $ingreso->persona_id) }}">

        <div class="row g-4">

            {{-- 1. DATOS DEL VISITANTE --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="card-title text-uppercase text-muted fw-bold mb-0">
                            1. Datos del Visitante
                        </h6>
                    </div>

                    <div class="card-body" style="overflow: visible;">
                        <div class="row g-3">

                            {{-- DNI / BUSCADOR --}}
                            <div class="col-md-5 position-relative">
                                <label for="dniInput" class="form-label fw-semibold">
                                    <i class="bi bi-card-text"></i>DNI / Documento
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           name="dni" 
                                           id="dniInput" 
                                           class="form-control @error('dni') is-invalid @enderror" 
                                           placeholder="Buscar o ingresar DNI..." 
                                           value="{{ old('dni', $ingreso->dni ?? $ingreso->persona?->dni) }}">
                                </div>
                                <div id="resultadosBusqueda" class="list-group position-absolute w-100 search-results-container"></div>
                                <small class="form-text text-muted">
                                    Puede buscar otra persona o modificar los datos manualmente.
                                </small>
                            </div>

                            {{-- APELLIDO --}}
                            <div class="col-md-7">
                                <label for="apellidoInput" class="form-label fw-semibold">
                                    <i class="bi bi-person"></i>Apellido
                                </label>
                                <input type="text" 
                                       name="apellido" 
                                       id="apellidoInput" 
                                       class="form-control @error('apellido') is-invalid @enderror" 
                                       value="{{ old('apellido', $ingreso->apellido ?? $ingreso->persona?->apellido) }}" 
                                       required>
                                @error('apellido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- NOMBRE --}}
                            <div class="col-md-12">
                                <label for="nombreInput" class="form-label fw-semibold">
                                    <i class="bi bi-person"></i>Nombre(s)
                                </label>
                                <input type="text" 
                                       name="nombre" 
                                       id="nombreInput" 
                                       class="form-control @error('nombre') is-invalid @enderror" 
                                       value="{{ old('nombre', $ingreso->nombre ?? $ingreso->persona?->nombre) }}" 
                                       required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. DETALLES DEL INGRESO --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="card-title text-uppercase text-muted fw-bold mb-0">
                            2. Detalles del Ingreso
                        </h6>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            {{-- FECHA --}}
                            <div class="col-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-calendar-date"></i>Fecha
                                </label>
                                <input type="date" 
                                       name="fecha_ingreso" 
                                       class="form-control @error('fecha_ingreso') is-invalid @enderror" 
                                       value="{{ old('fecha_ingreso', $ingreso->fecha_ingreso ? \Carbon\Carbon::parse($ingreso->fecha_ingreso)->format('Y-m-d') : '') }}" 
                                       required>
                                @error('fecha_ingreso')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- HORA --}}
                            <div class="col-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-clock"></i>Hora
                                </label>
                                <input type="time" 
                                       name="hora_ingreso" 
                                       class="form-control @error('hora_ingreso') is-invalid @enderror" 
                                       value="{{ old('hora_ingreso', $ingreso->hora_ingreso ? \Carbon\Carbon::parse($ingreso->hora_ingreso)->format('H:i') : '') }}" 
                                       required>
                                @error('hora_ingreso')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DERIVACIÓN --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-signpost-2"></i>Derivación / Destino
                                </label>
                                <select name="derivacion_id" id="derivacionSelect" class="form-select @error('derivacion_id') is-invalid @enderror">
                                    <option value="">Sin derivación</option>
                                    @foreach($derivaciones as $derivacion)
                                        <option value="{{ $derivacion->id }}" 
                                                data-nombre="{{ strtolower($derivacion->nombre) }}" 
                                                {{ old('derivacion_id', $ingreso->derivacion_id) == $derivacion->id ? 'selected' : '' }}>
                                            {{ $derivacion->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('derivacion_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. MENOR PRODENYA --}}
            <div class="col-12" id="contenedorMenor" style="display:none;">
                <div id="seccionMenor" class="shadow-sm">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-warning-subtle text-warning rounded-circle p-2 me-3">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-warning-emphasis">Datos del Menor (PRODENYA)</h5>
                            <p class="text-muted mb-0">Modifique los datos del menor asociado al ingreso.</p>
                        </div>
                    </div>

                    <hr class="border-warning opacity-25">

                    <input type="hidden" name="menor_persona_id" id="menorPersonaId" value="{{ old('menor_persona_id', $ingreso->menor_persona_id) }}">

                    <div class="row g-3">
                        {{-- BUSCADOR --}}
                        <div class="col-md-4 position-relative">
                            <label for="menorBuscador" class="form-label fw-semibold text-warning-emphasis">
                                Buscar Menor
                            </label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" 
                                       id="menorBuscador" 
                                       class="form-control" 
                                       placeholder="DNI, Apellido o Nombre..." 
                                       value="{{ $ingreso->menor ? $ingreso->menor->apellido . ', ' . $ingreso->menor->nombre : '' }}">
                            </div>
                            <div id="resultadosMenor" class="list-group position-absolute w-100 search-results-container"></div>
                        </div>

                        {{-- DNI MENOR --}}
                        <div class="col-md-2">
                            <label for="menorDni" class="form-label fw-semibold">DNI Menor</label>
                            <input type="text" 
                                   name="menor_dni" 
                                   id="menorDni" 
                                   class="form-control form-control-sm" 
                                   value="{{ old('menor_dni', $ingreso->menor_dni ?? $ingreso->menor?->dni) }}">
                        </div>

                        {{-- APELLIDO MENOR --}}
                        <div class="col-md-3">
                            <label for="menorApellido" class="form-label fw-semibold">Apellido Menor</label>
                            <input type="text" 
                                   name="menor_apellido" 
                                   id="menorApellido" 
                                   class="form-control form-control-sm" 
                                   value="{{ old('menor_apellido', $ingreso->menor_apellido ?? $ingreso->menor?->apellido) }}">
                        </div>

                        {{-- NOMBRE MENOR --}}
                        <div class="col-md-3">
                            <label for="menorNombre" class="form-label fw-semibold">Nombre Menor</label>
                            <input type="text" 
                                   name="menor_nombre" 
                                   id="menorNombre" 
                                   class="form-control form-control-sm" 
                                   value="{{ old('menor_nombre', $ingreso->menor_nombre ?? $ingreso->menor?->nombre) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. OBSERVACIONES Y ACCIONES --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-chat-left-text"></i>Observaciones / Motivo de la visita
                            </label>
                            <textarea name="observaciones" 
                                      rows="3" 
                                      class="form-control @error('observaciones') is-invalid @enderror" 
                                      placeholder="Escriba aquí detalles adicionales si es necesario...">{{ old('observaciones', $ingreso->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('recepcion.ingresos.index') }}" class="btn btn-lg btn-light border px-4">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-lg btn-primary px-5 shadow-sm">
                                <i class="bi bi-check-circle me-2"></i>Guardar cambios
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const urlBuscar = '{{ route("recepcion.ingresos.buscar-personas") }}';

    function debounce(func, timeout = 300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
    }

    async function buscarPersonas(texto) {
        if (texto.trim().length < 2) return [];
        try {
            const res = await fetch(`${urlBuscar}?texto=${encodeURIComponent(texto)}`);
            if (!res.ok) throw new Error('Error de red');
            return await res.json();
        } catch (e) {
            console.error('Error búsqueda:', e);
            return [];
        }
    }

    function renderResultados(contenedor, data, onSelect) {
        contenedor.innerHTML = '';

        if (data.length === 0) {
            contenedor.innerHTML = `
                <div class="list-group-item text-muted small">
                    No se encontraron resultados. Puede ingresar los datos manualmente.
                </div>
            `;
            contenedor.style.display = 'block';
            return;
        }

        data.forEach(p => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'list-group-item list-group-item-action';

            const dniStr = p.dni ? `DNI: ${p.dni}` : 'Sin DNI';

            btn.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-person-fill text-muted me-2"></i>
                        <strong>${p.apellido ?? ''}</strong>, ${p.nombre ?? ''}
                    </div>
                    <span class="badge bg-light text-dark rounded-pill">${dniStr}</span>
                </div>
            `;

            btn.addEventListener('click', function () {
                onSelect(p);
                contenedor.style.display = 'none';
            });

            contenedor.appendChild(btn);
        });

        contenedor.style.display = 'block';
    }

    document.addEventListener('click', function (e) {
        const elementos = [
            { container: document.getElementById('resultadosBusqueda'), input: document.getElementById('dniInput') },
            { container: document.getElementById('resultadosMenor'), input: document.getElementById('menorBuscador') }
        ];

        elementos.forEach(({ container, input }) => {
            if (container && !container.contains(e.target) && e.target !== input) {
                container.style.display = 'none';
            }
        });
    });

    const dniInput = document.getElementById('dniInput');
    const apellidoInput = document.getElementById('apellidoInput');
    const nombreInput = document.getElementById('nombreInput');
    const personaIdHidden = document.getElementById('personaId');
    const resultadosPersona = document.getElementById('resultadosBusqueda');

    dniInput.addEventListener('input', debounce(async function () {
        const texto = this.value;
        personaIdHidden.value = ''; /

        if (texto.trim().length < 2) {
            resultadosPersona.style.display = 'none';
            return;
        }

        const data = await buscarPersonas(texto);
        renderResultados(resultadosPersona, data, (persona) => {
            personaIdHidden.value = persona.id ?? '';
            dniInput.value = persona.dni ?? '';
            apellidoInput.value = persona.apellido ?? '';
            nombreInput.value = persona.nombre ?? '';
        });
    }));

    const menorBuscador = document.getElementById('menorBuscador');
    const menorPersonaIdHidden = document.getElementById('menorPersonaId');
    const menorDni = document.getElementById('menorDni');
    const menorApellido = document.getElementById('menorApellido');
    const menorNombre = document.getElementById('menorNombre');
    const resultadosMenor = document.getElementById('resultadosMenor');

    menorBuscador.addEventListener('input', debounce(async function () {
        const texto = this.value;
        menorPersonaIdHidden.value = '';

        if (texto.trim().length < 2) {
            resultadosMenor.style.display = 'none';
            return;
        }

        const data = await buscarPersonas(texto);
        renderResultados(resultadosMenor, data, (persona) => {
            menorPersonaIdHidden.value = persona.id ?? '';
            menorBuscador.value = `${persona.apellido ?? ''}, ${persona.nombre ?? ''}`;
            menorDni.value = persona.dni ?? '';
            menorApellido.value = persona.apellido ?? '';
            menorNombre.value = persona.nombre ?? '';
        });
    }));

    const derivacionSelect = document.getElementById('derivacionSelect');
    const contenedorMenor = document.getElementById('contenedorMenor');

    function checkProdenya() {
        const selectedOption = derivacionSelect.options[derivacionSelect.selectedIndex];
        const nombre = selectedOption ? selectedOption.getAttribute('data-nombre') : '';

        if (nombre && (nombre.includes('prodenya') || nombre.includes('menor'))) {
            contenedorMenor.style.display = 'block';
        } else {
            contenedorMenor.style.display = 'none';
        }
    }

    derivacionSelect.addEventListener('change', checkProdenya);
    checkProdenya(); 
});
</script>
@endpush