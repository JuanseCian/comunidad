@extends('frontend.estadisticas.layouts.app')

@section('titulo', $programa)
@section('subtitulo', 'Análisis estadístico integral')

@section('content')

<div class="container-fluid px-0 py-1">

    {{-- ==========================================
        CABECERA Y ACCIONES DE EXPORTACIÓN
    ========================================== --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <div class="stats-meta mb-1 text-muted small text-uppercase tracking-wider fw-bold">
                Módulo de Monitoreo Analítico
            </div>
            <h4 class="fw-bold tracking-tight text-dark m-0" style="font-size:1.75rem;">
                Programa: <span style="color: var(--sn-blue); font-weight:600;">{{ $programa }}</span>
            </h4>
        </div>

        {{-- BOTONES DE ACCIÓN (Se ocultan al imprimir automáticamente) --}}
        <div class="d-flex align-items-center gap-2 flex-wrap d-print-none">
            {{-- EXCEL --}}
            <a href="{{ route('estadisticas.destinatarios.programa.excel', array_merge(['programa' => strtolower($programa)], request()->query())) }}" 
               class="btn btn-success btn-sm rounded-3 d-flex align-items-center gap-2 px-3 py-2 shadow-xs fw-medium small transition-all">
                <i class="bi bi-file-earmark-excel"></i> Exportar a Excel
            </a>

            {{-- IMPRIMIR --}}
            <button onclick="window.print()" 
                    class="btn btn-white border border-light-subtle btn-sm rounded-3 d-flex align-items-center gap-2 px-3 py-2 shadow-xs fw-medium small text-secondary transition-all">
                <i class="bi bi-printer text-primary"></i> Imprimir Reporte
            </button>
            
            {{-- FECHA ACTUAL --}}
            <div class="badge bg-light text-dark border border-light-subtle px-3 py-2 fw-semibold rounded-3 shadow-xs d-flex align-items-center gap-2 small" style="min-height:38px;">
                <i class="bi bi-calendar3 text-muted"></i>
                {{ now()->format('d/m/Y') }}
            </div>
        </div>
    </div>

    {{-- ==========================================
        BARRA DE FILTROS AVANZADA Y ESTILIZADA
    ========================================== --}}
    <div class="card shadow-sm border-0 mb-4 card-filter d-print-none" style="border-radius: 16px;">
        <div class="card-body p-4">
            <form method="GET" class="row g-3 align-items-end">

                {{-- SEDE --}}
                <div class="col-12 col-md-4">
                    <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Sede</label>
                    <div class="input-group input-group-custom">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-building"></i></span>
                        <select name="sede_id" class="form-select bg-light border-start-0 small">
                            <option value="">Todas las sedes</option>
                            @foreach($listaSedes as $sede)
                                <option value="{{ $sede->id }}" {{ request('sede_id') == $sede->id ? 'selected' : '' }}>
                                    {{ $sede->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- AÑO --}}
                <div class="col-6 col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Año</label>
                    <div class="input-group input-group-custom">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-calendar-event"></i></span>
                        <select name="anio" class="form-select bg-light border-start-0 small">
                            <option value="">Todos</option>
                            @for($i = now()->year; $i >= 2023; $i--)
                                <option value="{{ $i }}" {{ request('anio') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                {{-- MES --}}
                <div class="col-6 col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase tracking-wider">Mes</label>
                    <div class="input-group input-group-custom">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-calendar-month"></i></span>
                        <select name="mes" class="form-select bg-light border-start-0 small">
                            <option value="">Todos</option>
                            @foreach([
                                1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril',
                                5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto',
                                9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre'
                            ] as $num => $nombre)
                                <option value="{{ $num }}" {{ request('mes') == $num ? 'selected' : '' }}>
                                    {{ $nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- ACCIONES DEL FORMULARIO --}}
                <div class="col-12 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-medium d-flex align-items-center justify-content-center gap-2 shadow-xs py-2" style="border-radius: 10px; min-height: 40px;">
                        <i class="bi bi-search small"></i> Filtrar
                    </button>
                    
                    @if(request()->hasAny(['sede_id','anio','mes']))
                        <a href="{{ request()->url() }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center px-3" style="border-radius: 10px;" title="Limpiar Filtros">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>

    {{-- ==========================================
        TARJETAS DE RESUMEN (KPIs)
    ========================================== --}}
    <div class="row g-4 mb-4">
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm p-3 card-hover-effect" style="border-radius: 16px;">
                <div class="d-flex align-items-center">
                    <div class="badge p-3 me-3 d-flex align-items-center justify-content-center bg-indigo-subtle text-indigo" style="width: 54px; height: 54px; border-radius: 14px;">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted small fw-bold text-uppercase tracking-wide">Total Matrícula</h6>
                        <h3 class="mb-0 fw-bold tracking-tight text-dark">{{ number_format($total) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm p-3 card-hover-effect" style="border-radius: 16px;">
                <div class="d-flex align-items-center">
                    <div class="badge p-3 me-3 d-flex align-items-center justify-content-center bg-success-subtle text-success" style="width: 54px; height: 54px; border-radius: 14px;">
                        <i class="bi bi-person-check fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted small fw-bold text-uppercase tracking-wide">Casos Activos</h6>
                        <h3 class="mb-0 fw-bold tracking-tight text-dark d-flex align-items-center flex-wrap gap-1">
                            {{ number_format($activos) }}
                            <span class="badge bg-success text-white px-2 py-0.5 rounded-pill d-none d-sm-inline" style="font-size: 0.65rem; font-weight: 500;">En curso</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm p-3 card-hover-effect" style="border-radius: 16px;">
                <div class="d-flex align-items-center">
                    <div class="badge p-3 me-3 d-flex align-items-center justify-content-center bg-secondary-subtle text-secondary" style="width: 54px; height: 54px; border-radius: 14px;">
                        <i class="bi bi-person-x fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted small fw-bold text-uppercase tracking-wide">Egresos / Finalizados</h6>
                        <h3 class="mb-0 fw-bold tracking-tight text-dark">{{ number_format($finalizados) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==========================================
        SECCIÓN MÓDULOS DE GRÁFICOS
    ========================================== --}}
    <div class="row g-4 mb-4">
        {{-- SEDES --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-dark mb-0">Distribución de Cobertura por Sede</h6>
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    <div class="chart-container">
                        <canvas id="sedesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- EDADES --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-dark mb-0">Segmentación por Edad</h6>
                </div>
                <div class="card-body px-4 pb-4 pt-2 d-flex align-items-center justify-content-center">
                    <div class="chart-container-doughnut">
                        <canvas id="edadesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        {{-- BARRIOS --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-dark mb-0">Barrios con Mayor Frecuencia</h6>
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    <div class="chart-container">
                        <canvas id="barriosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- BENEFICIOS --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-bold text-dark mb-0">Prestaciones y Beneficios Asociados</h6>
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    <div class="chart-container">
                        <canvas id="beneficiosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- LINEAL DE INGRESOS --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
            <h6 class="fw-bold text-dark mb-0">Evolución Cronológica de Altas / Ingresos</h6>
        </div>
        <div class="card-body px-4 pb-4 pt-2">
            <div class="chart-container-line">
                <canvas id="ingresosChart"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- ==========================================
    ESTILOS ESPECÍFICOS Y OPTIMIZACIÓN DE IMPRESIÓN
========================================== --}}
<style>
    .chart-container { position: relative; height: 260px; width: 100%; }
    .chart-container-doughnut { position: relative; height: 220px; width: 100%; }
    .chart-container-line { position: relative; height: 280px; width: 100%; }
    
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-tight { letter-spacing: -0.02em; }
    
    .card-hover-effect { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .card-hover-effect:hover { transform: translateY(-3px); box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.08)!important; }

    .input-group-custom { border-radius: 10px; overflow: hidden; }
    .input-group-custom .input-group-text { border: 1px solid #dee2e6; }
    .input-group-custom .form-select { border: 1px solid #dee2e6; border-radius: 0 10px 10px 0!important; }

    .bg-indigo-subtle { background-color: rgba(78, 115, 223, 0.1); }
    .text-indigo { color: #4e73df; }

    /* REGLAS EXCLUSIVAS PARA IMPRESIÓN */
    @media print {
        body { background: #fff !important; color: #000 !important; font-size: 12px; }
        .d-print-none { display: none !important; }
        .card { border: 1px solid #eaecf0 !important; shadow: none !important; margin-bottom: 15px !important; page-break-inside: avoid; }
        .container-fluid { padding: 0 !important; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// CONFIGURACIÓN GLOBAL DE CHART.JS PARA DISEÑO PROFESIONAL
Chart.defaults.font.family = "Inter, system-ui, -apple-system, sans-serif";
Chart.defaults.font.size = 11;
Chart.defaults.color = '#64748b';
Chart.defaults.plugins.legend.labels.usePointStyle = true;
Chart.defaults.plugins.legend.labels.boxWidth = 8;

const chartOptionsBase = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        x: { grid: { display: false }, ticks: { color: '#64748b' } },
        y: { 
            grid: { color: 'rgba(0,0,0,0.03)' }, 
            border: { dash: [4, 4] },
            ticks: { color: '#64748b', precision: 0 }
        }
    }
};

// CHART: Sedes
new Chart(document.getElementById('sedesChart'), {
    type: 'bar',
    data: {
        labels: @json($sedes->pluck('nombre')),
        datasets: [{
            data: @json($sedes->pluck('total')),
            backgroundColor: 'rgba(78, 115, 223, 0.85)',
            hoverBackgroundColor: '#4e73df',
            borderRadius: 6,
            barThickness: 24
        }]
    },
    options: chartOptionsBase
});

// CHART: Barrios
new Chart(document.getElementById('barriosChart'), {
    type: 'bar',
    data: {
        labels: @json($barrios->pluck('nombre')),
        datasets: [{
            data: @json($barrios->pluck('total')),
            backgroundColor: 'rgba(71, 85, 105, 0.85)',
            hoverBackgroundColor: '#334155',
            borderRadius: 5,
            barThickness: 18
        }]
    },
    options: chartOptionsBase
});

// CHART: Beneficios
new Chart(document.getElementById('beneficiosChart'), {
    type: 'bar',
    data: {
        labels: @json($beneficios->pluck('nombre')),
        datasets: [{
            data: @json($beneficios->pluck('total')),
            backgroundColor: 'rgba(100, 116, 139, 0.85)',
            hoverBackgroundColor: '#475569',
            borderRadius: 5,
            barThickness: 18
        }]
    },
    options: chartOptionsBase
});

// CHART: Edades (Doughnut)
new Chart(document.getElementById('edadesChart'), {
    type: 'doughnut',
    data: {
        labels: @json($edades->pluck('rango')),
        datasets: [{
            data: @json($edades->pluck('total')),
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#6f42c1'],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { 
                position: 'bottom',
                labels: { boxWidth: 10, padding: 12, usePointStyle: true }
            }
        },
        cutout: '72%'
    }
});

// CHART: Evolución Temporal
new Chart(document.getElementById('ingresosChart'), {
    type: 'line',
    data: {
        labels: @json($ingresosMensuales->pluck('periodo')),
        datasets: [{
            data: @json($ingresosMensuales->pluck('total')),
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.05)',
            fill: true,
            tension: 0.35,
            pointBackgroundColor: '#4e73df',
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false } },
            y: { grid: { color: 'rgba(0,0,0,0.03)' }, border: { dash: [4, 4] } }
        }
    }
});
</script>

@endsection