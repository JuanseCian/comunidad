@extends('frontend.layout.front')

@section('title', 'Historial — ' . $persona->apellido . ', ' . $persona->nombre)

@section('content')
<style>
.hi-page {
    padding: 28px 24px 60px;
    max-width: 960px;
    margin: 0 auto;
}

/* ── Header ── */
.hi-header {
    display: flex; align-items: center; gap: 14px;
    flex-wrap: wrap; margin-bottom: 24px;
}
.hi-back {
    width: 40px; height: 40px; border-radius: 11px;
    background: white; border: 1.5px solid var(--neutral-200);
    color: var(--neutral-600); display: inline-flex;
    align-items: center; justify-content: center;
    font-size: 17px; text-decoration: none; flex-shrink: 0;
    box-shadow: var(--shadow-sm); transition: all .15s;
}
.hi-back:hover { background: var(--neutral-100); color: var(--neutral-800); }
.hi-avatar {
    width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
    background: var(--grad-soft); border: 1.5px solid var(--teal-100);
    color: var(--teal-600); font-size: 16px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Plus Jakarta Sans', sans-serif;
    box-shadow: var(--shadow-sm);
}
.hi-name {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 19px; font-weight: 800; color: var(--neutral-800);
    margin: 0; letter-spacing: -.2px;
}
.hi-meta {
    font-size: 13px; color: var(--neutral-400);
    display: flex; align-items: center; gap: 7px;
    flex-wrap: wrap; margin: 3px 0 0;
}
.hi-sep { color: var(--neutral-200); }
.hi-chip {
    display: inline-flex; align-items: center; gap: 4px;
    border-radius: 20px; font-size: 11.5px; font-weight: 600; padding: 2px 10px;
}
.hi-chip--sky { background: var(--sky-50); color: var(--sky-600); border: 1px solid var(--sky-100); }

/* ── % ring ── */
.hi-pct {
    display: flex; align-items: center; gap: 14px;
    background: white; border: 1.5px solid var(--teal-100);
    border-radius: var(--radius-lg); padding: 12px 20px;
    box-shadow: var(--shadow-sm);
}
.hi-pct-ring {
    width: 62px; height: 62px; border-radius: 50%; flex-shrink: 0;
    background: conic-gradient(var(--teal-500) calc(var(--pct) * 1%), var(--neutral-100) 0);
    display: flex; align-items: center; justify-content: center; position: relative;
}
.hi-pct-ring::before {
    content: ''; position: absolute; inset: 9px;
    border-radius: 50%; background: white;
}
.hi-pct-num {
    position: relative; z-index: 1;
    font-size: 12px; font-weight: 800; color: var(--teal-600);
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.hi-pct-info {
    display: flex; flex-direction: column;
    font-size: 14px; font-weight: 700; color: var(--neutral-800); line-height: 1.5;
}
.hi-pct-sub { font-size: 11px; color: var(--neutral-400); font-weight: 500; }

/* ── Period bar ── */
.hi-period {
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    background: white; border: 1px solid var(--neutral-200);
    border-radius: var(--radius-md); padding: 12px 18px;
    margin-bottom: 20px; box-shadow: var(--shadow-sm);
}
.hi-period-lbl {
    display: flex; align-items: center; gap: 5px;
    font-size: 11px; font-weight: 700; color: var(--neutral-600);
    text-transform: uppercase; letter-spacing: .9px;
}
.hi-period-lbl i { color: var(--teal-500); }
.hi-period-sel {
    padding: 7px 12px; font-size: 13px; font-weight: 500;
    background: var(--neutral-50); border: 1.5px solid var(--neutral-200);
    border-radius: var(--radius-sm); color: var(--neutral-800); font-family: 'Nunito', sans-serif;
    transition: border-color .15s, box-shadow .15s;
}
.hi-period-sel:focus { outline: none; border-color: var(--teal-400); box-shadow: 0 0 0 3px rgba(23,163,133,.1); }

/* ── Calendar ── */
.hi-cal {
    background: white; border-radius: var(--radius-lg);
    border: 1px solid var(--neutral-200); box-shadow: var(--shadow-md);
    overflow: hidden; margin-bottom: 20px;
}
.hi-cal-head {
    padding: 14px 22px; background: var(--neutral-50);
    border-bottom: 1px solid var(--neutral-200);
    font-weight: 700; font-size: 14.5px; color: var(--neutral-800);
    font-family: 'Plus Jakarta Sans', sans-serif;
    display: flex; align-items: center; gap: 8px;
}
.hi-cal-body { padding: 18px; }
.hi-cal-grid { display: grid; grid-template-columns: repeat(7,1fr); gap: 5px; }
.hi-cal-dname {
    text-align: center; font-size: 11px; font-weight: 700;
    color: var(--neutral-400); text-transform: uppercase;
    letter-spacing: .8px; padding: 2px 0 10px;
}
.hi-cell {
    aspect-ratio: 1; border-radius: 11px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    position: relative; font-size: 13px; font-weight: 600;
    transition: transform .1s;
}
.hi-cell:not(.hi-cell--empty):not(.hi-cell--futuro):hover { transform: scale(1.08); }
.hi-cell-n { line-height: 1; }
.hi-cell-ico { font-size: 11px; margin-top: 2px; }
.hi-cell--empty, .hi-cell--futuro { background: transparent; color: var(--neutral-200); }
.hi-cell--vacio   { background: var(--neutral-100); color: var(--neutral-400); }
.hi-cell--presente { background: #d1fae5; color: #065f46; }
.hi-cell--ausente  { background: #fee2e2; color: #9f1239; }
.hi-cell--hoy { outline: 2.5px solid var(--teal-400); outline-offset: 1px; }
.hi-cell-obs { position: absolute; top: 3px; right: 4px; font-size: 9px; color: var(--sky-500); }

/* ── Legend ── */
.hi-legend {
    display: flex; gap: 18px; flex-wrap: wrap;
    padding: 12px 22px; border-top: 1px solid var(--neutral-100);
    font-size: 12px; font-weight: 600; color: var(--neutral-600);
}
.hi-leg-item { display: flex; align-items: center; gap: 6px; }
.hi-dot { display: inline-block; width: 12px; height: 12px; border-radius: 4px; }
.hi-dot--presente { background: #d1fae5; border: 1px solid #a7f3d0; }
.hi-dot--ausente  { background: #fee2e2; border: 1px solid #fca5a5; }
.hi-dot--vacio    { background: var(--neutral-100); border: 1px solid var(--neutral-200); }

/* ── List ── */
.hi-list {
    background: white; border-radius: var(--radius-lg);
    border: 1px solid var(--neutral-200); box-shadow: var(--shadow-md); overflow: hidden;
}
.hi-list-head {
    padding: 14px 22px; background: var(--neutral-50);
    border-bottom: 1px solid var(--neutral-200);
    font-weight: 700; font-size: 14.5px; color: var(--neutral-800);
    font-family: 'Plus Jakarta Sans', sans-serif;
    display: flex; align-items: center; gap: 8px;
}
.hi-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.hi-table thead th {
    padding: 10px 20px; font-size: 11px; text-transform: uppercase;
    letter-spacing: 1px; color: var(--neutral-400);
    background: var(--neutral-50); font-weight: 700;
    border-bottom: 1.5px solid var(--neutral-200);
}
.hi-table tbody td { padding: 11px 20px; border-bottom: 1px solid var(--neutral-100); vertical-align: middle; }
.hi-table tbody tr:last-child td { border-bottom: none; }
.hi-table tbody tr:hover td { background: var(--neutral-50); }
.hi-td-fecha { font-weight: 600; color: var(--neutral-600); text-transform: capitalize; }
.hi-td-obs { color: var(--neutral-400); }
.hi-estado {
    display: inline-flex; align-items: center; gap: 5px;
    border-radius: 20px; font-size: 12px; font-weight: 600; padding: 3px 10px;
}
.hi-estado--ok { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.hi-estado--no { background: #fee2e2; color: #9f1239; border: 1px solid #fca5a5; }

@media (max-width: 600px) {
    .hi-page { padding: 16px 14px 40px; }
    .hi-pct { width: 100%; }
    .hi-cal-body { padding: 10px; }
    .hi-cal-grid { gap: 3px; }
}
</style>

<div class="hi-page">

    {{-- ── HEADER ── --}}
    <div class="hi-header">
        <a href="{{ route('asistencia.index') }}" class="hi-back" title="Volver">
            <i class="bi bi-arrow-left" style="pointer-events:none"></i>
        </a>
        <div class="hi-avatar">
            {{ strtoupper(substr($persona->nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($persona->apellido ?? '', 0, 1)) }}
        </div>
        <div class="hi-header-info">
            <h1 class="hi-name">{{ $persona->apellido }}, {{ $persona->nombre }}</h1>
            <p class="hi-meta">
                <span>DNI {{ $persona->dni ?? '—' }}</span>
                @if($persona->sedeOrigen)
                    <span class="hi-sep">·</span>
                    <span class="hi-chip hi-chip--sky">
                        <i class="bi bi-geo-alt-fill" style="pointer-events:none"></i>
                        {{ $persona->sedeOrigen->nombre }}
                    </span>
                @endif
            </p>
        </div>
        <div class="hi-pct ms-auto">
            <div class="hi-pct-ring" style="--pct:{{ $porcentaje }}">
                <span class="hi-pct-num">{{ $porcentaje }}%</span>
            </div>
            <div class="hi-pct-info">
                <strong>{{ $presentes }}</strong> / {{ $totalDias }} días
                <span class="hi-pct-sub">presente este mes</span>
            </div>
        </div>
    </div>

    {{-- ── PERIODO ── --}}
    <form method="GET" action="{{ route('asistencia.historial', $persona->id) }}" class="hi-period">
        <label class="hi-period-lbl"><i class="bi bi-calendar3" style="pointer-events:none"></i> Período</label>
        <select name="mes" class="hi-period-sel" onchange="this.form.submit()">
            @foreach($mesesDisponibles as $m)
                <option value="{{ $m['mes'] }}" {{ ($mes == $m['mes'] && $anio == $m['anio']) ? 'selected' : '' }}>
                    {{ $m['label'] }}
                </option>
            @endforeach
        </select>
        <input type="hidden" name="anio" value="{{ $anio }}">
    </form>

    {{-- ── CALENDARIO ── --}}
    <div class="hi-cal">
        <div class="hi-cal-head">
            <i class="bi bi-calendar-week" style="pointer-events:none"></i>
            {{ ucfirst(\Carbon\Carbon::createFromDate($anio, $mes, 1)->translatedFormat('F Y')) }}
        </div>
        <div class="hi-cal-body">
            <div class="hi-cal-grid">
                @foreach(['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'] as $d)
                    <div class="hi-cal-dname">{{ $d }}</div>
                @endforeach

                @php
                    $primerDia = \Carbon\Carbon::createFromDate($anio, $mes, 1);
                    $offset    = $primerDia->dayOfWeekIso - 1;
                    $hoyStr    = \Carbon\Carbon::today()->toDateString();
                @endphp
                @for($i = 0; $i < $offset; $i++)
                    <div class="hi-cell hi-cell--empty"></div>
                @endfor

                @foreach($diasDelMes as $dia)
                    @php
                        $dStr   = $dia->toDateString();
                        $reg    = $asistencias->get($dStr);
                        $futuro = $dStr > $hoyStr;
                        $esHoy  = $dStr === $hoyStr;
                        if ($futuro)            $st = 'futuro';
                        elseif (!$reg)          $st = 'vacio';
                        elseif ($reg->presente) $st = 'presente';
                        else                    $st = 'ausente';
                    @endphp
                    <div class="hi-cell hi-cell--{{ $st }}{{ $esHoy ? ' hi-cell--hoy' : '' }}"
                         title="{{ ($st === 'presente' && $reg->observaciones) ? $reg->observaciones : '' }}">
                        <span class="hi-cell-n">{{ $dia->day }}</span>
                        @if($st === 'presente')
                            <i class="bi bi-check2 hi-cell-ico" style="pointer-events:none"></i>
                            @if($reg->observaciones)
                                <i class="bi bi-chat-dots hi-cell-obs" style="pointer-events:none"></i>
                            @endif
                        @elseif($st === 'ausente')
                            <i class="bi bi-x hi-cell-ico" style="pointer-events:none"></i>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="hi-legend">
            <span class="hi-leg-item"><span class="hi-dot hi-dot--presente"></span>Presente</span>
            <span class="hi-leg-item"><span class="hi-dot hi-dot--ausente"></span>Ausente</span>
            <span class="hi-leg-item"><span class="hi-dot hi-dot--vacio"></span>Sin registro</span>
            <span class="hi-leg-item"><i class="bi bi-chat-dots" style="font-size:11px;color:var(--sky-500)"></i>&nbsp;Con observación</span>
        </div>
    </div>

    {{-- ── LISTA ── --}}
    @if($asistencias->count())
    <div class="hi-list">
        <div class="hi-list-head">
            <i class="bi bi-list-ul" style="pointer-events:none"></i> Detalle de registros
        </div>
        <div class="table-responsive">
            <table class="hi-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asistencias->sortByDesc('fecha') as $reg)
                    <tr>
                        <td class="hi-td-fecha">
                            {{ \Carbon\Carbon::parse($reg->fecha)->translatedFormat('l j \d\e F') }}
                        </td>
                        <td>
                            @if($reg->presente)
                                <span class="hi-estado hi-estado--ok">
                                    <i class="bi bi-check-circle-fill" style="pointer-events:none"></i> Presente
                                </span>
                            @else
                                <span class="hi-estado hi-estado--no">
                                    <i class="bi bi-x-circle-fill" style="pointer-events:none"></i> Ausente
                                </span>
                            @endif
                        </td>
                        <td class="hi-td-obs">{{ $reg->observaciones ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection

@push('styles')

@endpush
