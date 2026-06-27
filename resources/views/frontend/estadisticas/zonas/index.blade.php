@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Análisis Territorial')
@section('subtitulo', 'Distribución demográfica por zonas y barrios')

@section('content')

<div class="container-fluid px-0">

    {{-- Filtros --}}
    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-4">
            <form method="GET" class="row g-3 align-items-end">
                
                <div class="col-md-2">
                    <label class="form-label text-muted small fw-bold text-uppercase">Programa</label>
                    <select name="programa_id" class="form-select shadow-none">
                        <option value="">Todos</option>
                        @foreach($programas as $programa)
                            <option value="{{ $programa->id }}" @selected(request('programa_id') == $programa->id)>
                                {{ $programa->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted small fw-bold text-uppercase">Sede</label>
                    <select name="sede_id" class="form-select shadow-none">
                        <option value="">Todas</option>
                        @foreach($sedes as $sede)
                            <option value="{{ $sede->id }}" @selected(request('sede_id') == $sede->id)>
                                {{ $sede->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted small fw-bold text-uppercase">Zona</label>
                    <select name="zona_id" class="form-select shadow-none">
                        <option value="">Todas</option>
                        @foreach($listaZonas as $z)
                            <option value="{{ $z->id }}" @selected(request('zona_id') == $z->id)>
                                {{ $z->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted small fw-bold text-uppercase">Barrio</label>
                    <select name="barrio_id" class="form-select shadow-none">
                        <option value="">Todos</option>
                        @foreach($listaBarrios as $b)
                            <option value="{{ $b->id }}" @selected(request('barrio_id') == $b->id)>
                                {{ $b->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1">
                    <label class="form-label text-muted small fw-bold text-uppercase">Año</label>
                    <select name="anio" class="form-select shadow-none">
                        <option value="">Todos</option>
                        @for($i = now()->year; $i >= 2023; $i--)
                            <option value="{{ $i }}" @selected(request('anio') == $i)>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-1">
                    <label class="form-label text-muted small fw-bold text-uppercase">Mes</label>
                    <select name="mes" class="form-select shadow-none">
                        <option value="">Todos</option>
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}" @selected(request('mes') == $i)>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">
                        Filtrar
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Resumen de KPIs --}}
    <div class="row g-3 mb-4">
        @php
            $kpis = [
                ['label' => 'Personas', 'value' => $totalPersonas, 'color' => 'text-primary'],
                ['label' => 'Barrios', 'value' => $totalBarrios, 'color' => 'text-success'],
                ['label' => 'Zonas', 'value' => $totalZonas, 'color' => 'text-info'],
                ['label' => 'Sin registrar', 'value' => $sinBarrio, 'color' => 'text-warning'],
                ['label' => 'Barrio Líder', 'value' => $barrioActivo, 'color' => 'text-danger'],
                ['label' => 'Zona Líder', 'value' => $zonaActiva, 'color' => 'text-secondary'],
            ];
        @endphp

        @foreach($kpis as $kpi)
        <div class="col-md-4 col-lg-2">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body p-3">
                    <h5 class="fw-bold mb-1 {{ $kpi['color'] }}">{{ $kpi['value'] }}</h5>
                    <small class="text-muted">{{ $kpi['label'] }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Gráficos --}}
    <div class="row g-4">
        
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Distribución por Zona</h6>
                    <div class="btn-group shadow-sm">
                        <button class="btn btn-sm btn-light border" onclick="changeChartType('zonasChart', 'bar')">Barras</button>
                        <button class="btn btn-sm btn-light border" onclick="changeChartType('zonasChart', 'doughnut')">Dona</button>
                        <button class="btn btn-sm btn-light border" onclick="changeChartType('zonasChart', 'pie')">Torta</button>
                    </div>
                </div>
                <div class="card-body position-relative" style="min-height: 350px;">
                    <canvas id="zonasChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Top 15 Barrios</h6>
                    <div class="btn-group shadow-sm">
                        <button class="btn btn-sm btn-light border" onclick="changeChartType('barriosChart', 'bar', 'y')">H</button>
                        <button class="btn btn-sm btn-light border" onclick="changeChartType('barriosChart', 'bar', 'x')">V</button>
                        <button class="btn btn-sm btn-light border" onclick="changeChartType('barriosChart', 'doughnut', 'x')">Dona</button>
                    </div>
                </div>
                <div class="card-body position-relative" style="min-height: 350px;">
                    <canvas id="barriosChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const colors = ['#0d92c2', '#17a385', '#4dbde8', '#f59e0b', '#8b5cf6', '#ec4899', '#10b981', '#6366f1', '#14b8a6', '#f43f5e', '#84cc16', '#0ea5e9', '#d946ef', '#eab308', '#64748b'];

    const configZonas = {
        type: 'bar',
        data: {
            labels: @json($zonas->pluck('zona')),
            datasets: [{
                label: 'Personas',
                data: @json($zonas->pluck('total')),
                backgroundColor: colors,
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    };

    const configBarrios = {
        type: 'bar',
        data: {
            labels: @json($barrios->pluck('barrio')),
            datasets: [{
                label: 'Personas',
                data: @json($barrios->pluck('total')),
                backgroundColor: colors,
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { display: false } }
        }
    };

    const zonasChart = new Chart(document.getElementById('zonasChart'), configZonas);
    const barriosChart = new Chart(document.getElementById('barriosChart'), configBarrios);

    window.changeChartType = function(chartId, newType, axis = 'x') {
        const chart = Chart.getChart(chartId);
        chart.config.type = newType;
        
        if (newType === 'bar') {
            chart.config.options.indexAxis = axis;
            chart.config.options.plugins.legend.display = false;
        } else {
            chart.config.options.indexAxis = 'x'; 
            chart.config.options.plugins.legend.display = true;
            chart.config.options.plugins.legend.position = 'right';
        }
        
        chart.update();
    };
</script>

@endsection