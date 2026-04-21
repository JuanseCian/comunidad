@extends('backend.layouts.back')

@section('content')
<a href="{{ route('provincias.create') }}" class="btn btn-primary">Nueva Provincia</a>

<table class="table mt-3">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Acciones</th>
    </tr>

    @foreach($provincias as $provincia)
    <tr>
        <td>{{ $provincia->id }}</td>
        <td>{{ $provincia->nombre }}</td>
        <td>
            <a href="{{ route('provincias.edit', $provincia->id) }}" class="btn btn-warning">Editar</a>

            <form action="{{ route('provincias.destroy', $provincia->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection