@extends('frontend.layout.front')

@section('title', 'Grupos Familiares')

@section('content')

{{-- HERO --}}
<section style="background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%); border-bottom: 1px solid #ddd6fe; padding: 2rem 0 1.6rem;">
    <div class="container">
        <div class="d-flex align-items-center gap-3 mb-2">
            <div style="width:44px; height:44px; background:linear-gradient(135deg,#7c3aed,#8b5cf6); border-radius:13px; display:flex; align-items:center; justify-content:center; color:white; font-size:20px; box-shadow:0 4px 10px rgba(124,58,237,0.25);">
                <i class="bi bi-diagram-3-fill"></i>
            </div>
            <div>
                <h1 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:1.5rem; color:#0f172a; margin:0; line-height:1.2;">Grupos Familiares</h1>
                <p style="color:#536070; font-size:13px; font-weight:500; margin:0;">Administración y visualización de grupos registrados</p>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">

    {{-- BUSCADOR --}}
    <div style="background:white; border-radius:16px; padding:20px; border:1px solid #e2e8f0; box-shadow:0 2px 10px rgba(0,0,0,0.04); margin-bottom:1.5rem;">
        <form method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label style="font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; color:#0f172a; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.5px;">Buscar</label>
                    <div style="position:relative;">
                        <i class="bi bi-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:14px;"></i>
                        <input type="text" name="q" class="form-control" placeholder="Código, apellido o DNI..." value="{{ request('q') }}" style="padding-left:36px; border-radius:10px; border-color:#e2e8f0; font-size:13.5px;">
                    </div>
                </div>
                <div class="col-md-4">
                    <label style="font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; color:#0f172a; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.5px;">Estado mercadería</label>
                    <select name="mercaderia" class="form-select" style="border-radius:10px; border-color:#e2e8f0; font-size:13.5px;">
                        <option value="">Todos</option>
                        <option value="si" {{ request('mercaderia')=='si'?'selected':'' }}>Retiró este mes</option>
                        <option value="no" {{ request('mercaderia')=='no'?'selected':'' }}>No retiró</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" style="width:100%; background:linear-gradient(135deg,#7c3aed,#8b5cf6); color:white; border:none; border-radius:10px; padding:9px 16px; font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13.5px; display:flex; align-items:center; justify-content:center; gap:7px; cursor:pointer;">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- LISTADO --}}
    <div class="row g-3">
        @forelse($familias as $familia)
            @php
                $ultimaEntrega = $familia->mercaderias->sortByDesc('fecha_entrega')->first();
                $retiroEsteMes = $ultimaEntrega &&
                    \Carbon\Carbon::parse($ultimaEntrega->fecha_entrega)->month == now()->month &&
                    \Carbon\Carbon::parse($ultimaEntrega->fecha_entrega)->year == now()->year;
            @endphp

            <div class="col-xl-4 col-md-6">
                <div style="background:white; border-radius:18px; border:1px solid #e2e8f0; border-top:3px solid #7c3aed; box-shadow:0 2px 12px rgba(0,0,0,0.04); height:100%; display:flex; flex-direction:column;">

                    {{-- HEADER de la card --}}
                    <div style="padding:18px 18px 14px; border-bottom:1px solid #f1f5f9;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:10px;">
                            <div>
                                <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
                                    <div style="width:32px; height:32px; background:linear-gradient(135deg,#7c3aed,#8b5cf6); border-radius:9px; display:flex; align-items:center; justify-content:center; color:white; font-size:14px; flex-shrink:0;">
                                        <i class="bi bi-house-fill"></i>
                                    </div>
                                    <h5 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:1rem; color:#0f172a; margin:0;">{{ $familia->codigo }}</h5>
                                </div>
                                <p style="font-size:12px; color:#536070; font-weight:500; margin:0;">{{ $familia->personas_count }} {{ $familia->personas_count == 1 ? 'integrante' : 'integrantes' }}</p>
                            </div>
                            <div>
                                @if($retiroEsteMes)
                                    <span style="background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; border-radius:40px; padding:4px 11px; font-size:11px; font-weight:700; white-space:nowrap;">
                                        <i class="bi bi-x-circle-fill" style="font-size:10px;"></i> Ya retiró
                                    </span>
                                @else
                                    <span style="background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; border-radius:40px; padding:4px 11px; font-size:11px; font-weight:700; white-space:nowrap;">
                                        <i class="bi bi-check-circle-fill" style="font-size:10px;"></i> Habilitado
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- INTEGRANTES --}}
                    <div style="padding:14px 18px; flex:1; display:flex; flex-direction:column; gap:7px;">
                        @foreach($familia->personas as $persona)
                        <div style="background:#f8fafc; border-radius:10px; padding:9px 12px; border:1px solid #f1f5f9;">
                            <div style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13px; color:#0f172a;">
                                {{ $persona->apellido }}, {{ $persona->nombre }}
                            </div>
                            <div style="font-size:11.5px; color:#536070; font-weight:500; margin-top:1px;">
                                DNI: {{ $persona->dni ?? 'No cargado' }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- FOOTER --}}
                    <div style="padding:12px 18px; border-top:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
                        @if($ultimaEntrega)
                            <span style="font-size:11.5px; color:#536070; font-weight:500;">
                                <i class="bi bi-clock-history" style="color:#94a3b8; font-size:12px;"></i>
                                Última entrega: <strong style="color:#0f172a;">{{ \Carbon\Carbon::parse($ultimaEntrega->fecha_entrega)->format('d/m/Y') }}</strong>
                            </span>
                        @else
                            <span style="font-size:11.5px; color:#94a3b8; font-weight:500;">Sin entregas registradas</span>
                        @endif
                        <a href="{{ route('familias.show', $familia->id) }}" style="background:#f3e8ff; color:#6d28d9; border:1px solid #d8b4fe; border-radius:8px; padding:5px 12px; font-size:12px; font-weight:700; text-decoration:none; white-space:nowrap;">
                            Ver grupo
                        </a>
                    </div>

                </div>
            </div>

        @empty
            <div class="col-12">
                <div style="background:white; border-radius:18px; padding:3rem; text-align:center; border:1px solid #e2e8f0;">
                    <div style="width:56px; height:56px; background:#f3e8ff; border-radius:16px; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; font-size:24px; color:#7c3aed;">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; color:#0f172a; margin-bottom:6px;">Sin resultados</h5>
                    <p style="color:#536070; font-size:13.5px; margin:0;">No hay grupos familiares que coincidan con la búsqueda.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-4">
        {{ $familias->links() }}
    </div>

</div>

@endsection