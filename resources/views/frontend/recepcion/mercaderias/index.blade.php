@extends('frontend.recepcion.layout.app')

@section('title', 'Mercadería')

@section('content')

<div class="container-fluid py-4">

    {{-- CABECERA --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Mercadería
            </h2>

            <p class="text-muted mb-0">
                Registro de entregas mensuales
            </p>

        </div>

        <a href="{{ route('recepcion.mercaderias.create') }}"
           class="btn btn-success">

            <i class="bi bi-plus-circle"></i>

            Nueva entrega

        </a>

    </div>

    {{-- ALERTAS --}}
    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    {{-- BUSCADOR --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('recepcion.mercaderias.index') }}">

                <div class="row g-3 align-items-end">

                    <div class="col-md-10">

                        <label class="form-label fw-semibold">
                            Buscar persona
                        </label>

                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Buscar por nombre, apellido o DNI..."
                               value="{{ request('search') }}">

                    </div>

                    <div class="col-md-2 d-grid">

                        <button class="btn btn-primary">

                            <i class="bi bi-search"></i>

                            Buscar

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- TABLA --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="80">
                                #
                            </th>

                            <th>
                                Persona
                            </th>

                            <th>
                                Familia
                            </th>

                            <th width="140">
                                Fecha
                            </th>

                            <th width="180">
                                Próximo retiro
                            </th>

                            <th width="160">
                                Estado
                            </th>

                            <th>
                                Registrado por
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($mercaderias as $m)

                            @php

                                $fechaEntrega = \Carbon\Carbon::parse($m->fecha_entrega);

                                // PLAZO DE 30 DÍAS
                                $proximoRetiro = $fechaEntrega->copy()->addDays(30);

                                $puedeRetirar = now()->greaterThanOrEqualTo($proximoRetiro);

                            @endphp

                            <tr>

                                {{-- ID --}}
                                <td>

                                    <span class="fw-semibold text-muted">

                                        #{{ $m->id }}

                                    </span>

                                </td>

                                {{-- PERSONA --}}
                                <td>

                                    <div class="fw-semibold">

                                        {{ $m->apellido }}
                                        {{ $m->nombre }}

                                    </div>

                                    @if($m->dni)

                                        <small class="text-muted">

                                            DNI:
                                            {{ $m->dni }}

                                        </small>

                                    @endif

                                </td>

                                {{-- FAMILIA --}}
                                <td>

                                    @if($m->familia)

                                        <span class="badge bg-success-subtle text-dark border">

                                            Familia #{{ $m->familia->id }}

                                        </span>

                                    @else

                                        <span class="text-muted">
                                            Sin grupo familiar
                                        </span>

                                    @endif

                                </td>

                                {{-- FECHA --}}
                                <td>

                                    {{ $fechaEntrega->format('d/m/Y') }}

                                </td>

                                {{-- PRÓXIMO RETIRO --}}
                                <td>

                                    {{ $proximoRetiro->format('d/m/Y') }}

                                </td>

                                {{-- ESTADO --}}
                                <td>

                                    @if($puedeRetirar)

                                        <span class="badge bg-success">

                                            Puede retirar

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            En espera

                                        </span>

                                    @endif

                                </td>

                                {{-- USUARIO --}}
                                <td>

                                    <span class="text-muted">

                                        {{ $m->usuario->username ?? 'Usuario' }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center py-5">

                                    <div class="d-flex flex-column align-items-center">

                                        <i class="bi bi-box-seam fs-1 text-muted mb-3"></i>

                                        <div class="fw-semibold text-muted">

                                            No hay entregas registradas

                                        </div>

                                        <small class="text-muted">Las entregas de mercadería aparecerán aquí.</small>
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