@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Beneficios')

@section('subtitulo', 'Programas y beneficios sociales')

@section('content')

@include('frontend.estadisticas.partials.navbar')

<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="badge bg-primary-soft text-primary p-3 me-3">
                    <i class="bi bi-gift fs-4"></i>
                </div>
                <div>
                    <h6 class="mb-1 text-muted">Total Beneficios Entregados</h6>
                    <h3 class="mb-0 fw-bold">{{ number_format($totalBeneficios, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="badge bg-success-soft text-success p-3 me-3">
                    <i class="bi bi-geo-alt fs-4"></i>
                </div>
                <div>
                    <h6 class="mb-1 text-muted">Barrio Mayor Impacto</h6>
                    <h3 class="mb-0 fw-bold">{{ $barrioDestacado }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        @include('frontend.estadisticas.partials.chart', [
            'title' => 'Beneficios Más Utilizados',
            'chartId' => 'beneficiosChart'
        ])
    </div>

    <div class="col-lg-4">
        @include('frontend.estadisticas.partials.chart', [
            'title' => 'Distribución Territorial (Barrios)',
            'chartId' => 'barriosChart'
        ])
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Paleta de colores persistente para los gráficos
    const colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#5a5c69', '#fd7e14', '#6f42c1'];

    // 1. Configuración Gráfico de Barras (Beneficios)
    const ctxBeneficios = document.getElementById('beneficiosChart');
    if (ctxBeneficios) {
        new Chart(ctxBeneficios, {
            type: 'bar',
            data: {
                labels: {!! json_encode($beneficios->pluck('nombre')) !!},
                datasets: [{
                    label: 'Cantidad',
                    data: {!! json_encode($beneficios->pluck('total')) !!},
                    backgroundColor: '#4e73df',
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // 2. Configuración Gráfico de Dona (Barrios)
    const ctxBarrios = document.getElementById('barriosChart');
    if (ctxBarrios) {
        new Chart(ctxBarrios, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($barrios->pluck('barrio')) !!},
                datasets: [{
                    data: {!! json_encode($barrios->pluck('total')) !!},
                    backgroundColor: colors,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12 }
                    }
                }
            }
        });
    }
});
</script>

@endsection