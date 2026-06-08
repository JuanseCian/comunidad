@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Programas Sociales')

@section('subtitulo', 'Seleccione un programa para visualizar estadísticas')

@section('content')

<div class="container py-4">
    <div class="row g-4 justify-content-center">

        {{-- ENVION --}}
        <div class="col-md-6">
            <a href="{{ route('estadisticas.destinatarios.envion') }}" class="program-wrapper-link text-decoration-none">
                <div class="card program-card-advanced h-100 border-0 p-4 position-relative overflow-hidden" style="--accent-color: #3b82f6;">
                    <div class="card-body d-flex flex-column justify-content-between p-0 z-1">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="icon-box d-flex align-items-center justify-content-center rounded-3 bg-light text-secondary fs-4">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="arrow-box text-muted opacity-50">
                                    <i class="bi bi-arrow-right fs-4"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-dark mb-2 h4">Envión</h3>
                            <p class="text-muted small line-clamp">Programa de responsabilidad social compartida orientado a jóvenes. Sedes: Norte · Sur · Oeste.</p>
                        </div>
                        
                        <div class="mt-5 pt-3 border-top border-light-subtle d-flex align-items-baseline justify-content-between">
                            <span class="text-secondary small text-uppercase tracking-wider fw-medium">Participantes Activos</span>
                            <span class="stat-number fw-light text-dark">{{ $envion }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- UDI --}}
        <div class="col-md-6">
            <a href="{{ route('estadisticas.destinatarios.udi') }}" class="program-wrapper-link text-decoration-none">
                <div class="card program-card-advanced h-100 border-0 p-4 position-relative overflow-hidden" style="--accent-color: #6366f1;">
                    <div class="card-body d-flex flex-column justify-content-between p-0 z-1">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="icon-box d-flex align-items-center justify-content-center rounded-3 bg-light text-secondary fs-4">
                                    <i class="bi bi-house"></i>
                                </div>
                                <div class="arrow-box text-muted opacity-50">
                                    <i class="bi bi-arrow-right fs-4"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-dark mb-2 h4">UDI</h3>
                            <p class="text-muted small line-clamp">Unidades de Desarrollo Infantil. Espacios de cuidado, protección y nutrición para la infancia.</p>
                        </div>
                        
                        <div class="mt-5 pt-3 border-top border-light-subtle d-flex align-items-baseline justify-content-between">
                            <span class="text-secondary small text-uppercase tracking-wider fw-medium">Participantes Activos</span>
                            <span class="stat-number fw-light text-dark">{{ $udi }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- GUARDERIA --}}
        <div class="col-md-6">
            <a href="{{ route('estadisticas.destinatarios.guarderia') }}" class="program-wrapper-link text-decoration-none">
                <div class="card program-card-advanced h-100 border-0 p-4 position-relative overflow-hidden" style="--accent-color: #0ec8a5;">
                    <div class="card-body d-flex flex-column justify-content-between p-0 z-1">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="icon-box d-flex align-items-center justify-content-center rounded-3 bg-light text-secondary fs-4">
                                    <i class="bi bi-backpack"></i>
                                </div>
                                <div class="arrow-box text-muted opacity-50">
                                    <i class="bi bi-arrow-right fs-4"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-dark mb-2 h4">Guardería</h3>
                            <p class="text-muted small line-clamp">Espacio de primera infancia dedicado a la atención integral, estimulación temprana y recreación.</p>
                        </div>
                        
                        <div class="mt-5 pt-3 border-top border-light-subtle d-flex align-items-baseline justify-content-between">
                            <span class="text-secondary small text-uppercase tracking-wider fw-medium">Participantes Activos</span>
                            <span class="stat-number fw-light text-dark">{{ $guarderia }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- MULTIESPACIO --}}
        <div class="col-md-6">
            <a href="{{ route('estadisticas.destinatarios.multiespacio') }}" class="program-wrapper-link text-decoration-none">
                <div class="card program-card-advanced h-100 border-0 p-4 position-relative overflow-hidden" style="--accent-color: #f59e0b;">
                    <div class="card-body d-flex flex-column justify-content-between p-0 z-1">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="icon-box d-flex align-items-center justify-content-center rounded-3 bg-light text-secondary fs-4">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="arrow-box text-muted opacity-50">
                                    <i class="bi bi-arrow-right fs-4"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-dark mb-2 h4">Multiespacio</h3>
                            <p class="text-muted small line-clamp">Centros comunitarios destinados al desarrollo de talleres culturales, educativos y de integración.</p>
                        </div>
                        
                        <div class="mt-5 pt-3 border-top border-light-subtle d-flex align-items-baseline justify-content-between">
                            <span class="text-secondary small text-uppercase tracking-wider fw-medium">Participantes Activos</span>
                            <span class="stat-number fw-light text-dark">{{ $multiespacio }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

<style>
/* Base de la Tarjeta */
.program-card-advanced {
    background-color: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

/* Elementos Internos */
.program-card-advanced .icon-box {
    width: 48px;
    height: 48px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.program-card-advanced .arrow-box {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), color 0.3s ease, opacity 0.3s ease;
}

.program-card-advanced .stat-number {
    font-size: 2.75rem;
    line-height: 1;
    transition: color 0.3s ease, transform 0.3s ease;
}

.program-card-advanced .tracking-wider {
    letter-spacing: 0.05em;
}

/* Efecto de línea de color sutil oculta a la izquierda */
.program-card-advanced::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background-color: var(--accent-color);
    opacity: 0;
    transition: opacity 0.3s ease;
}

/* --- INTERACCIONES (HOVER) --- */
.program-wrapper-link:hover .program-card-advanced {
    transform: translateY(-6px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
}

.program-wrapper-link:hover .program-card-advanced::before {
    opacity: 1;
}

.program-wrapper-link:hover .icon-box {
    background-color: var(--accent-color) !important;
    color: #ffffff !important;
}

.program-wrapper-link:hover .arrow-box {
    opacity: 1 !important;
    color: var(--accent-color) !important;
    transform: translateX(4px);
}

.program-wrapper-link:hover .stat-number {
    color: var(--accent-color) !important;
    font-weight: 400 !important; /* Toma un sutil relieve */
}

/* Limitar líneas de texto para homogeneidad */
.line-clamp {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}
</style>

@endsection