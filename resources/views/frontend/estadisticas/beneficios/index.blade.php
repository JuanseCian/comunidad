@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Beneficios')
@section('subtitulo', 'Programas y beneficios sociales')

@section('content')

<div class="container-fluid px-0">

    {{-- ==========================================
        CABECERA Y ACCIONES PRINCIPALES
    ========================================== --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <div class="stats-meta mb-1 text-muted small text-uppercase tracking-wider fw-bold">
                Seguimiento de programas y métricas operativas
            </div>
            <h4 class="fw-bold tracking-tight text-dark m-0" style="font-size:1.75rem;">
                Panel Estadístico de 
                <span style="color: var(--sn-blue); font-weight:400;">Beneficios</span>
            </h4>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            {{-- BOTÓN FILTROS --}}
            <button
                class="btn btn-white border border-light-subtle btn-sm d-flex align-items-center gap-2 px-3 py-2 shadow-xs rounded-3 transition-all"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseFilters"
                aria-expanded="false"
                aria-controls="collapseFilters"
            >
                <i class="bi bi-sliders2 text-secondary"></i>
                <span class="fw-medium text-secondary small">Filtrar Datos</span>
                <i class="bi bi-chevron-down small text-muted toggle-icon"></i>
            </button>

            {{-- FECHA ACTUAL --}}
            <div class="badge bg-light text-dark border border-light-subtle px-3 py-2 fw-semibold rounded-3 shadow-xs d-flex align-items-center gap-2" style="min-height:38px; font-size:.85rem;">
                <i class="bi bi-calendar3 text-primary"></i>
                {{ now()->format('d/m/Y') }}
            </div>

            {{-- ACCIONES DE EXPORTACIÓN --}}
            <a href="{{ url()->current() }}" class="btn btn-success btn-sm rounded-3 d-flex align-items-center gap-2 px-3 py-2 shadow-xs fw-medium small">
                <i class="bi bi-file-earmark-excel"></i> Excel
            </a>

            <button onclick="window.print()" class="btn btn-primary btn-sm rounded-3 d-flex align-items-center gap-2 px-3 py-2 shadow-xs fw-medium small">
                <i class="bi bi-printer"></i> Imprimir
            </button>
        </div>
    </div>

    {{-- ==========================================
        BLOQUE DE FILTROS AVANZADOS (COLLAPSE)
    ========================================== --}}
    <div class="collapse mb-4" id="collapseFilters">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: rgba(var(--bs-body-bg-rgb), 0.7); backdrop-filter: blur(10px);">
            <div class="card-body p-4">
                <form method="GET" class="row g-3 align-items-end">
                    
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Filtro Principal</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 10px 0 0 10px;"><i class="bi bi-funnel"></i></span>
                            <select name="filtro_id" class="form-select bg-light border-start-0 small" style="border-radius: 0 10px 10px 0;">
                                <option value="">Seleccione una opción...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Fecha Desde</label>
                        <input type="date" name="fecha_desde" class="form-control bg-light small" style="border-radius: 10px;">
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Fecha Hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control bg-light small" style="border-radius: 10px;">
                    </div>

                    <div class="col-12 col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-medium d-flex align-items-center justify-content-center gap-2 shadow-xs" style="border-radius: 10px; padding: 8px;">
                            <i class="bi bi-search"></i> Filtrar
                        </button>
                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" style="border-radius: 10px;" title="Limpiar Filtros">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm p-3 card-hover-effect" style="border-radius: 16px; transition: transform 0.2s ease;">
                <div class="d-flex align-items-center">
                    <div class="badge p-3 me-3 d-flex align-items-center justify-content-center" style="background-color: rgba(78, 115, 223, 0.1); color: #4e73df; width: 54px; height: 54px; border-radius: 14px;">
                        <i class="bi bi-gift fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted small fw-bold text-uppercase tracking-wide">Total Asignaciones</h6>
                        <h3 class="mb-0 fw-bold tracking-tight">{{ number_format($totalBeneficios, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm p-3 card-hover-effect" style="border-radius: 16px; transition: transform 0.2s ease;">
                <div class="d-flex align-items-center">
                    <div class="badge p-3 me-3 d-flex align-items-center justify-content-center" style="background-color: rgba(78, 115, 223, 0.1); color: #4e73df; width: 54px; height: 54px; border-radius: 14px;">
                        <i class="bi bi-gift fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted small fw-bold text-uppercase tracking-wide">Beneficio mas cobrado</h6>
                        <h4 class="card-title fw-bold mb-1 text-truncate" style="max-width: 180px;" title="{{ $beneficioMasCobrado }}">
                                {{ $beneficioMasCobrado }}
                            </h4>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm p-3 card-hover-effect" style="border-radius: 16px; transition: transform 0.2s ease;">
                <div class="d-flex align-items-center">
                    <div class="badge p-3 me-3 d-flex align-items-center justify-content-center" style="background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; width: 54px; height: 54px; border-radius: 14px;">
                        <i class="bi bi-geo-alt fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted small fw-bold text-uppercase tracking-wide">Barrio Mayor Impacto</h6>
                        <h3 class="mb-0 fw-bold tracking-tight text-truncate" style="max-width: 220px;">{{ $barrioDestacado }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-gradient-dark">Beneficios Más Demandados</h5>
                    <span class="badge bg-light text-dark border px-2 py-1.5 rounded-pill small"><i class="bi bi-bar-chart-line me-1"></i> Cobertura</span>
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    <div style="position: relative; height: 320px;">
                        @include('frontend.estadisticas.partials.chart', [
                            'title' => '',
                            'chartId' => 'beneficiosChart'
                        ])
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-gradient-dark">Distribución por Barrios</h5>
                    <span class="badge bg-light text-dark border px-2 py-1.5 rounded-pill small"><i class="bi bi-pie-chart me-1"></i> Densidad</span>
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    <div style="position: relative; height: 320px;">
                        @include('frontend.estadisticas.partials.chart', [
                            'title' => '',
                            'chartId' => 'barriosChart'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Efecto hover suave para métricas */
    .card-hover-effect:hover {
        transform: translateY(-3px);
    }
    /* Estilos adaptativos para fuentes */
    .tracking-wider { tracking-spacing: 0.05em; }
    .tracking-tight { tracking-spacing: -0.02em; }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Paleta Premium tipo Tailwind / Power BI UI
    const premiumColors = [
        'rgba(78, 115, 223, 0.85)',   // Indigo / Royal Blue
        'rgba(28, 200, 138, 0.85)',   // Teal / Green
        'rgba(54, 185, 204, 0.85)',   // Light Blue
        'rgba(246, 194, 62, 0.85)',   // Orange / Yellow
        'rgba(231, 74, 59, 0.85)',    // Rose / Red
        'rgba(111, 66, 193, 0.85)',   // Purple
        'rgba(253, 126, 20, 0.85)',   // Amber
        'rgba(90, 92, 105, 0.85)'     // Slate
    ];

    const borderColors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#6f42c1', '#fd7e14', '#5a5c69'];

    // Determinar si el tema actual de Bootstrap es Oscuro
    const isDarkMode = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.04)';
    const textColor = isDarkMode ? '#9ca3af' : '#5a5c69';

    // 1. Configuración Gráfico de Barras (Beneficios) con Gradiente
    const ctxBeneficios = document.getElementById('beneficiosChart');
    if (ctxBeneficios) {
        // Crear gradiente dinámico para las barras
        const ctx = ctxBeneficios.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(78, 115, 223, 1)');     // Solid Blue
        gradient.addColorStop(1, 'rgba(78, 115, 223, 0.25)');  // Translucent Blue

        new Chart(ctxBeneficios, {
            type: 'bar',
            data: {
                labels: {!! json_encode($beneficios->pluck('nombre')) !!},
                datasets: [{
                    label: 'Asignaciones',
                    data: {!! json_encode($beneficios->pluck('total')) !!},
                    backgroundColor: gradient,
                    borderColor: '#4e73df',
                    borderWidth: 1.5,
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.55
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        padding: 12,
                        cornerRadius: 8,
                        backgroundColor: isDarkMode ? '#1f2937' : '#ffffff',
                        titleColor: isDarkMode ? '#ffffff' : '#1f2937',
                        bodyColor: textColor,
                        borderColor: gridColor,
                        borderWidth: 1,
                        usePointStyle: true
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor, font: { family: 'Inter, system-ui', size: 11 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: { 
                            color: textColor,
                            font: { family: 'Inter, system-ui', size: 11 },
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // 2. Configuración Gráfico de Dona (Barrios)
    const ctxBarrios = document.getElementById('barriosChart');
    if (ctxBarrios) {
        new Chart(ctxBarrios, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($barrios->pluck('barrio')) !!},
                datasets: [{
                    data: {!! json_encode($barrios->pluck('total')) !!},
                    backgroundColor: premiumColors,
                    borderColor: isDarkMode ? '#111827' : '#ffffff',
                    borderWidth: 2,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            padding: 15,
                            color: textColor,
                            font: { family: 'Inter, system-ui', size: 11, weight: 500 },
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        padding: 12,
                        cornerRadius: 8,
                        backgroundColor: isDarkMode ? '#1f2937' : '#ffffff',
                        titleColor: isDarkMode ? '#ffffff' : '#1f2937',
                        bodyColor: textColor,
                        usePointStyle: true
                    }
                }
            }
        });
    }
});
</script>
@endsection