<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            Participantes por Sede
        </h5>

    </div>

    <div class="card-body">

        <table class="table table-hover">

            <thead>

                <tr>
                    <th>Programa</th>
                    <th>Sede</th>
                    <th>Total</th>
                </tr>

            </thead>

            <tbody>

                @foreach($sedes as $sede)

                    <tr>

                        <td>
                            {{ $sede->programa?->nombre }}
                        </td>

                        <td>
                            {{ $sede->sede?->nombre }}
                        </td>

                        <td>
                            {{ $sede->total }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>