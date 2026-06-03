@extends('frontend.layout.front')

@section('title', 'Historial — ' . $persona->apellido . ', ' . $persona->nombre)

@section('content')

<div class="container-fluid px-3 px-md-4 py-4">

    {{-- ── ENCABEZADO ── --}}
    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
        <a href="{{ route('asistencia.index') }}" class="hist-btn-back">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="hist-avatar-lg">
            {{ strtoupper(substr($persona->nombre ?? 'P', 0, 1)) }}{{ strtoupper(substr($persona->apellido ?? '', 0, 1)) }}
        </div>
        <div>
            <h4 class="mb-0 fw-700" style="font-family:'Plus Jakarta Sans',sans-serif; color:var(--neutral-800);">
                {{ $persona->apellido }}, {{ $persona->nombre }}
            </h4>
            <p class="mb-0 mt-1" style="font-size:13px; color:var(--neutral-400);">
                DNI {{ $persona->dni ?? '—' }}
                @if($persona->sedeOrigen)
                    &nbsp;·&nbsp;
                    <span class="asist-badge asist-badge--sede" style="font-size:11px;">
                        <i class="bi bi-geo-alt-fill"></i> {{ $persona->sedeOrigen->nombre }}
                    </span>
                @endif
            </p>
        </div>

        {{-- Resumen porcentaje --}}
        <div class="hist-pct-box ms-auto">
            <div class="hist-pct-circle" style="--pct: {{ $porcentaje }};">
                <span class="hist-pct-num">{{ $porcentaje }}%</span>
            </div>
            <div class="hist-pct-label">
                <strong>{{ $presentes }}</strong> / {{ $totalDias }} días
                <br><span style="font-size:11px; color:var(--neutral-400);">presente este mes</span>
            </div>
        </div>
    </div>

    {{-- ── SELECTOR DE MES ── --}}
    <form method="GET" action="{{ route('asistencia.historial', $persona->id) }}" class="mb-4">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <label class="fw-600" style="font-size:12.5px; color:var(--neutral-600);">
                <i class="bi bi-calendar3 me-1" style="color:var(--teal-500);"></i>Período
            </label>
            <select name="mes" class="form-select form-select-sm" style="width:auto; font-size:13px; border-radius:var(--radius-sm); border-color:var(--neutral-200);" onchange="this.form.submit()">
                @foreach($mesesDisponibles as $m)
                    <option value="{{ $m['mes'] }}"
                            {{ ($mes == $m['mes'] && $anio == $m['anio']) ? 'selected' : '' }}>
                        {{ $m['label'] }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="anio" value="{{ $anio }}">
        </div>
    </form>

    {{-- ── CALENDARIO DEL MES ── --}}
    <div class="hist-cal-card mb-4">
        <div class="hist-cal-header">
            <i class="bi bi-calendar-week me-2"></i>
            {{ ucfirst(\Carbon\Carbon::createFromDate($anio, $mes, 1)->translatedFormat('F Y')) }}
        </div>
        <div class="hist-cal-grid">
            {{-- Cabecera días semana --}}
            @foreach(['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'] as $dia)
                <div class="hist-cal-dayname">{{ $dia }}</div>
            @endforeach

            {{-- Espacios vacíos antes del primer día --}}
            @php
                $primerDia = \Carbon\Carbon::createFromDate($anio, $mes, 1);
                $offset    = ($primerDia->dayOfWeekIso - 1); // 0=lun
                $hoyStr    = \Carbon\Carbon::today()->toDateString();
            @endphp
            @for($i = 0; $i < $offset; $i++)
                <div class="hist-cal-cell hist-cal-cell--empty"></div>
            @endfor

            {{-- Días del mes --}}
            @foreach($diasDelMes as $dia)
                @php
                    $dStr  = $dia->toDateString();
                    $reg   = $asistencias->get($dStr);
                    $futuro = $dStr > $hoyStr;
                    $esHoy  = $dStr === $hoyStr;

                    if ($futuro)        $estado = 'futuro';
                    elseif (!$reg)      $estado = 'sin-registro';
                    elseif ($reg->presente) $estado = 'presente';
                    else                $estado = 'ausente';
                @endphp
                <div class="hist-cal-cell hist-cal-cell--{{ $estado }} {{ $esHoy ? 'hist-cal-cell--hoy' : '' }}"
                     title="{{ $estado === 'presente' && $reg->observaciones ? $reg->observaciones : '' }}">
                    <span class="hist-cal-num">{{ $dia->day }}</span>
                    @if($estado === 'presente')
                        <i class="bi bi-check2 hist-cal-icon"></i>
                        @if($reg->observaciones)
                            <i class="bi bi-chat-dots hist-cal-obs-dot" title="{{ $reg->observaciones }}"></i>
                        @endif
                    @elseif($estado === 'ausente')
                        <i class="bi bi-x hist-cal-icon"></i>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Leyenda --}}
        <div class="hist-cal-leyenda">
            <span><span class="hist-dot hist-dot--presente"></span> Presente</span>
            <span><span class="hist-dot hist-dot--ausente"></span> Ausente</span>
            <span><span class="hist-dot hist-dot--sin-registro"></span> Sin registro</span>
            <span><i class="bi bi-chat-dots" style="font-size:11px; color:var(--sky-500);"></i> Tiene observación</span>
        </div>
    </div>

    {{-- ── DETALLE LISTA (solo registros existentes) ── --}}
    @if($asistencias->count())
    <div class="hist-list-card">
        <div class="hist-list-header">
            <i class="bi bi-list-ul me-2"></i> Detalle de registros
        </div>
        <div class="table-responsive">
            <table class="table mb-0" style="font-size:13px;">
                <thead>
                    <tr>
                        <th style="padding:10px 16px; font-size:11px; text-transform:uppercase; letter-spacing:.8px; color:var(--neutral-400); background:var(--neutral-50); font-weight:700;">Fecha</th>
                        <th style="padding:10px 16px; font-size:11px; text-transform:uppercase; letter-spacing:.8px; color:var(--neutral-400); background:var(--neutral-50); font-weight:700;">Estado</th>
                        <th style="padding:10px 16px; font-size:11px; text-transform:uppercase; letter-spacing:.8px; color:var(--neutral-400); background:var(--neutral-50); font-weight:700;">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asistencias->sortByDesc('fecha') as $reg)
                    <tr style="border-bottom:1px solid var(--neutral-100);">
                        <td style="padding:10px 16px; color:var(--neutral-600); font-weight:600;">
                            {{ \Carbon\Carbon::parse($reg->fecha)->translatedFormat('l j \d\e F') }}
                        </td>
                        <td style="padding:10px 16px;">
                            @if($reg->presente)
                                <span class="asist-badge" style="background:#d1fae5; color:#065f46; border:1px solid #a7f3d0;">
                                    <i class="bi bi-check-circle-fill"></i> Presente
                                </span>
                            @else
                                <span class="asist-badge" style="background:#fee2e2; color:#991b1b; border:1px solid #fca5a5;">
                                    <i class="bi bi-x-circle-fill"></i> Ausente
                                </span>
                            @endif
                        </td>
                        <td style="padding:10px 16px; color:var(--neutral-600);">
                            {{ $reg->observaciones ?? '—' }}
                        </td>
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
<style>
    /* ─── Botón volver ─── */
    .hist-btn-back {
        width:36px; height:36px; border-radius:10px; background:var(--neutral-100);
        border:1px solid var(--neutral-200); color:var(--neutral-600);
        display:inline-flex; align-items:center; justify-content:center;
        font-size:16px; text-decoration:none; transition:background .15s; flex-shrink:0;
    }
    .hist-btn-back:hover { background:var(--neutral-200); color:var(--neutral-800); }

    /* ─── Avatar grande ─── */
    .hist-avatar-lg {
        width:48px; height:48px; border-radius:12px;
        background:var(--grad-soft); border:1px solid var(--teal-100);
        color:var(--teal-600); font-size:16px; font-weight:800;
        display:flex; align-items:center; justify-content:center;
        flex-shrink:0; font-family:'Plus Jakarta Sans',sans-serif;
    }

    /* ─── % porcentaje ─── */
    .hist-pct-box { display:flex; align-items:center; gap:12px; }
    .hist-pct-circle {
        width:60px; height:60px; border-radius:50%;
        background: conic-gradient(var(--teal-500) calc(var(--pct) * 1%), var(--neutral-100) 0);
        display:flex; align-items:center; justify-content:center;
        position:relative; flex-shrink:0;
    }
    .hist-pct-circle::before {
        content:''; position:absolute; width:44px; height:44px;
        border-radius:50%; background:white;
    }
    .hist-pct-num {
        position:relative; z-index:1; font-size:12px; font-weight:800;
        color:var(--teal-600); font-family:'Plus Jakarta Sans',sans-serif;
    }
    .hist-pct-label { font-size:13px; font-weight:600; color:var(--neutral-800); line-height:1.4; }

    /* ─── Calendario ─── */
    .hist-cal-card { background:white; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); overflow:hidden; border:1px solid var(--neutral-200); }
    .hist-cal-header { padding:14px 20px; background:var(--neutral-50); border-bottom:1px solid var(--neutral-200); font-weight:700; font-size:14px; color:var(--neutral-800); font-family:'Plus Jakarta Sans',sans-serif; }
    .hist-cal-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:4px; padding:16px; }
    .hist-cal-dayname { text-align:center; font-size:11px; font-weight:700; color:var(--neutral-400); text-transform:uppercase; letter-spacing:.8px; padding:4px 0 8px; }
    .hist-cal-cell {
        aspect-ratio:1; border-radius:10px; display:flex; flex-direction:column;
        align-items:center; justify-content:center; position:relative;
        font-size:13px; font-weight:600; transition:transform .1s;
    }
    .hist-cal-cell:not(.hist-cal-cell--empty):not(.hist-cal-cell--futuro):hover { transform:scale(1.08); }
    .hist-cal-num { line-height:1; }
    .hist-cal-icon { font-size:11px; margin-top:1px; }
    .hist-cal-cell--futuro { background:var(--neutral-50); color:var(--neutral-200); }
    .hist-cal-cell--sin-registro { background:var(--neutral-100); color:var(--neutral-400); }
    .hist-cal-cell--presente { background:#d1fae5; color:#065f46; }
    .hist-cal-cell--ausente { background:#fee2e2; color:#991b1b; }
    .hist-cal-cell--hoy { outline:2px solid var(--teal-400); outline-offset:1px; }
    .hist-cal-obs-dot { position:absolute; top:3px; right:4px; font-size:9px; color:var(--sky-500); }

    /* ─── Leyenda ─── */
    .hist-cal-leyenda { display:flex; gap:16px; flex-wrap:wrap; padding:12px 20px; border-top:1px solid var(--neutral-100); font-size:12px; font-weight:600; color:var(--neutral-600); }
    .hist-dot { display:inline-block; width:10px; height:10px; border-radius:3px; margin-right:4px; }
    .hist-dot--presente { background:#d1fae5; border:1px solid #a7f3d0; }
    .hist-dot--ausente { background:#fee2e2; border:1px solid #fca5a5; }
    .hist-dot--sin-registro { background:var(--neutral-100); border:1px solid var(--neutral-200); }

    /* ─── Lista detalle ─── */
    .hist-list-card { background:white; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); overflow:hidden; border:1px solid var(--neutral-200); }
    .hist-list-header { padding:14px 20px; background:var(--neutral-50); border-bottom:1px solid var(--neutral-200); font-weight:700; font-size:14px; color:var(--neutral-800); font-family:'Plus Jakarta Sans',sans-serif; }

    /* ─── Badges (reutilizados) ─── */
    .asist-badge { display:inline-flex; align-items:center; gap:4px; border-radius:20px; font-size:11.5px; font-weight:600; padding:2px 9px; white-space:nowrap; }
    .asist-badge--sede { background:var(--sky-50); color:var(--sky-600); border:1px solid var(--sky-100); }
</style>
@endpush