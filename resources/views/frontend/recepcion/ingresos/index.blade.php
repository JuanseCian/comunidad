@extends('frontend.recepcion.layout.app')

@section('title', 'Ingresos')

@section('content')

<div class="container-fluid py-4">

    {{-- Cabecera --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Ingresos
            </h2>

            <p class="text-muted mb-0">
                Mesa de entrada y derivaciones
            </p>

        </div>

        <a href="{{ route('recepcion.ingresos.create') }}"
           class="btn btn-success">

            <i class="bi bi-plus-circle"></i>
            Nuevo ingreso

        </a>

    </div>

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="70">
                                #
                            </th>

                            <th>
                                Persona
                            </th>

                            <th>
                                Derivación
                            </th>

                            <th width="140">
                                Fecha
                            </th>

                            <th width="120">
                                Hora
                            </th>

                            <th>
                                Registrado por
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($ingresos as $i)

                            <tr>

                                {{-- ID --}}
                                <td>

                                    <span class="fw-semibold text-muted">
                                        #{{ $i->id }}
                                    </span>

                                </td>

                                {{-- PERSONA --}}
                                <td>

                                    <div class="fw-semibold">

                                        @if($i->persona)

                                            {{ $i->persona->apellido }}
                                            {{ $i->persona->nombre }}

                                        @else

                                            {{ $i->apellido }}
                                            {{ $i->nombre }}

                                        @endif

                                    </div>

                                    @if($i->observaciones)

                                        <small class="text-muted d-block mt-1">

                                            {{ \Illuminate\Support\Str::limit($i->observaciones, 80) }}

                                        </small>

                                    @endif

                                </td>

                                {{-- DERIVACIÓN --}}
                                <td>

                                    @if($i->derivacion)

                                        <span class="badge bg-info-subtle text-dark border">

                                            {{ $i->derivacion }}

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            Sin derivación
                                        </span>

                                    @endif

                                </td>

                                {{-- FECHA --}}
                                <td>

                                    {{ \Carbon\Carbon::parse($i->fecha_ingreso)->format('d/m/Y') }}

                                </td>

                                {{-- HORA --}}
                                <td>

                                    {{ \Carbon\Carbon::parse($i->hora_ingreso)->format('H:i') }}

                                </td>

                                {{-- USUARIO --}}
                                <td>

                                    <span class="text-muted">

                                        {{ $i->usuario->username ?? 'Usuario' }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5">

                                    <div class="d-flex flex-column align-items-center">

                                        <i class="bi bi-inbox fs-1 text-muted mb-3"></i>

                                        <div class="fw-semibold text-muted">

                                            No hay ingresos registrados

                                        </div>

                                        <small class="text-muted">

                                            Los ingresos realizados desde recepción aparecerán aquí.

                                        </small>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection