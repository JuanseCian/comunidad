@extends('frontend.recepcion.layout.app')

@section('title', 'Nueva entrega')

@section('content')

<div class="container-fluid py-4" style="max-width: 900px;">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-1">Nueva entrega</h2>
            <p class="text-muted mb-0">Registrar entrega mensual de mercadería</p>
        </div>
    </div>

    {{-- ALERTAS --}}
    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center rounded-3 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- FORMULARIO --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('recepcion.mercaderias.store') }}" method="POST">
                @csrf
                
                <input type="hidden" name="persona_id" id="personaId">
                

                {{-- SECCIÓN 1: BUSCADOR (Destacado) --}}
                <div class="bg-light p-3 rounded-3 mb-4 position-relative border">
                    <label class="form-label fw-bold text-primary">1. Buscar familia o persona</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" id="buscadorPersona" class="form-control form-control-lg border-start-0 ps-0" placeholder="Ingresá DNI, nombre o apellido..." autocomplete="off">
                    </div>

                    {{-- Alerta: Ya retiró --}}
                    <div id="avisoFamilia" class="alert alert-warning mt-2 mb-0 py-2 d-none">
                        <i class="bi bi-exclamation-circle-fill me-1"></i> <strong>Atención:</strong> Esta familia ya retiró mercadería este mes.
                    </div>

                    {{-- Resultados del buscador --}}
                    <div id="resultadosBusqueda" class="list-group shadow position-absolute w-100 mt-1 d-none" style="z-index: 1050; max-height: 250px; overflow-y: auto;">
                    </div>
                </div>

                {{-- SECCIÓN 2: DATOS DE LA ENTREGA --}}
                <label class="form-label fw-bold text-secondary mb-3">2. Datos del retiro</label>
                
                <div class="col-md-6">
                    <label class="form-label small text-muted mb-1">DNI</label>
                    <input type="text"
                        name="dni"
                        id="dniInput"
                        class="form-control"
                        value="{{ old('dni') }}"
                        placeholder="Ingrese DNI">
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small text-muted mb-1">Apellido</label>
                        <input type="text" name="apellido" id="apellidoInput" class="form-control" value="{{ old('apellido') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted mb-1">Nombre</label>
                        <input type="text" name="nombre" id="nombreInput" class="form-control" value="{{ old('nombre') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small text-muted mb-1">Fecha de entrega</label>
                        <input type="date" name="fecha_entrega" class="form-control" value="{{ old('fecha_entrega', date('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label small text-muted mb-1">Observaciones</label>
                        <input type="text" name="observaciones" class="form-control" placeholder="Aclaraciones opcionales..." value="{{ old('observaciones') }}">
                    </div>
                </div>

                <hr class="my-4 text-muted">

                {{-- BOTONES --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('recepcion.mercaderias.index') }}" class="btn btn-light border px-4">Cancelar</a>
                    <button type="submit" class="btn btn-success px-4 fw-medium">
                        <i class="bi bi-check2-circle me-1"></i> Registrar entrega
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    
    const elements = {
        buscador: document.getElementById('buscadorPersona'),
        apellido: document.getElementById('apellidoInput'),
        nombre: document.getElementById('nombreInput'),
        dni: document.getElementById('dniInput'),
        personaId: document.getElementById('personaId'),
        resultados: document.getElementById('resultadosBusqueda'),
        aviso: document.getElementById('avisoFamilia')
    };

    // Evento de búsqueda
    elements.buscador.addEventListener('input', async (e) => {
        const texto = e.target.value.trim();

        // Resetear campos ocultos y alertas
        elements.personaId.value = '';
        elements.dni.value = '';
        elements.aviso.classList.add('d-none');

        if (texto.length < 2) {
            elements.resultados.innerHTML = '';
            elements.resultados.classList.add('d-none');
            return;
        }

        try {
            const response = await fetch(`{{ route('recepcion.mercaderias.buscar-personas') }}?texto=${encodeURIComponent(texto)}`);
            const data = await response.json();

            elements.resultados.innerHTML = '';

            
            if (data.length > 0) {
                elements.resultados.classList.remove('d-none');

                elements.personaId.value = '';

                elements.apellido.value = '';
                elements.nombre.value = '';

                data.forEach(p => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'list-group-item list-group-item-action py-2';
                    
                    const badge = p.familia_ya_retiro 
                        ? `<span class="badge bg-warning text-dark ms-2">Ya retiró</span>` 
                        : (p.familia_id ? `<span class="badge bg-success-subtle text-success ms-2">Familia #${p.familia_id}</span>` : '');

                    btn.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center">
                            <span><strong>${p.apellido}</strong>, ${p.nombre} ${badge}</span>
                            <span class="text-muted small">DNI: ${p.dni ?? 'S/D'}</span>
                        </div>
                    `;

                    // Al seleccionar una persona
                    btn.onclick = () => {
                        elements.personaId.value = p.id;
                        elements.dni.value = p.dni ?? '';
                        elements.buscador.value = `${p.apellido}, ${p.nombre}`;
                        elements.apellido.value = p.apellido;
                        elements.nombre.value = p.nombre;
                        
                        elements.resultados.classList.add('d-none');
                        
                        if (p.familia_ya_retiro) {
                            elements.aviso.classList.remove('d-none');
                        }
                    };

                    elements.resultados.appendChild(btn);
                });
            } else {
                elements.resultados.classList.add('d-none');
            }
        } catch (error) {
            console.error("Error buscando personas:", error);
        }
    });

    // Cerrar menú si se hace clic afuera
    document.addEventListener('click', (e) => {
        if (!elements.resultados.contains(e.target) && e.target !== elements.buscador) {
            elements.resultados.classList.add('d-none');
        }
    });
});
</script>
@endpush

@endsection