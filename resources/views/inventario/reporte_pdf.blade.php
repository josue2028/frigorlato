<!DOCTYPE html>
<html>
<head>
    <title>Reporte de inventario</title>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #4A4A4A; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #e2aeb0; padding: 8px; text-align: left; }
        th { background-color: #900C0F; color: #FDF8F0; }
        h2 { color: #900C0F; }
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
