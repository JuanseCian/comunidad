@extends('layouts.app')

@section('title', 'Acceso denegado')

@section('content')
<div class="container py-5">

    <div class="card shadow border-0 mx-auto" style="max-width:700px;">
        <div class="card-body text-center p-5">

            <i class="bi bi-shield-lock text-danger"
               style="font-size:5rem;"></i>

            <h2 class="fw-bold mt-3">
                Acceso denegado
            </h2>

            <p class="text-muted fs-5 mt-3">
                No posee permisos para ingresar a esta sección.
            </p>

            <p class="text-secondary">
                Si considera que esto es un error,
                comuníquese con un administrador.
            </p>

            <a href="{{ route('home') }}"
               class="btn btn-primary mt-3">
                Volver al inicio
            </a>

        </div>
    </div>

</div>
@endsection