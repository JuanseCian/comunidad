@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Colchones y Frazadas')
@section('subtitulo', 'Estadísticas de entregas de abrigo')
@section('is_ingresos_mercaderia', true)

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <div class="stats-meta mb-1">Seguimiento estadístico de asistencia</div>
            <h4 class="fw-bold tracking-tight text-dark m-0" style="font-size: 1.75rem;">Panel de <span style="color: var(--sn-blue); font-weight: 400;">Abrigo</span></h4>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('estadisticas.abrigo.excel') }}" class="btn btn-success rounded-3"><i class="bi bi-file-earmark-excel me-1"></i> Excel</a>
            <button onclick="window.print()" class="btn btn-primary rounded-3"><i class="bi bi-printer me-1"></i> Imprimir</button>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small text-muted fw-bold">Desde</label>
                    <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-muted fw-bold">Hasta</label>
                    <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="form-control">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button class="btn btn-primary flex-grow-1"><i class="bi bi-funnel me-1"></i> Filtrar</button>
                    <a href="{{ route('estadisticas.abrigo.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @foreach([
            ['title' => 'Entregas', 'value' => $totalEntregas, 'icon' => 'bi-box-seam', 'color' => 'primary'],
            ['title' => 'Colchones', 'value' => $totalColchones, 'icon' => 'bi-house-heart', 'color' => 'info'],
            ['title' => 'Frazadas', 'value' => $totalFrazadas, 'icon' => 'bi-grid-3x3-gap', 'color' => 'warning'],
            ['title' => 'Familias asistidas', 'value' => $familiasAsistidas, 'icon' => 'bi-people', 'color' => 'success'],
        ] as $kpi)
            <div class="col-6 col-xl-3">
                @include('frontend.estadisticas.partials.card', $kpi)
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card border border-light-subtle shadow-xs rounded-4 bg-white h-100">
                <div class="p-4 border-bottom">
                    <h5 class="fw-bold mb-1">Evolución mensual</h5>
                    <small class="text-muted">Unidades de abrigo entregadas por mes</small>
                </div>
                <div class="p-4"><div style="height: 360px;"><canvas id="abrigoMensualChart"></canvas></div></div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card border border-light-subtle shadow-xs rounded-4 bg-white h-100">
                <div class="p-4 border-bottom">
                    <h5 class="fw-bold mb-1">Distribución por producto</h5>
                    <small class="text-muted">Total de unidades registradas</small>
                </div>
                <div class="p-4"><div style="height: 300px;"><canvas id="abrigoProductoChart"></canvas></div></div>
                <div class="px-4 pb-4 small text-muted">Entregas registradas hoy: <strong>{{ $entregasHoy }}</strong></div>
            </div>
        </div>
        <div class="col-12">
            <div class="card border border-light-subtle shadow-xs rounded-4 bg-white">
                <div class="p-4 border-bottom"><h5 class="fw-bold mb-0">Últimas entregas</h5></div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light"><tr><th class="ps-4">Persona</th><th>Colchones</th><th>Frazadas</th><th>Fecha</th><th class="pe-4">Registrado por</th></tr></thead>
                        <tbody>
                            @forelse($ultimasEntregas as $entrega)
                                <tr>
                                    <td class="ps-4">{{ $entrega->apellido }}, {{ $entrega->nombre }}</td>
                                    <td>{{ $entrega->colchones }}</td>
                                    <td>{{ $entrega->frazadas }}</td>
                                    <td>{{ $entrega->fecha_entrega->format('d/m/Y') }}</td>
                                    <td class="pe-4">{{ $entrega->usuario->username ?? 'Sistema' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">No hay datos para el período seleccionado.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const labels = @json($mensuales->pluck('periodo')->values());
    const colchones = @json($mensuales->pluck('colchones')->values());
    const frazadas = @json($mensuales->pluck('frazadas')->values());

    new Chart(document.getElementById('abrigoMensualChart'), {
        type: 'line',
        data: { labels, datasets: [
            { label: 'Colchones', data: colchones, borderColor: '#0d92c2', backgroundColor: 'rgba(13,146,194,.12)', fill: true, tension: .35 },
            { label: 'Frazadas', data: frazadas, borderColor: '#f59e0b', backgroundColor: 'rgba(245,158,11,.10)', fill: true, tension: .35 }
        ]},
        options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('abrigoProductoChart'), {
        type: 'doughnut',
        data: { labels: ['Colchones', 'Frazadas'], datasets: [{ data: [{{ $totalColchones }}, {{ $totalFrazadas }}], backgroundColor: ['#0d92c2', '#f59e0b'] }] },
        options: { responsive: true, maintainAspectRatio: false, cutout: '68%' }
    });
});
</script>
@endsection
