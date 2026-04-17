<!DOCTYPE html>
<html>
<head>
    <title>Reporte Frigorlato</title>
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
    <p>Fecha de generación: {{ date('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>Lote</th>
                <th>Entrada</th>
                <th>Saldo Actual</th>
                <th>Vencimiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventario as $item)
            <tr>
                <td>{{ $item->numero_lote }}</td>
                <td>{{ $item->cantidad_entrada_libras }} Lbs</td>
                <td>{{ $item->saldo_actual_libras }} Lbs</td>
                <td>{{ $item->fecha_vencimiento }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>