<!DOCTYPE html>
<html>
<head>
    <title>{{ $titulo }}</title>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #4A4A4A; }
        h1 { color: #900C0F; margin-bottom: 6px; }
        h2 { color: #900C0F; margin: 26px 0 10px; font-size: 18px; }
        p { margin: 0 0 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #e2aeb0; padding: 8px; text-align: left; font-size: 11px; }
        th { background-color: #900C0F; color: #FDF8F0; }
        tbody tr:nth-child(even) td { background: #f8ebeb; }
    </style>
</head>
<body>
    <h1>{{ $titulo }}</h1>
    <p>Fecha de generacion: {{ $generatedAt->format('d/m/Y H:i') }}</p>

    @if ($scope !== 'salidas')
        <h2>Historial de lotes</h2>
        <table>
            <thead>
                <tr>
                    <th>Lote</th>
                    <th>Entrada</th>
                    <th>Vencimiento</th>
                    <th>Cantidad</th>
                    <th>Salidas</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lotesHistorial as $lote)
                    <tr>
                        <td>{{ $lote->numero_lote }}</td>
                        <td>{{ $lote->fecha_entrada->format('Y-m-d') }}</td>
                        <td>{{ $lote->fecha_vencimiento->format('Y-m-d') }}</td>
                        <td>{{ number_format($lote->cantidad_entrada, 2) }} lb</td>
                        <td>{{ $lote->movimientos_count }}</td>
                        <td>{{ $lote->user?->editor_label ?? 'Sin registro' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No hay registros de lotes para exportar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

    @if ($scope !== 'lotes')
        <h2>Historial de salidas</h2>
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
                @forelse($movimientos as $movimiento)
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
                @empty
                    <tr>
                        <td colspan="8">No hay registros de salidas para exportar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif
</body>
</html>
