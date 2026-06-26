@extends('frontend.estadisticas.layouts.app')

@section('titulo', 'Territorial')
@section('subtitulo', 'Análisis territorial por zonas y barrios')

@section('content')


<div class="container-fluid">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <form method="GET" class="row g-3">

                <div class="col-md-3">
                    <label>Programa</label>
                    <select name="programa_id" class="form-select">

                        <option value="">
                            Todos
                        </option>

                        @foreach($programas as $programa)
                            <option
                                value="{{ $programa->id }}"
                                @selected(request('programa_id') == $programa->id)
                            >
                                {{ $programa->nombre }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-3">
                    <label>Sede</label>

                    <select name="sede_id" class="form-select">

                        <option value="">
                            Todas
                        </option>

                        @foreach($sedes as $sede)
                            <option
                                value="{{ $sede->id }}"
                                @selected(request('sede_id') == $sede->id)
                            >
                                {{ $sede->nombre }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-2">
                    <label>Año</label>

                    <select
                        name="anio"
                        class="form-select"
                    >
                        <option value="">Todos</option>

                        @for($i = now()->year; $i >= 2023; $i--)
                            <option
                                value="{{ $i }}"
                                @selected(request('anio') == $i)
                            >
                                {{ $i }}
                            </option>
                        @endfor

                    </select>
                </div>

                <div class="col-md-2">
                    <label>Mes</label>

                    <select
                        name="mes"
                        class="form-select"
                    >
                        <option value="">Todos</option>

                        @for($i=1;$i<=12;$i++)
                            <option
                                value="{{ $i }}"
                                @selected(request('mes') == $i)
                            >
                                {{ $i }}
                            </option>
                        @endfor

                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button
                        class="btn btn-primary w-100"
                    >
                        Filtrar
                    </button>
                </div>

            </form>

        </div>
    </div>

    <div class="row mb-4">

        <div class="col-md-2">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3>{{ $totalPersonas }}</h3>
                    <small>Personas</small>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3>{{ $totalBarrios }}</h3>
                    <small>Barrios</small>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3>{{ $totalZonas }}</h3>
                    <small>Zonas</small>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h3>{{ $sinBarrio }}</h3>
                    <small>Sin barrio</small>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6>{{ $barrioActivo }}</h6>
                    <small>Barrio líder</small>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6>{{ $zonaActiva }}</h6>
                    <small>Zona líder</small>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-6">

            <div class="card shadow-sm">

                <div class="card-header">
                    Distribución por Zona
                </div>

                <div class="card-body">
                    <canvas id="zonasChart"></canvas>
                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card shadow-sm">

                <div class="card-header">
                    Top 15 Barrios
                </div>

                <div class="card-body">
                    <canvas id="barriosChart"></canvas>
                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(
    document.getElementById('zonasChart'),
    {
        type: 'bar',
        data: {
            labels: @json($zonas->pluck('zona')),
            datasets: [{
                data: @json($zonas->pluck('total'))
            }]
        }
    }
);

new Chart(
    document.getElementById('barriosChart'),
    {
        type: 'bar',
        data: {
            labels: @json($barrios->pluck('barrio')),
            datasets: [{
                data: @json($barrios->pluck('total'))
            }]
        },
        options: {
            indexAxis: 'y'
        }
    }
);

</script>

@endsection