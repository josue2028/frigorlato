<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="section-title">Panel administrativo</h1>
                <p class="mt-1 text-sm text-slate-600">Control central de inventario, trazabilidad y documentos.</p>
            </div>
        </div>
    </x-slot>

    <section class="table-shell mt-6">
        <div class="border-b border-brand-100 px-6 py-4">
            <h2 class="text-lg font-semibold text-brand-900">Movimientos recientes</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="table-base">
                <thead class="bg-brand-50 text-left text-xs uppercase tracking-[0.2em] text-brand-900">
                    <tr>
                        <th class="px-6 py-4">Numero de salida</th>
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4">Lote</th>
                        <th class="px-6 py-4">Libras</th>
                        <th class="px-6 py-4">Saldo posterior</th>
                        <th class="px-6 py-4">Editado por</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-100 bg-white">
                    @forelse ($movimientosRecientes as $movimiento)
                        <tr>
                            <td class="px-6 py-4 font-semibold text-brand-900">{{ $movimiento->numero_salida }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $movimiento->fecha_salida->format('Y-m-d') }} {{ $movimiento->hora_salida }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $movimiento->lote?->numero_lote }}</td>
                            <td class="px-6 py-4">{{ number_format($movimiento->cantidad_libras, 2) }} lb</td>
                            <td class="px-6 py-4">{{ number_format($movimiento->saldo_posterior, 2) }} lb</td>
                            <td class="px-6 py-4 text-slate-600">{{ $movimiento->user?->editor_label ?? 'Sistema' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-slate-500">Aun no hay movimientos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="grid gap-6 mt-6 md:grid-cols-4">
        <section class="card p-6">
            <p class="text-sm text-slate-500">Lotes activos</p>
            <p class="mt-3 text-3xl font-semibold text-brand-900">{{ $lotesActivos }}</p>
        </section>

        <section class="card p-6">
            <p class="text-sm text-slate-500">Salidas registradas</p>
            <p class="mt-3 text-3xl font-semibold text-brand-900">{{ $salidasRegistradas }}</p>
        </section>

        <section class="card p-6">
            <p class="text-sm text-slate-500">Stock total disponible</p>
            <p class="mt-3 text-3xl font-semibold text-brand-900">{{ number_format($stockTotal, 2) }} lb</p>
        </section>

        <section class="card p-6">
            <p class="text-sm text-slate-500">Proximo vencimiento</p>
            @if ($proximoVencimiento)
                <p class="mt-3 text-xl font-semibold text-brand-900">{{ $proximoVencimiento->numero_lote }}</p>
                <p class="mt-1 text-sm text-slate-600">{{ $proximoVencimiento->fecha_vencimiento->format('Y-m-d') }}</p>
            @else
                <p class="mt-3 text-sm text-slate-600">No hay lotes activos.</p>
            @endif
        </section>
    </div>

    <section class="table-shell mt-6">
        <div class="border-b border-brand-100 px-6 py-4">
            <h2 class="text-lg font-semibold text-brand-900">Lotes activos</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="table-base">
                <thead class="bg-brand-50 text-left text-xs uppercase tracking-[0.2em] text-brand-900">
                    <tr>
                        <th class="px-6 py-4">Lote</th>
                        <th class="px-6 py-4">Entrada</th>
                        <th class="px-6 py-4">Vencimiento</th>
                        <th class="px-6 py-4">Saldo</th>
                        <th class="px-6 py-4">Editado por</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-100 bg-white">
                    @forelse ($lotesActivosRecientes as $lote)
                        <tr>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $lote->numero_lote }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $lote->fecha_entrada->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $lote->fecha_vencimiento->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 font-semibold text-brand-900">{{ number_format($lote->saldo_disponible, 2) }} lb</td>
                            <td class="px-6 py-4 text-slate-600">{{ $lote->user?->editor_label ?? 'Sin registro' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-slate-500">No hay lotes activos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
