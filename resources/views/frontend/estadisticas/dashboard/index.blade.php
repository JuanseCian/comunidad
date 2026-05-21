@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Dashboard General')

@section('subtitulo', 'Resumen general del sistema Comunidad')

@section('content')

@include('frontend.estadisticas.partials.navbar')

<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Personas',
            'value' => number_format($totalPersonas, 0, ',', '.'),
            'icon' => 'bi bi-people'
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Ingresos',
            'value' => number_format($totalIngresos, 0, ',', '.'),
            'icon' => 'bi bi-box-arrow-in-right'
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Familias',
            'value' => number_format($totalFamilias, 0, ',', '.'),
            'icon' => 'bi bi-houses'
        ])
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        @include('frontend.estadisticas.partials.card', [
            'title' => 'Atenciones',
            'value' => number_format($totalAtenciones, 0, ',', '.'),
            'icon' => 'bi bi-heart-pulse'
        ])
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-lg-8">
        @include('frontend.estadisticas.partials.chart', [
            'title' => 'Tendencia de Ingresos Mensuales',
            'chartId' => 'ingresosChart'
        ])
    </div>

    <div class="col-12 col-lg-4">
        <div class="card stats-card p-4 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0 text-dark text-opacity-85 fs-6">
                    Barrios Más Activos
                </h5>
                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-15 px-2 py-1 small">
                    Top Zonas
                </span>
            </div>

            <div class="d-flex flex-column gap-3">
                @php 
                    // Obtenemos el valor máximo para calcular los porcentajes visuales de las barras
                    $maxIngresos = $barriosActivos->max('total_ingresos') ?? 1;
                @endphp

                @foreach($barriosActivos as $barrio)
                    @php 
                        $porcentaje = ($barrio->total_ingresos / $maxIngresos) * 100;
                    @endphp
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-secondary fw-medium small">
                                <i class="bi bi-geo-alt text-muted me-1"></i>{{ $barrio->barrio }}
                            </span>
                            <span class="badge bg-primary-subtle text-primary fw-bold rounded-pill">
                                {{ number_format($barrio->total_ingresos, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="progress" style="height: 6px; background-color: #f1f5f9;">
                            <div class="progress-bar bg-primary rounded-pill" 
                                 role="progressbar" 
                                 style="width: {{ $porcentaje }}%; transition: width 1s ease-in-out;" 
                                 aria-valuenow="{{ $porcentaje }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('ingresosChart').getContext('2d');
    
    // Creamos un degradado suave bajo la línea del gráfico para darle profundidad
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.25)');
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0.00)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                @foreach($ingresosMensuales as $item)
                    '{{ $item->periodo }}',
                @endforeach
            ],
            datasets: [{
                label: 'Ingresos Registrados',
                data: [
                    @foreach($ingresosMensuales as $item)
                        {{ $item->total }},
                    @endforeach
                ],
                borderColor: '#2563eb',          // Azul nítido de la paleta
                borderWidth: 3,
                backgroundColor: gradient,        // Fondo degradado aplicado
                fill: true,
                tension: 0.38,                    // Curvatura elegante y limpia
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Ocultamos la leyenda para un look más limpio y minimalista
                },
                tooltip: {
                    padding: 12,
                    displayColors: false,
                    backgroundColor: '#0f172a',
                    titleFont: { family: 'Inter', size: 13, weight: 'bold' },
                    bodyFont: { family: 'Inter', size: 13 },
                    borderRadius: 8
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false // Oculta líneas verticales pesadas
                    },
                    ticks: {
                        color: '#64748b',
                        font: { family: 'Inter', size: 12 }
                    }
                },
                y: {
                    grid: {
                        color: '#f1f5f9' // Líneas horizontales muy tenues
                    },
                    ticks: {
                        color: '#64748b',
                        font: { family: 'Inter', size: 12 },
                        precision: 0
                    },
                    border: {
                        dash: [5, 5] // Línea de eje punteada moderna
                    }
                }
            }
        }
    });
});
</script>

@endsection