@extends('frontend.recepcion.layout.app')

@section('title', 'Nuevo Sepelio')

@section('content')

<div class="container-fluid py-4" style="max-width: 1000px;">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-1">Nuevo Sepelio</h2>
            <p class="text-muted mb-0">Registrar asistencia funeraria o solicitud de sepelio</p>
        </div>
    </div>

    {{-- ERRORES --}}
    @if ($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('recepcion.sepelios.store') }}" method="POST">
                @csrf

                <input type="hidden" name="persona_id" id="personaId">
                <input type="hidden" name="dni" id="dniHidden">

                {{-- BUSCADOR --}}
                <div class="bg-light p-3 rounded-3 mb-4 position-relative border">
                    <label class="form-label fw-bold text-primary">1. Buscar solicitante</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" id="buscadorPersona" class="form-control form-control-lg border-start-0 ps-0" placeholder="Ingresá DNI, nombre o apellido..." autocomplete="off">
                    </div>
                    <div id="resultadosBusqueda" class="list-group shadow position-absolute w-100 mt-1 d-none" style="z-index:1050; max-height:250px; overflow-y:auto;"></div>
                </div>

                {{-- DATOS DEL SOLICITANTE --}}
                <label class="form-label fw-bold text-secondary mb-3">2. Datos del solicitante</label>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Apellido</label>
                        <input type="text" name="apellido" id="apellidoInput" class="form-control" required value="{{ old('apellido') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Nombre</label>
                        <input type="text" name="nombre" id="nombreInput" class="form-control" required value="{{ old('nombre') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">DNI</label>
                        <input type="text" id="dniVisible" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Carácter</label>
                        <select name="caracter" class="form-select">
                            <option value="">Seleccionar</option>
                            <option value="Familiar" {{ old('caracter') == 'Familiar' ? 'selected' : '' }}>Familiar</option>
                            <option value="Responsable" {{ old('caracter') == 'Responsable' ? 'selected' : '' }}>Responsable</option>
                            <option value="Tutor" {{ old('caracter') == 'Tutor' ? 'selected' : '' }}>Tutor</option>
                            <option value="Otro" {{ old('caracter') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Teléfono responsable</label>
                        <input type="text" name="telefono_responsable" id="telefonoInput" class="form-control" value="{{ old('telefono_responsable') }}">
                    </div>
                </div>

                {{-- DATOS DEL FALLECIDO --}}
                <label class="form-label fw-bold text-secondary mb-3">3. Datos del fallecido</label>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Nombre y Apellido</label>
                        <input type="text" name="fallecido_nombre" class="form-control" required value="{{ old('fallecido_nombre') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">DNI</label>
                        <input type="text" name="fallecido_dni" class="form-control" value="{{ old('fallecido_dni') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Fecha fallecimiento</label>
                        <input type="date" name="fecha_fallecimiento" class="form-control" value="{{ old('fecha_fallecimiento') }}">
                    </div>
                </div>

                {{-- DATOS DEL SERVICIO --}}
                <label class="form-label fw-bold text-secondary mb-3">4. Datos del servicio</label>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Origen de Cobertura</label>
                        <select name="tipo_sepelio" class="form-select" required>
                            <option value="municipal" {{ old('tipo_sepelio') == 'municipal' ? 'selected' : '' }}>Municipal</option>
                            <option value="particular" {{ old('tipo_sepelio') == 'particular' ? 'selected' : '' }}>Particular</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small text-muted">Servicio solicitado</label>
                        <select id="tipoServicioAux" name="categoria_servicio_aux" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <option value="sepelio" {{ old('categoria_servicio_aux') == 'sepelio' ? 'selected' : '' }}>Sepelio</option>
                            <option value="cremacion" {{ old('categoria_servicio_aux') == 'cremacion' ? 'selected' : '' }}>Cremación</option>
                        </select>
                    </div>

                    {{-- Se muestra dinámicamente si el selector auxiliar es 'sepelio' --}}
                    <div id="bloqueSepelio" class="col-md-4" style="display: none;">
                        <label class="form-label small text-muted">Variante de Sepelio</label>
                        <select name="categoria_servicio" id="categoriaServicio" class="form-select">
                            <option value="">Seleccionar...</option>
                            <option value="angelito" {{ old('categoria_servicio') == 'angelito' ? 'selected' : '' }}>Angelito (Bebé)</option>
                            <option value="normal" {{ old('categoria_servicio') == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="vaca" {{ old('categoria_servicio') == 'vaca' ? 'selected' : '' }}>Vaca</option>
                            <option value="extra_vaca" {{ old('categoria_servicio') == 'extra_vaca' ? 'selected' : '' }}>Extra Vaca</option>
                        </select>
                    </div>

                    <div id="bloqueMantenimiento" class="col-md-4 d-flex align-items-center pt-4" style="display: none;">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="mantenimiento" name="mantenimiento" value="1" {{ old('mantenimiento') ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium text-dark" for="mantenimiento">Incluye mantenimiento</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small text-muted">Costo</label>
                        <input type="number" step="0.01" name="costo" class="form-control" value="{{ old('costo') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small text-muted">Fecha solicitud</label>
                        <input type="date" name="fecha_solicitud" class="form-control" value="{{ old('fecha_solicitud') ?? date('Y-m-d') }}">
                    </div>
                </div>

                {{-- OBSERVACIONES --}}
                <label class="form-label fw-bold text-secondary mb-3">5. Observaciones</label>
                <div class="mb-4">
                    <textarea name="observaciones" rows="4" class="form-control" placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
                </div>

                <hr>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('recepcion.sepelios.index') }}" class="btn btn-light border px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check2-circle me-1"></i> Registrar Sepelio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Buscador asíncrono de solicitantes
    const elements = {
        buscador: document.getElementById('buscadorPersona'),
        apellido: document.getElementById('apellidoInput'),
        nombre: document.getElementById('nombreInput'),
        dniVisible: document.getElementById('dniVisible'),
        dniHidden: document.getElementById('dniHidden'),
        personaId: document.getElementById('personaId'),
        resultados: document.getElementById('resultadosBusqueda')
    };

    elements.buscador.addEventListener('input', async (e) => {
        const texto = e.target.value.trim();
        if (texto.length < 2) {
            elements.resultados.innerHTML = '';
            elements.resultados.classList.add('d-none');
            return;
        }

        try {
            const response = await fetch(`{{ route('recepcion.sepelios.buscar-personas') }}?texto=${encodeURIComponent(texto)}`);
            const data = await response.json();
            elements.resultados.innerHTML = '';

            if (data.length) {
                elements.resultados.classList.remove('d-none');
                data.forEach(p => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'list-group-item list-group-item-action';
                    btn.innerHTML = `
                        <div class="d-flex justify-content-between">
                            <span><strong>${p.apellido}</strong>, ${p.nombre}</span>
                            <span class="text-muted small">DNI: ${p.dni ?? 'S/D'}</span>
                        </div>`;
                    btn.onclick = () => {
                        elements.personaId.value = p.id;
                        elements.dniHidden.value = p.dni ?? '';
                        elements.apellido.value = p.apellido;
                        elements.nombre.value = p.nombre;
                        elements.dniVisible.value = p.dni ?? '';
                        document.getElementById('telefonoInput').value = p.telefono ?? '';
                        elements.buscador.value = `${p.apellido}, ${p.nombre}`;
                        elements.resultados.classList.add('d-none');
                    };
                    elements.resultados.appendChild(btn);
                });
            } else {
                elements.resultados.classList.add('d-none');
            }
        } catch (error) {
            console.error(error);
        }
    });

    document.addEventListener('click', (e) => {
        if (!elements.resultados.contains(e.target) && e.target !== elements.buscador) {
            elements.resultados.classList.add('d-none');
        }
    });

    // Control de UI dinámica condicional
    const tipoServicioAux = document.getElementById('tipoServicioAux');
    const bloqueSepelio = document.getElementById('bloqueSepelio');
    const bloqueMantenimiento = document.getElementById('bloqueMantenimiento');
    const categoriaServicio = document.getElementById('categoriaServicio');
    const mantenimiento = document.getElementById('mantenimiento');

    function actualizarFormulario() {
        if (tipoServicioAux.value === 'sepelio') {
            bloqueSepelio.style.display = 'block';
            bloqueMantenimiento.style.display = 'block';
        } else {
            bloqueSepelio.style.display = 'none';
            bloqueMantenimiento.style.display = 'none';
            if (categoriaServicio) categoriaServicio.value = '';
            if (mantenimiento) mantenimiento.checked = false;
        }
    }

    tipoServicioAux.addEventListener('change', actualizarFormulario);
    actualizarFormulario();
});
</script>
@endpush
@endsection