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
                <th>Numero de salida</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Lote</th>
                <th>Libras</th>
                <th>Saldo anterior</th>
                <th>Saldo posterior</th>
                <th>Editado por</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimientos as $movimiento)
                <tr>
                    <td>{{ $movimiento->numero_salida }}</td>
                    <td>{{ $movimiento->fecha_salida->format('Y-m-d') }}</td>
                    <td>{{ $movimiento->hora_salida }}</td>
                    <td>{{ $movimiento->lote?->numero_lote }}</td>
                    <td>{{ number_format($movimiento->cantidad_libras, 2) }} lb</td>
                    <td>{{ number_format($movimiento->saldo_anterior, 2) }} lb</td>
                    <td>{{ number_format($movimiento->saldo_posterior, 2) }} lb</td>
                    <td>{{ $movimiento->user?->editor_label ?? 'Sistema' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
