<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $titulo }}</title>
    <style>
        body { font-family: Calibri, Arial, sans-serif; color: #1e293b; }
        .sheet-title { font-size: 20px; font-weight: bold; color: #0f172a; margin-bottom: 4px; }
        .sheet-meta { margin-bottom: 18px; color: #475569; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 10px 12px; }
        th { background: #0f766e; color: #ffffff; font-weight: bold; text-align: left; }
        tr:nth-child(even) td { background: #f8fafc; }
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
