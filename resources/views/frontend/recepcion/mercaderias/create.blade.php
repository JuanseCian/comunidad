@extends('frontend.recepcion.layout.app')

@section('title', 'Nueva entrega')

@section('content')

<div class="container-fluid py-4">

    {{-- CABECERA --}}
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Nueva entrega de mercadería</h2>
        <p class="text-muted mb-0">Registrar entrega mensual</p>
    </div>

    {{-- ALERTAS --}}
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- CARD --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('recepcion.mercaderias.store') }}" method="POST">

                @csrf

                {{-- IDs ocultos --}}
                <input type="hidden" name="persona_id" id="personaId">
                <input type="hidden" name="dni"        id="dniHidden">

                <div class="row g-4">

                    {{-- BUSCADOR --}}
                    <div class="col-md-4 position-relative">

                        <label class="form-label fw-semibold">Buscar persona</label>

                        <input type="text"
                               id="buscadorPersona"
                               class="form-control"
                               placeholder="DNI, nombre o apellido..."
                               autocomplete="off">

                        {{-- Aviso familia ya retiró --}}
                        <div id="avisoFamilia"
                             class="alert alert-warning py-2 px-3 mt-2 mb-0 d-none small">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                            <strong>Atención:</strong> esta familia ya retiró mercadería este mes.
                        </div>

                        {{-- RESULTADOS --}}
                        <div id="resultadosBusqueda"
                             class="list-group shadow position-absolute bg-white border"
                             style="top:100%;left:0;right:0;z-index:9999;display:none;max-height:300px;overflow-y:auto;">
                        </div>

                    </div>

                    {{-- APELLIDO --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Apellido</label>
                        <input type="text"
                               name="apellido"
                               id="apellidoInput"
                               class="form-control"
                               value="{{ old('apellido') }}"
                               required>
                    </div>

                    {{-- NOMBRE --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nombre</label>
                        <input type="text"
                               name="nombre"
                               id="nombreInput"
                               class="form-control"
                               value="{{ old('nombre') }}"
                               required>
                    </div>

                    {{-- FECHA --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fecha entrega</label>
                        <input type="date"
                               name="fecha_entrega"
                               class="form-control"
                               value="{{ old('fecha_entrega', date('Y-m-d')) }}"
                               required>
                    </div>

                    {{-- OBSERVACIONES --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">Observaciones</label>
                        <textarea name="observaciones"
                                  rows="4"
                                  class="form-control">{{ old('observaciones') }}</textarea>
                    </div>

                </div>

                {{-- BOTONES --}}
                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('recepcion.mercaderias.index') }}"
                       class="btn btn-light border">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle me-1"></i>
                        Registrar entrega
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@push('scripts')
<script>

const buscador      = document.getElementById('buscadorPersona');
const apellidoInput = document.getElementById('apellidoInput');
const nombreInput   = document.getElementById('nombreInput');
const dniHidden     = document.getElementById('dniHidden');
const personaId     = document.getElementById('personaId');
const resultados    = document.getElementById('resultadosBusqueda');
const avisoFamilia  = document.getElementById('avisoFamilia');

/*
|--------------------------------------------------------------------------
| BUSCADOR
|--------------------------------------------------------------------------
*/
buscador.addEventListener('input', async function () {

    const texto = this.value.trim();

    // Reset
    personaId.value = '';
    dniHidden.value = '';
    avisoFamilia.classList.add('d-none');

    if (texto.length < 2) {
        resultados.innerHTML = '';
        resultados.style.display = 'none';
        return;
    }

    try {
        const response = await fetch(
            `{{ route('recepcion.mercaderias.buscar-personas') }}?texto=${encodeURIComponent(texto)}`
        );
        const data = await response.json();

        resultados.innerHTML = '';

        if (data.length > 0) {

            resultados.style.display = 'block';

            data.forEach(p => {

                const item = document.createElement('button');
                item.type      = 'button';
                item.className = 'list-group-item list-group-item-action';

                // Badge de familia si ya retiró
                const badgeRetiro = p.familia_ya_retiro
                    ? `<span class="badge bg-warning text-dark ms-2">Ya retiró este mes</span>`
                    : (p.familia_id
                        ? `<span class="badge bg-success-subtle text-success border border-success-subtle ms-2">Familia #${p.familia_id}</span>`
                        : '');

                item.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <span>
                            <strong>${p.apellido}</strong>, ${p.nombre}
                            ${badgeRetiro}
                        </span>
                        <small class="text-muted">DNI: ${p.dni ?? 'N/C'}</small>
                    </div>
                `;

                item.onclick = () => {
                    personaId.value     = p.id;
                    dniHidden.value     = p.dni ?? '';
                    buscador.value      = `${p.apellido} ${p.nombre}`;
                    apellidoInput.value = p.apellido;
                    nombreInput.value   = p.nombre;
                    resultados.style.display = 'none';

                    // Mostrar aviso si la familia ya retiró este mes
                    if (p.familia_ya_retiro) {
                        avisoFamilia.classList.remove('d-none');
                    } else {
                        avisoFamilia.classList.add('d-none');
                    }
                };

                resultados.appendChild(item);
            });

        } else {
            resultados.style.display = 'none';
        }

    } catch (error) {
        console.error(error);
    }
});

// Cerrar dropdown al hacer clic fuera
document.addEventListener('click', function (e) {
    if (!resultados.contains(e.target) && e.target !== buscador) {
        resultados.style.display = 'none';
    }
});

</script>
@endpush

@endsection
