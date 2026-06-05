<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Mercaderías - Municipalidad de San Nicolás</title>

    <style>
        /* CONFIGURACIÓN DE PÁGINA E IMPRESIÓN */
        @page {
            size: A4;
            /* Se aumentó el margen inferior (bottom) a 30mm para que la tabla nunca pise el footer negro */
            margin: 20mm 15mm 30mm 15mm;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            font-size: 11px;
        }

        /* CABECERA DEL DOCUMENTO */
        .header-container {
            border-bottom: 3px solid #0056b3; /* Azul institucional SN */
            padding-bottom: 12px;
            margin-bottom: 25px;
            display: table;
            width: 100%;
        }

        .header-title-cell {
            display: table-cell;
            vertical-align: middle;
        }

        .header-meta-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            color: #666666;
            font-size: 10px;
        }

        h1 {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 4px 0;
            color: #1a1a1a;
            letter-spacing: -0.5px;
        }

        .subtitle {
            font-size: 12px;
            color: #0056b3;
            margin: 0;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* INFORMACIÓN DE RESUMEN */
        .summary-box {
            background-color: #f4f6f9;
            border-left: 4px solid #0056b3;
            padding: 10px 15px;
            margin-bottom: 20px;
            font-size: 11px;
            /* Fuerza el renderizado del fondo gris en la impresión */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* TABLA ESTILIZADA */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th {
            background-color: #0056b3;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
            padding: 8px 10px;
            border: 1px solid #004b9b;
            text-align: left;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        th.text-center, td.text-center {
            text-align: center;
        }

        td {
            padding: 8px 10px; /* Un poquito más de aire en las celdas */
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
        }

        /* Filas alternas */
        tr:nth-child(even) td {
            background-color: #f8fafc;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* PIE DE PÁGINA FIJO EN NEGRO */
        .footer-container {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            background-color: #000000 !important;
            padding: 12px 20px; /* Padding equilibrado para contener el logo */
            display: table;
            box-sizing: border-box;
            
            /* Súper importante: fuerza al navegador a imprimir el fondo negro */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .footer-logo-cell {
            display: table-cell;
            vertical-align: middle;
            width: 150px;
        }

        .footer-text-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            font-size: 11px;
            font-weight: 700;
            color: #ffffff !important; /* Texto en blanco para contrastar */
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .logo-sn {
            height: 60px; /* Ajuste leve de tamaño para que calce perfecto */
            width: auto;
            display: block;
        }

        /* Evita cortes feos de filas entre páginas */
        tr {
            page-break-inside: avoid;
        }
    </style>
</head>
<body onload="window.print()">

    {{-- CABECERA INSTITUCIONAL --}}
    <div class="header-container">
        <div class="header-title-cell">
            <h1>Listado de Entregas de Mercadería</h1>
            <p class="subtitle">Control y Registro de Asistencias</p>
        </div>
        <div class="header-meta-cell">
            Fecha de Impresión: {{ now()->format('d/m/Y') }}<br>
            Filtros aplicados: {{ request('search') ? 'Búsqueda ("'.request('search').'")' : 'Todos' }}
        </div>
    </div>

    {{-- RECUENTO DE ASISTENCIAS --}}
    <div class="summary-box">
        <strong>Total de Registros Emitidos:</strong> {{ $mercaderias->count() }} entregas.
    </div>

    {{-- TABLA DE DATOS --}}
    <table>
        <thead>
            <tr>
                <th width="50" class="text-center">ID</th>
                <th>Apellido</th>
                <th>Nombre</th>
                <th width="100">DNI</th>
                <th width="110" class="text-center">Fecha Entrega</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mercaderias as $m)
                <tr>
                    <td class="text-center" style="font-weight: bold; color: #718096;">#{{ $m->id }}</td>
                    <td>{{ $m->apellido }}</td>
                    <td>{{ $m->nombre }}</td>
                    <td>{{ $m->dni ?? '---' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($m->fecha_entrega)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- PIE DE PÁGINA CON FILIACIÓN INSTITUCIONAL EN NEGRO --}}
    <div class="footer-container">
        <div class="footer-logo-cell">
            <img src="{{ asset('assets/img/municipalidad_logo.png') }}" class="logo-sn" alt="Municipalidad de San Nicolás">
        </div>
        <div class="footer-text-cell">
            Secretaría de Desarrollo Humano
        </div>
    </div>

</body>
</html>