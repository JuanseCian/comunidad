<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:11px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid #000;
    padding:5px;
}

.titulo{
    text-align:center;
    font-size:18px;
    font-weight:bold;
    margin-bottom:20px;
}

.seccion{
    margin-top:20px;
    margin-bottom:10px;
    font-weight:bold;
    background:#eee;
    padding:5px;
}

</style>

</head>

<body>

<div class="titulo">
    PLAN MÁS VIDA
    <br>
    FICHA SOCIAL
</div>

<div class="seccion">
    DATOS GENERALES
</div>

<table>

<tr>
    <td width="25%">
        Nombre
    </td>

    <td>
        {{ $ficha->beneficio->persona->apellido }},
        {{ $ficha->beneficio->persona->nombre }}
    </td>
</tr>

<tr>
    <td>DNI</td>
    <td>{{ $ficha->beneficio->persona->dni }}</td>
</tr>

<tr>
    <td>Teléfono</td>
    <td>{{ $ficha->beneficio->persona->telefono }}</td>
</tr>

<tr>
    <td>Barrio</td>
    <td>
        {{ optional($ficha->beneficio->persona->domicilio?->barrio)->nombre }}
    </td>
</tr>

<tr>
    <td>Grupo Familiar</td>
    <td>
        {{ $ficha->beneficio->persona->familia->codigo }}
    </td>
</tr>

</table>
<div class="seccion">
    GRUPO FAMILIAR
</div>

<table>

<thead>

<tr>
    <th>Apellido y Nombre</th>
    <th>Vínculo</th>
    <th>DNI</th>
    <th>Vacunas</th>
    <th>AUH</th>
</tr>

</thead>

<tbody>

@foreach($ficha->integrantes as $integrante)

<tr>

    <td>{{ $integrante->apellido_nombre }}</td>

    <td>{{ $integrante->vinculo }}</td>

    <td>{{ $integrante->cuil_dni }}</td>

    <td>
        {{ $integrante->vacunas ? 'SI' : 'NO' }}
    </td>

    <td>
        {{ $integrante->auh ? 'SI' : 'NO' }}
    </td>

</tr>

@endforeach

</tbody>

</table>
<div class="seccion">
    INFORME SOCIAL
</div>

<p>
    <strong>Observaciones:</strong><br>
    {{ $ficha->observaciones }}
</p>

<p>
    <strong>Situación Vivienda:</strong><br>
    {{ $ficha->situacion_vivienda }}
</p>

<p>
    <strong>Familia Numerosa:</strong><br>
    {{ $ficha->familia_numerosa }}
</p>

<p>
    <strong>Casos Judiciales:</strong><br>
    {{ $ficha->casos_judiciales }}
</p>

<p>
    <strong>Violencia Familiar:</strong><br>
    {{ $ficha->violencia_familiar }}
</p>

<p>
    <strong>Desnutrición:</strong><br>
    {{ $ficha->desnutricion }}
</p>

<p>
    <strong>Situación Salud:</strong><br>
    {{ $ficha->situacion_salud }}
</p>

<p>
    <strong>Situación Laboral:</strong><br>
    {{ $ficha->situacion_laboral }}
</p>
<br><br><br>

<table style="border:none">

<tr>

<td style="border:none; text-align:center;">

_________________________________

<br>

{{ $ficha->trabajador_social }}

<br>

Trabajador Social

</td>

</tr>

</table>

</body>
</html>