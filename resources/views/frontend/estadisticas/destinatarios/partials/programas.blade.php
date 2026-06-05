<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            Participantes por Programa
        </h5>

    </div>

    <div class="card-body">

        <div class="row g-4">

            @foreach($programas as $programa)

                <div class="col-lg-3">

                    <div class="border rounded p-3 h-100">

                        <h5 class="fw-bold">
                            {{ $programa->programa?->nombre }}
                        </h5>

                        <div>
                            Total:
                            <strong>
                                {{ $programa->total }}
                            </strong>
                        </div>

                        <div class="text-success">
                            Activos:
                            {{ $programa->activos }}
                        </div>

                        <div class="text-danger">
                            Finalizados:
                            {{ $programa->finalizados }}
                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>