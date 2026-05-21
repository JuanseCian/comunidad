@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Familias')

@section('subtitulo', 'Análisis familiar y composición')

@section('content')

@include('frontend.estadisticas.partials.navbar')

<div class="row g-4">

    <div class="col-md-12">

        @include('frontend.estadisticas.partials.card', [
            'title' => 'Total Familias',
            'value' => $totalFamilias,
            'icon' => 'bi bi-houses'
        ])

    </div>

</div>

@endsection