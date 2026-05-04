<!DOCTYPE html>
<html>
<head>
    <title>Reporte de movimientos</title>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #00c9a7; color: white; }
        h2 { color: #333; }
    </style>
</head>
<body>
    <h2>Reporte de Movimientos - Frigorlato</h2>
    <p>Fecha de generacion: {{ $generatedAt->format('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>Numero de salida</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Lote</th>
                <th>Libras</th>
                <th>Saldo anterior</th>
                <th>Saldo posterior</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $movimiento)
            <tr>
                <td>{{ $movimiento->numero_salida }}</td>
                <td>{{ $movimiento->fecha_salida->format('Y-m-d') }}</td>
                <td>{{ $movimiento->hora_salida }}</td>
                <td>{{ $movimiento->lote?->numero_lote }}</td>
                <td>{{ number_format($movimiento->cantidad_libras, 2) }} lb</td>
                <td>{{ number_format($movimiento->saldo_anterior, 2) }} lb</td>
                <td>{{ number_format($movimiento->saldo_posterior, 2) }} lb</td>
                <td>{{ $movimiento->user?->name ?? 'Sistema' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
