@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Estadísticas de Ingresos')

@section('subtitulo', 'Análisis de ingresos y derivaciones')

@section('content')

@include('frontend.estadisticas.partials.navbar')

<div class="container-fluid px-4 py-4">

    {{-- =========================
        ENCABEZADO Y CONTROL DE FILTROS
    ========================== --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-3 border-bottom border-light-subtle">
        <div>
            <h4 class="fw-bold tracking-tight text-dark mb-1">Panel Estadístico de Ingresos</h4>
            <p class="text-muted small mb-0">Visualización dinámica y análisis de registros en tiempo real</p>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button 
                class="btn btn-white border border-light-subtle btn-sm d-flex align-items-center gap-2 px-3 py-2 shadow-xs transition-all duration-200 hover-bg-light" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#collapseFilters" 
                aria-expanded="false" 
                aria-controls="collapseFilters"
            >
                <i class="bi bi-sliders2 text-secondary"></i>
                <span class="fw-medium text-secondary">Configurar Vista</span>
                <i class="bi bi-chevron-down small text-muted toggle-icon"></i>
            </button>

            <div class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fw-semibold rounded-2 shadow-xs">
                <i class="bi bi-calendar3 me-1.5"></i> {{ now()->format('d/m/Y') }}
            </div>
        </div>
    </div>

    {{-- =========================
        FILTROS COLAPSABLES
    ========================== --}}
    <div class="collapse mb-4" id="collapseFilters">
        <div class="card border border-light-subtle bg-body-tertiary shadow-sm p-4 rounded-3">
            <h6 class="fw-bold text-secondary mb-3 small text-uppercase tracking-wider">
                <i class="bi bi-funnel me-1.5 text-primary"></i> Parámetros de Análisis
            </h6>
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-medium text-muted small">
                        <i class="bi bi-calendar-event me-1"></i> Año Histórico
                    </label>
                    <select class="form-select border-light-subtle shadow-xs rounded-2 focus-ring" onchange="window.location=this.value">
                        @for($i = now()->year; $i >= 2024; $i--)
                            <option value="?anio={{ $i }}" {{ ($anio ?? now()->year) == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-medium text-muted small">
                        <i class="bi bi-bar-chart-line me-1"></i> Visualización
                    </label>
                    <select id="chartType" class="form-select border-light-subtle shadow-xs rounded-2 focus-ring">
                        <option value="line" selected>Líneas continuas</option>
                        <option value="bar">Barras de densidad</option>
                        <option value="doughnut">Gráfico de Dona</option>
                        <option value="pie">Gráfico de Torta</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-medium text-muted small">
                        <i class="bi bi-diagram-3 me-1"></i> Segmentación
                    </label>
                    <select id="groupType" class="form-select border-light-subtle shadow-xs rounded-2 focus-ring">
                        <option value="mensual" selected>Evolución Mensual</option>
                        <option value="derivacion">Por Derivaciones</option>
                        <option value="horas">Carga Horaria</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-medium text-muted small">
                        <i class="bi bi-activity me-1"></i> Origen de Datos
                    </label>
                    <div class="stats-status-box border border-light-subtle shadow-xs rounded-2 bg-white">
                        <span class="pulse-dot"></span>
                        <span class="small fw-medium text-dark">Sincronizado en Vivo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =========================
        KPIs (REUTILIZANDO TU PARTIAL CARD)
    ========================== --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            @include('frontend.estadisticas.partials.card', [
                'title' => 'Total Ingresos',
                'value' => $totalIngresos,
                'icon' => 'bi bi-box-arrow-in-right',
                'color' => 'success'
            ])
        </div>

        <div class="col-6 col-xl-3">
            @include('frontend.estadisticas.partials.card', [
                'title' => 'Ingresos Hoy',
                'value' => $ingresosHoy,
                'icon' => 'bi bi-calendar-day',
                'color' => 'primary'
            ])
        </div>

        <div class="col-6 col-xl-3">
            @include('frontend.estadisticas.partials.card', [
                'title' => 'Ingresos del Mes',
                'value' => $ingresosMes,
                'icon' => 'bi bi-calendar-month',
                'color' => 'warning'
            ])
        </div>

        <div class="col-6 col-xl-3">
            @include('frontend.estadisticas.partials.card', [
                'title' => 'Derivación Principal',
                'value' => $topDerivacion->nombre ?? 'Sin datos',
                'icon' => 'bi bi-diagram-3',
                'color' => 'info',
                'isText' => true {{-- Flag para que el partial baje el tamaño si es texto --}}
            ])
        </div>
    </div>

    {{-- =========================
        TIMELINE HORIZONTAL
    ========================== --}}
    <div class="card border border-light-subtle shadow-sm p-4 mb-4 rounded-3">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h5 class="fw-bold tracking-tight text-dark mb-0">Línea Temporal de Ingresos</h5>
                <p class="text-muted small mb-0">Evolución mensual del sistema</p>
            </div>
            <span class="badge bg-body-secondary border text-secondary px-3 py-2 fw-medium rounded-2">
                Período {{ $anio ?? now()->year }}
            </span>
        </div>

        <div class="timeline-wrapper pb-2">
            @foreach($mensuales as $item)
                <div class="timeline-item">
                    <div class="timeline-line"></div>
                    <div class="timeline-dot"></div>
                    <div class="timeline-month">{{ $item->periodo }}</div>
                    <div class="timeline-value text-dark">{{ $item->total }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- =========================
        CONTENIDO PRINCIPAL
    ========================== --}}
    <div class="row g-4">
        {{-- Gráfico Principal Reutilizado --}}
        <div class="col-lg-8">
            @include('frontend.estadisticas.partials.chart', [
                'title' => 'Visualización Estadística Dinámica',
                'chartId' => 'mainChart'
            ])
        </div>

        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4">
                {{-- Gráfico Donut Reutilizado --}}
                @include('frontend.estadisticas.partials.chart', [
                    'title' => 'Distribución General de Derivaciones',
                    'chartId' => 'donutChart'
                ])

                {{-- Actividad Reciente --}}
                <div class="card border border-light-subtle shadow-sm p-4 rounded-3">
                    <div class="mb-4">
                        <h5 class="fw-bold tracking-tight text-dark mb-0">Actividad Reciente</h5>
                        <p class="text-muted small mb-0">Últimos ingresos registrados en plataforma</p>
                    </div>

                    <div class="activity-container ps-1">
                        @foreach($timeline as $item)
                            <div class="timeline-activity">
                                <div class="timeline-dot-mini"></div>
                                <div class="flex-grow-1 min-w-0">
                                    <div class="fw-semibold text-dark text-truncate small">
                                        {{ $item->nombre }} {{ $item->apellido }}
                                    </div>
                                    <small class="text-muted d-block mb-1.5" style="font-size: 0.75rem;">
                                        <i class="bi bi-clock me-1"></i>{{ $item->created_at->format('d/m/Y H:i') }}
                                    </small>
                                    @if($item->derivacion)
                                        <span class="badge bg-light text-secondary border font-monospace px-2 py-1" style="font-size: 0.7rem;">
                                            {{ $item->derivacion->nombre }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Rendimiento de Operadores --}}
                <div class="card border border-light-subtle shadow-sm p-4 rounded-3">
                    <h5 class="fw-bold tracking-tight text-dark mb-3">Rendimiento de Operadores</h5>
                    <div class="d-flex flex-column gap-2 design-scroll" style="max-height: 280px; overflow-y: auto;">
                        @foreach($usuarios as $usuario)
                            <div class="operator-item p-2 rounded-2 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3 min-w-0">
                                    <div class="operator-avatar border border-light-subtle shadow-xs bg-body-secondary text-secondary">
                                        <i class="bi bi-person text-secondary-emphasis"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="fw-semibold text-dark text-truncate small">{{ $usuario->username }}</div>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">Módulo Operador</small>
                                    </div>
                                </div>
                                <div class="operator-count font-monospace shadow-xs border border-success-subtle">
                                    {{ $usuario->total_ingresos }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $horasFormateadas = $horas->map(function($item) {
        return str_pad($item->hora, 2, '0', STR_PAD_LEFT) . ':00';
    })->values();
@endphp

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const mensualLabels = @json($mensuales->pluck('periodo'));
        const mensualData   = @json($mensuales->pluck('total'));
        const derivacionLabels = @json($derivaciones->pluck('nombre'));
        const derivacionData   = @json($derivaciones->pluck('total'));
        const horasLabels = @json($horasFormateadas);
        const horasData   = @json($horas->pluck('total'));

        const ctx = document.getElementById('mainChart').getContext('2d');
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        const chartTypeSelect = document.getElementById('chartType');
        const groupTypeSelect = document.getElementById('groupType');

        let currentChart;

        const colors = {
            primary: '#198754',
            palette: ['#198754', '#0d6efd', '#ffc107', '#dc3545', '#0dcaf0', '#6f42c1', '#fd7e14', '#20c997']
        };

        function renderChart() {
            if(currentChart) currentChart.destroy();

            let labels = [], data = [];
            switch(groupTypeSelect.value) {
                case 'mensual':    labels = mensualLabels;    data = mensualData;    break;
                case 'derivacion': labels = derivacionLabels; data = derivacionData; break;
                case 'horas':      labels = horasLabels;      data = horasData;      break;
            }

            const type = chartTypeSelect.value;
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(25, 135, 84, 0.2)');
            gradient.addColorStop(1, 'rgba(25, 135, 84, 0.00)');

            let datasetConfig = {
                label: 'Registros',
                data: data,
                borderWidth: 2.5,
                tension: 0.3
            };

            if(type === 'line'){
                datasetConfig.borderColor = colors.primary;
                datasetConfig.backgroundColor = gradient;
                datasetConfig.fill = true;
                datasetConfig.pointBackgroundColor = colors.primary;
                datasetConfig.pointRadius = 4;
                datasetConfig.pointHoverRadius = 6;
            } else if(type === 'pie' || type === 'doughnut'){
                datasetConfig.backgroundColor = colors.palette;
                datasetConfig.borderColor = '#fff';
                datasetConfig.borderWidth = 2;
            } else {
                datasetConfig.backgroundColor = 'rgba(25, 135, 84, 0.85)';
                datasetConfig.borderRadius = 4;
            }

            currentChart = new Chart(ctx, {
                type: type,
                data: { labels: labels, datasets: [datasetConfig] },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: type === 'pie' || type === 'doughnut',
                            position: 'bottom',
                            labels: { boxWidth: 12, padding: 15, font: { size: 11, family: 'system-ui' } }
                        }
                    },
                    scales: (type === 'pie' || type === 'doughnut') ? {} : {
                        y: { grid: { color: '#f1f3f5' }, border: { dash: [5, 5] }, ticks: { font: { size: 11 } } },
                        x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                    }
                }
            });
        }

        if (donutCtx) {
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: derivacionLabels,
                    datasets: [{ data: derivacionData, backgroundColor: colors.palette, borderWidth: 2, borderColor: '#fff' }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: true, position: 'bottom', labels: { boxWidth: 10, padding: 10, font: { size: 11 } } } },
                    cutout: '75%'
                }
            });
        }

        renderChart();
        chartTypeSelect.addEventListener('change', renderChart);
        groupTypeSelect.addEventListener('change', renderChart);

        const collapsable = document.getElementById('collapseFilters');
        const icon = document.querySelector('.toggle-icon');
        collapsable.addEventListener('show.bs.collapse', () => icon.style.transform = 'rotate(180deg)');
        collapsable.addEventListener('hide.bs.collapse', () => icon.style.transform = 'rotate(0deg)');
    });
