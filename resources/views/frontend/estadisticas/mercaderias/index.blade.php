@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Mercaderías')

@section('subtitulo', 'Control y estadísticas de mercadería')

@section('content')

<div class="container-fluid px-0 py-2">

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

    <div>
        <div class="stats-meta mb-1">
            Seguimiento estadístico y volumétrico de entregas
        </div>

        <h4 class="fw-bold tracking-tight text-dark m-0" style="font-size: 1.75rem;">
            Panel Estadístico de
            <span style="color: var(--sn-blue); font-weight: 400;">
                Mercaderías
            </span>
        </h4>
    </div>

    <div class="badge bg-light text-dark border border-light-subtle px-3 py-2 fw-semibold rounded-3 shadow-xs d-flex align-items-center gap-2">
        <i class="bi bi-calendar3 text-primary"></i>
        {{ now()->format('d/m/Y') }}
    </div>

</div>

{{-- KPIs --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Total Entregas',
            'value' => $totalMercaderias,
            'icon' => 'bi bi-box-seam',
            'color' => 'primary'
        ])
    </div>

    <div class="col-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Entregas del Mes',
            'value' => $mercaderiasMes,
            'icon' => 'bi bi-calendar-check',
            'color' => 'success'
        ])
    </div>

    <div class="col-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Entregas Hoy',
            'value' => $mercaderiasHoy,
            'icon' => 'bi bi-clock-history',
            'color' => 'info'
        ])
    </div>

    <div class="col-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Núcleos Asistidos',
            'value' => $nucleosAsistidos,
            'icon' => 'bi bi-people',
            'color' => 'warning'
        ])
    </div>

</div>

<div class="row g-4">

    {{-- GRAFICO PRINCIPAL --}}
    <div class="col-xl-8">

        <div class="card border border-light-subtle shadow-xs rounded-4 h-100 bg-white">

            <div class="p-4 border-bottom">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>
                        <h5 class="fw-bold mb-1">
                            Línea de Tiempo de Entregas
                        </h5>

                        <small class="text-muted">
                            Evolución mensual de mercadería entregada
                        </small>
                    </div>

                </div>

            </div>

            <div class="p-4">

                <div style="height: 400px;">
                    <canvas id="timelineChart"></canvas>
                </div>

            </div>

        </div>

    </div>

    {{-- LATERAL --}}
    <div class="col-xl-4">

        <div class="d-flex flex-column gap-4">

            {{-- GRAFICO USUARIOS --}}
            <div class="card border border-light-subtle shadow-xs rounded-4 bg-white">

                <div class="p-4 border-bottom">

                    <h6 class="fw-bold mb-1">
                        Entregas por Usuario
                    </h6>

                    <small class="text-muted">
                        Operadores con mayor actividad
                    </small>

                </div>

                <div class="p-4">

                    <div style="height: 260px;">
                        <canvas id="usuariosChart"></canvas>
                    </div>

                </div>

            </div>

            {{-- ÚLTIMAS ENTREGAS --}}
            <div class="accordion accordion-flush" id="accordionMercaderias">

                <div class="accordion-item border border-light-subtle shadow-xs rounded-4 overflow-hidden">

                    <h2 class="accordion-header">

                        <button
                            class="accordion-button collapsed bg-white fw-semibold small"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseMercaderias"
                        >

                            <div>
                                <div class="fw-bold text-dark">
                                    Últimas Entregas
                                </div>

                                <small class="text-muted fw-normal">
                                    Registros recientes
                                </small>
                            </div>

                        </button>

                    </h2>

                    <div
                        id="collapseMercaderias"
                        class="accordion-collapse collapse"
                    >

                        <div
                            class="accordion-body p-3 design-scroll"
                            style="max-height: 320px; overflow-y: auto;"
                        >

                            @foreach($ultimasMercaderias as $item)

                                <div class="ranking-row">

                                    <div class="d-flex align-items-center gap-3">

                                        <div class="ranking-icon">
                                            <i class="bi bi-box"></i>
                                        </div>

                                        <div>

                                            <div class="fw-semibold small text-dark">
                                                {{ $item->apellido }} {{ $item->nombre }}
                                            </div>

                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($item->fecha_entrega)->format('d/m/Y') }}
                                            </small>

                                        </div>

                                    </div>

                                    <span class="ranking-badge">
                                        {{ $item->usuario->username ?? 'Sistema' }}
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

    const mensualLabels = @json($mensuales->pluck('periodo'));
    const mensualData   = @json($mensuales->pluck('total'));

    const usuariosLabels = @json($usuarios->pluck('username'));
    const usuariosData   = @json($usuarios->pluck('total'));

    const colors = [
        '#0070f3',
        '#10b981',
        '#f59e0b',
        '#6366f1',
        '#ec4899',
        '#06b6d4'
    ];

    /*
    |--------------------------------------------------------------------------
    | TIMELINE
    |--------------------------------------------------------------------------
    */

    new Chart(document.getElementById('timelineChart'), {

        type: 'line',

        data: {
            labels: mensualLabels,
            datasets: [{
                label: 'Entregas',
                data: mensualData,
                borderColor: '#0070f3',
                backgroundColor: 'rgba(0,112,243,.12)',
                fill: true,
                tension: .4,
                pointRadius: 4
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false
        }

    });

    /*
    |--------------------------------------------------------------------------
    | USUARIOS
    |--------------------------------------------------------------------------
    */

    new Chart(document.getElementById('usuariosChart'), {

        type: 'doughnut',

        data: {
            labels: usuariosLabels,
            datasets: [{
                data: usuariosData,
                backgroundColor: colors
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%'
        }

    });

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

</style>

@endpush

@endsection
