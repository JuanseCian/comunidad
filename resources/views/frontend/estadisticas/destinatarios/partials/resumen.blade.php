<div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">

            <div class="card-body">

                <small class="text-muted">
                    Participantes
                </small>

                <h2 class="fw-bold mb-0">
                    {{ number_format($totalParticipantes) }}
                </h2>

            </div>

        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">

            <div class="card-body">

                <small class="text-muted">
                    Activos
                </small>

                <h2 class="fw-bold text-success mb-0">
                    {{ number_format($activos) }}
                </h2>

            </div>

        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">

            <div class="card-body">

                <small class="text-muted">
                    Finalizados
                </small>

                <h2 class="fw-bold text-danger mb-0">
                    {{ number_format($finalizados) }}
                </h2>

            </div>

        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">

            <div class="card-body">

                <small class="text-muted">
                    Programas
                </small>

                <h2 class="fw-bold text-primary mb-0">
                    {{ $programasActivos }}
                </h2>

            </div>

        </div>
    </div>

</div>