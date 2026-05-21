@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Destinatarios')

@section('subtitulo', 'Análisis social y territorial')

@section('content')

@include('frontend.estadisticas.partials.navbar')

<div class="row g-4 mb-4">

    <div class="col-md-6">

        @include('frontend.estadisticas.partials.card', [
            'title' => 'Total Destinatarios',
            'value' => $totalDestinatarios,
            'icon' => 'bi bi-people'
        ])

    </div>

    <div class="col-md-6">

        @include('frontend.estadisticas.partials.card', [
            'title' => 'Nuevos este Mes',
            'value' => $nuevosMes,
            'icon' => 'bi bi-person-plus'
        ])

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-6">

        @include('frontend.estadisticas.partials.chart', [
            'title' => 'Destinatarios por Barrio',
            'chartId' => 'barriosChart'
        ])

    </div>

    <div class="col-lg-6">

        @include('frontend.estadisticas.partials.chart', [
            'title' => 'Destinatarios por Género',
            'chartId' => 'generosChart'
        ])

    </div>

</div>

<script>

new Chart(document.getElementById('barriosChart'), {

    type: 'pie',

    data: {

        labels: [
            @foreach($barrios as $item)
                '{{ $item->barrio }}',
            @endforeach
        ],

        datasets: [{
            data: [
                @foreach($barrios as $item)
                    {{ $item->total }},
                @endforeach
            ]
        }]
    }
});

new Chart(document.getElementById('generosChart'), {

    type: 'doughnut',

    data: {

        labels: [
            @foreach($generos as $item)
                '{{ $item->genero }}',
            @endforeach
        ],

        datasets: [{
            data: [
                @foreach($generos as $item)
                    {{ $item->total }},
                @endforeach
            ]
        }]
    }
});

</script>

@endsection