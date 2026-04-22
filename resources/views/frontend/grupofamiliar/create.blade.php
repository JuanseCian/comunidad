{{-- resources/views/frontend/grupofamiliar/create.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agregar integrante — {{ $persona->apellido }}, {{ $persona->nombre }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --bg:          #F5F3EE;
  --surface:     #FFFFFF;
  --border:      #E0DDD6;
  --border-md:   #C8C4BB;
  --text:        #1A1916;
  --muted:       #6B6860;
  --accent:      #2D5A3D;
  --accent-lt:   #EAF0EB;
  --accent-brd:  #B8CFC0;
  --danger:      #8B2E2E;
  --danger-lt:   #FBF0F0;
  --danger-brd:  #D4A5A5;
  --warn:        #7A5C1E;
  --warn-lt:     #FDF6E7;
  --warn-brd:    #E8D5A3;
  --radius:      10px;
  --radius-lg:   16px;
  --serif:       'Instrument Serif', Georgia, serif;
  --sans:        'DM Sans', system-ui, sans-serif;
  --ease:        160ms ease;
}

html { font-size: 15px; }
body { font-family: var(--sans); background: var(--bg); color: var(--text); min-height: 100vh; padding: 2rem 1rem 5rem; }

/* ── Layout ── */
.page { max-width: 780px; margin: 0 auto; }

/* ── Header ── */
.breadcrumb { font-size: 12px; color: var(--muted); display: flex; align-items: center; gap: 6px; margin-bottom: 12px; flex-wrap: wrap; }
.breadcrumb a { color: var(--muted); text-decoration: none; }
.breadcrumb a:hover { color: var(--accent); }
.breadcrumb span { opacity: .45; }

h1 { font-family: var(--serif); font-size: 2.1rem; font-weight: 400; letter-spacing: -.01em; line-height: 1.15; }
.titular-tag {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--accent-lt); border: 1px solid var(--accent-brd);
  color: var(--accent); font-size: 12.5px; font-weight: 500;
  padding: 5px 12px; border-radius: 20px; margin-top: 12px;
}
.titular-tag small { font-weight: 300; opacity: .7; }

/* ── Alerts ── */
.alert { padding: 14px 18px; border-radius: var(--radius); font-size: 13.5px; margin-bottom: 1.5rem; display: flex; gap: 10px; align-items: flex-start; }
.alert-danger  { background: var(--danger-lt);  border: 1px solid var(--danger-brd);  color: var(--danger); }
.alert ul { padding-left: 1.2rem; margin-top: 4px; }

/* ── Secciones ── */
.section { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); margin-bottom: 1.25rem; overflow: hidden; }
.section-header { padding: 15px 24px 13px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; }
.section-num { width: 26px; height: 26px; border-radius: 50%; background: var(--accent); color: #fff; font-size: 11px; font-weight: 500; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.section-title { font-size: 13.5px; font-weight: 500; }
.section-sub { font-size: 12px; color: var(--muted); margin-left: auto; }
.section-body { padding: 22px 24px; }

/* ── Grid ── */
.grid   { display: grid; gap: 18px 20px; }
.g2     { grid-template-columns: 1fr 1fr; }
.g3     { grid-template-columns: 1fr 1fr 1fr; }
.g1     { grid-template-columns: 1fr; }
.span2  { grid-column: span 2; }
.span3  { grid-column: span 3; }

@media (max-width: 600px) {
  .g2, .g3 { grid-template-columns: 1fr; }
  .span2, .span3 { grid-column: span 1; }
}

/* ── Campos ── */
.field { display: flex; flex-direction: column; gap: 6px; }
label { font-size: 11.5px; font-weight: 500; color: var(--muted); letter-spacing: .03em; text-transform: uppercase; }
label .req { color: var(--danger); margin-left: 2px; }

input[type="text"], input[type="number"], input[type="date"], select {
  width: 100%; height: 40px; padding: 0 12px;
  border: 1px solid var(--border-md); border-radius: var(--radius);
  font-family: var(--sans); font-size: 14px; color: var(--text);
  background: var(--surface); outline: none;
  transition: border-color var(--ease), box-shadow var(--ease);
  -webkit-appearance: none; appearance: none;
}
select {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M2 4l4 4 4-4' stroke='%236B6860' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  padding-right: 32px; cursor: pointer;
}
input:focus, select:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(45,90,61,.1); }
input::placeholder { color: #AEACA6; }
input.is-invalid, select.is-invalid { border-color: var(--danger) !important; }
.hint { font-size: 11.5px; color: var(--muted); }
.error-msg { font-size: 11.5px; color: var(--danger); }

/* ── Divider ── */
.divider { height: 1px; background: var(--border); margin: 20px 0; }

/* ── Toggle switch ── */
.toggle-group { display: grid; gap: 0; }
.toggle-row {
  display: flex; align-items: center; justify-content: space-between;
  padding: 12px 0; border-bottom: 1px solid var(--border);
}
.toggle-row:last-child { border-bottom: none; }
.toggle-label { font-size: 13.5px; color: var(--text); }
.toggle-label small { display: block; font-size: 11.5px; color: var(--muted); margin-top: 2px; font-style: italic; }

.switch { position: relative; display: inline-block; width: 42px; height: 24px; flex-shrink: 0; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider { position: absolute; inset: 0; background: var(--border-md); border-radius: 24px; cursor: pointer; transition: background var(--ease); }
.slider::before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: white; border-radius: 50%; transition: transform var(--ease); box-shadow: 0 1px 3px rgba(0,0,0,.15); }
.switch input:checked + .slider { background: var(--accent); }
.switch input:checked + .slider::before { transform: translateX(18px); }

/* ── Sección condicional ── */
.cond-block { display: none; margin-top: 16px; padding: 16px; background: var(--bg); border-radius: var(--radius); border: 1px solid var(--border); }
.cond-block.visible { display: block; }
.cond-block .grid { margin-top: 0; }

/* ── Acciones ── */
.actions { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border); }
.btn { height: 42px; padding: 0 24px; border-radius: var(--radius); font-family: var(--sans); font-size: 14px; font-weight: 500; cursor: pointer; border: 1px solid transparent; transition: all var(--ease); display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
.btn-primary { background: var(--accent); color: #fff; border-color: var(--accent); }
.btn-primary:hover { background: #245030; }
.btn-primary:active { transform: scale(.98); }
.btn-ghost { background: transparent; color: var(--muted); border-color: var(--border-md); }
.btn-ghost:hover { background: var(--bg); color: var(--text); }

/* ── Animación ── */
@keyframes fadeUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
.page > * { animation: fadeUp .3s ease both; }
.page > *:nth-child(1) { animation-delay: .00s; }
.page > *:nth-child(2) { animation-delay: .04s; }
.page > *:nth-child(3) { animation-delay: .08s; }
.page > *:nth-child(4) { animation-delay: .12s; }
.page > *:nth-child(5) { animation-delay: .16s; }
.page > *:nth-child(6) { animation-delay: .20s; }
.page > *:nth-child(7) { animation-delay: .24s; }
</style>
</head>
<body>
<div class="page">

  {{-- Breadcrumb --}}
  <div class="breadcrumb">
    <a href="{{ route('dashboard') }}">Inicio</a>
    <span>/</span>
    <a href="{{ route('personas.index') }}">Personas</a>
    <span>/</span>
    <a href="{{ route('personas.show', $persona) }}">{{ $persona->apellido }}, {{ $persona->nombre }}</a>
    <span>/</span>
    <span>Agregar integrante</span>
  </div>

  {{-- Título --}}
  <h1>Agregar integrante</h1>
  <div class="titular-tag">
    Titular: {{ $persona->apellido }}, {{ $persona->nombre }}
    <small>DNI {{ $persona->dni }}</small>
  </div>

  <div style="margin-top: 2rem;"></div>

  {{-- Errores de validación --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <div>
        Corregí los siguientes errores:
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  <form method="POST" action="{{ route('personas.grupo-familiar.store', $persona) }}" novalidate>
    @csrf

    {{-- ══════════════════════════════════════════
         SECCIÓN 1: Datos personales del integrante
    ══════════════════════════════════════════ --}}
    <div class="section">
      <div class="section-header">
        <div class="section-num">1</div>
        <span class="section-title">Datos personales</span>
        <span class="section-sub">Información básica del integrante</span>
      </div>
      <div class="section-body">
        <div class="grid g2">

          <div class="field span2">
            <label>Nombre completo <span class="req">*</span></label>
            <input type="text" name="nombre" value="{{ old('nombre') }}"
                   placeholder="Nombre y apellido del integrante"
                   class="{{ $errors->has('nombre') ? 'is-invalid' : '' }}">
            @error('nombre')<span class="error-msg">{{ $message }}</span>@enderror
          </div>

          <div class="field">
            <label>Tipo de documento</label>
            <select name="documento_id" class="{{ $errors->has('documento_id') ? 'is-invalid' : '' }}">
              <option value="">— Seleccionar —</option>
              @foreach($catalogos['tipos_documento'] as $td)
                <option value="{{ $td->id }}" {{ old('documento_id') == $td->id ? 'selected' : '' }}>
                  {{ $td->nombre }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="field">
            <label>Número de documento</label>
            <input type="text" name="numero_documento" value="{{ old('numero_documento') }}"
                   placeholder="Ej: 30123456"
                   class="{{ $errors->has('numero_documento') ? 'is-invalid' : '' }}">
            @error('numero_documento')<span class="error-msg">{{ $message }}</span>@enderror
          </div>

          <div class="field">
            <label>Sexo</label>
            <select name="sexo_id" class="{{ $errors->has('sexo_id') ? 'is-invalid' : '' }}">
              <option value="">— Seleccionar —</option>
              @foreach($catalogos['sexos'] as $s)
                <option value="{{ $s->id }}" {{ old('sexo_id') == $s->id ? 'selected' : '' }}>
                  {{ $s->nombre }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="field">
            <label>Fecha de nacimiento</label>
            <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                   class="{{ $errors->has('fecha_nacimiento') ? 'is-invalid' : '' }}">
            @error('fecha_nacimiento')<span class="error-msg">{{ $message }}</span>@enderror
          </div>

          <div class="field">
            <label>Relación con el titular</label>
            <select name="relacion_titular" class="{{ $errors->has('relacion_titular') ? 'is-invalid' : '' }}">
              <option value="">— Seleccionar —</option>
              @foreach(['Cónyuge/Pareja','Hijo/a','Padre/Madre','Hermano/a','Abuelo/a','Nieto/a','Otro familiar','Otro'] as $rel)
                <option value="{{ $rel }}" {{ old('relacion_titular') === $rel ? 'selected' : '' }}>{{ $rel }}</option>
              @endforeach
            </select>
          </div>

          <div class="field">
            <label>Estado civil</label>
            <select name="estado_civil_id" class="{{ $errors->has('estado_civil_id') ? 'is-invalid' : '' }}">
              <option value="">— Seleccionar —</option>
              @foreach($catalogos['estados_civiles'] as $ec)
                <option value="{{ $ec->id }}" {{ old('estado_civil_id') == $ec->id ? 'selected' : '' }}>
                  {{ $ec->nombre }}
                </option>
              @endforeach
            </select>
          </div>

        </div>
      </div>
    </div>

    {{-- ══════════════════════════════════════════
         SECCIÓN 2: Salud
    ══════════════════════════════════════════ --}}
    <div class="section">
      <div class="section-header">
        <div class="section-num">2</div>
        <span class="section-title">Salud</span>
        <span class="section-sub">Cobertura, discapacidad y enfermedades</span>
      </div>
      <div class="section-body">

        <div class="grid g1" style="margin-bottom:18px">
          <div class="field">
            <label>Cobertura médica</label>
            <select name="cobertura_id" class="{{ $errors->has('cobertura_id') ? 'is-invalid' : '' }}">
              <option value="">— Sin cobertura / No especificada —</option>
              @foreach($catalogos['coberturas'] as $c)
                <option value="{{ $c->id }}" {{ old('cobertura_id') == $c->id ? 'selected' : '' }}>
                  {{ $c->nombre }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="divider"></div>

        {{-- Toggles de salud --}}
        <div class="toggle-group">

          {{-- Discapacidad --}}
          <div class="toggle-row">
            <div class="toggle-label">
              Tiene discapacidad permanente
              <small>Activá para completar el tipo y tratamiento</small>
            </div>
            <label class="switch">
              <input type="checkbox" name="discapacidad_permanente" value="1" id="chk-discapacidad"
                     {{ old('discapacidad_permanente') ? 'checked' : '' }}>
              <span class="slider"></span>
            </label>
          </div>
          <div class="cond-block {{ old('discapacidad_permanente') ? 'visible' : '' }}" id="blk-discapacidad">
            <div class="grid g2">
              <div class="field">
                <label>Tipo de discapacidad</label>
                <select name="discapacidad_id">
                  <option value="">— Seleccionar —</option>
                  @foreach($catalogos['discapacidades'] as $d)
                    <option value="{{ $d->id }}" {{ old('discapacidad_id') == $d->id ? 'selected' : '' }}>
                      {{ $d->nombre }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="field">
                <label>Carátula / expediente</label>
                <input type="text" name="caratula" value="{{ old('caratula') }}" placeholder="Número o referencia">
              </div>
            </div>
            <div class="toggle-row" style="margin-top:14px;padding-top:14px;border-top:1px solid var(--border);">
              <div class="toggle-label">Recibe tratamiento por discapacidad</div>
              <label class="switch">
                <input type="checkbox" name="discapacidad_tratamiento" value="1"
                       {{ old('discapacidad_tratamiento') ? 'checked' : '' }}>
                <span class="slider"></span>
              </label>
            </div>
          </div>

          {{-- Enfermedad --}}
          <div class="toggle-row">
            <div class="toggle-label">
              Tiene enfermedad crónica o relevante
              <small>Activá para seleccionar el tipo y tratamiento</small>
            </div>
            <label class="switch">
              <input type="checkbox" name="_tiene_enfermedad" value="1" id="chk-enfermedad"
                     {{ old('enfermedad_id') ? 'checked' : '' }}>
              <span class="slider"></span>
            </label>
          </div>
          <div class="cond-block {{ old('enfermedad_id') ? 'visible' : '' }}" id="blk-enfermedad">
            <div class="grid g2">
              <div class="field">
                <label>Tipo de enfermedad</label>
                <select name="enfermedad_id">
                  <option value="">— Seleccionar —</option>
                  @foreach($catalogos['enfermedades'] as $e)
                    <option value="{{ $e->id }}" {{ old('enfermedad_id') == $e->id ? 'selected' : '' }}>
                      {{ $e->nombre }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="toggle-row" style="margin-top:14px;padding-top:14px;border-top:1px solid var(--border);">
              <div class="toggle-label">Recibe tratamiento por la enfermedad</div>
              <label class="switch">
                <input type="checkbox" name="enfermedad_tratamiento" value="1"
                       {{ old('enfermedad_tratamiento') ? 'checked' : '' }}>
                <span class="slider"></span>
              </label>
            </div>
          </div>

          {{-- Embarazo --}}
          <div class="toggle-row">
            <div class="toggle-label">
              Está embarazada
              <small>Solo aplicar si corresponde</small>
            </div>
            <label class="switch">
              <input type="checkbox" name="embarazo" value="1" id="chk-embarazo"
                     {{ old('embarazo') ? 'checked' : '' }}>
              <span class="slider"></span>
            </label>
          </div>
          <div class="cond-block {{ old('embarazo') ? 'visible' : '' }}" id="blk-embarazo">
            <div class="toggle-row">
              <div class="toggle-label">Realiza controles de embarazo</div>
              <label class="switch">
                <input type="checkbox" name="control_embarazo" value="1"
                       {{ old('control_embarazo') ? 'checked' : '' }}>
                <span class="slider"></span>
              </label>
            </div>
          </div>

          {{-- Vacunación --}}
          <div class="toggle-row">
            <div class="toggle-label">
              Esquema de vacunación completo
              <small>Según edad y calendario nacional</small>
            </div>
            <label class="switch">
              <input type="checkbox" name="esquema_vacunacion" value="1"
                     {{ old('esquema_vacunacion') ? 'checked' : '' }}>
              <span class="slider"></span>
            </label>
          </div>

        </div>{{-- /toggle-group --}}
      </div>
    </div>

    {{-- ══════════════════════════════════════════
         SECCIÓN 3: Situación laboral
    ══════════════════════════════════════════ --}}
    <div class="section">
      <div class="section-header">
        <div class="section-num">3</div>
        <span class="section-title">Situación laboral</span>
        <span class="section-sub">Ocupación e ingresos</span>
      </div>
      <div class="section-body">
        <div class="grid g2">

          <div class="field">
            <label>Situación ocupacional</label>
            <select name="situacion_ocupacional_id" id="sel-situacion"
                    class="{{ $errors->has('situacion_ocupacional_id') ? 'is-invalid' : '' }}">
              <option value="">— Seleccionar —</option>
              @foreach($catalogos['situaciones_ocupacional'] as $so)
                <option value="{{ $so->id }}" {{ old('situacion_ocupacional_id') == $so->id ? 'selected' : '' }}>
                  {{ $so->nombre }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="field" id="blk-inactividad" style="{{ old('condicion_inactividad_id') ? '' : 'display:none' }}">
            <label>Condición de inactividad</label>
            <select name="condicion_inactividad_id">
              <option value="">— Seleccionar —</option>
              @foreach($catalogos['condiciones_inactividad'] as $ci)
                <option value="{{ $ci->id }}" {{ old('condicion_inactividad_id') == $ci->id ? 'selected' : '' }}>
                  {{ $ci->nombre }}
                </option>
              @endforeach
            </select>
            <span class="hint">Completar si está inactivo.</span>
          </div>

          <div class="field">
            <label>Categoría ocupacional</label>
            <select name="categoria_ocupacional_id"
                    class="{{ $errors->has('categoria_ocupacional_id') ? 'is-invalid' : '' }}">
              <option value="">— Seleccionar —</option>
              @foreach($catalogos['categorias_ocupacional'] as $co)
                <option value="{{ $co->id }}" {{ old('categoria_ocupacional_id') == $co->id ? 'selected' : '' }}>
                  {{ $co->nombre }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="field">
            <label>Ingresos mensuales (ARS)</label>
            <input type="number" name="ingresos" value="{{ old('ingresos') }}"
                   placeholder="0.00" min="0" step="0.01"
                   class="{{ $errors->has('ingresos') ? 'is-invalid' : '' }}">
            @error('ingresos')<span class="error-msg">{{ $message }}</span>@enderror
          </div>

        </div>
      </div>
    </div>

    {{-- ══════════════════════════════════════════
         Acciones
    ══════════════════════════════════════════ --}}
    <div class="actions">
      <a href="{{ route('personas.show', $persona) }}" class="btn btn-ghost">Cancelar</a>
      <button type="submit" class="btn btn-primary">Guardar integrante</button>
    </div>

  </form>
</div>

<script>
// Toggles condicionales (discapacidad, enfermedad, embarazo)
[
  ['chk-discapacidad', 'blk-discapacidad'],
  ['chk-enfermedad',   'blk-enfermedad'],
  ['chk-embarazo',     'blk-embarazo'],
].forEach(function([chkId, blkId]) {
  const chk = document.getElementById(chkId);
  const blk = document.getElementById(blkId);
  if (!chk || !blk) return;
  chk.addEventListener('change', function() {
    blk.classList.toggle('visible', chk.checked);
    // Limpiar selects internos si se desactiva
    if (!chk.checked) {
      blk.querySelectorAll('select').forEach(function(s) { s.value = ''; });
      blk.querySelectorAll('input[type="checkbox"]').forEach(function(c) { c.checked = false; });
    }
  });
});

// Mostrar condición de inactividad solo cuando sea relevante
// (ajustar los IDs de situación ocupacional según los datos reales)
document.getElementById('sel-situacion').addEventListener('change', function() {
  const blk = document.getElementById('blk-inactividad');
  // Muestra el campo si hay cualquier valor seleccionado
  // Podés filtrar por un ID concreto de "Inactivo" si lo preferís
  blk.style.display = this.value ? '' : 'none';
  if (!this.value) {
    blk.querySelector('select').value = '';
  }
});

// Validación cliente: campo nombre obligatorio
document.querySelector('form').addEventListener('submit', function(e) {
  const nombre = document.querySelector('[name="nombre"]');
  if (!nombre.value.trim()) {
    nombre.classList.add('is-invalid');
    nombre.scrollIntoView({ behavior: 'smooth', block: 'center' });
    e.preventDefault();
  }
});
</script>
</body>
</html>
