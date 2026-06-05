<div class="card border-0 shadow-sm">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            Distribución por Edad
        </h5>

    </div>

    <div class="card-body">

        <table class="table">

            <thead>

                <tr>
                    <th>Programa</th>
                    <th>Rango</th>
                    <th>Total</th>
                </tr>

            </thead>

            <tbody>

                @foreach($edades as $edad)

                    <tr>

                        <td>{{ $edad->programa }}</td>

                        <td>{{ $edad->rango }}</td>

                        <td>{{ $edad->total }}</td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>