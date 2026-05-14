@extends('frontend.recepcion.layout.app')

@section('title', 'Inicio')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold">
        Mesa de Entrada
    </h2>

    <p class="text-muted">
        Gestión de ingresos y derivaciones
    </p>

</div>

<div class="row g-4">

    <div class="col-md-4">

        <a href="{{ route('recepcion.ingresos.create') }}"
           class="text-decoration-none">

            <div class="card card-home">

                <div class="card-body">

                    <div class="icon">
                        <i class="bi bi-person-plus"></i>
                    </div>

                    <h5 class="fw-bold">
                        Nuevo Ingreso
                    </h5>

                    <p class="text-muted mb-0">
                        Registrar nueva atención de mesa de entrada
                    </p>

                </div>

            </div>

        </a>

    </div>

    <div class="col-md-4">

        <a href="{{ route('personas.index') }}"
           class="text-decoration-none">

            <div class="card card-home">

                <div class="card-body">

                    <div class="icon">
                        <i class="bi bi-search"></i>
                    </div>

                    <h5 class="fw-bold">
                        Buscar Personas
                    </h5>

                    <p class="text-muted mb-0">
                        Consultar registros existentes
                    </p>

                </div>

            </div>

        </a>

    </div>

</div>

@endsection