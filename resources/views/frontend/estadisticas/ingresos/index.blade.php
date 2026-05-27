@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Estadísticas de Ingresos')

@section('subtitulo', 'Análisis de ingresos y derivaciones')

@section('content')

<div class="container-fluid px-0 py-2">

    {{-- =========================
        ENCABEZADO Y FILTROS INTEGRADOS (ESTILO POWER BI)
    ========================== --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <div class="stats-meta mb-1">Visualización dinámica y análisis de registros en tiempo real</div>
            <h4 class="fw-bold tracking-tight text-dark m-0" style="font-size: 1.75rem;">Panel Estadístico de <span style="color: var(--sn-blue); font-weight: 400;">Ingresos</span></h4>
        </div>

        <div class="d-flex align-items-center gap-2">
            <button 
                class="btn btn-white border border-light-subtle btn-sm d-flex align-items-center gap-2 px-3 py-2 shadow-xs rounded-3 transition-all" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#collapseFilters" 
                aria-expanded="false" 
                aria-controls="collapseFilters"
                style="min-height: 40px;"
            >
                <i class="bi bi-sliders2 text-secondary"></i>
                <span class="fw-medium text-secondary small">Filtrar Datos</span>
                <i class="bi bi-chevron-down small text-muted toggle-icon"></i>
            </button>

            <div class="badge bg-light text-dark border border-light-subtle px-3 py-2 fw-semibold rounded-3 shadow-xs d-flex align-items-center gap-2" style="min-height: 40px; font-size: 0.85rem;">
                <i class="bi bi-calendar3 text-primary"></i> {{ now()->format('d/m/Y') }}
            </div>
        </div>
    </div>

    {{-- COLAPSIBLE DE FILTROS --}}
    <div class="collapse mb-4" id="collapseFilters">
        <div class="card border border-light-subtle shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 bg-light-subtle">
                <form method="GET">
                    <div class="row g-3">
                        {{-- Año --}}
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-muted">Año</label>
                            <select name="anio" class="form-select rounded-3 small" onchange="this.form.submit()">
                                @for($i = now()->year; $i >= 2024; $i--)
                                    <option value="{{ $i }}" {{ request('anio', now()->year) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- Mes --}}
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-muted">Mes</label>
                            <select name="mes" class="form-select rounded-3 small" onchange="this.form.submit()">
                                <option value="">Todos los meses</option>
                                @foreach([1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre'] as $num => $mes)
                                    <option value="{{ $num }}" {{ request('mes') == $num ? 'selected' : '' }}>{{ $mes }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Derivación --}}
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-muted">Derivación</label>
                            <select name="derivacion" class="form-select rounded-3 small" onchange="this.form.submit()">
                                <option value="">Todas las derivaciones</option>
                                @foreach($derivaciones as $d)
                                    <option value="{{ $d->id }}" {{ request('derivacion') == $d->id ? 'selected' : '' }}>{{ $d->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Reiniciar --}}
                        <div class="col-md-3 d-flex align-items-end">
                            <a href="{{ route('estadisticas.ingresos') }}" class="btn btn-white border rounded-3 w-100 fw-medium small d-flex align-items-center justify-content-center gap-2" style="min-height: 38px;">
                                <i class="bi bi-arrow-counterclockwise"></i> Reiniciar filtros
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- =========================
        TARJETAS DE PRESENTACIÓN (KPIs)
    ========================== --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            @include('frontend.estadisticas.partials.card', ['title' => 'Total Ingresos', 'value' => $totalIngresos, 'icon' => 'bi bi-box-arrow-in-right', 'color' => 'primary'])
        </div>
        <div class="col-6 col-xl-3">
            @include('frontend.estadisticas.partials.card', ['title' => 'Ingresos Hoy', 'value' => $ingresosHoy, 'icon' => 'bi bi-calendar-day', 'color' => 'success'])
        </div>
        <div class="col-6 col-xl-3">
            @include('frontend.estadisticas.partials.card', ['title' => 'Ingresos del Mes', 'value' => $ingresosMes, 'icon' => 'bi bi-bar-chart-line', 'color' => 'info'])
        </div>
        <div class="col-6 col-xl-3">
            @include('frontend.estadisticas.partials.card', ['title' => 'Derivación Principal', 'value' => $topDerivacion->nombre ?? 'Sin datos', 'icon' => 'bi bi-diagram-3', 'color' => 'warning', 'isText' => true])
        </div>
    </div>

        {{-- NUEVA SECCIÓN DE ÚLTIMOS INGRESOS EN ACORDEÓN (DEBAJO DE LA LÍNEA DE TIEMPO) --}}
        <div class="accordion accordion-flush" id="accordionRecentActivity">
            <div class="accordion-item border-0">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed px-4 py-3 fw-semibold text-secondary small bg-light-subtle d-flex gap-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRecent" aria-expanded="false" aria-controls="collapseRecent">
                        <i class="bi bi-clock-history text-primary"></i> Ver Detalle de Últimos Ingresos Registrados
                    </button>
                </h2>
                <div id="collapseRecent" class="accordion-collapse collapse" data-bs-parent="#accordionRecentActivity">
                    <div class="accordion-body p-4 bg-white design-scroll" style="max-height: 380px; overflow-y: auto;">
                        <div class="row g-3">
                            @forelse($timeline as $item)
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="p-3 border rounded-3 bg-light-subtle h-100 d-flex flex-column justify-content-between transition-all hover-bg-light">
                                        <div>
                                            <div class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                                                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.75rem;">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                                {{ $item->nombre }} {{ $item->apellido }}
                                            </div>
                                            <small class="text-muted d-block mb-2">
                                                <i class="bi bi-clock me-1"></i> {{ $item->created_at->format('d/m/Y H:i') }}
                                            </small>
                                        </div>
                                        @if($item->derivacion)
                                            <div>
                                                <span class="badge bg-white text-secondary border rounded-2 px-2 py-1.5 font-monospace" style="font-size: 0.75rem;">
                                                    {{ $item->derivacion->nombre }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-3 text-muted small">No hay registros recientes disponibles.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =========================
        DISTRIBUCIÓN DE GRÁFICOS Y OPERADORES
    ========================== --}}
    <div class="row g-4">

        {{-- GRÁFICO DINÁMICO PRINCIPAL --}}
        <div class="col-xl-8">
            <div class="card border border-light-subtle shadow-xs rounded-4 h-100 bg-white">
                <div class="p-4 border-bottom">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h5 class="fw-bold mb-1" style="font-size: 1.15rem;">Visualización Estadística</h5>
                            <small class="text-muted">Distribución y comportamiento volumétrico de ingresos</small>
                        </div>
                        <div class="d-flex gap-2">
                            <select id="chartType" class="form-select form-select-sm rounded-3 bg-light border-0 small fw-medium text-secondary" style="height: 36px;">
                                <option value="line">Líneas</option>
                                <option value="bar">Barras</option>
                                <option value="doughnut">Dona</option>
                                <option value="pie">Torta</option>
                            </select>
                            <select id="groupType" class="form-select form-select-sm rounded-3 bg-light border-0 small fw-medium text-secondary" style="height: 36px;">
                                <option value="mensual">Mensual</option>
                                <option value="derivacion">Derivaciones</option>
                                <option value="horas">Horarios</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <div style="height: 380px; position: relative;">
                        <canvas id="mainChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA LATERAL UNIFICADA: TORTA + DETALLE OPERADORES --}}
        <div class="col-xl-4">
            <div class="d-flex flex-column gap-4">

                {{-- GRÁFICO DE TORTA DE DERIVACIONES --}}
                <div class="card border border-light-subtle shadow-xs rounded-4 bg-white">
                    <div class="p-4 border-bottom">
                        <h6 class="fw-bold mb-1" style="font-size: 1.05rem;">Distribución de Derivaciones</h6>
                        <small class="text-muted">Sectores institucionales con mayor demanda</small>
                    </div>
                    <div class="p-4">
                        <div style="height: 240px; position: relative;">
                            <canvas id="donutChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- MOVIDO DEBAJO DEL GRÁFICO: CONTROL DE CARGAS POR OPERADOR --}}
                <div class="card border border-light-subtle shadow-xs rounded-4 bg-white">
                    <div class="p-4 border-bottom">
                        <h6 class="fw-bold mb-1" style="font-size: 1.05rem;">Cargas por Usuario</h6>
                        <small class="text-muted">Volumen de ingresos procesados por cada operador</small>
                    </div>
                    <div class="p-3 design-scroll" style="max-height: 260px; overflow-y: auto;">
                        @forelse($usuarios as $usuario)
                            <div class="operator-row">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="operator-avatar shadow-2xs">
                                        <i class="bi bi-person-workspace"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold small text-dark">{{ $usuario->username }}</div>
                                        <small class="text-muted" style="font-size: 0.75rem;">Operador del Sistema</small>
                                    </div>
                                </div>
                                <span class="operator-badge shadow-3xs">
                                    {{ $usuario->total_ingresos }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-3 text-muted small">Sin operadores activos registrados.</div>
                        @endforelse
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

        // Paleta refinada estilo Power BI (Tonos azules, grises limpios y acentos corporativos)
        const colors = {
            primary: '#0070f3',
            palette: ['#0070f3', '#4b8df8', '#10b981', '#f59e0b', '#3b82f6', '#6366f1', '#8b5cf6', '#ec4899']
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
            const gradient = ctx.createLinearGradient(0, 0, 0, 350);
            gradient.addColorStop(0, 'rgba(0, 112, 243, 0.15)');
            gradient.addColorStop(1, 'rgba(0, 112, 243, 0.00)');

            let datasetConfig = {
                label: 'Registros Procesados',
                data: data,
                borderWidth: 2.5,
                tension: 0.35
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
                datasetConfig.backgroundColor = 'rgba(0, 112, 243, 0.85)';
                datasetConfig.borderRadius = 6;
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
                            labels: { boxWidth: 10, padding: 15, font: { size: 11, family: 'Inter' } }
                        }
                    },
                    scales: (type === 'pie' || type === 'doughnut') ? {} : {
                        y: { grid: { color: '#f1f5f9' }, border: { dash: [4, 4] }, ticks: { font: { size: 11, family: 'Inter' }, color: '#64748b' } },
                        x: { grid: { display: false }, ticks: { font: { size: 11, family: 'Inter' }, color: '#64748b' } }
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
                    plugins: { legend: { display: true, position: 'bottom', labels: { boxWidth: 8, padding: 10, font: { size: 10, family: 'Inter' }, color: '#64748b' } } },
                    cutout: '70%'
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
    .shadow-xs { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04); }
    .btn-white { background-color: #fff; color: #475569; }
    .hover-bg-light:hover { background-color: #f8fafc !important; }
    .toggle-icon { transition: transform 0.2s ease; }
    
    .design-scroll::-webkit-scrollbar { height: 5px; width: 5px; }
    .design-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

    /* Estilos Línea de Tiempo Superior */
    .timeline-modern { display: flex; justify-content: space-between; gap: 18px; overflow-x: auto; padding-bottom: 10px; }
    .timeline-modern-item { min-width: 95px; position: relative; text-align: center; flex: 1; }
    .timeline-modern-line { position: absolute; top: 18px; left: 50%; width: 100%; height: 2px; background: #e2e8f0; z-index: 1; }
    .timeline-modern-item:last-child .timeline-modern-line { display: none; }
    .timeline-modern-dot { width: 14px; height: 14px; background: var(--sn-blue); border-radius: 50%; margin: auto; position: relative; z-index: 2; border: 3px solid #fff; box-shadow: 0 0 0 2px rgba(0, 112, 243, 0.15); }
    .timeline-modern-content { margin-top: 12px; }
    .timeline-modern-month { display: block; font-size: .7rem; text-transform: uppercase; color: #64748b; font-weight: 700; margin-bottom: 4px; }
    .timeline-modern-total { font-size: 1.25rem; font-weight: 700; color: #0f172a; }

    /* Estilos Filas Operadores */
    .operator-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; border-radius: 12px; transition: .2s; }
    .operator-row:hover { background: #f8fafc; }
    .operator-avatar { width: 36px; height: 36px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #475569; }
    .operator-badge { background: #e6f0ff; color: var(--sn-blue); padding: 5px 10px; border-radius: 8px; font-weight: 700; font-size: .8rem; }

    /* Personalización Acordeón Flujo Limpio */
    .accordion-button:not(.collapsed) { background-color: #f8fafc; color: var(--sn-blue); box-shadow: none; }
    .accordion-button::after { background-size: 0.85rem; }
    .accordion-button:focus { box-shadow: none; border-color: transparent; }
</style>
@endpush

@endsection