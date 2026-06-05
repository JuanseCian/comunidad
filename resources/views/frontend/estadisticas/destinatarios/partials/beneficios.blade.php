<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            Beneficios Asociados
        </h5>

    </div>

    <div class="card-body">

        <table class="table">

            <thead>

                <tr>
                    <th>Beneficio</th>
                    <th>Total</th>
                </tr>

            </thead>

            <tbody>

                @foreach($beneficios as $beneficio)

                    <tr>

                        <td>
                            {{ $beneficio->nombre }}
                        </td>

                        <td>
                            {{ $beneficio->total }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>