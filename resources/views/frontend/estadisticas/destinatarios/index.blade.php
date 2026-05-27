@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Destinatarios')

@section('subtitulo', 'Análisis social y territorial')

@section('content')

<div class="container-fluid px-0 py-2">

    {{-- =========================
        HEADER
    ========================== --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <div class="stats-meta mb-1">
                Visualización demográfica y territorial de destinatarios
            </div>

            <h4 class="fw-bold tracking-tight text-dark m-0" style="font-size: 1.75rem;">
                Panel Estadístico de
                <span style="color: var(--sn-blue); font-weight: 400;">
                    Destinatarios
                </span>
            </h4>
        </div>

        <div class="badge bg-light text-dark border border-light-subtle px-3 py-2 fw-semibold rounded-3 shadow-xs d-flex align-items-center gap-2">
            <i class="bi bi-calendar3 text-primary"></i>
            {{ now()->format('d/m/Y') }}
        </div>

    </div>

    {{-- =========================
        KPIs
    ========================== --}}
    <div class="row g-3 mb-4">

        <div class="col-6 col-xl-3">
            @include('frontend.estadisticas.partials.card', [
                'title' => 'Total Destinatarios',
                'value' => $totalDestinatarios,
                'icon' => 'bi bi-people',
                'color' => 'primary'
            ])
        </div>

        <div class="col-6 col-xl-3">
            @include('frontend.estadisticas.partials.card', [
                'title' => 'Nuevos este Mes',
                'value' => $nuevosMes,
                'icon' => 'bi bi-person-plus',
                'color' => 'success'
            ])
        </div>

        <div class="col-6 col-xl-3">
            @include('frontend.estadisticas.partials.card', [
                'title' => 'Barrios Registrados',
                'value' => $barrios->count(),
                'icon' => 'bi bi-geo-alt',
                'color' => 'warning'
            ])
        </div>

        <div class="col-6 col-xl-3">
            @include('frontend.estadisticas.partials.card', [
                'title' => 'Coberturas Sociales',
                'value' => $coberturas->count(),
                'icon' => 'bi bi-shield-check',
                'color' => 'info'
            ])
        </div>

    </div>

    {{-- =========================
        CONTENIDO PRINCIPAL
    ========================== --}}
    <div class="row g-4">

        {{-- GRÁFICO PRINCIPAL --}}
        <div class="col-xl-8">

            <div class="card border border-light-subtle shadow-xs rounded-4 h-100">

                <div class="p-4 border-bottom">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <div>
                            <h5 class="fw-bold mb-1">
                                Visualización Estadística
                            </h5>

                            <small class="text-muted">
                                Distribución territorial y social
                            </small>
                        </div>

                        <select id="chartType"
                                class="form-select form-select-sm rounded-3 bg-light border-0 small fw-medium text-secondary"
                                style="width: 180px;">

                            <option value="bar">
                                Barrios
                            </option>

                            <option value="pie">
                                Zonas
                            </option>

                        </select>

                    </div>

                </div>

                <div class="p-4">
                    <div style="height: 420px;">
                        <canvas id="mainChart"></canvas>
                    </div>
                </div>

            </div>

        </div>

        {{-- LATERAL --}}
        <div class="col-xl-4">

            <div class="d-flex flex-column gap-4">

                {{-- GENEROS --}}
                <div class="card border border-light-subtle shadow-xs rounded-4">

                    <div class="p-4 border-bottom">
                        <h6 class="fw-bold mb-1">
                            Distribución por Género
                        </h6>

                        <small class="text-muted">
                            Composición demográfica
                        </small>
                    </div>

                    <div class="p-4">
                        <div style="height: 250px;">
                            <canvas id="generosChart"></canvas>
                        </div>
                    </div>

                </div>

                {{-- TOP BARRIOS ACORDEÓN --}}
                <div class="accordion accordion-flush" id="accordionBarrios">
                    <div class="accordion-item border border-light-subtle shadow-xs rounded-4 overflow-hidden">
                        <h2 class="accordion-header">
                            <button
                                class="accordion-button collapsed bg-white fw-semibold small"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseBarrios"
                                aria-expanded="false"
                                aria-controls="collapseBarrios"
                            >

                                <div>
                                    <div class="fw-bold text-dark">
                                        Barrios con Mayor Registro
                                    </div>

                                    <small class="text-muted fw-normal">
                                        Concentración territorial
                                    </small>
                                </div>
                            </button>
                        </h2>
                        <div
                            id="collapseBarrios"
                            class="accordion-collapse collapse"
                            data-bs-parent="#accordionBarrios"
                        >
                            <div
                                class="accordion-body p-3 design-scroll"
                                style="max-height: 320px; overflow-y: auto;"
                            >
                                @foreach($barrios->take(10) as $item)
                                    <div class="ranking-row">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="ranking-icon">
                                                <i class="bi bi-geo-alt"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold small text-dark">
                                                    {{ $item->nombre }}
                                                </div>
                                                <small class="text-muted">
                                                    Barrio registrado
                                                </small>
                                            </div>
                                        </div>
                                        <span class="ranking-badge">
                                            {{ $item->total }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const barriosLabels = @json($barrios->pluck('nombre'));
    const barriosData   = @json($barrios->pluck('total'));

    const zonasLabels = @json($zonas->pluck('nombre'));
    const zonasData   = @json($zonas->pluck('total'));

    const generosLabels = @json($generos->pluck('nombre'));
    const generosData   = @json($generos->pluck('total'));

    const ctx = document.getElementById('mainChart').getContext('2d');
    const generoCtx = document.getElementById('generosChart').getContext('2d');

    const selector = document.getElementById('chartType');

    let currentChart;

    const colors = [
        '#0070f3',
        '#10b981',
        '#f59e0b',
        '#6366f1',
        '#ec4899',
        '#06b6d4',
        '#8b5cf6',
        '#ef4444'
    ];

    function renderChart() {

        if(currentChart){
            currentChart.destroy();
        }

        let labels = [];
        let data = [];
        let type = 'bar';

        if(selector.value === 'bar'){
            labels = barriosLabels;
            data = barriosData;
            type = 'bar';
        } else {
            labels = zonasLabels;
            data = zonasData;
            type = 'pie';
        }

        currentChart = new Chart(ctx, {

            type: type,

            data: {
                labels: labels,
                datasets: [{
                    label: 'Registros',
                    data: data,
                    backgroundColor: colors,
                    borderRadius: 8
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }

        });

    }

    new Chart(generoCtx, {

        type: 'doughnut',

        data: {
            labels: generosLabels,
            datasets: [{
                data: generosData,
                backgroundColor: colors
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%'
        }

    });

    renderChart();

    selector.addEventListener('change', renderChart);

});

</script>

@push('styles')

<style>

.tracking-tight {
    letter-spacing: -0.02em;
}

.shadow-xs {
    box-shadow: 0 1px 2px rgba(0,0,0,.04);
}

.summary-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.summary-text {
    color: #475569;
    line-height: 1.7;
    font-size: .92rem;
}

.design-scroll::-webkit-scrollbar {
    width: 5px;
}

.design-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 20px;
}

.ranking-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    border-radius: 14px;
    transition: .2s;
}

.ranking-row:hover {
    background: #f8fafc;
}

.ranking-icon {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: #eff6ff;
    color: #0070f3;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ranking-badge {
    background: #e0f2fe;
    color: #0369a1;
    padding: 6px 12px;
    border-radius: 10px;
    font-size: .8rem;
    font-weight: 700;
}

.accordion-button:not(.collapsed) {
    background-color: #f8fafc;
    color: var(--sn-blue);
    box-shadow: none;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: transparent;
}

.accordion-button::after {
    background-size: .85rem;
}

</style>

@endpush

@endsection