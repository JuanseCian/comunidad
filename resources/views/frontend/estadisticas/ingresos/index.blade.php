@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Estadísticas de Ingresos')

@section('subtitulo', 'Análisis de ingresos y derivaciones')

@section('content')

@include('frontend.estadisticas.partials.navbar')

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
<div class="stats-card p-4 mb-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h5 class="fw-bold mb-1">
                Línea Temporal de Ingresos
            </h5>

            <small class="text-muted">
                Evolución mensual durante el año
            </small>

        </div>

        <div class="badge bg-primary px-3 py-2">

            {{ now()->year }}

        </div>

    </div>

    <div class="timeline-wrapper">

        @foreach($mensuales as $item)

            <div class="timeline-item">

                <div class="timeline-line"></div>

                <div class="timeline-dot"></div>

                <div class="timeline-month">

                    {{ $item->periodo }}

                </div>

                <div class="timeline-value">

                    {{ $item->total }}

                </div>

            </div>

        @endforeach

    </div>

</div>

{{-- CONTROLES --}}
<div class="stats-card p-4 mb-4">

    <div class="row g-3 align-items-end">

        {{-- Tipo gráfico --}}
        <div class="col-md-3">

            <label class="form-label fw-bold small">

                Tipo de gráfico

            </label>

            <select id="chartType"
                    class="form-select">

                <option value="bar">
                    Histograma
                </option>

                <option value="line">
                    Línea
                </option>

                <option value="doughnut">
                    Donut
                </option>

                <option value="pie">
                    Pie
                </option>

            </select>

        </div>

        {{-- Agrupar por --}}
        <div class="col-md-4">

            <label class="form-label fw-bold small">

                Agrupar información

            </label>

            <select id="groupType"
                    class="form-select">

                <option value="mensual">
                    Ingresos Mensuales
                </option>

                <option value="derivacion">
                    Derivaciones
                </option>

            </select>

        </div>

    </div>

</div>

{{-- GRÁFICOS --}}
<div class="row g-4">

    <div class="col-lg-8">

        @include('frontend.estadisticas.partials.chart', [
            'title' => 'Visualización Estadística',
            'chartId' => 'mainChart'
        ])

    </div>

    <div class="col-lg-4">

        <div class="stats-card p-4 h-100">

            <h5 class="fw-bold mb-4">

                Usuarios con más ingresos

            </h5>

            @foreach($usuarios as $usuario)

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div class="d-flex align-items-center gap-2">

                        <div class="mini-user-dot"></div>

                        <span>

                            {{ $usuario->username }}

                        </span>

                    </div>

                    <strong>

                        {{ $usuario->total_ingresos }}

                    </strong>

                </div>

            @endforeach

        </div>

    </div>

</div>

{{-- DATOS --}}
<script>

    /*
    |--------------------------------------------------------------------------
    | DATOS MENSUALES
    |--------------------------------------------------------------------------
    */

    const mensualLabels = [

        @foreach($mensuales as $item)

            '{{ $item->periodo }}',

        @endforeach

    ];

    const mensualData = [

        @foreach($mensuales as $item)

            {{ $item->total }},

        @endforeach

    ];

    /*
    |--------------------------------------------------------------------------
    | DATOS DERIVACIONES
    |--------------------------------------------------------------------------
    */

    const derivacionLabels = [

        @foreach($derivaciones as $item)

            '{{ $item->nombre }}',

        @endforeach

    ];

    const derivacionData = [

        @foreach($derivaciones as $item)

            {{ $item->total }},

        @endforeach

    ];

    /*
    |--------------------------------------------------------------------------
    | CONFIGURACIÓN
    |--------------------------------------------------------------------------
    */

    const ctx = document.getElementById('mainChart');

    const chartTypeSelect = document.getElementById('chartType');

    const groupTypeSelect = document.getElementById('groupType');

    let currentChart;

    /*
    |--------------------------------------------------------------------------
    | RENDER CHART
    |--------------------------------------------------------------------------
    */

    function renderChart()
    {
        if(currentChart)
        {
            currentChart.destroy();
        }

        let labels = [];
        let data = [];

        if(groupTypeSelect.value === 'derivacion')
        {
            labels = derivacionLabels;
            data = derivacionData;
        }
        else
        {
            labels = mensualLabels;
            data = mensualData;
        }

        currentChart = new Chart(ctx, {

            type: chartTypeSelect.value,

            data: {

                labels: labels,

                datasets: [{

                    label: 'Ingresos',

                    data: data,

                    borderWidth: 2,

                    tension: .4,

                    fill: true

                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {

                        display: true

                    }
                }
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | INIT
    |--------------------------------------------------------------------------
    */

    renderChart();

    /*
    |--------------------------------------------------------------------------
    | EVENTS
    |--------------------------------------------------------------------------
    */

    chartTypeSelect.addEventListener('change', renderChart);

    groupTypeSelect.addEventListener('change', renderChart);

</script>

{{-- ESTILOS --}}
<style>

.timeline-wrapper{

    display:flex;

    justify-content:space-between;

    gap:14px;

    overflow-x:auto;

    padding-top:10px;
}

.timeline-item{

    min-width:90px;

    text-align:center;

    position:relative;
}

.timeline-line{

    position:absolute;

    top:6px;

    left:50%;

    width:100%;

    height:2px;

    background:#dbeafe;

    z-index:1;
}

.timeline-dot{

    width:14px;

    height:14px;

    background:#2563eb;

    border-radius:50%;

    margin:auto;

    position:relative;

    z-index:2;

    box-shadow:0 0 0 5px rgba(37,99,235,.12);
}

.timeline-month{

    margin-top:14px;

    font-size:13px;

    color:#64748b;

    font-weight:700;
}

.timeline-value{

    font-size:22px;

    font-weight:800;

    margin-top:4px;
}

.mini-user-dot{

    width:10px;

    height:10px;

    border-radius:50%;

    background:#3b82f6;
}

#mainChart{

    min-height:420px;
}

</style>

@endsection