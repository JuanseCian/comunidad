@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Beneficios')

@section('subtitulo', 'Programas y beneficios sociales')

@section('content')

@include('frontend.estadisticas.partials.navbar')

<div class="row g-4">

    <div class="col-lg-8">

        @include('frontend.estadisticas.partials.chart', [
            'title' => 'Beneficios Más Utilizados',
            'chartId' => 'beneficiosChart'
        ])

    </div>

</div>

<script>

new Chart(document.getElementById('beneficiosChart'), {

    type: 'bar',

    data: {

        labels: [
            @foreach($beneficios as $item)
                '{{ $item->nombre }}',
            @endforeach
        ],

        datasets: [{
            data: [
                @foreach($beneficios as $item)
                    {{ $item->total }},
                @endforeach
            ]
        }]
    }
});

</script>

@endsection