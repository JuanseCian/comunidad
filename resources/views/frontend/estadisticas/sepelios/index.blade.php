@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Sepelios')
@section('subtitulo', 'Estadísticas de servicios funerarios')

@section('content')

<div class="container-fluid px-0">

{{-- FILTROS --}}
<div class="card border-0 shadow-sm mb-4"
     style="border-radius:16px;background:rgba(var(--bs-body-bg-rgb),0.7);backdrop-filter:blur(10px);">
    <div class="card-body p-4">

        <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-end">

            <div class="col-md-3">
                <label class="form-label small text-muted fw-bold">
                    Categoría
                </label>

                <select name="categoria" class="form-select">
                    <option value="">Todas</option>
                    <option value="angelito" {{ request('categoria')=='angelito' ? 'selected' : '' }}>Angelito</option>
                    <option value="normal" {{ request('categoria')=='normal' ? 'selected' : '' }}>Normal</option>
                    <option value="vaca" {{ request('categoria')=='vaca' ? 'selected' : '' }}>Vaca</option>
                    <option value="extra_vaca" {{ request('categoria')=='extra_vaca' ? 'selected' : '' }}>Extra Vaca</option>
                    <option value="cremacion" {{ request('categoria')=='cremacion' ? 'selected' : '' }}>Cremación</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small text-muted fw-bold">
                    Tipo de Sepelio
                </label>

                <select name="tipo" class="form-select">
                    <option value="">Todos</option>
                    <option value="municipal" {{ request('tipo')=='municipal' ? 'selected' : '' }}>Municipal</option>
                    <option value="particular" {{ request('tipo')=='particular' ? 'selected' : '' }}>Particular</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label small text-muted fw-bold">
                    Desde
                </label>

                <input type="date"
                       name="fecha_desde"
                       value="{{ request('fecha_desde') }}"
                       class="form-control">
            </div>

            <div class="col-md-2">
                <label class="form-label small text-muted fw-bold">
                    Hasta
                </label>

                <input type="date"
                       name="fecha_hasta"
                       value="{{ request('fecha_hasta') }}"
                       class="form-control">
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-primary w-100">
                    <i class="bi bi-search"></i>
                    Filtrar
                </button>

                <a href="{{ url()->current() }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>

        </form>

    </div>
</div>

{{-- MÉTRICAS --}}
<div class="row g-4 mb-4">

    <div class="col-lg-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">

                <div class="badge p-3 me-3"
                     style="background:rgba(78,115,223,.15);color:#4e73df;">
                    <i class="bi bi-heartbreak fs-4"></i>
                </div>

                <div>
                    <small class="text-muted d-block">
                        Total Sepelios
                    </small>

                    <h3 class="mb-0 fw-bold">
                        {{ number_format($totalSepelios,0,',','.') }}
                    </h3>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">

                <div class="badge p-3 me-3"
                     style="background:rgba(28,200,138,.15);color:#1cc88a;">
                    <i class="bi bi-award fs-4"></i>
                </div>

                <div>
                    <small class="text-muted d-block">
                        Categoría Principal
                    </small>

                    <h5 class="mb-0 fw-bold">
                        {{ $categoriaMasUsada }}
                    </h5>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">

                <div class="badge p-3 me-3"
                     style="background:rgba(246,194,62,.15);color:#f6c23e;">
                    <i class="bi bi-geo-alt fs-4"></i>
                </div>

                <div>
                    <small class="text-muted d-block">
                        Barrio Destacado
                    </small>

                    <h5 class="mb-0 fw-bold">
                        {{ $barrioDestacado }}
                    </h5>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">

                <div class="badge p-3 me-3"
                     style="background:rgba(231,74,59,.15);color:#e74a3b;">
                    <i class="bi bi-currency-dollar fs-4"></i>
                </div>

                <div>
                    <small class="text-muted d-block">
                        Costo Total
                    </small>

                    <h5 class="mb-0 fw-bold">
                        $ {{ number_format($costoTotal,0,',','.') }}
                    </h5>
                </div>

            </div>
        </div>
    </div>

</div>

{{-- GRÁFICOS --}}
<div class="row g-4">

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="fw-bold mb-0">
                    Sepelios por Categoría
                </h5>
            </div>

            <div class="card-body">
                <div style="height:350px;">
                    <canvas id="categoriasChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="fw-bold mb-0">
                    Distribución por Barrio
                </h5>
            </div>

            <div class="card-body">
                <div style="height:350px;">
                    <canvas id="barriosChart"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>
```

</div>

<script>

document.addEventListener('DOMContentLoaded', function() {

    const premiumColors = [
        '#4e73df',
        '#1cc88a',
        '#36b9cc',
        '#f6c23e',
        '#e74a3b',
        '#6f42c1',
        '#fd7e14'
    ];

    new Chart(document.getElementById('categoriasChart'), {

        type: 'bar',

        data: {
            labels: {!! json_encode($categorias->pluck('nombre')) !!},
            datasets: [{
                data: {!! json_encode($categorias->pluck('total')) !!},
                backgroundColor: '#4e73df',
                borderRadius: 8
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display:false
                }
            }
        }

    });

    new Chart(document.getElementById('barriosChart'), {

        type: 'doughnut',

        data: {
            labels: {!! json_encode($barrios->pluck('barrio')) !!},
            datasets: [{
                data: {!! json_encode($barrios->pluck('total')) !!},
                backgroundColor: premiumColors
            }]
        },

        options: {
            responsive:true,
            maintainAspectRatio:false
        }

    });

});

</script>

@endsection
