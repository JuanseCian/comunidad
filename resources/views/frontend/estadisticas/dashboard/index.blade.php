@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Dashboard General')

@section('subtitulo', 'Resumen general del sistema Comunidad')

@section('content')


<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <div class="stats-meta mb-1 text-muted small text-uppercase tracking-wider fw-bold">
            Filtros generales del dashboard
        </div>
        <h4 class="fw-bold tracking-tight text-dark m-0" style="font-size:1.75rem;">
            Resumen global de estadísticas
        </h4>
    </div>

    <div class="d-flex align-items-center gap-2 flex-wrap">
        <button
            class="btn btn-white border border-light-subtle btn-sm d-flex align-items-center gap-2 px-3 py-2 shadow-xs rounded-3"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseFilters"
            aria-expanded="false"
            aria-controls="collapseFilters"
        >
            <i class="bi bi-sliders2 text-secondary"></i>
            <span class="fw-medium text-secondary small">Filtrar Datos</span>
            <i class="bi bi-chevron-down small text-muted"></i>
        </button>

        <div class="badge bg-light text-dark border border-light-subtle px-3 py-2 fw-semibold rounded-3 shadow-xs d-flex align-items-center gap-2" style="min-height:38px; font-size:.85rem;">
            <i class="bi bi-calendar3 text-primary"></i>
            {{ now()->format('d/m/Y') }}
        </div>

        <a href="{{ route('estadisticas.dashboard.excel', request()->query()) }}" class="btn btn-success btn-sm rounded-3 d-flex align-items-center gap-2 px-3 py-2 shadow-xs fw-medium small">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </a>

        <button onclick="window.print()" class="btn btn-primary btn-sm rounded-3 d-flex align-items-center gap-2 px-3 py-2 shadow-xs fw-medium small">
            <i class="bi bi-printer"></i> Imprimir
        </button>
    </div>
</div>

