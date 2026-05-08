<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="section-kicker">Inventario</p>
                <h1 class="section-title mt-3">Inventario disponible</h1>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">Consulta lotes con saldo disponible, alertas de vencimiento y navegacion paginada.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.inventario.export.pdf', request()->query()) }}" class="btn-secondary">Exportar PDF</a>
                <a href="{{ route('admin.inventario.export.excel', request()->query()) }}" class="btn-secondary">Exportar Excel</a>
                <div class="rounded-[1.6rem] bg-brand-900 px-5 py-4 text-white shadow-soft">
                    <p class="text-xs uppercase tracking-[0.24em] text-brand-200">Stock total</p>
                    <p class="mt-2 text-2xl font-semibold">{{ number_format($stockTotal, 2) }} lb</p>
                </div>
            </div>
        </div>
    </x-slot>

    <section class="card p-6">
        <form method="GET" action="{{ route('admin.inventario.index') }}" class="grid gap-4 md:grid-cols-4">
            <div>
                <label for="numero_lote" class="form-label">Numero de lote</label>
                <input id="numero_lote" name="numero_lote" type="text" class="form-input" value="{{ $filtros['numero_lote'] ?? '' }}">
            </div>
            <div>
                <label for="fecha_desde" class="form-label">Fecha desde</label>
                <input id="fecha_desde" name="fecha_desde" type="date" class="form-input" value="{{ $filtros['fecha_desde'] ?? '' }}">
            </div>
            <div>
                <label for="fecha_hasta" class="form-label">Fecha hasta</label>
                <input id="fecha_hasta" name="fecha_hasta" type="date" class="form-input" value="{{ $filtros['fecha_hasta'] ?? '' }}">
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="btn-primary">Filtrar</button>
                <a href="{{ route('admin.inventario.index') }}" class="btn-secondary">Limpiar</a>
            </div>
        </form>
    </section>

    <section class="table-shell">
        <div class="flex items-center justify-between border-b border-brand-100/70 px-6 py-5">
            <div>
                <p class="section-kicker">Tabla</p>
                <h2 class="mt-2 text-xl font-semibold text-brand-900">Lotes con saldo disponible</h2>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table-base">
                <thead class="bg-brand-50/80 text-left text-xs uppercase tracking-[0.24em] text-brand-800">
                    <tr>
                        <th class="px-6 py-4">Numero lote</th>
                        <th class="px-6 py-4">Fecha entrada</th>
                        <th class="px-6 py-4">Fecha vencimiento</th>
                        <th class="px-6 py-4">Cantidad entrada</th>
                        <th class="px-6 py-4">Saldo disponible</th>
                        <th class="px-6 py-4">Editado por</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-100/60 bg-white/90">
                    @forelse ($lotes as $lote)
                        @php
                            $porVencer = now()->diffInDays($lote->fecha_vencimiento, false) <= 7;
                        @endphp
                        <tr @class(['bg-amber-50/60' => $porVencer, 'hover:bg-brand-50/45' => ! $porVencer])>
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $lote->numero_lote }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $lote->fecha_entrada->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $lote->fecha_vencimiento->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">{{ number_format($lote->cantidad_entrada, 2) }} lb</td>
                            <td class="px-6 py-4 font-semibold text-brand-900">{{ number_format($lote->saldo_disponible, 2) }} lb</td>
                            <td class="px-6 py-4 text-slate-600">{{ $lote->user?->editor_label ?? 'Sin registro' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-500">No hay lotes con saldo disponible.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{ $lotes->onEachSide(1)->links() }}
</x-app-layout>
