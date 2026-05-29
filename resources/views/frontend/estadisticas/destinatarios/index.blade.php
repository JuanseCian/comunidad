@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Destinatarios')

@section('subtitulo', 'Análisis social y territorial')

@section('content')

<div class="container-fluid px-0 py-2">

    {{-- =========================
    ENCABEZADO Y FILTROS INTEGRADOS
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

    <div class="d-flex align-items-center gap-2">

        {{-- BOTÓN FILTROS --}}
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

            <span class="fw-medium text-secondary small">
                Filtrar Datos
            </span>

            <i class="bi bi-chevron-down small text-muted toggle-icon"></i>
        </button>

        {{-- FECHA --}}
        <div class="badge bg-light text-dark border border-light-subtle px-3 py-2 fw-semibold rounded-3 shadow-xs d-flex align-items-center gap-2"
            style="min-height: 40px; font-size: 0.85rem;">

            <i class="bi bi-calendar3 text-primary"></i>

            {{ now()->format('d/m/Y') }}
        </div>

        </div>

    </div>

    {{-- =========================
    FILTROS COLAPSABLES
    ========================== --}}

    <div class="collapse mb-4" id="collapseFilters">

    <div class="card border border-light-subtle shadow-sm rounded-4 overflow-hidden">

        <div class="card-body p-4 bg-light-subtle">

            <form method="GET">

                <div class="row g-3">

                    {{-- AÑO --}}
                    <div class="col-md-2">

                        <label class="form-label small fw-semibold text-muted">
                            Año
                        </label>

                        <select name="anio"
                                class="form-select rounded-3 small"
                                onchange="this.form.submit()">

                            @for($i = now()->year; $i >= 2024; $i--)
                                <option value="{{ $i }}"
                                    {{ request('anio', now()->year) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor

                        </select>

                    </div>

                    {{-- MES --}}
                    <div class="col-md-2">

                        <label class="form-label small fw-semibold text-muted">
                            Mes
                        </label>

                        <select name="mes"
                                class="form-select rounded-3 small"
                                onchange="this.form.submit()">

                            <option value="">
                                Todos
                            </option>

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
                            ] as $num => $mes)

                                <option value="{{ $num }}"
                                    {{ request('mes') == $num ? 'selected' : '' }}>
                                    {{ $mes }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- BARRIO --}}
                    <div class="col-md-2">

                        <label class="form-label small fw-semibold text-muted">
                            Barrio
                        </label>

                        <select name="barrio"
                                class="form-select rounded-3 small"
                                onchange="this.form.submit()">

                            <option value="">
                                Todos
                            </option>

                            @foreach($barrios as $barrio)

                                <option value="{{ $barrio->id }}"
                                    {{ request('barrio') == $barrio->id ? 'selected' : '' }}>

                                    {{ $barrio->nombre }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- ZONA --}}
                    <div class="col-md-2">

                        <label class="form-label small fw-semibold text-muted">
                            Zona
                        </label>

                        <select name="zona"
                                class="form-select rounded-3 small"
                                onchange="this.form.submit()">

                            <option value="">
                                Todas
                            </option>

                            @foreach($zonas as $zona)

                                <option value="{{ $zona->id }}"
                                    {{ request('zona') == $zona->id ? 'selected' : '' }}>

                                    {{ $zona->nombre }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- GENERO --}}
                    <div class="col-md-2">

                        <label class="form-label small fw-semibold text-muted">
                            Género
                        </label>

                        <select name="genero"
                                class="form-select rounded-3 small"
                                onchange="this.form.submit()">

                            <option value="">
                                Todos
                            </option>

                            @foreach($generos as $genero)

                                <option value="{{ $genero->id }}"
                                    {{ request('genero') == $genero->id ? 'selected' : '' }}>

                                    {{ $genero->nombre }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- RESETEAR --}}
                    <div class="col-md-2 d-flex align-items-end">

                        <a href="{{ route('estadisticas.destinatarios') }}"
                        class="btn btn-white border rounded-3 w-100 fw-medium small d-flex align-items-center justify-content-center gap-2"
                        style="min-height: 38px;">

                            <i class="bi bi-arrow-counterclockwise"></i>

                            Reiniciar

                        </a>

                    </div>

                </div>

            </form>

        </div>

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


const collapsable = document.getElementById('collapseFilters');
const icon = document.querySelector('.toggle-icon');

if(collapsable){

collapsable.addEventListener('show.bs.collapse', () => {
    icon.style.transform = 'rotate(180deg)';
});

collapsable.addEventListener('hide.bs.collapse', () => {
    icon.style.transform = 'rotate(0deg)';
});

}


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

.btn-white {
background-color: #fff;
color: #475569;
}

.toggle-icon {
transition: transform .2s ease;
}

</style>

@endpush

@endsection