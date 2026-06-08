@extends('frontend.layout.front')

@section('title', 'Grupo Familiar · ' . $familia->codigo)

@section('content')
<div class="container-fluid py-4 px-3 px-lg-4">

    {{-- HERO --}}
    <div class="gf-hero d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="gf-hero-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="gf-label">Grupo familiar</div>
                    <h1 class="gf-hero-title mb-0">{{ $familia->codigo }}</h1>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-1">
                <span class="gf-badge gf-badge-blue">
                    <i class="bi bi-people"></i> {{ $familia->personas->count() }} integrante{{ $familia->personas->count() !== 1 ? 's' : '' }}
                </span>
                <span class="gf-badge gf-badge-green">
                    <i class="bi bi-box-seam"></i> {{ $familia->mercaderias->count() }} entrega{{ $familia->mercaderias->count() !== 1 ? 's' : '' }}
                </span>
                <span class="gf-badge gf-badge-red">
                    <i class="bi bi-heartbreak"></i> {{ $familia->sepelios->count() }} sepelio{{ $familia->sepelios->count() !== 1 ? 's' : '' }}
                </span>
            </div>
        </div>
        <a href="{{ route('familias.index') }}" class="gf-btn-back">
            <i class="bi bi-arrow-left"></i> Volver al listado
        </a>
    </div>

    <div class="row g-4">

        {{-- COLUMNA PRINCIPAL --}}
        <div class="col-lg-8">
            <div class="gf-card mb-0">

                {{-- Header integrantes (no colapsable, siempre visible) --}}
                <div class="gf-card-header d-flex align-items-center justify-content-between" style="cursor:default">
                    <span class="gf-section-title">
                        <i class="bi bi-people text-primary"></i> Integrantes del grupo
                    </span>
                    <span class="gf-count-pill">{{ $familia->personas->count() }}</span>
                </div>

                <div class="gf-card-body">
                    @forelse($familia->personas as $index => $persona)
                        @php
                            $programasActivos = $persona->personaPrograma->whereNull('fecha_fin')->filter(fn($pp) => $pp->programa);
                            $beneficiosActivos = $persona->personaBeneficio->where('activo', 1)->filter(fn($pb) => $pb->beneficio);
                            $tieneBajoPeso = $persona->bajoPesoActivo;
                            $tieneInfo = $programasActivos->count() || $beneficiosActivos->count() || ($persona->grupoFamiliar && $persona->grupoFamiliar->count());
                            $collapseId = 'persona-' . $persona->id;
                            $openByDefault = $index === 0;
                        @endphp

                        <div class="gf-persona-card {{ $index < $familia->personas->count() - 1 ? 'mb-2' : '' }}">

                            {{-- Cabecera de persona (colapsable) --}}
                            <div class="gf-persona-header"
                                 data-bs-toggle="collapse"
                                 data-bs-target="#{{ $collapseId }}"
                                 aria-expanded="{{ $openByDefault ? 'true' : 'false' }}"
                                 aria-controls="{{ $collapseId }}">

                                <div class="d-flex align-items-center gap-3">
                                    <div class="gf-avatar">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <div class="gf-persona-name">{{ $persona->apellido }}, {{ $persona->nombre }}</div>
                                        <div class="gf-persona-dni">
                                            <i class="bi bi-person-vcard"></i> {{ $persona->dni ?? 'Sin DNI cargado' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    @if($programasActivos->count())
                                        <span class="gf-badge gf-badge-blue gf-badge-sm d-none d-sm-inline-flex">
                                            {{ $programasActivos->count() }} {{ $programasActivos->count() === 1 ? 'programa' : 'programas' }}
                                        </span>
                                    @endif
                                    <i class="bi bi-chevron-down gf-chevron"></i>
                                </div>
                            </div>

                            {{-- Cuerpo colapsable de persona --}}
                            <div class="collapse {{ $openByDefault ? 'show' : '' }}" id="{{ $collapseId }}">
                                <div class="gf-persona-body">

                                    {{-- Programas y Beneficios --}}
                                    @if($programasActivos->count() || $beneficiosActivos->count())
                                        <div class="row g-2 mb-3">
                                            @if($programasActivos->count())
                                                <div class="col-sm-6">
                                                    <div class="gf-info-box">
                                                        <div class="gf-info-label">
                                                            <i class="bi bi-diagram-3 text-primary"></i> Programas activos
                                                        </div>
                                                        <div class="d-flex flex-wrap gap-1 mt-1">
                                                            @foreach($programasActivos as $pp)
                                                                <span class="gf-tag gf-tag-blue">{{ $pp->programa->nombre }}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($beneficiosActivos->count())
                                                <div class="col-sm-6">
                                                    <div class="gf-info-box">
                                                        <div class="gf-info-label">
                                                            <i class="bi bi-award text-success"></i> Beneficios activos
                                                        </div>
                                                        <div class="d-flex flex-wrap gap-1 mt-1">
                                                            @foreach($beneficiosActivos as $pb)
                                                                <span class="gf-tag gf-tag-green">{{ $pb->beneficio->nombre }}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                     @if($tieneBajoPeso)
                                        <div class="col-sm-6">
                                            <div class="gf-info-box">
                                                <div class="gf-info-label">
                                                    <i class="bi bi-heart-pulse text-danger"></i>
                                                    Programa Bajo Peso
                                                </div>

                                                <div class="mt-1">
                                                    <span class="gf-tag gf-tag-red">
                                                        Activo
                                                    </span>

                                                    <span class="gf-tag">
                                                        Desde
                                                        {{ $tieneBajoPeso->created_at->format('d/m/Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Red familiar --}}
                                    @if($persona->grupoFamiliar && $persona->grupoFamiliar->count())
                                        @php
                                            $nucleoIds = $persona->nucleosConvivientes?->pluck('id') ?? collect();
                                            $gfConvIds = $nucleoIds->isNotEmpty()
                                                ? $persona->nucleosConvivientes->flatMap(fn($n) => $n->miembrosGrupoFamiliar->pluck('id'))->unique()
                                                : collect();

                                            $convivientes = $persona->grupoFamiliar->filter(fn($f) => $gfConvIds->contains($f->id));
                                            $externos     = $persona->grupoFamiliar->reject(fn($f) => $gfConvIds->contains($f->id));
                                        @endphp

                                        <div class="gf-familiar-block">
                                            <div class="gf-info-label mb-2">
                                                <i class="bi bi-people text-secondary"></i> Red familiar asociada
                                            </div>

                                            @if($convivientes->isNotEmpty())
                                                <div class="gf-familiar-group-label gf-familiar-green mb-1">
                                                    <i class="bi bi-house-door-fill"></i> Núcleo conviviente
                                                </div>
                                                <div class="gf-familiar-list mb-3">
                                                    @foreach($convivientes as $familiar)
                                                        <div class="gf-familiar-row">
                                                            <span class="gf-familiar-name">{{ $familiar->nombre }}</span>
                                                            <span class="gf-familiar-rel">{{ $familiar->relacion_titular ?? '—' }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if($externos->isNotEmpty())
                                                <div class="gf-familiar-group-label gf-familiar-amber mb-1">
                                                    <i class="bi bi-signpost-split-fill"></i> Externos al domicilio
                                                </div>
                                                <div class="gf-familiar-list">
                                                    @foreach($externos as $familiar)
                                                        <div class="gf-familiar-row">
                                                            <span class="gf-familiar-name">{{ $familiar->nombre }}</span>
                                                            <span class="gf-familiar-rel">{{ $familiar->relacion_titular ?? '—' }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if($gfConvIds->isEmpty())
                                                <div class="gf-familiar-list">
                                                    @foreach($persona->grupoFamiliar as $familiar)
                                                        <div class="gf-familiar-row">
                                                            <span class="gf-familiar-name">{{ $familiar->nombre }}</span>
                                                            <span class="gf-familiar-rel">{{ $familiar->relacion_titular ?? '—' }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if(!$tieneInfo)
                                        <p class="gf-empty-inline">Sin programas, beneficios ni vínculos cargados.</p>
                                    @endif

                                    <div class="text-end mt-3 pt-2 border-top">
                                        <a href="{{ route('personas.show', $persona->id) }}" class="gf-btn-back gf-btn-sm">
                                            <i class="bi bi-eye"></i> Ver perfil completo
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="gf-empty">
                            <i class="bi bi-people fs-3 d-block mb-2"></i>
                            No hay integrantes vinculados a este grupo.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="col-lg-4">

            {{-- Resumen --}}
            <div class="gf-card mb-3">
                <div class="gf-card-body gf-card-body-tight">
                    <div class="gf-info-label mb-2">Resumen del grupo</div>
                    <div class="gf-sidebar-row">
                        <span class="gf-sidebar-label">Código familiar</span>
                        <span class="fw-semibold">{{ $familia->codigo }}</span>
                    </div>
                    <div class="gf-sidebar-row">
                        <span class="gf-sidebar-label">Integrantes</span>
                        <span class="gf-count-pill">{{ $familia->personas->count() }}</span>
                    </div>
                </div>
            </div>

            {{-- Entregas colapsable --}}
            <div class="gf-card mb-3">
                <div class="gf-card-header"
                     data-bs-toggle="collapse"
                     data-bs-target="#sidebar-entregas"
                     aria-expanded="true"
                     aria-controls="sidebar-entregas">
                    <span class="gf-section-title">
                        <i class="bi bi-box-seam text-success"></i> Entregas
                    </span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="gf-count-pill">{{ $familia->mercaderias->count() }}</span>
                        <i class="bi bi-chevron-down gf-chevron"></i>
                    </div>
                </div>
                <div class="collapse show" id="sidebar-entregas">
                    <div class="gf-card-body">
                        @forelse($familia->mercaderias->sortByDesc('fecha_entrega') as $mercaderia)
                            <div class="gf-timeline-item">
                                <div class="gf-timeline-dot gf-dot-green"></div>
                                <div>
                                    <div class="gf-timeline-date">
                                        {{ \Carbon\Carbon::parse($mercaderia->fecha_entrega)->format('d M, Y') }}
                                    </div>
                                    <div class="gf-timeline-sub">
                                        <i class="bi bi-person-check"></i> {{ $mercaderia->nombre }} {{ $mercaderia->apellido }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="gf-empty">
                                <i class="bi bi-inbox d-block mb-1 fs-4"></i> Sin entregas registradas
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="gf-card mb-3">

                <div class="gf-card-body gf-card-body-tight">

                    <div class="gf-info-label mb-2">
                        Programa Bajo Peso
                    </div>

                    @php
                        $menoresBajoPeso = $familia->personas
                            ->filter(fn($p) => $p->bajoPesoActivo);
                    @endphp

                    <div class="gf-sidebar-row">
                        <span class="gf-sidebar-label">
                            Cupos utilizados
                        </span>

                        <span class="gf-count-pill">
                            {{ $menoresBajoPeso->count() }}/3
                        </span>
                    </div>

                    @foreach($menoresBajoPeso as $menor)

                        <div class="gf-sidebar-row">

                            <span>
                                {{ $menor->apellido }},
                                {{ $menor->nombre }}
                            </span>

                            <span class="gf-tag gf-tag-red">
                                Activo
                            </span>

                        </div>

                    @endforeach

                </div>

            </div>

            {{-- Sepelios colapsable --}}
            <div class="gf-card">
                <div class="gf-card-header"
                     data-bs-toggle="collapse"
                     data-bs-target="#sidebar-sepelios"
                     aria-expanded="true"
                     aria-controls="sidebar-sepelios">
                    <span class="gf-section-title">
                        <i class="bi bi-heartbreak text-danger"></i> Sepelios
                    </span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="gf-count-pill">{{ $familia->sepelios->count() }}</span>
                        <i class="bi bi-chevron-down gf-chevron"></i>
                    </div>
                </div>
                <div class="collapse show" id="sidebar-sepelios">
                    <div class="gf-card-body">
                        @forelse($familia->sepelios->sortByDesc('created_at') as $sepelio)
                            <div class="gf-timeline-item">
                                <div class="gf-timeline-dot gf-dot-red"></div>
                                <div style="flex:1">
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div class="gf-timeline-date">{{ $sepelio->fallecido_nombre }}</div>
                                        <span class="gf-tag {{ $sepelio->servicio_tipo === 'cremacion' ? '' : 'gf-tag-red' }}" style="white-space:nowrap">
                                            {{ ucfirst($sepelio->servicio_tipo) }}
                                        </span>
                                    </div>
                                    <div class="gf-timeline-sub">
                                        {{ \Carbon\Carbon::parse($sepelio->created_at)->format('d/m/Y') }}
                                        @if($sepelio->solicitante)
                                            · Resp: {{ $sepelio->solicitante }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="gf-empty">
                                <i class="bi bi-heartbreak d-block mb-1 fs-4 text-black-50"></i> Sin sepelios registrados
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* =============================================
   GRUPO FAMILIAR — SHOW VIEW
   Namespace: gf-
   ============================================= */

/* --- Chevron animado con Bootstrap Collapse --- */
[data-bs-toggle="collapse"] .gf-chevron {
    transition: transform .2s ease;
}
[data-bs-toggle="collapse"][aria-expanded="true"] .gf-chevron {
    transform: rotate(180deg);
}

/* --- Hero --- */
.gf-hero {
    background-color: var(--bs-body-bg, #f8f9fa);
    border: 1px solid rgba(0,0,0,.08);
    border-radius: 1rem;
    padding: 1.25rem 1.5rem;
}
.gf-hero-icon {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background-color: rgba(79, 70, 229, .1);
    color: #4f46e5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.gf-hero-title {
    font-size: 1.35rem;
    font-weight: 700;
    line-height: 1.2;
}
.gf-label {
    font-size: .7rem;
    text-transform: uppercase;
    letter-spacing: .06em;
    font-weight: 600;
    color: var(--bs-secondary-color, #6c757d);
    margin-bottom: 2px;
}

/* --- Badges --- */
.gf-badge {
    font-size: .72rem;
    font-weight: 500;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    border: 1px solid transparent;
}
.gf-badge-blue  { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
.gf-badge-green { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
.gf-badge-red   { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
.gf-badge-sm    { font-size: .65rem; padding: 2px 8px; }

/* --- Tags (inline) --- */
.gf-tag {
    font-size: .7rem;
    padding: 2px 9px;
    border-radius: 20px;
    border: 1px solid rgba(0,0,0,.1);
    background: #f1f5f9;
    color: #475569;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    white-space: nowrap;
}
.gf-tag-blue  { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
.gf-tag-green { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
.gf-tag-red   { background: #fef2f2; color: #991b1b; border-color: #fecaca; }

/* --- Buttons --- */
.gf-btn-back {
    font-size: .8rem;
    font-weight: 500;
    color: var(--bs-secondary-color, #6c757d);
    border: 1px solid rgba(0,0,0,.12);
    border-radius: 8px;
    padding: 6px 14px;
    background: var(--bs-body-bg, #fff);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    white-space: nowrap;
    transition: background .15s;
}
.gf-btn-back:hover {
    background: #f1f5f9;
    color: var(--bs-body-color, #212529);
}
.gf-btn-sm { font-size: .75rem; padding: 4px 11px; }

/* --- Cards --- */
.gf-card {
    background: var(--bs-body-bg, #fff);
    border: 1px solid rgba(0,0,0,.09);
    border-radius: 1rem;
    overflow: hidden;
}
.gf-card-header {
    padding: .9rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    user-select: none;
    transition: background .15s;
}
.gf-card-header:hover { background: rgba(0,0,0,.02); }
.gf-section-title {
    font-size: .9rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 7px;
}
.gf-card-body {
    padding: .9rem 1.25rem;
    border-top: 1px solid rgba(0,0,0,.07);
}
.gf-card-body-tight { padding: 1rem 1.25rem; border-top: none; }

/* --- Count pill --- */
.gf-count-pill {
    font-size: .72rem;
    font-weight: 500;
    background: rgba(0,0,0,.05);
    border: 1px solid rgba(0,0,0,.08);
    border-radius: 20px;
    padding: 2px 9px;
    color: var(--bs-secondary-color, #6c757d);
}

/* --- Persona card --- */
.gf-persona-card {
    border: 1px solid rgba(0,0,0,.08);
    border-radius: .75rem;
    overflow: hidden;
}
.gf-persona-header {
    padding: .85rem 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    background: rgba(0,0,0,.02);
    transition: background .15s;
    user-select: none;
    gap: .75rem;
}
.gf-persona-header:hover { background: rgba(0,0,0,.04); }
.gf-persona-name {
    font-size: .9rem;
    font-weight: 600;
    line-height: 1.2;
}
.gf-persona-dni {
    font-size: .75rem;
    color: var(--bs-secondary-color, #6c757d);
    margin-top: 2px;
}
.gf-persona-body {
    padding: .9rem 1rem;
    border-top: 1px solid rgba(0,0,0,.07);
}
.gf-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: #94a3b8;
    flex-shrink: 0;
    border: 1px solid rgba(0,0,0,.08);
}

/* --- Info boxes dentro de persona --- */
.gf-info-box {
    background: rgba(0,0,0,.02);
    border: 1px solid rgba(0,0,0,.07);
    border-radius: .5rem;
    padding: .6rem .75rem;
    height: 100%;
}
.gf-info-label {
    font-size: .7rem;
    text-transform: uppercase;
    letter-spacing: .05em;
    font-weight: 600;
    color: var(--bs-secondary-color, #6c757d);
    display: flex;
    align-items: center;
    gap: 5px;
}

/* --- Familiar block --- */
.gf-familiar-block {
    background: rgba(0,0,0,.02);
    border: 1px solid rgba(0,0,0,.07);
    border-radius: .5rem;
    padding: .75rem;
}
.gf-familiar-group-label {
    font-size: .7rem;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.gf-familiar-green { background: #f0fdf4; color: #166534; }
.gf-familiar-amber { background: #fffbeb; color: #92400e; }
.gf-familiar-list { }
.gf-familiar-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 5px 0;
    border-bottom: 1px solid rgba(0,0,0,.05);
}
.gf-familiar-row:last-child { border-bottom: none; }
.gf-familiar-name { font-size: .82rem; font-weight: 500; }
.gf-familiar-rel  { font-size: .75rem; color: var(--bs-secondary-color, #6c757d); }

/* --- Sidebar --- */
.gf-sidebar-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid rgba(0,0,0,.06);
    font-size: .85rem;
}
.gf-sidebar-row:last-child { border-bottom: none; }
.gf-sidebar-label { color: var(--bs-secondary-color, #6c757d); }

/* --- Timeline --- */
.gf-timeline-item {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    padding: 6px 0;
    border-bottom: 1px solid rgba(0,0,0,.05);
}
.gf-timeline-item:last-child { border-bottom: none; }
.gf-timeline-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-top: 4px;
    flex-shrink: 0;
}
.gf-dot-green { background: #16a34a; }
.gf-dot-red   { background: #dc2626; }
.gf-timeline-date { font-size: .82rem; font-weight: 600; }
.gf-timeline-sub  { font-size: .75rem; color: var(--bs-secondary-color, #6c757d); margin-top: 1px; }

/* --- Empty states --- */
.gf-empty {
    text-align: center;
    padding: 1.5rem;
    color: var(--bs-secondary-color, #6c757d);
    font-size: .82rem;
}
.gf-empty-inline {
    font-size: .82rem;
    color: var(--bs-secondary-color, #6c757d);
    margin: 0;
}
</style>
@endsection