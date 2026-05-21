@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Mercaderías')

@section('subtitulo', 'Control y estadísticas de mercadería')

@section('content')

@include('frontend.estadisticas.partials.navbar')

<div class="row g-4 mb-4">

    <div class="col-md-3">

        @include('frontend.estadisticas.partials.card', [
            'title' => 'Total',
            'value' => $totalMercaderias,
            'icon' => 'bi bi-box'
        ])

    </div>

    <div class="col-md-3">

        @include('frontend.estadisticas.partials.card', [
            'title' => 'Activas',
            'value' => $mercaderiasActivas,
            'icon' => 'bi bi-check-circle'
        ])

    </div>

    <div class="col-md-3">

        @include('frontend.estadisticas.partials.card', [
            'title' => 'Retiradas',
            'value' => $mercaderiasRetiradas,
            'icon' => 'bi bi-box-arrow-up'
        ])

    </div>

    <div class="col-md-3">

        @include('frontend.estadisticas.partials.card', [
            'title' => 'Vencidas',
            'value' => $mercaderiasVencidas,
            'icon' => 'bi bi-exclamation-circle'
        ])

    </div>

</div>

@endsection