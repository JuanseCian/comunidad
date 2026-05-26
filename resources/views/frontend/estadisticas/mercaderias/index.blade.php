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
            'title' => 'Entregas del Mes',
            'value' => $mercaderiasMes,
            'icon' => 'bi bi-calendar-check'
        ])

    </div>

    <div class="col-md-3">

        @include('frontend.estadisticas.partials.card', [
            'title' => 'Entregas Hoy',
            'value' => $mercaderiasHoy,
            'icon' => 'bi bi-clock-history'
        ])

    </div>

    <div class="col-md-3">

        @include('frontend.estadisticas.partials.card', [
            'title' => 'Núcleos Asistidos',
            'value' => $nucleosAsistidos,
            'icon' => 'bi bi-people'
        ])

    </div>

</div>

@endsection