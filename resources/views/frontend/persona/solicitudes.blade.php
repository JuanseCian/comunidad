@extends('frontend.layout.front')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Solicitudes de Alta Pendientes</h2>

    @if($pendientes->count() > 0)
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Persona</th>
                            <th>DNI</th>
                            <th>Sede Origen</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendientes as $p)
                        <tr>
                            <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $p->apellido }}, {{ $p->nombre }}</strong></td>
                            <td>{{ $p->dni }}</td>
                            <td>{{ $p->sedeOrigen?->nombre ?? 'No asignada' }}</td>
                            <td class="text-end">
                                <!-- Botón Aprobar (Verde) -->
                                <form action="{{ route('personas.aprobar', $p->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success" title="Aprobar Alta"
                                            onclick="return confirm('¿Aprobar el alta de {{ $p->apellido }}, {{ $p->nombre }}?')">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>

                                <!-- Botón Rechazar (Rojo) -->
                                <form action="{{ route('personas.rechazar', $p->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Rechazar y eliminar esta solicitud?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">
            {{ $pendientes->links() }}
        </div>
    @else
        <div class="alert alert-info border-0 shadow-sm">
            No hay solicitudes pendientes de aprobación en este momento.
        </div>
    @endif
</div>
@endsection