<div class="collapse mb-4" id="collapseFilters">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: rgba(var(--bs-body-bg-rgb), 0.7); backdrop-filter: blur(10px);">
        <div class="card-body p-4">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Fecha Desde</label>
                    <input type="date" name="fecha_desde" value="{{ $fechaDesde }}" class="form-control bg-light small" style="border-radius: 10px;">
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label small fw-semibold text-muted text-uppercase tracking-wider">Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" value="{{ $fechaHasta }}" class="form-control bg-light small" style="border-radius: 10px;">
                </div>

                <div class="col-12 col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-medium d-flex align-items-center justify-content-center gap-2 shadow-xs" style="border-radius: 10px; padding: 8px;">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                    <a href="{{ route('estadisticas.dashboard') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" style="border-radius: 10px;" title="Limpiar Filtros">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Personas',
            'value' => number_format($totalPersonas, 0, ',', '.'),
            'icon' => 'bi bi-people'
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Ingresos',
            'value' => number_format($totalIngresos, 0, ',', '.'),
            'icon' => 'bi bi-box-arrow-in-right'
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Familias',
            'value' => number_format($totalFamilias, 0, ',', '.'),
            'icon' => 'bi bi-houses'
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Atenciones',
            'value' => number_format($totalAtenciones, 0, ',', '.'),
            'icon' => 'bi bi-heart-pulse'
        ])
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Programas Activos',
            'value' => number_format($totalProgramasActivos, 0, ',', '.'),
            'icon' => 'bi bi-flag'
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Personas con Programa',
            'value' => number_format($personasConProgramas, 0, ',', '.'),
            'icon' => 'bi bi-person-badge'
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Beneficios Activos',
            'value' => number_format($totalBeneficiosActivos, 0, ',', '.'),
            'icon' => 'bi bi-gift'
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Personas con Beneficio',
            'value' => number_format($personasConBeneficios, 0, ',', '.'),
            'icon' => 'bi bi-person-check'
        ])
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-lg-8">
        @include('frontend.estadisticas.partials.chart', [
            'title' => 'Tendencia de Ingresos Mensuales',
            'chartId' => 'ingresosChart'
        ])
    </div>

    <div class="col-12 col-lg-4">
        <div class="card stats-card p-4 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0 text-dark text-opacity-85 fs-6">
                    Barrios Más Activos
                </h5>
                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-15 px-2 py-1 small">
                    Top Zonas
                </span>
            </div>

            <div class="d-flex flex-column gap-3">
                @php 
                    $maxIngresos = $barriosActivos->max('total_ingresos') ?? 1;
                @endphp

                @foreach($barriosActivos as $barrio)
                    @php 
                        $porcentaje = ($barrio->total_ingresos / $maxIngresos) * 100;
                    @endphp
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-secondary fw-medium small">
                                <i class="bi bi-geo-alt text-muted me-1"></i>{{ $barrio->barrio }}
                            </span>
                            <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill">
                                {{ number_format($barrio->total_ingresos, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="progress" style="height: 6px; background-color: #f1f5f9;">
                            <div class="progress-bar bg-primary rounded-pill" 
                                 role="progressbar" 
                                 style="width: {{ $porcentaje }}%; transition: width 1s ease-in-out;" 
                                 aria-valuenow="{{ $porcentaje }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-lg-6">
        <div class="card stats-card p-4 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1 text-dark text-opacity-85 fs-6">Programas con más personas</h5>
                    <p class="text-muted small mb-0">Distribución general de los programas activos</p>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold rounded-pill px-3 py-2">Top 6</span>
            </div>
            <div class="list-group list-group-flush">
                @foreach($programasActivos as $programa)
                    <div class="list-group-item px-0 py-3 border-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <div class="fw-semibold">{{ $programa->nombre }}</div>
                                <span class="text-secondary small">Personas activas</span>
                            </div>
                            <span class="fw-bold text-dark">{{ number_format($programa->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="progress" style="height: 7px; background-color: #eef2ff;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ round(($programa->total / max($programasActivos->max('total'), 1)) * 100, 1) }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card stats-card p-4 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1 text-dark text-opacity-85 fs-6">Beneficios más otorgados</h5>
                    <p class="text-muted small mb-0">Resumen de los beneficios más frecuentes</p>
                </div>
                <span class="badge bg-success bg-opacity-10 text-success fw-bold rounded-pill px-3 py-2">Top 6</span>
            </div>
            <div class="list-group list-group-flush">
                @foreach($beneficiosActivos as $beneficio)
                    <div class="list-group-item px-0 py-3 border-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <div class="fw-semibold">{{ $beneficio->nombre }}</div>
                                <span class="text-secondary small">Registros activos</span>
                            </div>
                            <span class="fw-bold text-dark">{{ number_format($beneficio->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="progress" style="height: 7px; background-color: #ecfdf5;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ round(($beneficio->total / max($beneficiosActivos->max('total'), 1)) * 100, 1) }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('ingresosChart').getContext('2d');
    
    // Creamos un degradado suave bajo la línea del gráfico para darle profundidad
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.25)');
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0.00)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                @foreach($ingresosMensuales as $item)
                    '{{ $item->periodo }}',
                @endforeach
            ],
            datasets: [{
                label: 'Ingresos Registrados',
                data: [
                    @foreach($ingresosMensuales as $item)
                        {{ $item->total }},
                    @endforeach
                ],
                borderColor: '#2563eb',          // Azul nítido de la paleta
                borderWidth: 3,
                backgroundColor: gradient,        // Fondo degradado aplicado
                fill: true,
                tension: 0.38,                    // Curvatura elegante y limpia
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Ocultamos la leyenda para un look más limpio y minimalista
                },
                tooltip: {
                    padding: 12,
                    displayColors: false,
                    backgroundColor: '#0f172a',
                    titleFont: { family: 'Inter', size: 13, weight: 'bold' },
                    bodyFont: { family: 'Inter', size: 13 },
                    borderRadius: 8
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false // Oculta líneas verticales pesadas
                    },
                    ticks: {
                        color: '#64748b',
                        font: { family: 'Inter', size: 12 }
                    }
                },
                y: {
                    grid: {
                        color: '#f1f5f9' // Líneas horizontales muy tenues
                    },
                    ticks: {
                        color: '#64748b',
                        font: { family: 'Inter', size: 12 },
                        precision: 0
                    },
                    border: {
                        dash: [5, 5] // Línea de eje punteada moderna
                    }
                }
            }
        }
    });
});
</script>

@endsection