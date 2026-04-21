@extends('backend.layouts.back')

@section('content')
<form action="{{ isset($provincia) ? route('provincias.update', $provincia->id) : route('provincias.store') }}" method="POST">
    @csrf
    @if(isset($provincia)) @method('PUT') @endif

    <input type="text" name="nombre" class="form-control"
           value="{{ $provincia->nombre ?? '' }}" placeholder="Nombre">

    <button class="btn btn-success mt-2">Guardar</button>
</form>
@endsection