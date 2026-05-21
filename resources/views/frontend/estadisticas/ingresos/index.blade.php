@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Estadísticas de Ingresos')

@section('subtitulo', 'Análisis de ingresos y derivaciones')

@section('content')

@include('frontend.estadisticas.partials.navbar')

<div class="container-fluid px-0 py-2">

    {{-- KPIs --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            @include('frontend.estadisticas.partials.card', [
                'title' => 'Total Ingresos',
                'value' => $totalIngresos,
                'icon' => 'bi bi-box-arrow-in-right'
            ])
        </div>

        <div class="col-md-4">
            @include('frontend.estadisticas.partials.card', [
                'title' => 'Ingresos Hoy',
                'value' => $ingresosHoy,
                'icon' => 'bi bi-calendar-day'
            ])
        </div>

        <div class="col-md-4">
            @include('frontend.estadisticas.partials.card', [
                'title' => 'Ingresos del Mes',
                'value' => $ingresosMes,
                'icon' => 'bi bi-calendar-month'
            ])
        </div>
    </div>

    {{-- TIMELINE --}}
    <div class="card border-0 shadow-sm p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1 text-dark">Línea Temporal de Ingresos</h5>
                <small class="text-muted">Evolución mensual durante el año en curso</small>
            </div>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fw-bold">
                {{ now()->year }}
            </span>
        </div>

        <div class="timeline-wrapper pb-2">
            @foreach($mensuales as $item)
                <div class="timeline-item">
                    <div class="timeline-line"></div>
                    <div class="timeline-dot"></div>
                    <div class="timeline-month text-uppercase">{{ $item->periodo }}</div>
                    <div class="timeline-value text-dark mt-1">{{ $item->total }}</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- CONTROLES DE FILTRADO --}}
    <div class="card border-0 shadow-sm p-4 mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary small mb-2">
                    <i class="bi bi-pie-chart text-muted me-1"></i> Tipo de gráfico
                </label>
                <select id="chartType" class="form-select shadow-sm">
                    <option value="bar" selected>Histograma de Barras</option>
                    <option value="line">Gráfico de Líneas</option>
                    <option value="doughnut">Vista de Donut</option>
                    <option value="pie">Vista de Torta (Pie)</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary small mb-2">
                    <i class="bi bi-segmented-nav text-muted me-1"></i> Agrupar información
                </label>
                <select id="groupType" class="form-select shadow-sm">
                    <option value="mensual" selected>Ingresos Mensuales</option>
                    <option value="derivacion">Distribución por Derivación</option>
                </select>
            </div>
        </div>
    </div>

    {{-- GRÁFICOS Y PANEL LATERAL --}}
    <div class="row g-4">
        <div class="col-lg-8">
            @include('frontend.estadisticas.partials.chart', [
                'title' => 'Visualización Estadística Dinámica',
                'chartId' => 'mainChart'
            ])
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark">Rendimiento de Operadores</h5>
                
                <div class="d-flex flex-column gap-3">
                    @foreach($usuarios as $usuario)
                        <div class="d-flex justify-content-between align-items-center p-2.5 rounded-3 hover-bg-light">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light border p-2 rounded-circle text-success d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-person text-secondary"></i>
                                </span>
                                <span class="fw-medium text-dark">{{ $usuario->username }}</span>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 fw-bold">
                                {{ $usuario->total_ingresos }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

{{-- DATOS Y RENDERIZADO CON CHART.JS OPTIMIZADO --}}
<script>
    {{-- Inyección de colecciones PHP a arrays puros de JavaScript --}}
    const mensualLabels = [@foreach($mensuales as $item) '{{ $item->periodo }}', @endforeach];
    const mensualData = [@foreach($mensuales as $item) {{ $item->total }}, @endforeach];

    const derivacionLabels = [@foreach($derivaciones as $item) '{{ $item->nombre }}', @endforeach];
    const derivacionData = [@foreach($derivaciones as $item) {{ $item->total }}, @endforeach];

    const ctx = document.getElementById('mainChart').getContext('2d');
    const chartTypeSelect = document.getElementById('chartType');
    const groupTypeSelect = document.getElementById('groupType');
    let currentChart;

    {{-- Paleta estricta del Dashboard Comunidad --}}
    const colors = {
        primary: '#198754',       {{-- Verde Bootstrap Success --}}
        primaryLight: '#d1e7dd',
        darkText: '#212529',
        mutedText: '#6c757d',
        palette: ['#198754', '#0d6efd', '#ffc107', '#dc3545', '#0dcaf0', '#6610f2', '#fd7e14', '#20c997']
    };

    function renderChart() {
        if(currentChart) {
            currentChart.destroy();
        }

        let labels = [];
        let data = [];
        const isDerivacion = groupTypeSelect.value === 'derivacion';
        const type = chartTypeSelect.value;

        if(isDerivacion) {
            labels = derivacionLabels;
            data = derivacionData;
        } else {
            labels = mensualLabels;
            data = mensualData;
        }

        {{-- Configuración de gradiente dinámico para barras y líneas --}}
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(25, 135, 84, 0.35)');
        gradient.addColorStop(1, 'rgba(25, 135, 84, 0.01)');

        let datasetConfig = {
            label: isDerivacion ? 'Casos por Derivación' : 'Ingresos Mensuales',
            data: data,
            tension: 0.35,
            borderWidth: 2.5
        };

        {{-- Ajustes estéticos según el tipo de gráfico --}}
        if (type === 'pie' || type === 'doughnut') {
            datasetConfig.backgroundColor = colors.palette.slice(0, data.length);
            datasetConfig.borderColor = '#ffffff';
            datasetConfig.borderWidth = 2;
        } else if (type === 'line') {
            datasetConfig.borderColor = colors.primary;
            datasetConfig.backgroundColor = gradient;
            datasetConfig.fill = true;
            datasetConfig.pointBackgroundColor = colors.primary;
            datasetConfig.pointBorderColor = '#fff';
            datasetConfig.pointRadius = 4;
            datasetConfig.pointHoverRadius = 6;
        } else { {{-- Barras --}}
            datasetConfig.borderColor = colors.primary;
            datasetConfig.backgroundColor = 'rgba(25, 135, 84, 0.85)';
            datasetConfig.borderRadius = 6;
            datasetConfig.borderSkipped = false;
        }

        currentChart = new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: [datasetConfig]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: (type === 'pie' || type === 'doughnut'),
                        position: 'bottom',
                        labels: {
                            color: colors.darkText,
                            font: { family: 'inherit', size: 12, weight: '500' },
                            padding: 15
                        }
                    },
                    tooltip: {
                        padding: 12,
                        backgroundColor: 'rgba(33, 37, 41, 0.95)',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 13 },
                        cornerRadius: 6,
                        boxPadding: 6
                    }
                },
                scales: (type === 'pie' || type === 'doughnut') ? {} : {
                    y: {
                        grid: { color: 'rgba(0, 0, 0, 0.04)', drawBorder: false },
                        ticks: { color: colors.mutedText, font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: colors.mutedText, font: { size: 11, weight: '500' } }
                    }
                }
            }
        });
    }

    {{-- Inicialización y listeners --}}
    renderChart();
    chartTypeSelect.addEventListener('change', renderChart);
    groupTypeSelect.addEventListener('change', renderChart);
</script>

@push('styles')
<style>
    .timeline-wrapper {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        overflow-x: auto;
        padding-top: 15px;
    }

    .timeline-item {
        min-width: 100px;
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
        background: #e9ecef;
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
        box-shadow: 0 0 0 5px rgba(25, 135, 84, 0.15);
        transition: all 0.2s ease;
    }

    .timeline-item:hover .timeline-dot {
        transform: scale(1.2);
        background: #157347;
    }

    .timeline-month {
        margin-top: 14px;
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .timeline-value {
        font-size: 1.35rem;
        font-weight: 800;
    }

    .hover-bg-light:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease-in-out;
    }

    #mainChart {
        min-height: 400px;
    }
</style>
@endpush

@endsection