@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Programas Sociales')

@section('subtitulo', 'Seleccione un programa para visualizar estadísticas')

@section('content')


<div class="container-fluid px-0 py-3">

    <div class="row g-3">

        {{-- ENVION --}}
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('estadisticas.destinatarios.envion') }}" class="text-decoration-none text-reset">
                <div class="card border border-light-subtle h-100 dashboard-program-card bg-white">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-secondary mb-3 fs-4">
                                <i class="bi bi-people"></i>
                            </div>
                            <h4 class="fw-semibold text-dark mb-1">Envión</h4>
                            <p class="text-muted small mb-0">Norte · Sur · Oeste</p>
                        </div>
                        <div class="mt-4 pt-2 border-top border-light-subtle d-flex align-items-center justify-content-between">
                            <span class="text-secondary small">Participantes</span>
                            <span class="fw-bold text-dark fs-5">{{ $envion }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- UDI --}}
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('estadisticas.destinatarios.udi') }}" class="text-decoration-none text-reset">
                <div class="card border border-light-subtle h-100 dashboard-program-card bg-white">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-secondary mb-3 fs-4">
                                <i class="bi bi-house"></i>
                            </div>
                            <h4 class="fw-semibold text-dark mb-1">UDI</h4>
                            <p class="text-muted small mb-0">Norte · Sur · Oeste</p>
                        </div>
                        <div class="mt-4 pt-2 border-top border-light-subtle d-flex align-items-center justify-content-between">
                            <span class="text-secondary small">Participantes</span>
                            <span class="fw-bold text-dark fs-5">{{ $udi }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- GUARDERIA --}}
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('estadisticas.destinatarios.guarderia') }}" class="text-decoration-none text-reset">
                <div class="card border border-light-subtle h-100 dashboard-program-card bg-white">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-secondary mb-3 fs-4">
                                <i class="bi bi-backpack"></i>
                            </div>
                            <h4 class="fw-semibold text-dark mb-1">Guardería</h4>
                            <p class="text-muted small invisible mb-0">—</p> {{-- Mantiene la simetría de altura --}}
                        </div>
                        <div class="mt-4 pt-2 border-top border-light-subtle d-flex align-items-center justify-content-between">
                            <span class="text-secondary small">Participantes</span>
                            <span class="fw-bold text-dark fs-5">{{ $guarderia }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- MULTIESPACIO --}}
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('estadisticas.destinatarios.multiespacio') }}" class="text-decoration-none text-reset">
                <div class="card border border-light-subtle h-100 dashboard-program-card bg-white">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-secondary mb-3 fs-4">
                                <i class="bi bi-building"></i>
                            </div>
                            <h4 class="fw-semibold text-dark mb-1">Multiespacio</h4>
                            <p class="text-muted small invisible mb-0">—</p> {{-- Mantiene la simetría de altura --}}
                        </div>
                        <div class="mt-4 pt-2 border-top border-light-subtle d-flex align-items-center justify-content-between">
                            <span class="text-secondary small">Participantes</span>
                            <span class="fw-bold text-dark fs-5">{{ $multiespacio }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

</div>

<style>
.dashboard-program-card {
    transition: all 0.2s ease-in-out;
    border-radius: 8px; /* Bordes menos redondeados, más sobrios */
}

.dashboard-program-card:hover {
    border-color: #0056b3 !important; /* Resalte sutil con el azul institucional */
    background-color: #fafbfc !important;
}
</style>

@endsection