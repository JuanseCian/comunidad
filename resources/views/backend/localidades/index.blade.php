@extends('backend.layouts.back')

@section('content')
<a href="{{ route('localidades.create') }}" class="btn btn-primary">Nueva Localidad</a>

<table class="table mt-3">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Provincia</th>
        <th>Acciones</th>
    </tr>

    @foreach($localidades as $loc)
    <tr>
        <td>{{ $loc->id }}</td>
        <td>{{ $loc->nombre }}</td>
        <td>{{ $loc->provincia->nombre ?? '' }}</td>
        <td>
            <a href="{{ route('localidades.edit', $loc->id) }}" class="btn btn-warning">Editar</a>

            <form action="{{ route('localidades.destroy', $loc->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection