{{-- resources/views/frontend/persona/show.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $persona->apellido }}, {{ $persona->nombre }} — Comunidad</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
  --bg:         #F5F3EE;
  --surface:    #FFFFFF;
  --border:     #E0DDD6;
  --border-md:  #C8C4BB;
  --text:       #1A1916;
  --muted:      #6B6860;
  --accent:     #2D5A3D;
  --accent-lt:  #EAF0EB;
  --accent-brd: #B8CFC0;
  --danger:     #8B2E2E;
  --danger-lt:  #FBF0F0;
  --amber:      #7A5C1E;
  --amber-lt:   #FDF6E7;
  --amber-brd:  #E8D5A3;
  --blue:       #1E3A5F;
  --blue-lt:    #EBF2FA;
  --blue-brd:   #AECBE8;
  --radius:     10px;
  --radius-lg:  16px;
  --serif:      'Instrument Serif', Georgia, serif;
  --sans:       'DM Sans', system-ui, sans-serif;
  --ease:       160ms ease;
}
html { font-size: 15px; }
body { font-family: var(--sans); background: var(--bg); color: var(--text); min-height: 100vh; padding: 2rem 1rem 5rem; }

/* ── Layout ── */
.page { max-width: 860px; margin: 0 auto; }

/* ── Breadcrumb ── */
.breadcrumb { font-size: 12px; color: var(--muted); display: flex; align-items: center; gap: 6px; margin-bottom: 1.5rem; flex-wrap: wrap; }
.breadcrumb a { color: var(--muted); text-decoration: none; }
.breadcrumb a:hover { color: var(--accent); }
.breadcrumb span { opacity: .45; }

