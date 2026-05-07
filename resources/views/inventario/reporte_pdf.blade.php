<!DOCTYPE html>
<html>
<head>
    <title>Reporte de inventario</title>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #00c9a7; color: white; }
        h2 { color: #333; }
    </style>
</head>
<body>
    <h2>Reporte de Inventario - Frigorlato</h2>
    <p>Fecha de generacion: {{ $generatedAt->format('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>Lote</th>
                <th>Fecha entrada</th>
                <th>Fecha vencimiento</th>
                <th>Entrada</th>
                <th>Saldo actual</th>
                <th>Editado por</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventario as $item)
            <tr>
                <td>{{ $item->numero_lote }}</td>
                <td>{{ $item->fecha_entrada->format('Y-m-d') }}</td>
                <td>{{ $item->fecha_vencimiento->format('Y-m-d') }}</td>
                <td>{{ number_format($item->cantidad_entrada, 2) }} lb</td>
                <td>{{ number_format($item->saldo_disponible, 2) }} lb</td>
                <td>{{ $item->user?->editor_label ?? 'Sin registro' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
