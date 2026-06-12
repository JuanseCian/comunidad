@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Intervenciones')

@section('subtitulo', 'Intervenciones y seguimientos')

@section('content')

<div class="container-fluid px-0 py-2">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <div class="stats-meta mb-1">
                Seguimiento de intervenciones sociales y operativas
            </div>

            <h4 class="fw-bold tracking-tight text-dark m-0"
                style="font-size:1.75rem;">

                Panel Estadístico de

                <span style="color: var(--sn-blue); font-weight:400;">
                    Intervenciones
                </span>

            </h4>
        </div>

        <div class="d-flex align-items-center gap-2">

            {{-- FILTROS --}}
            <button
                class="btn btn-white border border-light-subtle btn-sm d-flex align-items-center gap-2 px-3 py-2 shadow-xs rounded-3 transition-all"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseFilters"
            >

                <i class="bi bi-sliders2 text-secondary"></i>

                <span class="fw-medium text-secondary small">
                    Filtrar Datos
                </span>

                <i class="bi bi-chevron-down small text-muted toggle-icon"></i>

            </button>

            {{-- FECHA --}}
            <div
                class="badge bg-light text-dark border border-light-subtle px-3 py-2 fw-semibold rounded-3 shadow-xs d-flex align-items-center gap-2"
                style="min-height:40px; font-size:.85rem;"
            >

                <i class="bi bi-calendar3 text-primary"></i>
                {{ now()->format('d/m/Y') }}

            </div>

            <a href="{{ route('estadisticas.atenciones.excel', request()->query()) }}" class="btn btn-success btn-sm rounded-3 d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-excel"></i>
                Excel
            </a>

            <button onclick="window.print()" class="btn btn-primary btn-sm rounded-3 d-flex align-items-center gap-2">
                <i class="bi bi-printer"></i>
                Imprimir
            </button>

        </div>

    </div>

    {{-- =========================
        FILTROS
    ========================== --}}
    <div class="collapse mb-4" id="collapseFilters">

        <div class="card border border-light-subtle shadow-sm rounded-4 overflow-hidden">

            <div class="card-body p-4 bg-light-subtle">

                <form method="GET">

                    <div class="row g-3">

                        {{-- AÑO --}}
                        <div class="col-md-3">

                            <label class="form-label small fw-semibold text-muted">
                                Año
                            </label>

                            <select
                                name="anio"
                                class="form-select rounded-3 small"
                                onchange="this.form.submit()"
                            >

                                @for($i = now()->year; $i >= 2024; $i--)

                                    <option
                                        value="{{ $i }}"
                                        {{ request('anio', now()->year) == $i ? 'selected' : '' }}
                                    >
                                        {{ $i }}
                                    </option>

                                @endfor

                            </select>

                        </div>

                        {{-- MES --}}
                        <div class="col-md-3">

                            <label class="form-label small fw-semibold text-muted">
                                Mes
                            </label>

                            <select
                                name="mes"
                                class="form-select rounded-3 small"
                                onchange="this.form.submit()"
                            >

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
                                ] as $num => $mesNombre)

                                    <option
                                        value="{{ $num }}"
                                        {{ request('mes') == $num ? 'selected' : '' }}
                                    >
                                        {{ $mesNombre }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- TIPO --}}
                        <div class="col-md-3">

                            <label class="form-label small fw-semibold text-muted">
                                Tipo
                            </label>

                            <select
                                name="tipo"
                                class="form-select rounded-3 small"
                                onchange="this.form.submit()"
                            >

                                <option value="">
                                    Todos
                                </option>

                                <option value="entrevista">Entrevista</option>
                                <option value="visita_domiciliaria">Visita Domiciliaria</option>
                                <option value="llamado">Llamado</option>
                                <option value="seguimiento">Seguimiento</option>
                                <option value="derivacion">Derivación</option>
                                <option value="otro">Otro</option>

                            </select>

                        </div>

                        {{-- VISTA --}}
                        <div class="col-md-2">

                            <label class="form-label small fw-semibold text-muted">
                                Visualización
                            </label>

                            <select
                                name="vista"
                                class="form-select rounded-3 small"
                                onchange="this.form.submit()"
                            >

                                <option value="dia" {{ request('vista') == 'dia' ? 'selected' : '' }}>
                                    Día
                                </option>

                                <option value="semana" {{ request('vista') == 'semana' ? 'selected' : '' }}>
                                    Semana
                                </option>

                                <option value="mes" {{ request('vista', 'mes') == 'mes' ? 'selected' : '' }}>
                                    Mes
                                </option>

                                <option value="anio" {{ request('vista') == 'anio' ? 'selected' : '' }}>
                                    Año
                                </option>

                            </select>

                        </div>

                        {{-- RESET --}}
                        <div class="col-md-1 d-flex align-items-end">

                            <a
                                href="{{ route('estadisticas.atenciones') }}"
                                class="btn btn-white border rounded-3 w-100 fw-medium small"
                            >

                                <i class="bi bi-arrow-counterclockwise"></i>

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

        <div class="col-6 col-xl-4">

            @include('frontend.estadisticas.partials.card', [
                'title' => 'Total Atenciones',
                'value' => $totalAtenciones,
                'icon'  => 'bi bi-heart-pulse',
                'color' => 'primary'
            ])

        </div>

        <div class="col-6 col-xl-4">

            @include('frontend.estadisticas.partials.card', [
                'title' => 'Intervenciones del Mes',
                'value' => $atencionesMes,
                'icon'  => 'bi bi-calendar2-week',
                'color' => 'success'
            ])

        </div>

        <div class="col-6 col-xl-4">

            @include('frontend.estadisticas.partials.card', [
                'title' => 'Intervenciones Hoy',
                'value' => $atencionesHoy,
                'icon'  => 'bi bi-clock-history',
                'color' => 'warning'
            ])

        </div>

    </div>

    {{-- =========================
        CONTENIDO
    ========================== --}}
    <div class="row g-4">

        {{-- TIMELINE --}}
        <div class="col-xl-8">

            <div class="card border border-light-subtle shadow-xs rounded-4 h-100">

                <div class="p-4 border-bottom">

                    <div>
                        <h5 class="fw-bold mb-1">
                            Evolución Temporal
                        </h5>

                        <small class="text-muted">
                            Línea temporal de Intervenciones registradas
                        </small>
                    </div>

                </div>

                <div class="p-4">

                    <div style="height:420px;">

                        <canvas id="timelineChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

        {{-- LATERAL --}}
        <div class="col-xl-4">

            <div class="d-flex flex-column gap-4">

                {{-- TIPOS --}}
                <div class="card border border-light-subtle shadow-xs rounded-4">

                    <div class="p-4 border-bottom">

                        <h6 class="fw-bold mb-1">
                            Tipos de Intervención
                        </h6>

                        <small class="text-muted">
                            Distribución operativa
                        </small>

                    </div>

                    <div class="p-4">

                        <div style="height:250px;">

                            <canvas id="tiposChart"></canvas>

                        </div>

                    </div>

                </div>

                {{-- TOP USUARIOS --}}
                <div class="accordion accordion-flush">

                    <div class="accordion-item border border-light-subtle shadow-xs rounded-4 overflow-hidden">

                        <h2 class="accordion-header">

                            <button
                                class="accordion-button collapsed bg-white fw-semibold small"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseUsuarios"
                            >

                                <div>

                                    <div class="fw-bold text-dark">
                                        Operadores con Más Intervenciones
                                    </div>

                                    <small class="text-muted fw-normal">
                                        Productividad operativa
                                    </small>

                                </div>

                            </button>

                        </h2>

                        <div
                            id="collapseUsuarios"
                            class="accordion-collapse collapse"
                        >

                            <div
                                class="accordion-body p-3 design-scroll"
                                style="max-height:320px; overflow-y:auto;"
                            >

                                @foreach($usuarios as $usuario)

                                    <div class="ranking-row">

                                        <div class="d-flex align-items-center gap-3">

                                            <div class="ranking-icon">

                                                <i class="bi bi-person"></i>

                                            </div>

                                            <div>

                                                <div class="fw-semibold small text-dark">

                                                    {{ $usuario->users->nombre ?? 'Usuario' }}

                                                </div>

                                                <small class="text-muted">
                                                    Operador
                                                </small>

                                            </div>

                                        </div>

                                        <span class="ranking-badge">

                                            {{ $usuario->total }}

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
    <div class="card border border-light-subtle shadow-xs rounded-4 mt-4">

        <div class="p-4 border-bottom">

            <h5 class="fw-bold mb-1">
                Últimas Intervenciones
            </h5>

            <small class="text-muted">
                Actividad reciente del sistema
            </small>

        </div>

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Fecha</th>
                        <th>Persona</th>
                        <th>Tipo</th>
                        <th>Operador</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($ultimasAtenciones as $item)

                        <tr>

                            <td class="fw-medium">

                                {{ \Carbon\Carbon::parse($item->fecha_atencion)->format('d/m/Y') }}

                            </td>

                            <td>

                                {{ $item->persona->apellido ?? '' }},
                                {{ $item->persona->nombre ?? '' }}

                            </td>

                            <td>

                                <span class="badge bg-light text-dark border">

                                    {{ str_replace('_', ' ', ucfirst($item->tipo)) }}

                                </span>

                            </td>

                            <td>

                                {{ $item->users->nombre ?? 'Usuario' }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const timelineLabels = @json($timeline->pluck('periodo'));
    const timelineData   = @json($timeline->pluck('total'));

    const tiposLabels = @json($tiposMasUsados->pluck('tipo'));
    const tiposData   = @json($tiposMasUsados->pluck('total'));

    const colors = [
        '#0070f3',
        '#10b981',
        '#f59e0b',
        '#6366f1',
        '#ec4899',
        '#06b6d4'
    ];

    new Chart(
        document.getElementById('timelineChart'),
        {
            type: 'line',

            data: {
                labels: timelineLabels,

                datasets: [{
                    label: 'Intervenciones',
                    data: timelineData,
                    fill: true,
                    tension: .4
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    );

    new Chart(
        document.getElementById('tiposChart'),
        {
            type: 'doughnut',

            data: {
                labels: tiposLabels,

                datasets: [{
                    data: tiposData,
                    backgroundColor: colors
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%'
            }
        }
    );

});

</script>

@push('styles')

<style>

.tracking-tight {
    letter-spacing: -.02em;
}

.shadow-xs {
    box-shadow: 0 1px 2px rgba(0,0,0,.04);
}

.btn-white {
    background:#fff;
    color:#475569;
}

.design-scroll::-webkit-scrollbar {
    width:5px;
}

.design-scroll::-webkit-scrollbar-thumb {
    background:#cbd5e1;
    border-radius:20px;
}

.ranking-row {
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px;
    border-radius:14px;
    transition:.2s;
}

.ranking-row:hover {
    background:#f8fafc;
}

.ranking-icon {
    width:38px;
    height:38px;
    border-radius:12px;
    background:#eff6ff;
    color:#0070f3;
    display:flex;
    align-items:center;
    justify-content:center;
}

.ranking-badge {
    background:#e0f2fe;
    color:#0369a1;
    padding:6px 12px;
    border-radius:10px;
    font-size:.8rem;
    font-weight:700;
}

.accordion-button:not(.collapsed) {
    background-color:#f8fafc;
    color:var(--sn-blue);
    box-shadow:none;
}

.accordion-button:focus {
    box-shadow:none;
    border-color:transparent;
}

.toggle-icon {
    transition:transform .2s ease;
}

</style>

@endpush

@endsection