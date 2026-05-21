@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Territorial')

@section('subtitulo', 'Actividad por zonas y barrios')

@section('content')

@include('frontend.estadisticas.partials.navbar')

<div class="row g-4">

    <div class="col-lg-6">

        @include('frontend.estadisticas.partials.chart', [
            'title' => 'Zonas Más Activas',
            'chartId' => 'zonasChart'
        ])

    </div>

</div>

<script>

new Chart(document.getElementById('zonasChart'), {

    type: 'bar',

    data: {

        labels: [
            @foreach($zonas as $item)
                '{{ $item->zona }}',
            @endforeach
        ],

        datasets: [{
            data: [
                @foreach($zonas as $item)
                    {{ $item->total }},
                @endforeach
            ]
        }]
    }
});

</script>

@endsection