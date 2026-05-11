@extends('frontend.layout.front')

@section('title', 'Editar Intervención')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">

            {{-- Encabezado --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold mb-1 text-dark">
                        <i class="fas fa-edit me-2 text-warning"></i>
                        Editar intervención
                    </h2>
                    <p class="text-muted mb-0">
                        Modificá la información registrada de la intervención.
                    </p>
                </div>
                <a href="{{ route('personas.show', $atencion->persona) }}"
                   class="btn btn-light border rounded-pill px-3">
                    <i class="fas fa-arrow-left me-1"></i>
                    Volver
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 rounded-4 mb-4">
                    <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
                </div>
            @endif

            {{-- Card datos intervención --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                <div class="card-header bg-white border-0 py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width:50px; height:50px;">
                            <i class="fas fa-pen text-warning"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-1 fw-semibold">Datos de la intervención</h5>
                            <small class="text-muted">Actualizá los campos necesarios antes de guardar.</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-4 mb-4">
                            <div class="fw-semibold mb-2">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                Revisá los siguientes errores:
                            </div>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('atenciones.update', $atencion) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @php
                            $opciones = ['entrevista','visita_domiciliaria','llamado','seguimiento','derivacion','otro'];
                        @endphp

                        <div class="row g-4">

                            {{-- Tipo --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Tipo de intervención</label>
                                <select name="tipo"
                                        class="form-select rounded-3 shadow-sm @error('tipo') is-invalid @enderror"
                                        required>
                                    @foreach($opciones as $opcion)
                                        <option value="{{ $opcion }}"
                                            {{ old('tipo', $atencion->tipo) == $opcion ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $opcion)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Fecha --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Fecha</label>
                                <input type="date"
                                       name="fecha_atencion"
                                       class="form-control rounded-3 shadow-sm @error('fecha_atencion') is-invalid @enderror"
                                       value="{{ old('fecha_atencion', \Carbon\Carbon::parse($atencion->fecha_atencion)->format('Y-m-d')) }}"
                                       required>
                                @error('fecha_atencion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Descripción --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Descripción</label>
                                <textarea name="descripcion"
                                          rows="6"
                                          class="form-control rounded-3 shadow-sm @error('descripcion') is-invalid @enderror"
                                          placeholder="Describí los detalles de la intervención..."
                                          required>{{ old('descripcion', $atencion->descripcion) }}</textarea>
                                <div class="form-text">
                                    Actualizá la información importante relacionada a esta intervención.
                                </div>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ── Archivos adjuntos ── --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Archivos adjuntos</label>

                                {{-- Archivos ya guardados --}}
                                @php $adjuntos = $atencion->adjuntos ?? collect(); @endphp

                                @if($adjuntos->isNotEmpty())
                                    <ul class="list-group list-group-flush rounded-3 border mb-3">
                                        @foreach($adjuntos as $adjunto)
                                            <li class="list-group-item d-flex align-items-center justify-content-between py-3 px-3">

                                                <div class="d-flex align-items-center gap-3">
                                                    <i class="fas {{ $adjunto->icono }} fa-lg"></i>
                                                    <div>
                                                        <span class="fw-semibold small text-dark">{{ $adjunto->nombre_original }}</span><br>
                                                        <small class="text-muted">
                                                            {{ $adjunto->tamaño_formateado }}
                                                            &middot; {{ \Carbon\Carbon::parse($adjunto->created_at)->format('d/m/Y') }}
                                                        </small>
                                                    </div>
                                                </div>

                                                <div class="d-flex gap-2 flex-shrink-0">
                                                    <a href="{{ route('adjuntos.download', $adjunto) }}"
                                                       class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                        <i class="fas fa-download me-1"></i>Descargar
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                            onclick="confirmarEliminar({{ $adjunto->id }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>

                                            </li>
                                        @endforeach
                                    </ul>

                                    {{-- Forms de eliminación (ocultos, se disparan con JS) --}}
                                    @foreach($adjuntos as $adjunto)
                                        <form id="form-delete-{{ $adjunto->id }}"
                                              method="POST"
                                              action="{{ route('adjuntos.destroy', $adjunto) }}"
                                              class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endforeach
                                @endif

                                {{-- Zona para subir nuevos archivos --}}
                                <div id="dropZone"
                                     class="border border-2 border-dashed rounded-4 p-4 text-center position-relative"
                                     style="cursor:pointer; transition: background .15s, border-color .15s;">

                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2 d-block"></i>
                                    <p class="text-muted mb-1">
                                        Agregá nuevos archivos arrastrando aquí o
                                        <label for="archivosInput" class="text-primary fw-semibold" style="cursor:pointer;">
                                            hacé clic para seleccionar
                                        </label>
                                    </p>
                                    <small class="text-muted">PDF, JPG o PNG &middot; máx. 10 MB por archivo</small>

                                    <input type="file"
                                           id="archivosInput"
                                           name="archivos[]"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           multiple
                                           class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                           style="cursor:pointer;">
                                </div>

                                <ul id="previewLista" class="list-group mt-3 d-none"></ul>

                                @error('archivos')
                                    <div class="text-danger small mt-2">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                @error('archivos.*')
                                    <div class="text-danger small mt-2">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-end gap-2 mt-5 pt-4 border-top">
                            <a href="{{ route('personas.show', $atencion->persona) }}"
                               class="btn btn-light border rounded-pill px-4">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning text-white rounded-pill px-4 shadow-sm">
                                <i class="fas fa-save me-1"></i>
                                Guardar cambios
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Drag & drop + preview
(function () {
    const input    = document.getElementById('archivosInput');
    const lista    = document.getElementById('previewLista');
    const dropZone = document.getElementById('dropZone');
    if (!input) return;

    function renderPreview(files) {
        lista.innerHTML = '';
        if (!files.length) { lista.classList.add('d-none'); return; }
        lista.classList.remove('d-none');
        Array.from(files).forEach(f => {
            const ext  = f.name.split('.').pop().toLowerCase();
            const icon = ext === 'pdf' ? 'fa-file-pdf text-danger'
                       : ['jpg','jpeg','png'].includes(ext) ? 'fa-file-image text-info'
                       : 'fa-file text-secondary';
            const size = f.size >= 1048576
                ? (f.size / 1048576).toFixed(2) + ' MB'
                : (f.size / 1024).toFixed(1) + ' KB';
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex align-items-center justify-content-between py-2 px-3';
            li.innerHTML = '<span><i class="fas ' + icon + ' me-2"></i><span class="small fw-semibold">' + f.name + '</span></span>'
                         + '<span class="badge bg-secondary rounded-pill">' + size + '</span>';
            lista.appendChild(li);
        });
    }

    input.addEventListener('change', () => renderPreview(input.files));

    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.style.background  = 'rgba(13,110,253,.06)';
        dropZone.style.borderColor = '#0d6efd';
    });
    dropZone.addEventListener('dragleave', () => {
        dropZone.style.background  = '';
        dropZone.style.borderColor = '';
    });
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.style.background  = '';
        dropZone.style.borderColor = '';
        const dt = new DataTransfer();
        Array.from(e.dataTransfer.files).forEach(f => dt.items.add(f));
        input.files = dt.files;
        renderPreview(input.files);
    });
})();

// Confirmación para eliminar adjunto
function confirmarEliminar(id) {
    if (confirm('¿Eliminás este archivo? Esta acción no se puede deshacer.')) {
        document.getElementById('form-delete-' + id).submit();
    }
}
</script>
@endpush
