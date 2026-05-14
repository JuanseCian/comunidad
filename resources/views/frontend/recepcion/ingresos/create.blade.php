@extends('frontend.recepcion.layout.app')

@section('title', 'Nuevo ingreso')

@section('content')

<div class="container-fluid py-4">

    {{-- Cabecera --}}
    <div class="mb-4">

        <h2 class="fw-bold mb-1">
            Nuevo ingreso
        </h2>

        <p class="text-muted mb-0">
            Registrar ingreso desde recepción
        </p>

    </div>

    {{-- Card --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form action="{{ route('recepcion.ingresos.store') }}"
                  method="POST">

                @csrf

                <div class="row g-4">

                    {{-- PERSONA --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Persona
                        </label>

                        <input type="text"
                               name="persona_texto"
                               id="personaInput"
                               class="form-control"
                               list="listaPersonas"
                               placeholder="Escriba apellido y nombre"
                               autocomplete="off"
                               required>

                        {{-- Lista autocompletado --}}
                        <datalist id="listaPersonas">

                            @foreach($personas as $p)

                                <option
                                    value="{{ $p->apellido }} {{ $p->nombre }}"
                                    data-id="{{ $p->id }}">
                                </option>

                            @endforeach

                        </datalist>

                        {{-- Persona seleccionada --}}
                        <input type="hidden"
                               name="persona_id"
                               id="personaId">

                        <small class="text-muted">

                            Si la persona ya existe,
                            selecciónela de la lista.

                            Si no existe,
                            igualmente podrá registrar el ingreso.

                        </small>

                    </div>

                    {{-- FECHA --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Fecha de ingreso
                        </label>

                        <input type="date"
                               name="fecha_ingreso"
                               class="form-control"
                               value="{{ date('Y-m-d') }}"
                               required>

                    </div>

                    {{-- HORA --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Hora de ingreso
                        </label>

                        <input type="time"
                               name="hora_ingreso"
                               class="form-control"
                               value="{{ date('H:i') }}"
                               required>

                    </div>

                    {{-- DERIVACIÓN --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Derivación
                        </label>

                        <input type="text"
                               name="derivacion"
                               class="form-control"
                               placeholder="Ej: Trabajo Social, Discapacidad, UDI...">

                    </div>

                    {{-- OBSERVACIONES --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Observaciones
                        </label>

                        <textarea name="observaciones"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Observaciones adicionales..."></textarea>

                    </div>

                </div>

                {{-- BOTONES --}}
                <div class="mt-4 d-flex justify-content-end gap-2">

                    <a href="{{ route('recepcion.ingresos.index') }}"
                       class="btn btn-light border">

                        Cancelar

                    </a>

                    <button type="submit"
                            class="btn btn-success px-4">

                        <i class="bi bi-check-circle"></i>
                        Registrar ingreso

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

const inputPersona = document.getElementById('personaInput');
const hiddenId     = document.getElementById('personaId');
const opciones     = document.querySelectorAll('#listaPersonas option');

inputPersona.addEventListener('input', function () {

    hiddenId.value = '';

    opciones.forEach(option => {

        if (
            option.value.toLowerCase()
            === inputPersona.value.toLowerCase()
        ) {
            hiddenId.value = option.dataset.id;
        }

    });

});

</script>

@endpush