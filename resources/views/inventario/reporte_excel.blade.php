<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $titulo }}</title>
    <style>
        body { font-family: Calibri, Arial, sans-serif; color: #4A4A4A; }
        .sheet-title { font-size: 20px; font-weight: bold; color: #900C0F; margin-bottom: 4px; }
        .sheet-meta { margin-bottom: 18px; color: #4A4A4A; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e2aeb0; padding: 10px 12px; }
        th { background: #900C0F; color: #FDF8F0; font-weight: bold; text-align: left; }
        tr:nth-child(even) td { background: #f8ebeb; }
    </style>
</head>
<body>
    <div class="sheet-title">{{ $titulo }}</div>
    <div class="sheet-meta">Fecha de generacion: {{ $generatedAt->format('d/m/Y H:i') }}</div>
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
            @foreach ($inventario as $item)
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
