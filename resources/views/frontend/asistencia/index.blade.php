@extends('frontend.layout.front')

@section('title', 'Asistencia')

@section('content')
<style>
.asi-page {
    padding: 28px 24px 80px;
    max-width: 1400px;
    margin: 0 auto;
}

/* ── Header ── */
.asi-header {
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap;
    gap: 16px; margin-bottom: 24px;
}
.asi-header-left { display: flex; align-items: center; gap: 14px; }
.asi-icon {
    width: 46px; height: 46px; border-radius: 13px;
    background: var(--grad-main);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 20px; flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(13,146,194,.28);
}
.asi-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 22px; font-weight: 800; color: var(--neutral-800);
    margin: 0; line-height: 1.1; letter-spacing: -.3px;
}
.asi-subtitle {
    font-size: 13px; color: var(--neutral-400); font-weight: 500;
    display: flex; align-items: center; gap: 8px;
    flex-wrap: wrap; margin: 4px 0 0;
}
.asi-badge-warn {
    display: inline-flex; align-items: center; gap: 4px;
    background: #fef3c7; color: #92400e;
    border: 1px solid #fcd34d; border-radius: 20px;
    font-size: 11px; font-weight: 700; padding: 3px 9px;
}
.asi-link-today {
    display: inline-flex; align-items: center; gap: 4px;
    color: var(--teal-500); font-weight: 600; font-size: 13px; text-decoration: none;
}
.asi-link-today:hover { color: var(--teal-600); text-decoration: underline; }

/* ── Counter ── */
.asi-counter {
    display: flex; flex-direction: column; align-items: center;
    background: white; border: 1.5px solid var(--teal-100);
    border-radius: var(--radius-lg); padding: 12px 28px;
    box-shadow: var(--shadow-sm);
}
.asi-counter-nums { display: flex; align-items: baseline; gap: 3px; line-height: 1; }
.asi-counter-n {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 38px; font-weight: 800; color: var(--teal-500);
    min-width: 40px; text-align: right;
}
.asi-counter-sep { font-size: 24px; color: var(--neutral-400); font-weight: 300; }
.asi-counter-d { font-size: 24px; font-weight: 600; color: var(--neutral-400); }
.asi-counter-lbl {
    font-size: 10px; font-weight: 700; color: var(--neutral-400);
    text-transform: uppercase; letter-spacing: 1.3px; margin-top: 4px;
}

