@extends('frontend.layout.front')

@section('title', 'Asistencia')

@section('content')

<div class="container-fluid px-3 px-md-4" style="padding-top:28px; padding-bottom:60px;">

    {{-- ── ENCABEZADO ── --}}
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="page-icon-wrap">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>
                <h4 class="mb-0 page-title">Asistencia</h4>
            </div>
            <p class="mb-0 page-subtitle">
                @if(!$esHoy)
                    <span class="badge-fecha-pasada me-2">
                        <i class="bi bi-clock-history me-1"></i>Fecha pasada
                    </span>
                @endif
                {{ \Carbon\Carbon::parse($fecha)->translatedFormat('l j \d\e F \d\e Y') }}
                @if(!$esHoy)
                    &nbsp;·&nbsp;
                    <a href="{{ route('asistencia.index') }}" class="link-hoy">
                        <i class="bi bi-arrow-left-short"></i>Volver a hoy
                    </a>
                @endif
            </p>
        </div>

        {{-- Contador --}}
        <div class="counter-pill" id="counterBox">
            <div class="counter-num-wrap">
                <span class="counter-num" id="cntPresente">0</span>
                <span class="counter-sep">/</span>
                <span class="counter-denom" id="cntTotal">0</span>
            </div>
            <span class="counter-label">presentes hoy</span>
        </div>
    </div>

    {{-- ── ALERTAS ── --}}
    @if(session('success'))
        <div class="alert-custom alert-custom--success mb-3" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="alert-close" data-bs-dismiss="alert" aria-label="Cerrar">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert-custom alert-custom--warning mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ session('warning') }}</span>
            <button type="button" class="alert-close" data-bs-dismiss="alert" aria-label="Cerrar">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    {{-- ── FILTROS ── --}}
    <form method="GET" action="{{ route('asistencia.index') }}" id="formFiltros"
          class="filter-bar mb-4">
        <div class="row g-2 align-items-end">

            <div class="col-6 col-md-3">
                <label class="filter-label">
                    <i class="bi bi-calendar3"></i>Fecha
                </label>
                <input type="date"
                       name="fecha"
                       class="filter-input"
                       value="{{ $fecha }}"
                       max="{{ \Carbon\Carbon::today()->toDateString() }}"
                       onchange="this.form.submit()">
            </div>

            <div class="col-6 col-md-3">
                <label class="filter-label">
                    <i class="bi bi-geo-alt"></i>Sede
                </label>
                <select name="sede_id" class="filter-input" onchange="this.form.submit()">
                    <option value="">Todas las sedes</option>
                    @foreach($sedes as $sede)
                        <option value="{{ $sede->id }}" {{ $sedeId == $sede->id ? 'selected' : '' }}>
                            {{ $sede->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-3">
                <label class="filter-label">
                    <i class="bi bi-collection"></i>Programa
                </label>
                <select name="programa_id" class="filter-input" onchange="this.form.submit()">
                    <option value="">Todos los programas</option>
                    @foreach($programas as $prog)
                        <option value="{{ $prog->id }}" {{ $programaId == $prog->id ? 'selected' : '' }}>
                            {{ $prog->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-3">
                <label class="filter-label">
                    <i class="bi bi-search"></i>Buscar
                </label>
                <input type="text"
                       id="inputBuscar"
                       class="filter-input"
                       placeholder="Nombre o apellido…"
                       autocomplete="off">
            </div>

        </div>

        @if($sedeId || $programaId || $fecha !== \Carbon\Carbon::today()->toDateString())
            <div class="mt-2 d-flex align-items-center gap-2">
                <a href="{{ route('asistencia.index') }}" class="btn-limpiar">
                    <i class="bi bi-x-circle me-1"></i>Limpiar filtros
                </a>
            </div>
        @endif
    </form>

    {{-- ── FORMULARIO PRINCIPAL ── --}}
    <form method="POST" action="{{ route('asistencia.guardar') }}" id="formAsistencia">
        @csrf
        <input type="hidden" name="fecha" value="{{ $fecha }}">

        @foreach($personas as $persona)
            <input type="hidden" name="todos_ids[]" value="{{ $persona->id }}">
        @endforeach

        <div class="main-card">

            {{-- Toolbar --}}
            <div class="main-card-toolbar">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="pill-count" id="tagTotal">
                        <i class="bi bi-people-fill me-1"></i>
                        {{ $personas->count() }} personas
                    </span>
                    <button type="button" class="btn-action btn-action--solid" id="btnMarcarTodos">
                        <i class="bi bi-check2-all"></i> Marcar todos
                    </button>
                    <button type="button" class="btn-action btn-action--ghost" id="btnDesmarcarTodos">
                        <i class="bi bi-x-square"></i> Desmarcar
                    </button>
                </div>
                <button type="submit" class="btn-guardar">
                    <i class="bi bi-floppy2-fill me-1"></i>
                    {{ $esHoy ? 'Guardar asistencia' : 'Guardar cambios' }}
                </button>
            </div>

            @if($personas->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-person-x"></i>
                    <p>No hay personas con los filtros aplicados.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="asist-table" id="tablaPersonas">
                        <thead>
                            <tr>
                                <th class="col-check text-center">
                                    <i class="bi bi-check2-circle" title="Presente"></i>
                                </th>
                                <th>Persona</th>
                                <th class="d-none d-md-table-cell">DNI</th>
                                <th class="d-none d-xl-table-cell">Sede</th>
                                <th class="d-none d-xl-table-cell">Programas</th>
                                <th class="col-obs">Observaciones</th>
                                <th class="col-hist d-none d-md-table-cell text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($personas as $persona)
                                @php
                                    $reg          = $asistenciasDia->get($persona->id);
                                    $estaPresente = $reg ? $reg->presente : false;
                                    $obsActual    = $reg ? $reg->observaciones : '';
                                @endphp
                                <tr class="asist-row {{ $estaPresente ? 'is-presente' : '' }}"
                                    id="row-{{ $persona->id }}"
                                    data-nombre="{{ strtolower($persona->apellido . ' ' . $persona->nombre) }}">

                                    {{-- Checkbox --}}
                                    <td class="col-check text-center">
                                        <label class="check-label">
                                            <input type="checkbox"
                                                   class="asist-checkbox"
                                                   name="presentes[]"
                                                   value="{{ $persona->id }}"
                                                   data-persona-id="{{ $persona->id }}"
                                                   {{ $estaPresente ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>

                                    {{-- Persona --}}
                                    <td>
                                        <div class="persona-cell">
                                            <div class="persona-avatar">
                                                {{ strtoupper(substr($persona->nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($persona->apellido ?? '', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="persona-nombre">
                                                    {{ $persona->apellido }}, {{ $persona->nombre }}
                                                </div>
                                                <div class="persona-sub d-md-none">
                                                    DNI {{ $persona->dni ?? '—' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- DNI --}}
                                    <td class="td-muted d-none d-md-table-cell">
                                        {{ $persona->dni ?? '—' }}
                                    </td>

                                    {{-- Sede --}}
                                    <td class="d-none d-xl-table-cell">
                                        @if($persona->sedeOrigen)
                                            <span class="chip chip--sede">
                                                <i class="bi bi-geo-alt-fill"></i>
                                                {{ $persona->sedeOrigen->nombre }}
                                            </span>
                                        @else
                                            <span class="td-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- Programas --}}
                                    <td class="d-none d-xl-table-cell">
                                        @forelse($persona->programas->where('pivot.activo', 1) as $prog)
                                            <span class="chip chip--prog">{{ $prog->nombre }}</span>
                                        @empty
                                            <span class="td-muted">—</span>
                                        @endforelse
                                    </td>

                                    {{-- Observaciones --}}
                                    <td class="col-obs">
                                        <input type="text"
                                               name="observaciones[{{ $persona->id }}]"
                                               class="obs-field"
                                               id="obs-{{ $persona->id }}"
                                               value="{{ $obsActual }}"
                                               placeholder="Observación…"
                                               maxlength="255"
                                               {{ !$estaPresente ? 'disabled' : '' }}>
                                    </td>

                                    {{-- Historial --}}
                                    <td class="col-hist d-none d-md-table-cell text-center">
                                        <a href="{{ route('asistencia.historial', $persona->id) }}"
                                           class="btn-hist"
                                           title="Historial de {{ $persona->nombre }}">
                                            <i class="bi bi-clock-history"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>{{-- /main-card --}}

        {{-- Guardar sticky mobile --}}
        <div class="sticky-save d-md-none">
            <button type="submit" class="btn-guardar w-100">
                <i class="bi bi-floppy2-fill me-1"></i>Guardar asistencia
            </button>
        </div>

    </form>

</div>
@endsection

@push('styles')
<style>
/* ── Page header ── */
.page-icon-wrap {
    width:36px; height:36px; border-radius:10px;
    background:linear-gradient(135deg,#0d92c2,#17a385);
    display:flex; align-items:center; justify-content:center;
    color:white; font-size:16px; flex-shrink:0;
}
.page-title {
    font-family:'Plus Jakarta Sans',sans-serif;
    font-size:20px; font-weight:800; color:var(--neutral-800); line-height:1;
}
.page-subtitle {
    font-size:13px; color:var(--neutral-400); font-weight:500;
    display:flex; align-items:center; gap:4px; flex-wrap:wrap;
}
.badge-fecha-pasada {
    display:inline-flex; align-items:center;
    background:#fef9c3; color:#854d0e; border:1px solid #fde047;
    border-radius:20px; font-size:11px; font-weight:700; padding:2px 8px;
}
.link-hoy {
    color:var(--teal-500); font-weight:600; font-size:13px;
    text-decoration:none; display:inline-flex; align-items:center; gap:1px;
}
.link-hoy:hover { color:var(--teal-600); text-decoration:underline; }

/* ── Counter pill ── */
.counter-pill {
    display:flex; flex-direction:column; align-items:center;
    background:white; border:1.5px solid var(--teal-100);
    border-radius:16px; padding:10px 22px;
    box-shadow:0 2px 12px rgba(23,163,133,.1);
}
.counter-num-wrap { display:flex; align-items:baseline; gap:3px; line-height:1; }
.counter-num {
    font-family:'Plus Jakarta Sans',sans-serif;
    font-size:32px; font-weight:800; color:var(--teal-500);
    min-width:36px; text-align:right;
}
.counter-sep { font-size:22px; color:var(--neutral-300); font-weight:300; }
.counter-denom { font-size:22px; font-weight:600; color:var(--neutral-300); }
.counter-label {
    font-size:10.5px; font-weight:700; color:var(--neutral-400);
    text-transform:uppercase; letter-spacing:1px; margin-top:2px;
}

/* ── Alertas ── */
.alert-custom {
    display:flex; align-items:center; gap:10px; padding:11px 16px;
    border-radius:var(--radius-md); font-size:13.5px; font-weight:500;
    position:relative;
}
.alert-custom--success { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; }
.alert-custom--warning { background:#fef9c3; color:#713f12; border:1px solid #fde047; }
.alert-close {
    margin-left:auto; background:transparent; border:none; cursor:pointer;
    color:inherit; opacity:.6; font-size:13px; padding:0 2px;
    line-height:1; display:flex; align-items:center;
}
.alert-close:hover { opacity:1; }

/* ── Filtros ── */
.filter-label {
    display:flex; align-items:center; gap:5px;
    font-size:11.5px; font-weight:700; color:var(--neutral-500);
    text-transform:uppercase; letter-spacing:.7px; margin-bottom:5px;
}
.filter-label i { color:var(--teal-500); font-size:13px; }
.filter-input {
    display:block; width:100%;
    padding:7px 11px; font-size:13px; font-weight:500;
    color:var(--neutral-800); background:white;
    border:1.5px solid var(--neutral-200); border-radius:var(--radius-sm);
    transition:border-color .15s, box-shadow .15s;
    appearance:auto;
}
.filter-input:focus {
    outline:none; border-color:var(--teal-400);
    box-shadow:0 0 0 3px rgba(23,163,133,.12);
}
.btn-limpiar {
    display:inline-flex; align-items:center; gap:4px;
    background:transparent; border:1.5px solid var(--neutral-200);
    border-radius:var(--radius-sm); color:var(--neutral-500);
    font-size:12px; font-weight:600; padding:5px 12px;
    text-decoration:none; transition:background .15s, border-color .15s;
}
.btn-limpiar:hover { background:var(--neutral-100); border-color:var(--neutral-400); color:var(--neutral-700); }

/* ── Card principal ── */
.main-card {
    background:white; border-radius:var(--radius-lg);
    border:1px solid var(--neutral-200);
    box-shadow:0 2px 16px rgba(0,0,0,.06);
    overflow:hidden;
}
.main-card-toolbar {
    display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;
    padding:13px 18px; background:var(--neutral-50);
    border-bottom:1px solid var(--neutral-200);
}
.pill-count {
    display:inline-flex; align-items:center;
    background:white; border:1.5px solid var(--teal-100);
    color:var(--teal-700); border-radius:20px;
    font-size:12px; font-weight:700; padding:3px 10px;
}
.btn-action {
    display:inline-flex; align-items:center; gap:5px;
    border-radius:var(--radius-sm); font-size:12px; font-weight:600;
    padding:5px 11px; cursor:pointer; transition:all .15s; white-space:nowrap; border:none;
}
.btn-action--solid { background:var(--teal-500); color:white; }
.btn-action--solid:hover { background:var(--teal-600); }
.btn-action--ghost { background:transparent; border:1.5px solid var(--neutral-200) !important; color:var(--neutral-600); }
.btn-action--ghost:hover { background:var(--neutral-100); border-color:var(--neutral-400) !important; }
.btn-guardar {
    display:inline-flex; align-items:center;
    background:linear-gradient(135deg,#0d92c2,#17a385); color:white; border:none;
    border-radius:var(--radius-sm); font-size:13px; font-weight:700;
    padding:9px 22px; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif;
    box-shadow:0 2px 8px rgba(23,163,133,.3); transition:opacity .15s, transform .1s;
    white-space:nowrap;
}
.btn-guardar:hover { opacity:.9; transform:translateY(-1px); }
.btn-guardar:active { transform:translateY(0); }

/* ── Empty state ── */
.empty-state {
    text-align:center; padding:64px 20px; color:var(--neutral-300);
}
.empty-state i { font-size:48px; display:block; margin-bottom:14px; }
.empty-state p { font-size:14px; margin:0; color:var(--neutral-400); }

/* ── Tabla ── */
.asist-table { width:100%; border-collapse:collapse; }
.asist-table thead th {
    padding:9px 14px; font-size:11px; font-weight:700;
    text-transform:uppercase; letter-spacing:.9px;
    color:var(--neutral-400); background:var(--neutral-50);
    border-bottom:1.5px solid var(--neutral-200);
    white-space:nowrap;
}
.asist-table tbody td {
    padding:9px 14px; border-bottom:1px solid var(--neutral-100);
    vertical-align:middle;
}
.asist-table tbody tr:last-child td { border-bottom:none; }
.asist-row { transition:background .12s; }
.asist-row:hover td { background:var(--mint-50); }
.asist-row.is-presente td { background:#f0fdf9; }
.asist-row.is-presente:hover td { background:#dcfce7; }
.asist-row.row-hidden { display:none; }

.col-check { width:48px; }
.col-obs { min-width:160px; width:200px; }
.col-hist { width:40px; }
.td-muted { font-size:13px; color:var(--neutral-500); }

/* ── Persona cell ── */
.persona-cell { display:flex; align-items:center; gap:10px; }
.persona-avatar {
    width:34px; height:34px; border-radius:9px; flex-shrink:0;
    background:linear-gradient(135deg,#e6f5fb,#e8f9f5);
    border:1px solid var(--teal-100); color:var(--teal-600);
    font-size:11px; font-weight:800; display:flex; align-items:center; justify-content:center;
    font-family:'Plus Jakarta Sans',sans-serif;
}
.persona-nombre { font-size:13.5px; font-weight:600; color:var(--neutral-800); }
.persona-sub { font-size:11.5px; color:var(--neutral-400); margin-top:1px; }

/* ── Chips ── */
.chip {
    display:inline-flex; align-items:center; gap:4px;
    border-radius:20px; font-size:11.5px; font-weight:600;
    padding:2px 9px; white-space:nowrap;
}
.chip--sede { background:var(--sky-50); color:var(--sky-700); border:1px solid var(--sky-100); }
.chip--prog { background:var(--teal-50); color:var(--teal-700); border:1px solid var(--teal-100); margin-right:3px; }

/* ── Checkbox custom ── */
.check-label {
    display:inline-flex; align-items:center; justify-content:center;
    cursor:pointer; position:relative; width:28px; height:28px;
}
.asist-checkbox { position:absolute; opacity:0; width:0; height:0; }
.checkmark {
    width:22px; height:22px; border-radius:7px;
    border:2px solid var(--neutral-200); background:white;
    display:flex; align-items:center; justify-content:center;
    transition:all .15s;
}
.checkmark::after {
    content:''; width:5px; height:9px;
    border:2.5px solid white; border-top:none; border-left:none;
    transform:rotate(45deg) scale(0); transition:transform .12s ease; margin-top:-2px;
}
.asist-checkbox:checked ~ .checkmark {
    background:var(--teal-500); border-color:var(--teal-500);
    box-shadow:0 0 0 3px rgba(23,163,133,.15);
}
.asist-checkbox:checked ~ .checkmark::after { transform:rotate(45deg) scale(1); }
.check-label:hover .checkmark { border-color:var(--teal-400); }

/* ── Campo observación ── */
.obs-field {
    width:100%; border:1.5px solid var(--neutral-200); border-radius:var(--radius-sm);
    font-size:12.5px; padding:5px 9px; color:var(--neutral-800);
    background:white; font-family:'Nunito',sans-serif;
    transition:border-color .15s, background .15s;
}
.obs-field:focus { border-color:var(--teal-400); outline:none; box-shadow:0 0 0 3px rgba(23,163,133,.1); }
.obs-field:disabled { background:var(--neutral-100); color:var(--neutral-300); border-color:var(--neutral-100); cursor:not-allowed; }

/* ── Botón historial ── */
.btn-hist {
    width:30px; height:30px; border-radius:8px;
    background:var(--sky-50); color:var(--sky-600); border:1px solid var(--sky-100);
    display:inline-flex; align-items:center; justify-content:center;
    font-size:14px; text-decoration:none; transition:all .15s;
}
.btn-hist:hover { background:var(--sky-100); color:var(--sky-700); transform:scale(1.08); }

/* ── Sticky mobile ── */
.sticky-save {
    position:fixed; bottom:0; left:0; right:0;
    padding:12px 16px; background:white;
    border-top:1px solid var(--neutral-200);
    box-shadow:0 -4px 20px rgba(0,0,0,.08); z-index:1000;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes   = document.querySelectorAll('.asist-checkbox');
    const cntPresente  = document.getElementById('cntPresente');
    const cntTotal     = document.getElementById('cntTotal');
    const btnMarcar    = document.getElementById('btnMarcarTodos');
    const btnDesmarcar = document.getElementById('btnDesmarcarTodos');
    const inputBuscar  = document.getElementById('inputBuscar');

    function actualizarContador() {
        const visibles  = [...checkboxes].filter(c => !c.closest('tr').classList.contains('row-hidden'));
        cntPresente.textContent = visibles.filter(c => c.checked).length;
        cntTotal.textContent    = visibles.length;
    }

    function actualizarFila(cb) {
        const row = document.getElementById('row-' + cb.dataset.personaId);
        const obs = document.getElementById('obs-'  + cb.dataset.personaId);
        if (!row) return;
        row.classList.toggle('is-presente', cb.checked);
        if (obs) {
            obs.disabled = !cb.checked;
            if (!cb.checked) obs.value = '';
        }
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => { actualizarFila(cb); actualizarContador(); });
    });

    btnMarcar?.addEventListener('click', () => {
        checkboxes.forEach(cb => {
            if (!cb.closest('tr').classList.contains('row-hidden')) {
                cb.checked = true; actualizarFila(cb);
            }
        });
        actualizarContador();
    });

    btnDesmarcar?.addEventListener('click', () => {
        checkboxes.forEach(cb => {
            if (!cb.closest('tr').classList.contains('row-hidden')) {
                cb.checked = false; actualizarFila(cb);
            }
        });
        actualizarContador();
    });

    inputBuscar?.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('#tablaPersonas tbody tr').forEach(tr => {
            tr.classList.toggle('row-hidden', q !== '' && !tr.dataset.nombre?.includes(q));
        });
        actualizarContador();
    });

    actualizarContador();
});
</script>
@endpush