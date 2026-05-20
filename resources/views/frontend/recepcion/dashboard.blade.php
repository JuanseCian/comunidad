@extends('frontend.recepcion.layout.app')

@section('title', 'Inicio')

@section('content')

<style>

    .dashboard-header {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 18px;
        padding: 24px 28px;
        color: white;
        margin-bottom: 24px;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
    }

    .dashboard-header h2 {
        font-weight: 700;
        margin-bottom: 6px;
    }

    .dashboard-header p {
        margin: 0;
        color: rgba(255,255,255,.75);
        font-size: .95rem;
    }

    .dashboard-card {
        border: 0;
        border-radius: 18px;
        transition: .2s ease;
        overflow: hidden;
        position: relative;
        height: 100%;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
    }

    .dashboard-card .card-body {
        padding: 22px;
    }

    .dashboard-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }

    .card-success::before {
        background: linear-gradient(90deg, #16a34a, #22c55e);
    }

    .card-primary::before {
        background: linear-gradient(90deg, #2563eb, #3b82f6);
    }

    .card-warning::before {
        background: linear-gradient(90deg, #d97706, #f59e0b);
    }

    .card-danger::before {
        background: linear-gradient(90deg, #dc2626, #ef4444);
    }

    .dashboard-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 16px;
    }

    .icon-success {
        background: rgba(34, 197, 94, .12);
        color: #16a34a;
    }

    .icon-primary {
        background: rgba(59, 130, 246, .12);
        color: #2563eb;
    }

    .icon-warning {
        background: rgba(245, 158, 11, .14);
        color: #d97706;
    }

    .icon-danger {
        background: rgba(239, 68, 68, .12);
        color: #dc2626;
    }

    .dashboard-card h5 {
        font-weight: 700;
        margin-bottom: 8px;
        color: #111827;
    }

    .dashboard-card p {
        font-size: .9rem;
        color: #6b7280;
        margin-bottom: 0;
        line-height: 1.5;
    }

</style>

{{-- HEADER --}}
<div class="dashboard-header">

    <h2>
        Mesa de Entrada
    </h2>

    <p>
        Gestión rápida de ingresos, derivaciones y entregas.
    </p>

</div>

{{-- CARDS --}}
<div class="row g-3">

    {{-- NUEVO INGRESO --}}
    <div class="col-md-6 col-xl-3">

        <a href="{{ route('recepcion.ingresos.create') }}"
           class="text-decoration-none">

            <div class="card dashboard-card shadow-sm card-success">

                <div class="card-body">

                    <div class="dashboard-icon icon-success">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>

                    <h5>
                        Nuevo Ingreso
                    </h5>

                    <p>
                        Registrar una nueva atención.
                    </p>

                </div>

            </div>

        </a>

    </div>

    {{-- HISTORIAL --}}
    <div class="col-md-6 col-xl-3">

        <a href="{{ route('recepcion.ingresos.index') }}"
           class="text-decoration-none">

            <div class="card dashboard-card shadow-sm card-primary">

                <div class="card-body">

                    <div class="dashboard-icon icon-primary">
                        <i class="bi bi-journal-text"></i>
                    </div>

                    <h5>
                        Historial
                    </h5>

                    <p>
                        Consultar ingresos registrados.
                    </p>

                </div>

            </div>

        </a>

    </div>

    {{-- NUEVA ENTREGA --}}
    <div class="col-md-6 col-xl-3">

        <a href="{{ route('recepcion.mercaderias.create') }}"
           class="text-decoration-none">

            <div class="card dashboard-card shadow-sm card-warning">

                <div class="card-body">

                    <div class="dashboard-icon icon-warning">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>

                    <h5>
                        Nueva Entrega de Mercadería
                    </h5>

                    <p>
                        Registrar entrega de mercadería.
                    </p>

                </div>

            </div>

        </a>

    </div>

    {{-- MERCADERIA --}}
    <div class="col-md-6 col-xl-3">

        <a href="{{ route('recepcion.mercaderias.index') }}"
           class="text-decoration-none">

            <div class="card dashboard-card shadow-sm card-danger">

                <div class="card-body">

                    <div class="dashboard-icon icon-danger">
                        <i class="bi bi-clipboard-data-fill"></i>
                    </div>

                    <h5>
                        Mercadería
                    </h5>

                    <p>
                        Ver historial y control mensual.
                    </p>

                </div>

            </div>

        </a>

    </div>

</div>

@endsection