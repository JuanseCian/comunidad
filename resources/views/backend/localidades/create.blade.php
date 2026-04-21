@extends('backend.layouts.back')

@section('content')
<form method="POST"
      action="{{ isset($localidad) ? route('localidades.update', $localidad->id) : route('localidades.store') }}">
    @csrf
    @if(isset($localidad)) @method('PUT') @endif

    <input type="text" name="nombre" class="form-control"
           value="{{ $localidad->nombre ?? '' }}" placeholder="Nombre">

    <select name="provincia_id" class="form-control mt-2">
        @foreach($provincias as $prov)
            <option value="{{ $prov->id }}"
                {{ (isset($localidad) && $localidad->provincia_id == $prov->id) ? 'selected' : '' }}>
                {{ $prov->nombre }}
            </option>
        @endforeach
    </select>

    <button class="btn btn-success mt-2">Guardar</button>
</form>
@endsection