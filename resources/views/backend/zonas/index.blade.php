@extends('backend.layouts.back')

@section('content')
<a href="{{ route('zonas-barrios.create') }}" class="btn btn-primary">Nueva Zona</a>

<table class="table mt-3">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Localidad</th>
        <th>Acciones</th>
    </tr>

    @foreach($zonas as $zona)
    <tr>
        <td>{{ $zona->id }}</td>
        <td>{{ $zona->nombre }}</td>
        <td>{{ $zona->localidad->nombre ?? '' }}</td>
        <td>
            <a href="{{ route('zonas-barrios.edit', $zona->id) }}" class="btn btn-warning">Editar</a>

            <form action="{{ route('zonas-barrios.destroy', $zona->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection