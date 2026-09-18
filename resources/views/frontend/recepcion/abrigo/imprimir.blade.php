<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Entregas de abrigo</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #222; }
        h1 { font-size: 20px; margin-bottom: 4px; }
        p { color: #666; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 7px; text-align: left; }
        th { background: #f1f3f5; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <button class="no-print" onclick="window.print()">Imprimir</button>
    <h1>Entregas de colchones y frazadas</h1>
    <p>Listado generado el {{ now()->format('d/m/Y H:i') }}</p>
    <table>
        <thead><tr><th>Persona</th><th>DNI</th><th>Colchones</th><th>Frazadas</th><th>Fecha</th></tr></thead>
        <tbody>
            @foreach($entregas as $entrega)
                <tr>
                    <td>{{ $entrega->apellido }}, {{ $entrega->nombre }}</td>
                    <td>{{ $entrega->dni ?: 'S/D' }}</td>
                    <td>{{ $entrega->colchones }}</td>
                    <td>{{ $entrega->frazadas }}</td>
                    <td>{{ $entrega->fecha_entrega->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