/* ── Alerts ── */
.asi-alert {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px; border-radius: var(--radius-md);
    font-size: 13.5px; font-weight: 500;
}
.asi-alert--ok  { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.asi-alert--warn{ background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
.asi-alert-close {
    margin-left: auto; background: none; border: none;
    cursor: pointer; color: inherit; opacity: .6; font-size: 12px;
}
.asi-alert-close:hover { opacity: 1; }

/* ── Filters ── */
.asi-filters {
    background: white; border: 1px solid var(--neutral-200);
    border-radius: var(--radius-md); padding: 18px 20px;
    margin-bottom: 20px; box-shadow: var(--shadow-sm);
}
.asi-filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 14px;
}
.asi-field { display: flex; flex-direction: column; }
.asi-label {
    display: flex; align-items: center; gap: 5px;
    font-size: 11px; font-weight: 700; color: var(--neutral-600);
    text-transform: uppercase; letter-spacing: .9px; margin-bottom: 6px;
}
.asi-label i { color: var(--teal-500); font-size: 12px; }
.asi-input {
    padding: 8px 12px; font-size: 13.5px; font-weight: 500;
    color: var(--neutral-800); background: var(--neutral-50);
    border: 1.5px solid var(--neutral-200); border-radius: var(--radius-sm);
    transition: border-color .15s, box-shadow .15s;
    width: 100%; font-family: 'Nunito', sans-serif;
}
.asi-input:focus {
    outline: none; border-color: var(--teal-400); background: white;
    box-shadow: 0 0 0 3px rgba(23,163,133,.12);
}
.asi-btn-clear {
    display: inline-flex; align-items: center; gap: 5px;
    border: 1.5px solid var(--neutral-200); border-radius: var(--radius-sm);
    color: var(--neutral-600); font-size: 12px; font-weight: 600;
    padding: 5px 14px; text-decoration: none; transition: all .15s; background: transparent;
}
.asi-btn-clear:hover { background: var(--neutral-100); color: var(--neutral-800); border-color: var(--neutral-400); }

/* ── Card ── */
.asi-card {
    background: white; border-radius: var(--radius-lg);
    border: 1px solid var(--neutral-200);
    box-shadow: var(--shadow-md); overflow: hidden;
}
.asi-toolbar {
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 10px;
    padding: 14px 20px;
    background: var(--neutral-50);
    border-bottom: 1px solid var(--neutral-200);
}
.asi-toolbar-left { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.asi-count-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: white; border: 1.5px solid var(--teal-100);
    color: var(--teal-600); border-radius: 20px;
    font-size: 12.5px; font-weight: 700; padding: 4px 14px;
}
.asi-btn {
    display: inline-flex; align-items: center; gap: 6px;
    border-radius: var(--radius-sm); font-size: 12.5px; font-weight: 600;
    padding: 7px 14px; cursor: pointer; transition: all .15s;
    white-space: nowrap; border: none; font-family: 'Nunito', sans-serif;
}
.asi-btn--fill { background: var(--teal-500); color: white; }
.asi-btn--fill:hover { background: var(--teal-600); }
.asi-btn--ghost {
    background: transparent; color: var(--neutral-600);
    border: 1.5px solid var(--neutral-200) !important;
}
.asi-btn--ghost:hover { background: var(--neutral-100); border-color: var(--neutral-400) !important; }
.asi-save {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--grad-main); color: white; border: none;
    border-radius: var(--radius-md); font-size: 13.5px; font-weight: 700;
    padding: 10px 24px; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
    box-shadow: 0 4px 14px rgba(13,146,194,.3);
    transition: opacity .15s, transform .12s;
    letter-spacing: -.1px; white-space: nowrap;
}
.asi-save:hover { opacity: .9; transform: translateY(-1px); }
.asi-save:active { transform: none; }

/* ── Empty ── */
.asi-empty { text-align: center; padding: 80px 20px; }
.asi-empty i { font-size: 52px; color: var(--neutral-200); display: block; margin-bottom: 14px; }
.asi-empty p { font-size: 14px; color: var(--neutral-400); margin: 0; }

/* ── Table ── */
.asi-table { width: 100%; border-collapse: collapse; }
.asi-table thead th {
    padding: 10px 16px; font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1px;
    color: var(--neutral-400); background: var(--neutral-50);
    border-bottom: 1.5px solid var(--neutral-200); white-space: nowrap;
}
.asi-table tbody td { padding: 11px 16px; border-bottom: 1px solid var(--neutral-100); vertical-align: middle; }
.asi-table tbody tr:last-child td { border-bottom: none; }
.asi-row { transition: background .1s; }
.asi-row:hover td { background: var(--mint-50); }
.asi-row--on td { background: var(--mint-50); }
.asi-row--on:hover td { background: var(--mint-100); }
.asi-row.row-hidden { display: none; }

.asi-th-chk { width: 52px; text-align: center; }
.asi-th-obs { min-width: 180px; width: 220px; }
.asi-th-hist { width: 46px; text-align: center; }
.asi-muted { font-size: 13px; color: var(--neutral-400); }