</script>

@push('styles')
<style>
    .tracking-tight { letter-spacing: -0.02em; }
    .tracking-wider { letter-spacing: 0.04em; }
    .shadow-xs { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .btn-white { background-color: #fff; }
    .hover-bg-light:hover { background-color: #f8fafc !important; }
    .toggle-icon { transition: transform 0.2s ease; }
    
    .stats-status-box {
        height: 38px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 12px;
    }

    .pulse-dot {
        width: 7px;
        height: 7px;
        background: #198754;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.5); }
        70% { transform: scale(1); box-shadow: 0 0 0 5px rgba(25, 135, 84, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(25, 135, 84, 0); }
    }

    .timeline-wrapper {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        overflow-x: auto;
    }
    .timeline-wrapper::-webkit-scrollbar, .design-scroll::-webkit-scrollbar {
        height: 5px; width: 5px;
    }
    .timeline-wrapper::-webkit-scrollbar-thumb, .design-scroll::-webkit-scrollbar-thumb {
        background: #e2e8f0; border-radius: 10px;
    }

    .timeline-item {
        min-width: 90px;
        text-align: center;
        position: relative;
        flex-grow: 1;
    }

    .timeline-item:not(:last-child) .timeline-line {
        position: absolute;
        top: 6px;
        left: 50%;
        width: 100%;
        height: 2px;
        background: #f1f3f5;
        z-index: 1;
    }

    .timeline-dot {
        width: 14px;
        height: 14px;
        background: #198754;
        border-radius: 50%;
        margin: auto;
        position: relative;
        z-index: 2;
        border: 3px solid #fff;
        box-shadow: 0 0 0 1px #198754;
    }

    .timeline-month {
        margin-top: 12px;
        font-size: .65rem;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
    }

    .timeline-value {
        font-size: 1.1rem;
        font-weight: 700;
        margin-top: 1px;
        letter-spacing: -0.02em;
    }

    .timeline-activity {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        position: relative;
        padding-bottom: 16px;
    }

    .timeline-activity:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 5px;
        top: 14px;
        width: 1px;
        height: 100%;
        background: #e2e8f0;
    }

    .timeline-dot-mini {
        width: 11px;
        height: 11px;
        background: #fff;
        border-radius: 50%;
        margin-top: 4px;
        position: relative;
        z-index: 2;
        border: 3px solid #198754;
        flex-shrink: 0;
    }

    .activity-container {
        max-height: 320px;
        overflow-y: auto;
    }
    .activity-container::-webkit-scrollbar { width: 4px; }
    .activity-container::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

    .operator-item {
        transition: all 0.2s ease;
    }
    .operator-item:hover {
        background-color: #f8fafc;
    }

    .operator-avatar {
        width: 34px;
        height: 34px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .operator-count {
        padding: 4px 10px;
        border-radius: 6px;
        background: #f0fdf4;
        color: #166534;
        font-weight: 700;
        font-size: 0.8rem;
    }
</style>
@endpush

@endsection