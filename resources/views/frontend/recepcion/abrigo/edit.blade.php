@extends('frontend.recepcion.layout.app')

@section('title', 'Editar entrega de abrigo')

@section('content')
<div class="container-fluid py-4" style="max-width: 900px;">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Editar entrega de abrigo</h2>
        <p class="text-muted mb-0">Modificar los datos de colchones y frazadas entregados.</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center rounded-3 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    @include('frontend.recepcion.abrigo._form', ['abrigo' => $abrigo])
</div>
@endsection
