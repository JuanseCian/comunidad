<div class="row g-4 mb-4">

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">

                <small class="text-muted">
                    Programa más concurrido
                </small>

                <h5 class="fw-bold">
                    {{ $programaMasConcurrido?->programa?->nombre }}
                </h5>

                <span class="badge bg-primary">
                    {{ $programaMasConcurrido?->total }}
                </span>

            </div>
        </div>

    </div>

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">

                <small class="text-muted">
                    Sede más concurrida
                </small>

                <h5 class="fw-bold">
                    {{ $sedeMasConcurrida?->sede?->nombre }}
                </h5>

            </div>
        </div>

    </div>

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">

                <small class="text-muted">
                    Barrio predominante
                </small>

                <h5 class="fw-bold">
                    {{ $barrioMasFrecuente?->barrio }}
                </h5>

            </div>
        </div>

    </div>

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">

                <small class="text-muted">
                    Beneficio predominante
                </small>

                <h5 class="fw-bold">
                    {{ $beneficioMasFrecuente?->nombre }}
                </h5>

            </div>
        </div>

    </div>

</div>