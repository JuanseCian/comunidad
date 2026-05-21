@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Atenciones')

@section('subtitulo', 'Intervenciones y seguimientos')

@section('content')

@include('frontend.estadisticas.partials.navbar')

<div class="row g-4 mb-4">

    <div class="col-md-6">

        @include('frontend.estadisticas.partials.card', [
            'title' => 'Total Atenciones',
            'value' => $totalAtenciones,
            'icon' => 'bi bi-heart-pulse'
        ])

    </div>

    <div class="col-md-6">

        @include('frontend.estadisticas.partials.card', [
            'title' => 'Atenciones del Mes',
            'value' => $atencionesMes,
            'icon' => 'bi bi-calendar2-week'
        ])

    </div>

</div>

@endsection