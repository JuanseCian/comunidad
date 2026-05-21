<div class="card stats-card p-4 border-0 shadow-sm h-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0 text-dark text-opacity-85 fs-6">
            {{ $title }}
        </h5>
        
        <div class="dropdown">
            <button class="btn btn-link text-muted p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-light">
                <li><a class="dropdown-menu-item small py-2 px-3 text-secondary text-decoration-none d-block" href="#" onclick="window.print(); return false;"><i class="bi bi-download me-2"></i>Exportar reporte</a></li>
            </ul>
        </div>
    </div>

    <div class="chart-container position-relative" style="height: 300px; width: 100%;">
        <canvas id="{{ $chartId }}"></canvas>
    </div>
</div>