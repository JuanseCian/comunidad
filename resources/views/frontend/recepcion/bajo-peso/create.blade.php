@extends('frontend.recepcion.layout.app')

@section('title', 'Nuevo Beneficiario Bajo Peso')

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
        color: #ffc107;
    }
    .form-label i {
        margin-right: 0.5rem;
        color: #6c757d;
    }
</style>
@endpush

@section('content')

<div class="container-fluid py-4">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-bold mb-0 text-gray-800">
                <i class="bi bi-heart-pulse-fill text-warning me-2"></i>Nuevo Beneficiario Bajo Peso
            </h2>
            <p class="text-muted mb-0 ms-4 ps-1">
                Registro de beneficiarios y control del programa Bajo Peso.
            </p>
        </div>
        <a href="{{ route('bajo-peso.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado
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

    <form action="{{ route('bajo-peso.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
        @csrf

        {{-- Campos Ocultos de Relaciones --}}
        <input type="hidden" name="persona_id" id="personaId" value="{{ old('persona_id') }}">
        <input type="hidden" name="familia_id" id="familiaId" value="{{ old('familia_id') }}">

        <div class="row g-4">

            {{-- ── DATOS DEL BENEFICIARIO ── --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="card-title text-uppercase text-muted fw-bold mb-0">1. Datos del Beneficiario (Menor)</h6>
                    </div>
                    <div class="card-body" style="overflow: visible;">
                        
                        <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                            <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                            <div>
                                Busque un menor ya registrado. Si no existe, complete los datos manualmente y el sistema lo creará de forma automática.
                            </div>
                        </div>

                        <div class="row g-3">
                            {{-- BUSCADOR --}}
                            <div class="col-12 position-relative">
                                <label for="beneficiarioBuscador" class="form-label fw-semibold">
                                    <i class="bi bi-search"></i>Buscar Beneficiario existente
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-person-search text-muted"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        id="beneficiarioBuscador" 
                                        class="form-control" 
                                        placeholder="Buscar por DNI, apellido o nombre..."
                                    >
                                </div>
                                {{-- Resultados autocomplete --}}
                                <div id="resultadosBeneficiario" class="list-group position-absolute w-100 search-results-container"></div>
                            </div>

                            {{-- DNI --}}
                            <div class="col-md-4">
                                <label for="dni" class="form-label fw-semibold">
                                    <i class="bi bi-card-text"></i>DNI / Documento
                                </label>
                                <input 
                                    type="text" 
                                    name="dni" 
                                    id="dni" 
                                    class="form-control @error('dni') is-invalid @enderror" 
                                    value="{{ old('dni') }}"
                                >
                                @error('dni')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- APELLIDO --}}
                            <div class="col-md-4">
                                <label for="apellido" class="form-label fw-semibold">
                                    <i class="bi bi-person"></i>Apellido
                                </label>
                                <input 
                                    type="text" 
                                    name="apellido" 
                                    id="apellido" 
                                    class="form-control @error('apellido') is-invalid @enderror" 
                                    value="{{ old('apellido') }}"
                                    required
                                >
                                @error('apellido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- NOMBRE --}}
                            <div class="col-md-4">
                                <label for="nombre" class="form-label fw-semibold">
                                    <i class="bi bi-person"></i>Nombre(s)
                                </label>
                                <input 
                                    type="text" 
                                    name="nombre" 
                                    id="nombre" 
                                    class="form-control @error('nombre') is-invalid @enderror" 
                                    value="{{ old('nombre') }}"
                                    required
                                >
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- FECHA DE NACIMIENTO --}}
                            <div class="col-md-4">
                                <label for="fecha_nacimiento" class="form-label fw-semibold">
                                    <i class="bi bi-calendar-date"></i>Fecha de Nacimiento
                                </label>
                                <input 
                                    type="date" 
                                    name="fecha_nacimiento" 
                                    id="fecha_nacimiento" 
                                    class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                    value="{{ old('fecha_nacimiento') }}"
                                >
                                @error('fecha_nacimiento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- EDAD --}}
                            <div class="col-md-4">
                                <label for="edad" class="form-label fw-semibold">
                                    <i class="bi bi-clock-history"></i>Edad calculada
                                </label>
                                <input 
                                    type="text" 
                                    id="edad" 
                                    class="form-control bg-light" 
                                    value="{{ old('edad') }}" 
                                    readonly
                                >
                            </div>

                            {{-- CÓDIGO FAMILIA --}}
                            <div class="col-md-4">
                                <label for="familia_codigo" class="form-label fw-semibold">
                                    <i class="bi bi-house-door"></i>Código Familia
                                </label>
                                <input 
                                    type="text" 
                                    id="familia_codigo" 
                                    class="form-control bg-light" 
                                    value="{{ old('familia_codigo') }}" 
                                    readonly
                                >
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="row g-4">
                    
                    <div class="col-12">
                        <label for="tutor_nombre" class="form-label fw-semibold">
                            <i class="bi bi-person"></i>
                            Nombre del Tutor
                        </label>

                        <input
                            type="text"
                            name="tutor_nombre"
                            id="tutor_nombre"
                            class="form-control @error('tutor_nombre') is-invalid @enderror"
                            value="{{ old('tutor_nombre') }}"
                        >

                        @error('tutor_nombre')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="tutor_dni" class="form-label fw-semibold">
                            <i class="bi bi-card-text"></i>
                            DNI del Tutor
                        </label>

                        <input
                            type="text"
                            name="tutor_dni"
                            id="tutor_dni"
                            class="form-control @error('tutor_dni') is-invalid @enderror"
                            value="{{ old('tutor_dni') }}"
                        >

                        @error('tutor_dni')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="tutor_parentezco" class="form-label fw-semibold">
                            <i class="bi bi-person-check"></i>
                            Responsable
                        </label>

                        <input
                            type="text"
                            name="tutor_parentezco"
                            id="tutor_parentezco"
                            class="form-control @error('tutor_parentezco') is-invalid @enderror"
                            value="{{ old('tutor_parentezco') }}"
                            placeholder="Ej: Madre, Padre, Tutor Legal, Abuela"
                        >

                        @error('tutor_parentezco')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- DOCUMENTACIÓN --}}
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                                <h6 class="card-title text-uppercase text-muted fw-bold mb-0">3. Archivos / Documentación</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="certificado_bajo_peso" class="form-label fw-semibold">
                                            <i class="bi bi-file-earmark-medical"></i>Certificado Bajo Peso
                                        </label>
                                        <input 
                                            type="file" 
                                            name="certificado_bajo_peso" 
                                            id="certificado_bajo_peso"
                                            class="form-control" 
                                            accept=".pdf,.jpg,.jpeg,.png"
                                        >
                                    </div>
                                    <div class="col-12">
                                        <label for="informe_socioambiental" class="form-label fw-semibold">
                                            <i class="bi bi-file-earmark-text"></i>Informe Socioambiental
                                        </label>
                                        <input 
                                            type="file" 
                                            name="informe_socioambiental" 
                                            id="informe_socioambiental"
                                            class="form-control" 
                                            accept=".pdf,.jpg,.jpeg,.png"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── INFORMACIÓN MÉDICA Y EVOLUCIÓN ── --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="card-title text-uppercase text-muted fw-bold mb-0">4. Información Médica y Diagnóstico</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="diagnostico" class="form-label fw-semibold">
                                    <i class="bi bi-clipboard2-pulse"></i>Diagnóstico Inicial
                                </label>
                                <textarea 
                                    name="diagnostico" 
                                    id="diagnostico"
                                    rows="3" 
                                    class="form-control" 
                                    placeholder="Detalles sobre el estado nutricional y diagnóstico..."
                                >{{ old('diagnostico') }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label for="tratamiento" class="form-label fw-semibold">
                                    <i class="bi bi-capsule"></i>Tratamiento / Indicaciones
                                </label>
                                <textarea 
                                    name="tratamiento" 
                                    id="tratamiento"
                                    rows="3" 
                                    class="form-control" 
                                    placeholder="Plan alimentario, suplementación o pasos médicos a seguir..."
                                >{{ old('tratamiento') }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label for="observaciones" class="form-label fw-semibold">
                                    <i class="bi bi-chat-left-text"></i>Observaciones Generales
                                </label>
                                <textarea 
                                    name="observaciones" 
                                    id="observaciones"
                                    rows="3" 
                                    class="form-control" 
                                    placeholder="Notas adicionales o información ambiental relevante..."
                                >{{ old('observaciones') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACCIONES DE BOTONES --}}
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('bajo-peso.index') }}" class="btn btn-secondary px-4">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-warning px-4 text-dark fw-semibold">
                        <i class="bi bi-save me-2"></i>Guardar Beneficiario
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const urlBuscar = '{{ route("recepcion.bajo-peso.buscar-personas") }}';
    const buscador = document.getElementById('beneficiarioBuscador');
    const resultados = document.getElementById('resultadosBeneficiario');
    const personaId = document.getElementById('personaId');
    const familiaId = document.getElementById('familiaId');

    /**
     * Función asíncrona para buscar personas en el servidor
     */
    async function buscar(texto) {
        try {
            const res = await fetch(`${urlBuscar}?texto=${encodeURIComponent(texto)}`);
            if (!res.ok) throw new Error('Error de red');
            return await res.json();
        } catch (e) {
            console.error('Error en búsqueda:', e);
            return [];
        }
    }

    /**
     * Listener de escritura para renderizar los resultados dinámicos
     */
    buscador.addEventListener('input', async function () {
        let texto = this.value.trim();

        if (!texto || texto.length < 2) {
            resultados.style.display = 'none';
            resultados.innerHTML = '';
            return;
        }

        const personas = await buscar(texto);
        resultados.innerHTML = '';

        if (personas.length === 0) {
            resultados.innerHTML = `
                <div class="list-group-item text-muted small">
                    <i class="bi bi-info-circle me-1"></i>No se encontraron resultados. Complete los datos manualmente.
                </div>`;
            resultados.style.display = 'block';
            return;
        }

        personas.forEach(p => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action';

            item.innerHTML = `
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong>${p.apellido ?? ''}</strong>, ${p.nombre ?? ''}
                        <br>
                        <small class="text-muted">DNI: ${p.dni ?? 'Sin DNI'} | Edad: ${p.edad ?? '-'} años</small>
                    </div>
                </div>
            `;

            item.addEventListener('click', function (e) {
                e.preventDefault();

                // Setear valores en inputs ocultos
                personaId.value = p.id;
                familiaId.value = p.familia_id;

                // Rellenar datos en inputs visibles
                document.getElementById('dni').value = p.dni ?? '';
                document.getElementById('apellido').value = p.apellido ?? '';
                document.getElementById('nombre').value = p.nombre ?? '';

                if (p.fecha_nacimiento) {
                    document.getElementById('fecha_nacimiento').value = p.fecha_nacimiento.split(' ')[0];
                }

                document.getElementById('edad').value = p.edad ?? '';
                document.getElementById('familia_codigo').value = p.familia_codigo ?? '';

                buscador.value = `${p.apellido ?? ''}, ${p.nombre ?? ''}`;
                resultados.style.display = 'none';
            });

            resultados.appendChild(item);
        });

        resultados.style.display = 'block';
    });

    /**
     * Cerrar contenedor de autocompletado al presionar afuera
     */
    document.addEventListener('click', function(e){
        if (resultados && !resultados.contains(e.target) && e.target !== buscador) {
            resultados.style.display = 'none';
        }
    });

    /**
     * Cálculo de edad automatizado por cambio manual de fecha
     */
    const fechaNacimientoInput = document.getElementById('fecha_nacimiento');
    if (fechaNacimientoInput) {
        fechaNacimientoInput.addEventListener('change', function(){
            if(!this.value) return;

            let nacimiento = new Date(this.value);
            let hoy = new Date();
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            let m = hoy.getMonth() - nacimiento.getMonth();

            if (m < 0 || (m === 0 && hoy.getDate() < nacimiento.getDate())) {
                edad--;
            }

            document.getElementById('edad').value = edad;
        });
    }
});
</script>
@endpush