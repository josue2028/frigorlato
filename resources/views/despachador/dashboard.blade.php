<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="section-title">Agregar salida</h1>
            <p class="mt-1 text-sm text-slate-600">Registra salidas y consulta los movimientos recientes desde un mismo panel.</p>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <section class="space-y-6">
            <div class="card p-6">
                <p class="text-sm text-slate-500">Stock total disponible</p>
                <p class="mt-3 text-3xl font-semibold text-brand-900">{{ number_format($stockTotal, 2) }} lb</p>
                <a href="{{ route('salidas.create') }}" class="btn-primary mt-6">Registrar nueva salida</a>
            </div>

            <div class="table-shell">
                <div class="border-b border-brand-100 px-6 py-4">
                    <h2 class="text-lg font-semibold text-brand-900">Lotes disponibles</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-base">
                        <thead class="bg-brand-50 text-left text-xs uppercase tracking-[0.2em] text-brand-900">
                            <tr>
                                <th class="px-6 py-4">Lote</th>
                                <th class="px-6 py-4">Entrada</th>
                                <th class="px-6 py-4">Vencimiento</th>
                                <th class="px-6 py-4">Saldo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-brand-100 bg-white">
                            @forelse ($lotesDisponibles as $lote)
                                @php
                                    $porVencer = now()->diffInDays($lote->fecha_vencimiento, false) <= 7;
                                @endphp
                                <tr @class(['bg-red-50' => $porVencer])>
                                    <td class="px-6 py-4 font-medium text-slate-800">{{ $lote->numero_lote }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $lote->fecha_entrada->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $lote->fecha_vencimiento->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 font-semibold text-brand-900">{{ number_format($lote->saldo_disponible, 2) }} lb</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-6 text-center text-slate-500">No hay lotes disponibles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="table-shell">
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-6 text-center text-slate-500">Aun no hay movimientos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="card p-6">
            <h2 class="text-lg font-semibold text-brand-900">Lotes proximos a vencer</h2>
            <div class="mt-4 space-y-3">
                @forelse ($lotesProximosAVencer as $lote)
                    <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-4">
                        <p class="font-semibold text-brand-900">{{ $lote->numero_lote }}</p>
                        <p class="mt-1 text-sm text-slate-600">Entrada: {{ $lote->fecha_entrada->format('Y-m-d') }}</p>
                        <p class="text-sm text-slate-600">Vence: {{ $lote->fecha_vencimiento->format('Y-m-d') }}</p>
                        <p class="text-sm text-slate-600">Saldo: {{ number_format($lote->saldo_disponible, 2) }} lb</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-600">No hay lotes por vencer en los proximos 7 dias.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