/* ── Persona ── */
.asi-persona { display: flex; align-items: center; gap: 12px; }
.asi-avatar {
    width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
    background: var(--grad-soft); border: 1px solid var(--teal-100);
    color: var(--teal-600); font-size: 11px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.asi-name { font-size: 13.5px; font-weight: 600; color: var(--neutral-800); }
.asi-dni-mob { font-size: 11.5px; color: var(--neutral-400); margin-top: 1px; }

/* ── Chips ── */
.asi-chip {
    display: inline-flex; align-items: center; gap: 4px;
    border-radius: 20px; font-size: 11.5px; font-weight: 600;
    padding: 3px 10px; white-space: nowrap;
}
.asi-chip--sky  { background: var(--sky-50);  color: var(--sky-600);  border: 1px solid var(--sky-100); }
.asi-chip--teal { background: var(--teal-50); color: var(--teal-600); border: 1px solid var(--teal-100); margin-right: 3px; }

/* ── Checkbox ── */
.asi-chk-wrap {
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer; width: 32px; height: 32px;
}
.asist-checkbox { position: absolute; opacity: 0; width: 0; height: 0; }
.asi-checkmark {
    width: 24px; height: 24px; border-radius: 7px;
    border: 2px solid var(--neutral-200); background: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: transparent; transition: all .15s;
}
.asist-checkbox:checked ~ .asi-checkmark {
    background: var(--teal-500); border-color: var(--teal-500);
    color: white; box-shadow: 0 0 0 3px rgba(23,163,133,.15);
}
.asi-chk-wrap:hover .asi-checkmark { border-color: var(--teal-400); }

/* ── Observacion ── */
.asi-obs {
    width: 100%; border: 1.5px solid var(--neutral-200);
    border-radius: var(--radius-sm); font-size: 12.5px;
    padding: 6px 10px; color: var(--neutral-800);
    background: white; font-family: 'Nunito', sans-serif;
    transition: border-color .15s;
}
.asi-obs:focus { border-color: var(--teal-400); outline: none; box-shadow: 0 0 0 3px rgba(23,163,133,.1); }
.asi-obs:disabled { background: var(--neutral-50); color: var(--neutral-400); border-color: var(--neutral-100); cursor: not-allowed; }

/* ── Hist btn ── */
.asi-hist-btn {
    width: 32px; height: 32px; border-radius: 9px;
    background: var(--sky-50); color: var(--sky-500);
    border: 1px solid var(--sky-100);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 15px; text-decoration: none; transition: all .15s;
}
.asi-hist-btn:hover { background: var(--sky-100); transform: scale(1.1); }

/* ── Sticky mobile ── */
.asi-sticky {
    position: fixed; bottom: 0; left: 0; right: 0;
    padding: 12px 16px; background: white;
    border-top: 1px solid var(--neutral-200);
    box-shadow: 0 -4px 24px rgba(0,0,0,.1); z-index: 1000;
}

@media (max-width: 600px) {
    .asi-page { padding: 16px 14px 80px; }
    .asi-counter-n { font-size: 28px; }
    .asi-counter-d { font-size: 20px; }
}
</style>

<div class="asi-page">

    {{-- ── HEADER ── --}}
    <div class="asi-header">
        <div class="asi-header-left">
            <div class="asi-icon">
                <i class="bi bi-calendar-check-fill" style="pointer-events:none"></i>
            </div>
            <div>
                <h1 class="asi-title">Asistencia</h1>
                <p class="asi-subtitle">
                    @if(!$esHoy)
                        <span class="asi-badge-warn">
                            <i class="bi bi-clock-history" style="pointer-events:none"></i> Fecha pasada
                        </span>
                    @endif
                    {{ \Carbon\Carbon::parse($fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}
                    @if(!$esHoy)
                        <a href="{{ route('asistencia.index') }}" class="asi-link-today">
                            <i class="bi bi-arrow-counterclockwise" style="pointer-events:none"></i> Volver a hoy
                        </a>
                    @endif
                </p>
            </div>
        </div>

        <div class="asi-counter" id="counterBox">
            <div class="asi-counter-nums">
                <span class="asi-counter-n" id="cntPresente">0</span>
                <span class="asi-counter-sep">/</span>
                <span class="asi-counter-d" id="cntTotal">0</span>
            </div>
            <span class="asi-counter-lbl">presentes hoy</span>
        </div>
    </div>

    {{-- ── ALERTAS ── --}}
    @if(session('success'))
        <div class="asi-alert asi-alert--ok mb-3" role="alert">
            <i class="bi bi-check-circle-fill" style="pointer-events:none"></i>
            <span>{{ session('success') }}</span>
            <button class="asi-alert-close" data-bs-dismiss="alert"><i class="bi bi-x-lg" style="pointer-events:none"></i></button>
        </div>
    @endif
    @if(session('warning'))
        <div class="asi-alert asi-alert--warn mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill" style="pointer-events:none"></i>
            <span>{{ session('warning') }}</span>
            <button class="asi-alert-close" data-bs-dismiss="alert"><i class="bi bi-x-lg" style="pointer-events:none"></i></button>
        </div>
    @endif

    {{-- ── FILTROS ── --}}
    <form method="GET" action="{{ route('asistencia.index') }}" id="formFiltros" class="asi-filters">
        <div class="asi-filters-grid">
            <div class="asi-field">
                <label class="asi-label"><i class="bi bi-calendar3" style="pointer-events:none"></i> Fecha</label>
                <input type="date" name="fecha" class="asi-input"
                       value="{{ $fecha }}"
                       max="{{ \Carbon\Carbon::today()->toDateString() }}"
                       onchange="this.form.submit()">
            </div>
            <div class="asi-field">
                <label class="asi-label"><i class="bi bi-geo-alt" style="pointer-events:none"></i> Sede</label>
                <select name="sede_id" class="asi-input" onchange="this.form.submit()">
                    <option value="">Todas las sedes</option>
                    @foreach($sedes as $sede)
                        <option value="{{ $sede->id }}" {{ $sedeId == $sede->id ? 'selected' : '' }}>{{ $sede->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="asi-field">
                <label class="asi-label"><i class="bi bi-collection" style="pointer-events:none"></i> Programa</label>
                <select name="programa_id" class="asi-input" onchange="this.form.submit()">
                    <option value="">Todos los programas</option>
                    @foreach($programas as $prog)
                        <option value="{{ $prog->id }}" {{ $programaId == $prog->id ? 'selected' : '' }}>{{ $prog->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="asi-field">
                <label class="asi-label"><i class="bi bi-search" style="pointer-events:none"></i> Buscar</label>
                <input type="text" id="inputBuscar" class="asi-input" placeholder="Nombre o apellido…" autocomplete="off">
            </div>
        </div>
        @if($sedeId || $programaId || $fecha !== \Carbon\Carbon::today()->toDateString())
            <div style="margin-top:10px">
                <a href="{{ route('asistencia.index') }}" class="asi-btn-clear">
                    <i class="bi bi-x-circle" style="pointer-events:none"></i> Limpiar filtros
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

        <div class="asi-card">
            <div class="asi-toolbar">
                <div class="asi-toolbar-left">
                    <span class="asi-count-pill">
                        <i class="bi bi-people-fill" style="pointer-events:none"></i>
                        {{ $personas->count() }} personas
                    </span>
                    <button type="button" class="asi-btn asi-btn--fill" id="btnMarcarTodos">
                        <i class="bi bi-check2-all" style="pointer-events:none"></i> Marcar todos
                    </button>
                    <button type="button" class="asi-btn asi-btn--ghost" id="btnDesmarcarTodos">
                        <i class="bi bi-x-square" style="pointer-events:none"></i> Desmarcar
                    </button>
                </div>
                <button type="submit" class="asi-save d-none d-md-inline-flex">
                    <i class="bi bi-floppy2-fill" style="pointer-events:none"></i>
                    {{ $esHoy ? 'Guardar asistencia' : 'Guardar cambios' }}
                </button>
            </div>

            @if($personas->isEmpty())
                <div class="asi-empty">
                    <i class="bi bi-person-slash"></i>
                    <p>No hay personas con los filtros aplicados.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="asi-table" id="tablaPersonas">
                        <thead>
                            <tr>
                                <th class="asi-th-chk"><i class="bi bi-check2-circle" style="pointer-events:none"></i></th>
                                <th>Persona</th>
                                <th class="d-none d-md-table-cell">DNI</th>
                                <th class="d-none d-xl-table-cell">Sede</th>
                                <th class="d-none d-xl-table-cell">Programas</th>
                                <th class="asi-th-obs">Observaciones</th>
                                <th class="asi-th-hist d-none d-md-table-cell"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($personas as $persona)
                                @php
                                    $reg          = $asistenciasDia->get($persona->id);
                                    $estaPresente = $reg ? $reg->presente : false;
                                    $obsActual    = $reg ? $reg->observaciones : '';
                                @endphp
                                <tr class="asi-row {{ $estaPresente ? 'asi-row--on' : '' }}"
                                    id="row-{{ $persona->id }}"
                                    data-nombre="{{ strtolower($persona->apellido . ' ' . $persona->nombre) }}">

                                    <td class="asi-th-chk">
                                        <label class="asi-chk-wrap">
                                            <input type="checkbox"
                                                   class="asist-checkbox"
                                                   name="presentes[]"
                                                   value="{{ $persona->id }}"
                                                   data-persona-id="{{ $persona->id }}"
                                                   {{ $estaPresente ? 'checked' : '' }}>
                                            <span class="asi-checkmark">
                                                <i class="bi bi-check" style="pointer-events:none"></i>
                                            </span>
                                        </label>
                                    </td>

                                    <td>
                                        <div class="asi-persona">
                                            <div class="asi-avatar">
                                                {{ strtoupper(substr($persona->nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($persona->apellido ?? '', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="asi-name">{{ $persona->apellido }}, {{ $persona->nombre }}</div>
                                                <div class="asi-dni-mob d-md-none">DNI {{ $persona->dni ?? '—' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="asi-muted d-none d-md-table-cell">{{ $persona->dni ?? '—' }}</td>

                                    <td class="d-none d-xl-table-cell">
                                        @php
                                            $programaActivo = $persona->personaPrograma
                                                ->where('activo', 1)
                                                ->when($programaId, function ($collection) use ($programaId) {
                                                    return $collection->where('programa_id', $programaId);
                                                })
                                                ->first();
                                        @endphp

                                        @if($programaActivo?->sede)
                                            <span class="asi-chip asi-chip--sky">
                                                <i class="bi bi-geo-alt-fill"></i>
                                                {{ $programaActivo->sede->nombre }}
                                            </span>
                                        @else
                                            <span class="asi-muted">—</span>
                                        @endif
                                    </td>

                                    <td class="d-none d-xl-table-cell">
                                        @forelse($persona->programas->where('pivot.activo', 1) as $prog)
                                            <span class="asi-chip asi-chip--teal">{{ $prog->nombre }}</span>
                                        @empty
                                            <span class="asi-muted">—</span>
                                        @endforelse
                                    </td>

                                    <td class="asi-th-obs">
                                        <input type="text"
                                               name="observaciones[{{ $persona->id }}]"
                                               class="asi-obs"
                                               id="obs-{{ $persona->id }}"
                                               value="{{ $obsActual }}"
                                               placeholder="Agregar observación…"
                                               maxlength="255"
                                               {{ !$estaPresente ? 'disabled' : '' }}>
                                    </td>

                                    <td class="asi-th-hist d-none d-md-table-cell">
                                        <a href="{{ route('asistencia.historial', $persona->id) }}" class="asi-hist-btn" title="Ver historial">
                                            <i class="bi bi-clock-history" style="pointer-events:none"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="asi-sticky d-md-none">
            <button type="submit" class="asi-save w-100">
                <i class="bi bi-floppy2-fill" style="pointer-events:none"></i> Guardar asistencia
            </button>
        </div>
    </form>
</div>
@endsection



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
        const visibles = [...checkboxes].filter(c => !c.closest('tr').classList.contains('row-hidden'));
        cntPresente.textContent = visibles.filter(c => c.checked).length;
        cntTotal.textContent    = visibles.length;
    }
    function actualizarFila(cb) {
        const row = document.getElementById('row-' + cb.dataset.personaId);
        const obs = document.getElementById('obs-'  + cb.dataset.personaId);
        if (!row) return;
        row.classList.toggle('asi-row--on', cb.checked);
        if (obs) { obs.disabled = !cb.checked; if (!cb.checked) obs.value = ''; }
    }
    checkboxes.forEach(cb => cb.addEventListener('change', () => { actualizarFila(cb); actualizarContador(); }));
    btnMarcar?.addEventListener('click', () => {
        checkboxes.forEach(cb => { if (!cb.closest('tr').classList.contains('row-hidden')) { cb.checked = true; actualizarFila(cb); } });
        actualizarContador();
    });
    btnDesmarcar?.addEventListener('click', () => {
        checkboxes.forEach(cb => { if (!cb.closest('tr').classList.contains('row-hidden')) { cb.checked = false; actualizarFila(cb); } });
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
