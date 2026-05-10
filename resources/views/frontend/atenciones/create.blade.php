@extends('frontend.layout.front')

@section('title', 'Nueva Intervención')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">

            {{-- Encabezado --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold mb-1 text-dark">
                        <i class="fas fa-notes-medical me-2 text-primary"></i>
                        Nueva intervención
                    </h2>

                    <p class="text-muted mb-0">
                        Registrá una nueva intervención realizada sobre la persona.
                    </p>
                </div>

                <a href="{{ route('personas.show', $persona) }}"
                   class="btn btn-light border rounded-pill px-3">
                    <i class="fas fa-arrow-left me-1"></i>
                    Volver
                </a>
            </div>

            {{-- Card principal --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                {{-- Header --}}
                <div class="card-header bg-white border-0 py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width:50px; height:50px;">
                            <i class="fas fa-plus text-primary"></i>
                        </div>

                        <div class="ms-3">
                            <h5 class="mb-1 fw-semibold">
                                Información de la intervención
                            </h5>

                            <small class="text-muted">
                                Completá los campos para guardar la intervención.
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Body --}}
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

                    <form method="POST" action="{{ route('atenciones.store', $persona) }}">
                        @csrf

                        <div class="row g-4">

                            {{-- Tipo --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">
                                    Tipo de intervención
                                </label>

                                <select name="tipo"
                                        class="form-select rounded-3 shadow-sm @error('tipo') is-invalid @enderror"
                                        required>

                                    <option value="" disabled {{ old('tipo') ? '' : 'selected' }}>
                                        Seleccionar tipo...
                                    </option>

                                    <option value="entrevista" {{ old('tipo') == 'entrevista' ? 'selected' : '' }}>
                                        Entrevista
                                    </option>

                                    <option value="visita_domiciliaria" {{ old('tipo') == 'visita_domiciliaria' ? 'selected' : '' }}>
                                        Visita domiciliaria
                                    </option>

                                    <option value="llamado" {{ old('tipo') == 'llamado' ? 'selected' : '' }}>
                                        Llamado
                                    </option>

                                    <option value="seguimiento" {{ old('tipo') == 'seguimiento' ? 'selected' : '' }}>
                                        Seguimiento
                                    </option>

                                    <option value="derivacion" {{ old('tipo') == 'derivacion' ? 'selected' : '' }}>
                                        Derivación
                                    </option>

                                    <option value="otro" {{ old('tipo') == 'otro' ? 'selected' : '' }}>
                                        Otro
                                    </option>
                                </select>

                                @error('tipo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Fecha --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">
                                    Fecha
                                </label>

                                <input type="date"
                                       name="fecha"
                                       class="form-control rounded-3 shadow-sm @error('fecha') is-invalid @enderror"
                                       value="{{ old('fecha', date('Y-m-d')) }}"
                                       required>

                                @error('fecha')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Descripción --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">
                                    Descripción
                                </label>

                                <textarea name="descripcion"
                                          rows="6"
                                          class="form-control rounded-3 shadow-sm @error('descripcion') is-invalid @enderror"
                                          placeholder="Escribí los detalles importantes de la intervención..."
                                          required>{{ old('descripcion') }}</textarea>

                                <div class="form-text">
                                    Intentá describir brevemente lo realizado, observado o acordado.
                                </div>

                                @error('descripcion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-end gap-2 mt-5 pt-4 border-top">

                            <a href="{{ route('personas.show', $persona) }}"
                               class="btn btn-light border rounded-pill px-4">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="fas fa-save me-1"></i>
                                Guardar intervención
                            </button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection