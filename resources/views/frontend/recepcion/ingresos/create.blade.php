@extends('frontend.recepcion.layout.app')

@section('title', 'Nuevo Ingreso')

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

    .list-group-item-action:hover, .list-group-item-action:focus {
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

    {{-- Encabezado de página optimizado --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-bold mb-0 text-gray-800">
                <i class="bi bi-person-plus-fill text-success me-2"></i>Nuevo Ingreso
            </h2>
            <p class="text-muted mb-0 ms-4 ps-1">
                Registrar nueva visita o gestión desde la recepción central.
            </p>
        </div>
        <a href="{{ route('recepcion.ingresos.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado
        </a>
    </div>

    <form action="{{ route('recepcion.ingresos.store') }}" method="POST" autocomplete="off">
        @csrf

        {{-- ID PERSONA PRINCIPAL Oculto --}}
        <input type="hidden" name="persona_id" id="personaId">

        <div class="row g-4">
            
            {{-- COLUMNA PRINCIPAL: DATOS DE LA PERSONA --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="card-title text-uppercase text-muted fw-bold mb-0">1. Datos del Visitante</h6>
                    </div>
                    <div class="card-body" style="overflow: visible;">
                        <div class="row g-3">

                            {{-- BUSCADOR / DNI --}}
                            <div class="col-md-5 position-relative">
                                <label for="dniInput" class="form-label fw-semibold">
                                    <i class="bi bi-card-text"></i>DNI / Documento
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                                    <input 
                                        type="text" 
                                        name="dni" 
                                        id="dniInput" 
                                        class="form-control" 
                                        placeholder="Buscar o ingresar DNI..."
                                        required
                                    >
                                </div>
                                
                                {{-- CONTENEDOR DE RESULTADOS --}}
                                <div id="resultadosBusqueda" class="list-group position-absolute w-100 search-results-container">
                                    {{-- Se llena vía JS --}}
                                </div>
                                <small class="form-text text-muted">Busque por DNI para autocompletar o ingrese uno nuevo.</small>
                            </div>

                            {{-- APELLIDO --}}
                            <div class="col-md-7">
                                <label for="apellidoInput" class="form-label fw-semibold">
                                    <i class="bi bi-person"></i>Apellido
                                </label>
                                <input 
                                    type="text" 
                                    name="apellido" 
                                    id="apellidoInput" 
                                    class="form-control" 
                                    required
                                >
                            </div>

                            {{-- NOMBRE --}}
                            <div class="col-md-12">
                                <label for="nombreInput" class="form-label fw-semibold">
                                    <i class="bi bi-person"></i>Nombre(s)
                                </label>
                                <input 
                                    type="text" 
                                    name="nombre" 
                                    id="nombreInput" 
                                    class="form-control" 
                                    required
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- COLUMNA SECUNDARIA: INFO DEL INGRESO --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="card-title text-uppercase text-muted fw-bold mb-0">2. Detalles del Ingreso</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- FECHA --}}
                            <div class="col-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-calendar-date"></i>Fecha
                                </label>
                                <input 
                                    type="date" 
                                    name="fecha_ingreso" 
                                    class="form-control" 
                                    value="{{ now('America/Argentina/Buenos_Aires')->format('Y-m-d') }}" 
                                    required
                                >
                            </div>

                            {{-- HORA --}}
                            <div class="col-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-clock"></i>Hora
                                </label>
                                <input 
                                    type="time" 
                                    name="hora_ingreso" 
                                    class="form-control" 
                                    value="{{ now('America/Argentina/Buenos_Aires')->format('H:i') }}" 
                                    required
                                >
                            </div>
                            
                            {{-- DERIVACIÓN --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-signpost-2"></i>Derivación / Destino
                                </label>
                                <select name="derivacion_id" class="form-select" required>
                                    <option value="" selected disabled>Seleccionar destino...</option>
                                    @foreach($derivaciones as $derivacion)
                                        <option value="{{ $derivacion->id }}">
                                            {{ $derivacion->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN CONDICIONAL: DATOS DEL MENOR (PRODENYA) --}}
            <div class="col-12" id="contenedorMenor" style="display:none;">
                <div id="seccionMenor" class="shadow-sm">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-warning-subtle text-warning rounded-circle p-2 me-3">
                            <i class="bi bi-children fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-warning-emphasis">Datos del Menor (Caso PRODENYA)</h5>
                            <p class="text-muted mb-0">Complete si el ingreso está vinculado a un menor de edad.</p>
                        </div>
                    </div>
                    
                    <hr class="border-warning opacity-25">

                    {{-- ID OCULTO MENOR --}}
                    <input type="hidden" name="menor_persona_id" id="menorPersonaId">

                    <div class="row g-3">
                        {{-- BUSCADOR MENOR --}}
                        <div class="col-md-4 position-relative">
                            <label for="menorBuscador" class="form-label fw-semibold text-warning-emphasis">Buscar Menor</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                                <input 
                                    type="text" 
                                    id="menorBuscador" 
                                    class="form-control" 
                                    placeholder="DNI, Apellido o Nombre..."
                                >
                            </div>
                            <div id="resultadosMenor" class="list-group position-absolute w-100 search-results-container"></div>
                        </div>

                        {{-- DNI MENOR --}}
                        <div class="col-md-2">
                            <label for="menorDni" class="form-label fw-semibold">DNI Menor</label>
                            <input type="text" name="menor_dni" id="menorDni" class="form-control form-control-sm">
                        </div>

                        {{-- APELLIDO MENOR --}}
                        <div class="col-md-3">
                            <label for="menorApellido" class="form-label fw-semibold">Apellido Menor</label>
                            <input type="text" name="menor_apellido" id="menorApellido" class="form-control form-control-sm">
                        </div>

                        {{-- NOMBRE MENOR --}}
                        <div class="col-md-3">
                            <label for="menorNombre" class="form-label fw-semibold">Nombre Menor</label>
                            <input type="text" name="menor_nombre" id="menorNombre" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
            </div>

            {{-- OBSERVACIONES Y ACCIONES --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-chat-left-text"></i>Observaciones / Motivo de la visita
                            </label>
                            <textarea 
                                name="observaciones" 
                                rows="3" 
                                class="form-control"
                                placeholder="Escriba aquí detalles adicionales si es necesario..."
                            ></textarea>
                        </div>

                        {{-- BOTONES DE ACCIÓN --}}
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('recepcion.ingresos.index') }}" class="btn btn-lg btn-light border px-4">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-lg btn-success px-5 shadow-sm">
                                <i class="bi bi-check-circle me-2"></i>Registrar Ingreso
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div> {{-- Fin Row g-4 --}}
    </form>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    async function realizarBusqueda(texto, url) {
        if (texto.length < 2) return [];
        try {
            const response = await fetch(`${url}?texto=${encodeURIComponent(texto)}`);
            if (!response.ok) throw new Error('Error en red');
            return await response.json();
        } catch (error) {
            console.error('Error en búsqueda:', error);
            return [];
        }
    }

    document.addEventListener('click', function (e) {
        const buscadores = [
            { container: document.getElementById('resultadosBusqueda'), input: document.getElementById('dniInput') },
            { container: document.getElementById('resultadosMenor'), input: document.getElementById('menorBuscador') }
        ];

        buscadores.forEach(b => {
            if (b.container && !b.container.contains(e.target) && e.target !== b.input) {
                b.container.style.display = 'none';
            }
        });
    });


    const dniInput = document.getElementById('dniInput');
    const apellidoInput = document.getElementById('apellidoInput');
    const nombreInput = document.getElementById('nombreInput');
    const personaIdHidden = document.getElementById('personaId');
    const resultadosPersona = document.getElementById('resultadosBusqueda');
    const urlBuscar = `{{ route('recepcion.personas.buscar') }}`;

    dniInput.addEventListener('keyup', async function () {
        const texto = this.value.trim();

        if (texto === '') {
            personaIdHidden.value = '';
        }

        if (texto.length < 2) {
            resultadosPersona.innerHTML = '';
            resultadosPersona.style.display = 'none';
            return;
        }

        const data = await realizarBusqueda(texto, urlBuscar);
        resultadosPersona.innerHTML = '';

        if (data.length === 0) {
            resultadosPersona.innerHTML = '<div class="list-group-item text-muted small">No se encontraron personas. Se registrará como nueva.</div>';
            resultadosPersona.style.display = 'block';
            personaIdHidden.value = ''; // Es nueva
            return;
        }

        data.forEach(persona => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'list-group-item list-group-item-action';
            
            const dniStr = persona.dni ? `DNI: ${persona.dni}` : 'Sin DNI';
            
            btn.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-person-fill text-muted me-2"></i>
                        <strong>${persona.apellido}</strong>, ${persona.nombre}
                    </div>
                    <span class="badge bg-light text-dark rounded-pill">${dniStr}</span>
                </div>
            `;

            btn.addEventListener('click', function () {
                dniInput.value = persona.dni ?? '';
                apellidoInput.value = persona.apellido ?? '';
                nombreInput.value = persona.nombre ?? '';
                personaIdHidden.value = persona.id; // Asignar ID existente

                resultadosPersona.innerHTML = '';
                resultadosPersona.style.display = 'none';
            });

            resultadosPersona.appendChild(btn);
        });

        resultadosPersona.style.display = 'block';
    });


    const derivacionSelect = document.querySelector('select[name="derivacion_id"]');
    const contenedorMenor = document.getElementById('contenedorMenor');
    const inputsMenor = contenedorMenor.querySelectorAll('input[type="text"]');

    derivacionSelect.addEventListener('change', function () {
        const textSelected = this.options[this.selectedIndex].text.toLowerCase();

        if (textSelected.includes('prodenya')) {
            contenedorMenor.style.display = 'block';
        } else {
            contenedorMenor.style.display = 'none';
            document.getElementById('menorPersonaId').value = '';
            document.getElementById('menorBuscador').value = '';
            inputsMenor.forEach(i => {
                i.value = '';
            });
        }
    });

    const menorBuscador = document.getElementById('menorBuscador');
    const resultadosMenor = document.getElementById('resultadosMenor');
    const menorIdHidden = document.getElementById('menorPersonaId');
    const menorDni = document.getElementById('menorDni');
    const menorApellido = document.getElementById('menorApellido');
    const menorNombre = document.getElementById('menorNombre');

    menorBuscador.addEventListener('keyup', async function () {
        const texto = this.value.trim();

        if (texto === '') {
            menorIdHidden.value = '';
        }

        if (texto.length < 2) {
            resultadosMenor.style.display = 'none';
            return;
        }

        const data = await realizarBusqueda(texto, urlBuscar); // Usamos la misma URL
        resultadosMenor.innerHTML = '';

        if (data.length === 0) {
            resultadosMenor.innerHTML = '<div class="list-group-item text-muted small">No encontrado. Ingrese datos manualmente.</div>';
            resultadosMenor.style.display = 'block';
            menorIdHidden.value = '';
            return;
        }

        data.forEach(persona => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'list-group-item list-group-item-action';

            const dniStr = persona.dni ? `DNI: ${persona.dni}` : 'Sin DNI';

            btn.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <span><strong>${persona.apellido}</strong>, ${persona.nombre}</span>
                    <small class="text-muted">${dniStr}</small>
                </div>
            `;

            btn.addEventListener('click', function () {
                menorIdHidden.value = persona.id;
                menorDni.value = persona.dni ?? '';
                menorApellido.value = persona.apellido ?? '';
                menorNombre.value = persona.nombre ?? '';
                menorBuscador.value = `${persona.apellido}, ${persona.nombre}`; 

                resultadosMenor.style.display = 'none';
            });

            resultadosMenor.appendChild(btn);
        });

        resultadosMenor.style.display = 'block';
    });
});
</script>
@endpush

@endsection