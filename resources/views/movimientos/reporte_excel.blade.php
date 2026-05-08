<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $titulo }}</title>
    <style>
        body { font-family: Calibri, Arial, sans-serif; color: #4A4A4A; }
        .sheet-title { font-size: 20px; font-weight: bold; color: #900C0F; margin-bottom: 4px; }
        .sheet-meta { margin-bottom: 18px; color: #4A4A4A; }
        .section-title { margin: 18px 0 8px; font-size: 16px; font-weight: bold; color: #900C0F; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th, td { border: 1px solid #e2aeb0; padding: 10px 12px; }
        th { background: #900C0F; color: #FDF8F0; font-weight: bold; text-align: left; }
        tr:nth-child(even) td { background: #f8ebeb; }
    </style>
</head>
<body>
    <div class="sheet-title">{{ $titulo }}</div>
    <div class="sheet-meta">Fecha de generacion: {{ $generatedAt->format('d/m/Y H:i') }}</div>

    @if ($scope !== 'salidas')
        <div class="section-title">Historial de lotes</div>
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
        <div class="section-title">Historial de salidas</div>
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
                @forelse ($movimientos as $movimiento)
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
