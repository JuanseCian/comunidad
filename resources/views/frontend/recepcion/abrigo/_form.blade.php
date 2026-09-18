@php($editando = isset($abrigo))

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="{{ $editando ? route('recepcion.abrigo.update', $abrigo) : route('recepcion.abrigo.store') }}" method="POST" autocomplete="off">
            @csrf
            @if($editando)
                @method('PUT')
            @endif

            <input type="hidden" name="persona_id" id="personaId" value="{{ old('persona_id', $abrigo->persona_id ?? '') }}">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!$editando)
                <div class="bg-light p-3 rounded-3 mb-4 position-relative border">
                    <label for="buscadorPersona" class="form-label fw-bold text-primary">1. Buscar persona o familia</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" id="buscadorPersona" class="form-control form-control-lg border-start-0 ps-0" placeholder="Ingresá DNI, nombre o apellido...">
                    </div>
                    <div id="resultadosBusqueda" class="list-group shadow position-absolute w-100 mt-1 d-none" style="z-index: 1050; max-height: 250px; overflow-y: auto;"></div>
                </div>
            @endif

            <label class="form-label fw-bold text-secondary mb-3">{{ $editando ? 'Datos de la entrega' : '2. Datos de la entrega' }}</label>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="dniInput" class="form-label small text-muted">DNI</label>
                    <input type="text" name="dni" id="dniInput" class="form-control" value="{{ old('dni', $abrigo->dni ?? '') }}">
                </div>
                <div class="col-md-8">
                    <label for="direccionInput" class="form-label small text-muted">Dirección</label>
                    <input type="text" name="direccion" id="direccionInput" class="form-control" value="{{ old('direccion', $abrigo->direccion ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label for="apellidoInput" class="form-label small text-muted">Apellido</label>
                    <input type="text" name="apellido" id="apellidoInput" class="form-control" value="{{ old('apellido', $abrigo->apellido ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="nombreInput" class="form-label small text-muted">Nombre</label>
                    <input type="text" name="nombre" id="nombreInput" class="form-control" value="{{ old('nombre', $abrigo->nombre ?? '') }}" required>
                </div>
                <div class="col-sm-4">
                    <label for="colchones" class="form-label small text-muted">Colchones</label>
                    <input type="number" name="colchones" id="colchones" class="form-control" min="0" value="{{ old('colchones', $abrigo->colchones ?? 0) }}" required>
                </div>
                <div class="col-sm-4">
                    <label for="frazadas" class="form-label small text-muted">Frazadas</label>
                    <input type="number" name="frazadas" id="frazadas" class="form-control" min="0" value="{{ old('frazadas', $abrigo->frazadas ?? 0) }}" required>
                </div>
                <div class="col-sm-4">
                    <label for="fecha_entrega" class="form-label small text-muted">Fecha de entrega</label>
                    <input type="date" name="fecha_entrega" id="fecha_entrega" class="form-control" value="{{ old('fecha_entrega', isset($abrigo) ? $abrigo->fecha_entrega->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
                </div>
                <div class="col-12">
                    <label for="observaciones" class="form-label small text-muted">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" class="form-control" rows="2" placeholder="Aclaraciones opcionales...">{{ old('observaciones', $abrigo->observaciones ?? '') }}</textarea>
                </div>
            </div>

            <hr class="my-4 text-muted">
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('recepcion.abrigo.index') }}" class="btn btn-light border px-4">Cancelar</a>
                <button type="submit" class="btn btn-success px-4 fw-medium">
                    <i class="bi bi-check2-circle me-1"></i> {{ $editando ? 'Guardar cambios' : 'Registrar entrega' }}
                </button>
            </div>
        </form>
    </div>
</div>

@if(!$editando)
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buscador = document.getElementById('buscadorPersona');
            const resultados = document.getElementById('resultadosBusqueda');
            const personaId = document.getElementById('personaId');
            const campos = {
                dni: document.getElementById('dniInput'),
                direccion: document.getElementById('direccionInput'),
                apellido: document.getElementById('apellidoInput'),
                nombre: document.getElementById('nombreInput')
            };

            buscador.addEventListener('input', async () => {
                const texto = buscador.value.trim();
                personaId.value = '';
                if (texto.length < 2) {
                    resultados.innerHTML = '';
                    resultados.classList.add('d-none');
                    return;
                }

                const response = await fetch(`{{ route('recepcion.abrigo.buscar-personas') }}?texto=${encodeURIComponent(texto)}`);
                const personas = await response.json();
                resultados.innerHTML = '';

                personas.forEach(persona => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'list-group-item list-group-item-action py-2';
                    button.textContent = `${persona.apellido}, ${persona.nombre} | DNI: ${persona.dni ?? 'S/D'}`;
                    button.addEventListener('click', () => {
                        personaId.value = persona.id;
                        campos.dni.value = persona.dni ?? '';
                        campos.direccion.value = persona.direccion ?? '';
                        campos.apellido.value = persona.apellido;
                        campos.nombre.value = persona.nombre;
                        buscador.value = `${persona.apellido}, ${persona.nombre}`;
                        resultados.classList.add('d-none');
                    });
                    resultados.appendChild(button);
                });
                resultados.classList.toggle('d-none', personas.length === 0);
            });

            document.addEventListener('click', event => {
                if (!resultados.contains(event.target) && event.target !== buscador) {
                    resultados.classList.add('d-none');
                }
            });
        });
    </script>
    @endpush
@endif
