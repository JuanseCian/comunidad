@extends('frontend.estadisticas.layouts.app')

@section('titulo', $programa)

@section('subtitulo', 'Análisis estadístico integral')

@section('content')

<div class="container-fluid px-0 py-3">

    {{-- BARRA DE FILTROS MINIMALISTA --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <form method="GET" class="row g-3 align-items-end">

                {{-- SEDE --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Sede
                    </label>

                    <select name="sede_id" class="form-select">
                        <option value="">Todas las sedes</option>

                        @foreach($listaSedes as $sede)
                            <option
                                value="{{ $sede->id }}"
                                {{ request('sede_id') == $sede->id ? 'selected' : '' }}
                            >
                                {{ $sede->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- AÑO --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        Año
                    </label>

                    <select name="anio" class="form-select">

                        <option value="">Todos</option>

                        @for($i = now()->year; $i >= 2023; $i--)
                            <option
                                value="{{ $i }}"
                                {{ request('anio') == $i ? 'selected' : '' }}
                            >
                                {{ $i }}
                            </option>
                        @endfor

                    </select>
                </div>

                {{-- MES --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        Mes
                    </label>

                    <select name="mes" class="form-select">

                        <option value="">Todos</option>

                        @foreach([
                            1=>'Enero',
                            2=>'Febrero',
                            3=>'Marzo',
                            4=>'Abril',
                            5=>'Mayo',
                            6=>'Junio',
                            7=>'Julio',
                            8=>'Agosto',
                            9=>'Septiembre',
                            10=>'Octubre',
                            11=>'Noviembre',
                            12=>'Diciembre'
                        ] as $num => $nombre)

                            <option
                                value="{{ $num }}"
                                {{ request('mes') == $num ? 'selected' : '' }}
                            >
                                {{ $nombre }}
                            </option>

                        @endforeach

                    </select>
                </div>

                {{-- BOTONES --}}
                <div class="col-md-2">

                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >
                        Filtrar
                    </button>

                    @if(request()->hasAny(['sede_id','anio','mes']))
                        <a
                            href="{{ request()->url() }}"
                            class="btn btn-outline-secondary w-100 mt-2"
                        >
                            Limpiar
                        </a>
                    @endif

                </div>

            </form>

        </div>
    </div>

    {{-- TARJETAS DE RESUMEN (KPIs) --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="card border border-light-subtle h-100 bg-white">
                <div class="card-body p-4">
                    <span class="text-secondary small fw-medium d-block mb-1">Total Matrícula</span>
                    <h3 class="fw-bold text-dark m-0">{{ number_format($total) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card border border-light-subtle h-100 bg-white">
                <div class="card-body p-4">
                    <span class="text-secondary small fw-medium d-block mb-1">Casos Activos</span>
                    <h3 class="fw-bold text-dark m-0 d-flex align-items-center">
                        {{ number_format($activos) }}
                        <span class="badge bg-success-subtle text-success fs-7 ms-2 border border-success-subtle fw-medium py-1 px-2">En curso</span>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border border-light-subtle h-100 bg-white">
                <div class="card-body p-4">
                    <span class="text-secondary small fw-medium d-block mb-1">Egresos / Finalizados</span>
                    <h3 class="fw-bold text-dark m-0">{{ number_format($finalizados) }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- SECCIÓN MÓDULOS DE GRÁFICOS COMBINADOS --}}
    <div class="row g-3 mb-4">
        {{-- SEDES --}}
        <div class="col-lg-8">
            <div class="card border border-light-subtle h-100 bg-white">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-semibold text-dark mb-0">Distribución de Cobertura por Sede</h6>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container">
                        <canvas id="sedesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- EDADES --}}
        <div class="col-lg-4">
            <div class="card border border-light-subtle h-100 bg-white">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-semibold text-dark mb-0">Segmentación por Edad</h6>
                </div>
                <div class="card-body p-4 d-flex align-items-center justify-content-center">
                    <div class="chart-container-doughnut">
                        <canvas id="edadesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        {{-- BARRIOS --}}
        <div class="col-md-6">
            <div class="card border border-light-subtle bg-white">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-semibold text-dark mb-0">Barrios con Mayor Frecuencia</h6>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container">
                        <canvas id="barriosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- BENEFICIOS --}}
        <div class="col-md-6">
            <div class="card border border-light-subtle bg-white">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h6 class="fw-semibold text-dark mb-0">Prestaciones y Beneficios Asociados</h6>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container">
                        <canvas id="beneficiosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- LINEAL DE INGRESOS (ANCHO COMPLETO) --}}
    <div class="card border border-light-subtle bg-white mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
            <h6 class="fw-semibold text-dark mb-0">Evolución Cronológica de Altas / Ingresos</h6>
        </div>
        <div class="card-body p-4">
            <div class="chart-container-line">
                <canvas id="ingresosChart"></canvas>
            </div>
        </div>
    </div>

</div>

<style>
/* Estructuración fija para que Chart.js dibuje de forma predecible y fluida */
.chart-container { position: relative; height: 260px; width: 100%; }
.chart-container-doughnut { position: relative; height: 220px; width: 100%; }
.chart-container-line { position: relative; height: 280px; width: 100%; }
.fs-7 { font-size: 0.75rem; }
.form-select-sm, .btn-sm { font-size: 0.825rem; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// CONFIGURACIÓN GLOBAL DE CHART.JS PARA DISEÑO PROFESIONAL
Chart.defaults.font.family = "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif";
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
            grid: { color: '#f1f5f9' }, 
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
            backgroundColor: '#0056b3',
            hoverBackgroundColor: '#004085',
            borderRadius: 4,
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
            backgroundColor: '#475569',
            hoverBackgroundColor: '#334155',
            borderRadius: 4,
            barThickness: 20
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
            backgroundColor: '#64748b',
            hoverBackgroundColor: '#475569',
            borderRadius: 4,
            barThickness: 20
        }]
    },
    options: chartOptionsBase
});

// CHART: Edades (Doughnut minimalista en vez de Pie)
new Chart(document.getElementById('edadesChart'), {
    type: 'doughnut',
    data: {
        labels: @json($edades->pluck('rango')),
        datasets: [{
            data: @json($edades->pluck('total')),
            backgroundColor: ['#0056b3', '#475569', '#94a3b8', '#cbd5e1'],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true, position: 'bottom' }
        },
        cutout: '75%'
    }
});

// CHART: Evolución Temporal
new Chart(document.getElementById('ingresosChart'), {
    type: 'line',
    data: {
        labels: @json($ingresosMensuales->pluck('periodo')),
        datasets: [{
            data: @json($ingresosMensuales->pluck('total')),
            borderColor: '#0056b3',
            backgroundColor: 'rgba(0, 86, 179, 0.04)',
            fill: true,
            tension: 0.35,
            pointBackgroundColor: '#0056b3',
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false } },
            y: { grid: { color: '#f1f5f9' }, border: { dash: [4, 4] } }
        }
    }
});
</script>

@endsection