/* ── Hero header ── */
.hero {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 24px 28px;
  margin-bottom: 1.25rem;
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 20px;
  flex-wrap: wrap;
}
.hero-left { display: flex; align-items: center; gap: 18px; }
.avatar {
  width: 56px; height: 56px; border-radius: 50%;
  background: var(--accent-lt); border: 1px solid var(--accent-brd);
  display: flex; align-items: center; justify-content: center;
  font-family: var(--serif); font-size: 1.4rem; color: var(--accent);
  flex-shrink: 0;
}
.hero-name { font-family: var(--serif); font-size: 1.8rem; font-weight: 400; line-height: 1.1; }
.hero-meta { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px; }
.pill {
  font-size: 11.5px; font-weight: 500; padding: 3px 10px;
  border-radius: 20px; border: 1px solid;
}
.pill-gray   { background: var(--bg);       border-color: var(--border-md); color: var(--muted); }
.pill-green  { background: var(--accent-lt); border-color: var(--accent-brd); color: var(--accent); }
.pill-amber  { background: var(--amber-lt);  border-color: var(--amber-brd); color: var(--amber); }
.pill-blue   { background: var(--blue-lt);   border-color: var(--blue-brd); color: var(--blue); }
.pill-danger { background: var(--danger-lt); border-color: #D4A5A5; color: var(--danger); }

.hero-actions { display: flex; gap: 8px; flex-shrink: 0; }
.btn { height: 38px; padding: 0 18px; border-radius: var(--radius); font-family: var(--sans); font-size: 13px; font-weight: 500; cursor: pointer; border: 1px solid transparent; transition: all var(--ease); display: inline-flex; align-items: center; gap: 7px; text-decoration: none; }
.btn-primary { background: var(--accent); color: #fff; border-color: var(--accent); }
.btn-primary:hover { background: #245030; }
.btn-ghost { background: transparent; color: var(--muted); border-color: var(--border-md); }
.btn-ghost:hover { background: var(--bg); color: var(--text); }

/* ── Alerta éxito ── */
.alert-success { padding: 12px 18px; border-radius: var(--radius); font-size: 13.5px; margin-bottom: 1.25rem; background: var(--accent-lt); border: 1px solid var(--accent-brd); color: var(--accent); display: flex; gap: 10px; align-items: center; }

/* ── Grid de secciones ── */
.grid-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.col-full { grid-column: span 2; }
@media (max-width: 640px) { .grid-layout { grid-template-columns: 1fr; } .col-full { grid-column: span 1; } }

/* ── Sección card ── */
.section { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; }
.section-header { padding: 13px 20px 11px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.section-title { font-size: 12.5px; font-weight: 500; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; }
.section-action { font-size: 12px; color: var(--accent); text-decoration: none; font-weight: 500; }
.section-action:hover { text-decoration: underline; }
.section-body { padding: 18px 20px; }

/* ── Lista de datos ── */
.data-list { display: flex; flex-direction: column; gap: 0; }
.data-row { display: flex; justify-content: space-between; align-items: baseline; gap: 12px; padding: 9px 0; border-bottom: 1px solid var(--border); font-size: 13.5px; }
.data-row:last-child { border-bottom: none; }
.data-label { color: var(--muted); font-size: 12.5px; flex-shrink: 0; }
.data-val { color: var(--text); text-align: right; font-weight: 400; }
.data-val.empty { color: var(--border-md); font-style: italic; }

/* ── Tabla grupo familiar ── */
.gf-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.gf-table th { font-size: 11px; font-weight: 500; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; padding: 8px 12px; text-align: left; border-bottom: 1px solid var(--border); background: var(--bg); }
.gf-table td { padding: 10px 12px; border-bottom: 1px solid var(--border); vertical-align: middle; }
.gf-table tr:last-child td { border-bottom: none; }
.gf-table tr:hover td { background: var(--bg); }
.gf-relacion { font-size: 11px; color: var(--muted); margin-top: 2px; }

/* ── Estado vacío ── */
.empty-state { text-align: center; padding: 28px 20px; color: var(--muted); font-size: 13.5px; }
.empty-state a { color: var(--accent); text-decoration: none; font-weight: 500; }
.empty-state a:hover { text-decoration: underline; }

/* ── Programas / beneficios ── */
.tag-list { display: flex; flex-wrap: wrap; gap: 8px; }
.tag { font-size: 12.5px; padding: 4px 12px; border-radius: 20px; border: 1px solid; }

/* ── Atenciones ── */
.atencion-row { padding: 12px 0; border-bottom: 1px solid var(--border); display: flex; gap: 14px; align-items: flex-start; }
.atencion-row:last-child { border-bottom: none; }
.atencion-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--accent); margin-top: 5px; flex-shrink: 0; }
.atencion-tipo { font-size: 12px; font-weight: 500; color: var(--accent); text-transform: capitalize; }
.atencion-fecha { font-size: 11.5px; color: var(--muted); margin-left: auto; white-space: nowrap; }
.atencion-desc { font-size: 13px; color: var(--text); margin-top: 3px; line-height: 1.5; }
.atencion-usuario { font-size: 11.5px; color: var(--muted); margin-top: 2px; }

/* ── CUD ── */
.cud-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 500; padding: 4px 12px; border-radius: 20px; }

/* ── Animación ── */
@keyframes fadeUp { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
.page > * { animation: fadeUp .3s ease both; }
.page > *:nth-child(1){animation-delay:.00s}
.page > *:nth-child(2){animation-delay:.04s}
.page > *:nth-child(3){animation-delay:.08s}
.page > *:nth-child(4){animation-delay:.12s}
.page > *:nth-child(5){animation-delay:.16s}
</style>
</head>
<body>


@if(session('abrirProgramaModal'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('modalPrograma').style.display = 'flex';
});
</script>
@endif

<div class="page">

  {{-- Breadcrumb --}}
  <div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Inicio</a>
    <span>/</span>
    
    <span>/</span>
    <span>{{ $persona->apellido }}, {{ $persona->nombre }}</span>
  </div>

  {{-- Flash --}}
  @if(session('success'))
    <div class="alert-success">
      <span>&#10003;</span> {{ session('success') }}
    </div>
  @endif

  {{-- Hero --}}
  <div class="hero">
    <div class="hero-left">
      <div class="avatar">
        {{ strtoupper(substr($persona->nombre, 0, 1)) }}{{ strtoupper(substr($persona->apellido, 0, 1)) }}
      </div>
      <div>
        <div class="hero-name">{{ $persona->apellido }}, {{ $persona->nombre }}</div>
        <div class="hero-meta">
          @if($persona->tipoDocumento)
            <span class="pill pill-gray">{{ $persona->tipoDocumento->nombre }} {{ $persona->dni }}</span>
          @endif
          @if($persona->sexo)
            <span class="pill pill-gray">{{ $persona->sexo->nombre }}</span>
          @endif
          @if($persona->fecha_nacimiento)
            <span class="pill pill-gray">
              {{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->age }} años
            </span>
          @endif
          @if($persona->sedeOrigen)
            <span class="pill pill-green">{{ $persona->sedeOrigen->nombre }}</span>
          @endif
          @if($persona->trabaja)
            <span class="pill pill-blue">Trabaja</span>
          @endif
        </div>
      </div>
    </div>
    <div class="hero-actions">
      <a href="{{ route('personas.grupo-familiar.create', $persona) }}" class="btn btn-primary">
        + Agregar integrante
      </a>
      <a href="{{ route('personas.create') }}" class="btn btn-ghost">Nueva persona</a>
    </div>
  </div>

  <div class="grid-layout">

    {{-- ── Datos personales ── --}}
    <div class="section">
      <div class="section-header">
        <span class="section-title">Datos personales</span>
      </div>
      <div class="section-body">
        <div class="data-list">
          <div class="data-row">
            <span class="data-label">Correo</span>
            <span class="data-val {{ !$persona->correo ? 'empty' : '' }}">
              {{ $persona->correo ?? '—' }}
            </span>
          </div>
          <div class="data-row">
            <span class="data-label">Teléfono</span>
            <span class="data-val {{ !$persona->telefono ? 'empty' : '' }}">
              {{ $persona->telefono ?? '—' }}
            </span>
          </div>
          <div class="data-row">
            <span class="data-label">Fecha de nac.</span>
            <span class="data-val {{ !$persona->fecha_nacimiento ? 'empty' : '' }}">
              {{ $persona->fecha_nacimiento
                  ? \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/Y')
                  : '—' }}
            </span>
          </div>
          <div class="data-row">
            <span class="data-label">CUIL</span>
            <span class="data-val {{ !$persona->cuil ? 'empty' : '' }}">
              {{ $persona->cuil ?? '—' }}
            </span>
          </div>
          <div class="data-row">
            <span class="data-label">Grupo sanguíneo</span>
            <span class="data-val {{ !$persona->grupo_sanguineo ? 'empty' : '' }}">
              {{ $persona->grupo_sanguineo ?? '—' }}
            </span>
          </div>
          <div class="data-row">
            <span class="data-label">Nivel de estudio</span>
            <span class="data-val {{ !$persona->nivelEstudio ? 'empty' : '' }}">
              {{ $persona->nivelEstudio?->nombre ?? '—' }}
            </span>
          </div>
        </div>
      </div>
    </div>

    {{-- ── Domicilio ── --}}
    <div class="section">
      <div class="section-header">
        <span class="section-title">Domicilio</span>
      </div>
      <div class="section-body">
        <div class="data-list">
          <div class="data-row">
            <span class="data-label">Provincia</span>
            <span class="data-val {{ !$persona->provincia ? 'empty' : '' }}">
              {{ $persona->provincia?->nombre ?? '—' }}
            </span>
          </div>
          <div class="data-row">
            <span class="data-label">Localidad</span>
            <span class="data-val {{ !$persona->localidad ? 'empty' : '' }}">
              {{ $persona->localidad?->nombre ?? '—' }}
            </span>
          </div>
          @if($persona->domicilio)
            <div class="data-row">
              <span class="data-label">Barrio</span>
              <span class="data-val {{ !$persona->domicilio->barrio ? 'empty' : '' }}">
                {{ $persona->domicilio->barrio?->nombre ?? '—' }}
              </span>
            </div>
            <div class="data-row">
              <span class="data-label">Calle</span>
              <span class="data-val {{ !$persona->domicilio->calle ? 'empty' : '' }}">
                {{ $persona->domicilio->calle
                    ? $persona->domicilio->calle . ' ' . ($persona->domicilio->numero ?? '')
                    : '—' }}
              </span>
            </div>
            @if($persona->domicilio->piso || $persona->domicilio->dpto)
              <div class="data-row">
                <span class="data-label">Piso / Dpto</span>
                <span class="data-val">
                  {{ $persona->domicilio->piso }} {{ $persona->domicilio->dpto }}
                </span>
              </div>
            @endif
          @else
            <div class="data-row">
              <span class="data-label">Dirección</span>
              <span class="data-val empty">Sin domicilio registrado</span>
            </div>
          @endif
        </div>
      </div>
    </div>

    {{-- ── CUD ── --}}
    <div class="section">
      <div class="section-header">
        <span class="section-title">CUD — Discapacidad</span>
      </div>
      <div class="section-body">
        @if($persona->cud)
          <div class="data-list">
            <div class="data-row">
              <span class="data-label">Tiene CUD</span>
              <span class="data-val">
                @if($persona->cud->tiene_cud)
                  <span class="pill pill-green">Sí</span>
                @else
                  <span class="pill pill-gray">No</span>
                @endif
              </span>
            </div>
            @if($persona->cud->tiene_cud)
              <div class="data-row">
                <span class="data-label">Número</span>
                <span class="data-val">{{ $persona->cud->numero_cud ?? '—' }}</span>
              </div>
              <div class="data-row">
                <span class="data-label">Emisión</span>
                <span class="data-val">
                  {{ $persona->cud->fecha_emision
                      ? \Carbon\Carbon::parse($persona->cud->fecha_emision)->format('d/m/Y')
                      : '—' }}
                </span>
              </div>
              <div class="data-row">
                <span class="data-label">Vencimiento</span>
                <span class="data-val">
                  {{ $persona->cud->fecha_vencimiento
                      ? \Carbon\Carbon::parse($persona->cud->fecha_vencimiento)->format('d/m/Y')
                      : '—' }}
                </span>
              </div>
            @endif
          </div>
        @else
          <div class="empty-state">Sin registro de CUD</div>
        @endif
      </div>
    </div>

    {{-- ── Programas ── --}}
    <div class="section">
      <div class="section-header">
        <span class="section-title">Programas de asistencia</span>
      </div>
      <div class="section-body">
        @if($persona->personaPrograma && $persona->personaPrograma->count())
          <div class="tag-list">
            @foreach($persona->personaPrograma as $pp)
              <span class="tag pill-green">{{ $pp->programa->nombre }}</span>
            @endforeach
          </div>
        @else
          <div class="empty-state">Sin programas asignados</div> 
          <button onclick="document.getElementById('modalPrograma').style.display='flex'">
              + Asignar programa
          </button>
        @endif
      </div>
    </div>

    {{-- ── Beneficios ── --}}
    <div class="section">
      <div class="section-header">
        <span class="section-title">Beneficios</span>
      </div>
      <div class="section-body">
        @if($persona->personaBeneficio && $persona->personaBeneficio->count())
          <div class="tag-list">
            @foreach($persona->personaBeneficio as $pb)
              <span class="tag pill-amber">{{ $pb->beneficio->nombre }}</span>
            @endforeach
          </div>
        @else
          <div class="empty-state">Sin beneficios asignados</div>
        @endif
      </div>
    </div>

    {{-- ── Grupo familiar ── --}}
    <div class="section col-full">
      <div class="section-header">
        <span class="section-title">
          Grupo familiar
          @if($persona->grupoFamiliar && $persona->grupoFamiliar->count())
            ({{ $persona->grupoFamiliar->count() }})
          @endif
        </span>
        <a href="{{ route('personas.grupo-familiar.create', $persona) }}" class="section-action">
          + Agregar integrante
        </a>
      </div>
      @if($persona->grupoFamiliar && $persona->grupoFamiliar->count())
        <table class="gf-table">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Documento</th>
              <th>Nacimiento</th>
              <th>Cobertura</th>
              <th>Situación</th>
              <th>Ingresos</th>
            </tr>
          </thead>
          <tbody>
            @foreach($persona->grupoFamiliar as $m)
              <tr>
                <td>
                  <div style="font-weight:500">{{ $m->nombre }}</div>
                  <div class="gf-relacion">{{ $m->relacion_titular ?? '—' }}</div>
                </td>
                <td>
                  {{ $m->tipo_documento?->nombre?->nombre ?? '' }}
                  {{ $m->numero_documento ?? '—' }}
                </td>
                <td>
                  {{ $m->fecha_nacimiento
                      ? \Carbon\Carbon::parse($m->fecha_nacimiento)->format('d/m/Y')
                      : '—' }}
                </td>
                <td>{{ $m->cobertura?->nombre ?? '—' }}</td>
                <td>{{ $m->situacion_ocupacional?->nombre ?? '—' }}</td>
                <td>
                  {{ $m->ingresos
                      ? '$' . number_format($m->ingresos, 0, ',', '.')
                      : '—' }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="empty-state">
          Sin integrantes registrados.
          <a href="{{ route('personas.grupo-familiar.create', $persona) }}">Agregar el primero</a>
        </div>
      @endif
    </div>

    {{-- ── Últimas atenciones ── --}}
    <div class="section col-full">
      <div class="section-header">
        <span class="section-title">Últimas atenciones</span>
      </div>
      <div class="section-body">
        @if($persona->atenciones && $persona->atenciones->count())
          @foreach($persona->atenciones as $a)
            <div class="atencion-row">
              <div class="atencion-dot"></div>
              <div style="flex:1">
                <div style="display:flex;align-items:center;gap:10px">
                  <span class="atencion-tipo">{{ str_replace('_', ' ', $a->tipo) }}</span>
                  <span class="atencion-fecha">
                    {{ \Carbon\Carbon::parse($a->fecha_atencion)->format('d/m/Y H:i') }}
                  </span>
                </div>
                @if($a->descripcion)
                  <div class="atencion-desc">{{ $a->descripcion }}</div>
                @endif
                @if($a->usuario)
                  <div class="atencion-usuario">Registrado por {{ $a->usuario->nombre }} {{ $a->usuario->apellido }}</div>
                @endif
                @if($a->proxima_atencion)
                  <div class="atencion-usuario" style="color:var(--amber)">
                    Próxima: {{ \Carbon\Carbon::parse($a->proxima_atencion)->format('d/m/Y') }}
                  </div>
                @endif
              </div>
            </div>
          @endforeach
        @else
          <div class="empty-state">Sin atenciones registradas.</div>
        @endif
      </div>
    </div>

    <div id="modalPrograma" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.4); align-items:center; justify-content:center; z-index:9999;">
        <div style="background:white; width:500px; border-radius:14px; padding:22px;">
            
            <h3 style="margin-bottom:10px;">Asignar a programa</h3>

            <form method="POST" action="{{ route('persona-programa.store') }}">
                @csrf

                <input type="hidden" name="persona_id" value="{{ $persona->id }}">

                <label>Programa</label>
                <select name="programa_id" style="width:100%; margin-bottom:10px;">
                    @foreach($programas as $prog)
                        <option value="{{ $prog->id }}">{{ $prog->nombre }}</option>
                    @endforeach
                </select>

                <label>Fecha inicio</label>
                <input type="date" name="fecha_inicio" style="width:100%; margin-bottom:10px;">

                <label>Observaciones</label>
                <textarea name="observaciones" style="width:100%;"></textarea>

                <div style="margin-top:15px; display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" onclick="document.getElementById('modalPrograma').style.display='none'">Cancelar</button>
                    <button type="submit">Guardar</button>
                </div>

            </form>
        </div>
    </div>

  </div>{{-- /grid-layout --}}
</div>
</body>
</html>
