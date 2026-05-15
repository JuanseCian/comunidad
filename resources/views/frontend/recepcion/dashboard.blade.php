@extends('frontend.recepcion.layout.app')

@section('title', 'Inicio')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold text-dark">
        Mesa de Entrada
    </h2>

    <p class="text-muted">
        Gestión de ingresos, derivaciones y mercadería en tiempo real
    </p>

</div>

<div class="row g-4">

    {{-- NUEVO INGRESO --}}
    <div class="col-md-4">

        <a href="{{ route('recepcion.ingresos.create') }}"
           class="text-decoration-none">

            <div class="card card-home border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <div class="icon mb-3 bg-success-subtle text-success d-inline-flex align-items-center justify-content-center rounded-3 p-3 fs-3">

                        <i class="bi bi-person-plus-fill"></i>

                    </div>

                    <h5 class="fw-bold text-dark mt-2">
                        Nuevo Ingreso
                    </h5>

                    <p class="text-muted small mb-0">
                        Registrar nueva atención inmediata en la mesa de entrada.
                    </p>

                </div>

            </div>

        </a>

    </div>

    {{-- HISTORIAL INGRESOS --}}
    <div class="col-md-4">

        <a href="{{ route('recepcion.ingresos.index') }}"
           class="text-decoration-none">

            <div class="card card-home border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <div class="icon mb-3 bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center rounded-3 p-3 fs-3">

                        <i class="bi bi-journal-text"></i>

                    </div>

                    <h5 class="fw-bold text-dark mt-2">
                        Historial de Ingresos
                    </h5>

                    <p class="text-muted small mb-0">
                        Ver, buscar y controlar ingresos y derivaciones realizadas.
                    </p>

                </div>

            </div>

        </a>

    </div>

    {{-- NUEVA ENTREGA MERCADERÍA --}}
    <div class="col-md-4">

        <a href="{{ route('recepcion.mercaderias.create') }}"
           class="text-decoration-none">

            <div class="card card-home border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <div class="icon mb-3 bg-warning-subtle text-warning d-inline-flex align-items-center justify-content-center rounded-3 p-3 fs-3">

                        <i class="bi bi-box-seam-fill"></i>

                    </div>

                    <h5 class="fw-bold text-dark mt-2">
                        Nueva Entrega
                    </h5>

                    <p class="text-muted small mb-0">
                        Registrar entrega mensual de mercadería a grupos familiares.
                    </p>

                </div>

            </div>

        </a>

    </div>

    {{-- HISTORIAL MERCADERÍA --}}
    <div class="col-md-4">

        <a href="{{ route('recepcion.mercaderias.index') }}"
           class="text-decoration-none">

            <div class="card card-home border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="icon mb-3 bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center rounded-3 p-3 fs-3">
                        <i class="bi bi-clipboard-data-fill"></i>
                    </div>
                    
                    <h5 class="fw-bold text-dark mt-2">Historial Mercadería</h5>

                    <p class="text-muted small mb-0">Consultar entregas realizadas y control mensual de familias.</p>
                </div>
            </div>
        </a>
    </div>
</div>

@endsection