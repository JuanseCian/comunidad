<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white">
        <h5 class="mb-0">Top Barrios</h5>
    </div>

    <div class="card-body">

        <table class="table">

            <thead>
                <tr>
                    <th>Programa</th>
                    <th>Barrio</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>

                @foreach($barrios->take(20) as $item)

                    <tr>

                        <td>{{ $item->programa }}</td>
                        <td>{{ $item->barrio }}</td>
                        <td>{{ $item->total }}</td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>