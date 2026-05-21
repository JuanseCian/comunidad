@extends('frontend.recepcion.layout.app')

@section('title', 'Ingresos')

@section('content')

<div class="container-fluid py-4">

    {{-- Cabecera --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Ingresos</h2>
            <p class="text-muted small mb-0">
                Mesa de entrada y derivaciones activas del sistema
            </p>
        </div>
        <a href="{{ route('recepcion.ingresos.create') }}" class="btn btn-success d-inline-flex align-items-center gap-2 shadow-sm fw-semibold px-3">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Nuevo ingreso</span>
        </a>
    </div>

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase fs-7 text-muted border-bottom">
                        <tr>
                            <th width="90" class="ps-4 text-center">ID</th>
                            <th>Persona</th>
                            <th>Derivación</th>
                            <th>Menor a Cargo</th>
                            <th width="140">Fecha</th>
                            <th width="120">Hora</th>
                            <th>Registrado por</th>
                            <th width="100" class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ingresos as $i)
                            <tr>
                                {{-- ID --}}
                                <td class="ps-4 text-center">
                                    <span class="badge bg-light text-secondary border fw-bold px-2 py-1.5">
                                        #{{ $i->id }}
                                    </span>
                                </td>

                                {{-- PERSONA --}}
                                <td>
                                    <div class="fw-semibold text-dark mb-0">
                                        @if($i->persona)
                                            {{ $i->persona->apellido }}, {{ $i->persona->nombre }}
                                        @else
                                            {{ $i->apellido }}, {{ $i->nombre }}
                                        @endif
                                    </div>
                                    @if($i->observaciones)
                                        <small class="text-muted d-block text-truncate mt-1" style="max-width: 280px;" title="{{ $i->observaciones }}">
                                            <i class="bi bi-chat-left-text text-secondary me-1"></i>
                                            {{ \Illuminate\Support\Str::limit($i->observaciones, 50) }}
                                        </small>
                                    @endif
                                </td>

                                {{-- DERIVACIÓN --}}
                                <td>
                                    @if($i->derivacion)
                                        <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-2 py-1.5 fw-medium">
                                            <i class="bi bi-arrow-right-short me-1"></i>{{ $i->derivacion->nombre }}
                                        </span>
                                    @else
                                        <span class="text-muted fs-7 custom-italic">Sin derivación</span>
                                    @endif
                                </td>

                                {{-- MENOR --}}
                                <td>
                                    @if($i->menor_nombre || $i->menor_apellido || $i->menor)
                                        <div class="d-inline-flex flex-column">
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 mb-1 fw-semibold text-start">
                                                <i class="bi bi-person-fill me-1"></i>
                                                @if($i->menor)
                                                    {{ $i->menor->apellido }}, {{ $i->menor->nombre }}
                                                @else
                                                    {{ $i->menor_apellido }}, {{ $i->menor_nombre }}
                                                @endif
                                            </span>
                                            @if($i->menor_dni)
                                                <small class="text-muted fs-7 ps-1"><span class="fw-medium">DNI:</span> {{ $i->menor_dni }}</small>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted ps-2">—</span>
                                    @endif
                                </td>

                                {{-- FECHA --}}
                                <td>
                                    <div class="d-flex align-items-center text-dark small">
                                        <i class="bi bi-calendar3 text-muted me-2"></i>
                                        <span>{{ \Carbon\Carbon::parse($i->fecha_ingreso)->format('d/m/Y') }}</span>
                                    </div>
                                </td>

                                {{-- HORA --}}
                                <td>
                                    <div class="d-flex align-items-center text-dark small">
                                        <i class="bi bi-clock text-muted me-2"></i>
                                        <span>{{ \Carbon\Carbon::parse($i->hora_ingreso)->format('H:i') }}</span>
                                    </div>
                                </td>

                                {{-- REGISTRADO POR --}}
                                <td>
                                    <span class="text-secondary d-inline-flex align-items-center gap-1.5 small">
                                        <i class="bi bi-person-circle text-muted fs-6"></i>
                                        {{ $i->usuario->username ?? 'Usuario' }}
                                    </span>
                                </td>

                                {{-- ACCIONES --}}
                                <td class="text-end pe-4">
                                    <a href="#" class="btn btn-sm btn-light border shadow-sm px-2.5" title="Ver detalles">
                                        <i class="bi bi-eye text-secondary"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center py-3">
                                        <i class="bi bi-inbox text-muted mb-3" style="font-size: 3rem;"></i>
                                        <h5 class="fw-semibold text-secondary mb-1">No hay ingresos registrados</h5>
                                        <p class="text-muted small mb-0">
                                            Los ingresos realizados desde recepción aparecerán listados en este panel.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection