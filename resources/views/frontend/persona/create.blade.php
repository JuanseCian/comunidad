<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Alta de persona — Comunidad</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --bg:#F5F3EE;--surface:#FFFFFF;--border:#E0DDD6;--border-md:#C8C4BB;
  --text:#1A1916;--muted:#6B6860;--accent:#2D5A3D;
  --accent-lt:#EAF0EB;--accent-brd:#B8CFC0;
  --danger:#8B2E2E;--danger-lt:#FBF0F0;--warn-brd:#D4A5A5;
  --radius:10px;--radius-lg:16px;
  --serif:'Instrument Serif',Georgia,serif;
  --sans:'DM Sans',system-ui,sans-serif;
  --transition:160ms ease;
}

body{font-family:var(--sans);background:var(--bg);color:var(--text);padding:2rem}
.page{max-width:760px;margin:auto}

.page-header{margin-bottom:2rem}
.page-header h1{font-family:var(--serif);font-size:2rem}

.alert{padding:12px;border-radius:var(--radius);margin-bottom:1rem}
.alert-success{background:var(--accent-lt);border:1px solid var(--accent-brd)}
.alert-danger{background:var(--danger-lt);border:1px solid var(--warn-brd)}

.section{background:#fff;border:1px solid var(--border);border-radius:var(--radius-lg);margin-bottom:1rem}
.section-header{padding:16px;border-bottom:1px solid var(--border)}
.section-body{padding:20px}

.grid{display:grid;gap:16px}
.grid-2{grid-template-columns:1fr 1fr}
.col-span-2{grid-column:span 2}

label{font-size:12px;color:var(--muted);text-transform:uppercase}

input,select{
height:40px;padding:0 10px;border:1px solid var(--border-md);
border-radius:var(--radius);width:100%;
}

.btn{padding:10px 20px;border:none;border-radius:var(--radius);cursor:pointer}
.btn-primary{background:var(--accent);color:#fff}
.btn-ghost{background:transparent;border:1px solid var(--border-md)}
</style>
</head>
<body>

<div class="page">

<div class="page-header">
<h1>Nueva persona</h1>
<p>Completá los datos del titular para registrarlo en el sistema.</p>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
<ul>
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('personas.store') }}">
@csrf

<div class="section">
<div class="section-header">Datos personales</div>
<div class="section-body">
<div class="grid grid-2">

<div>
<label>Apellido *</label>
<input type="text" name="apellido" value="{{ old('apellido') }}">
</div>

<div>
<label>Nombre *</label>
<input type="text" name="nombre" value="{{ old('nombre') }}">
</div>

<div>
<label>Tipo de documento</label>
<select name="documento_id">
<option value="">Seleccionar</option>
@foreach($tipos_doc as $item)
<option value="{{ $item->id }}" {{ old('documento_id') == $item->id ? 'selected' : '' }}>
{{ $item->nombre }}
</option>
@endforeach
</select>
</div>

<div>
<label>DNI *</label>
<input type="text" name="dni" value="{{ old('dni') }}">
</div>
<div>
<label>CUIL</label>
<input type="text" name="cuil" value="{{ old('cuil') }}">
</div>
<div>
<label>Sexo</label>
<select name="sexo_id">
<option value="">Seleccionar</option>
@foreach($sexos as $item)
<option value="{{ $item->id }}" {{ old('sexo_id') == $item->id ? 'selected' : '' }}>
{{ $item->nombre }}
</option>
@endforeach
</select>
</div>
<div>
<label>Estado civil</label>
<select name="estado_civil_id">
<option value="">Seleccionar</option>
@foreach($estados_civiles as $item)
<option value="{{ $item->id }}" {{ old('estado_civil_id') == $item->id ? 'selected' : '' }}>
{{ $item->nombre }}
</option>
@endforeach
</select>
</div>
<div>
<label>Fecha de nacimiento</label>
<input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}">
</div>

<div>
<label>Grupo sanguíneo</label>
<select name="grupo_sanguineo">
<option value="">Seleccionar</option>
@foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-','NS/NR'] as $gs)
<option value="{{ $gs }}" {{ old('grupo_sanguineo') == $gs ? 'selected' : '' }}>{{ $gs }}</option>
@endforeach
</select>
</div>

<div>
<label>Nivel de estudio</label>
<select name="nivel_estudio_id">
<option value="">Seleccionar</option>
@foreach($niveles as $item)
<option value="{{ $item->id }}" {{ old('nivel_estudio_id') == $item->id ? 'selected' : '' }}>
{{ $item->nombre }}
</option>
@endforeach
</select>
</div>

</div>

<div style="margin-top:15px">
<label>
<input type="checkbox" name="trabaja" value="1" {{ old('trabaja') ? 'checked' : '' }}>
Trabaja actualmente
</label>
</div>

</div>
</div>

<div class="section">
<div class="section-header">Contacto</div>
<div class="section-body">
<div class="grid grid-2">

<div>
<label>Teléfono</label>
<input type="tel" name="telefono" value="{{ old('telefono') }}">
</div>

<div>
<label>Correo</label>
<input type="email" name="correo" value="{{ old('correo') }}">
</div>

</div>
</div>
</div>
<div class="section">
<div class="section-header">Domicilio</div>
<div class="section-body">
<div class="grid grid-2">

<div class="col-span-2">
<label>Provincia</label>
<select name="provincia_id">
<option value="">Seleccionar</option>
@foreach($provincias as $item)
<option value="{{ $item->id }}" {{ old('provincia_id') == $item->id ? 'selected' : '' }}>
{{ $item->nombre }}
</option>
@endforeach
</select>
</div>

<div class="col-span-2">
<label>Localidad</label>
<select name="localidad_id">
<option value="">Seleccionar</option>
@foreach($localidades as $item)
<option value="{{ $item->id }}" {{ old('localidad_id') == $item->id ? 'selected' : '' }}>
{{ $item->nombre }}
</option>
@endforeach
</select>
</div>

<div class="col-span-2">
<label>Barrio</label>
<select name="barrio_id">
<option value="">Seleccionar</option>
@foreach($barrios as $item)
<option value="{{ $item->id }}" {{ old('barrio_id') == $item->id ? 'selected' : '' }}>
{{ $item->nombre }}
</option>
@endforeach
</select>
</div>

<div class="col-span-2">
<label>Calle</label>
<input type="text" name="calle" value="{{ old('calle') }}">
</div>

<div>
<label>Número</label>
<input type="text" name="numero" value="{{ old('numero') }}">
</div>

<div>
<label>Piso</label>
<input type="text" name="piso" value="{{ old('piso') }}">
</div>

<div>
<label>Dpto</label>
<input type="text" name="dpto" value="{{ old('dpto') }}">
</div>

</div>
</div>
</div>

<div class="section">
<div class="section-header">Sistema</div>
<div class="section-body">

<div>
<label>Sede de origen</label>
<select name="sede_origen_id">
<option value="">Seleccionar</option>
@foreach($sedes as $item)
<option value="{{ $item->id }}" {{ old('sede_origen_id') == $item->id ? 'selected' : '' }}>
{{ $item->nombre }}
</option>
@endforeach
</select>
</div>

</div>
</div>

<div style="display:flex;justify-content:space-between;margin-top:20px">

<button type="submit" class="btn btn-primary">Guardar persona</button>
</div>

</form>

</div>

</body>
</html>