<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="section-title">{{ $titulo }}</h1>
                <p class="mt-1 text-sm text-slate-600">Consulta completa y trazable de movimientos por lote, fecha y cantidad.</p>
            </div>
            @if (request()->routeIs('admin.*'))
                <div class="flex gap-3">
                    <a href="{{ route('admin.historial.export.pdf', request()->query()) }}" class="btn-secondary">Exportar PDF</a>
                    <a href="{{ route('admin.historial.export.excel', request()->query()) }}" class="btn-secondary">Exportar Excel</a>
                </div>
            @endif
        </div>
    </x-slot>

    <section class="card p-6">
        <form method="GET" action="{{ url()->current() }}" class="grid gap-4 md:grid-cols-5">
            <div>
                <label for="fecha_desde" class="form-label">Fecha desde</label>
                <input id="fecha_desde" name="fecha_desde" type="date" class="form-input" value="{{ $filtros['fecha_desde'] ?? '' }}">
            </div>
            <div>
                <label for="fecha_hasta" class="form-label">Fecha hasta</label>
                <input id="fecha_hasta" name="fecha_hasta" type="date" class="form-input" value="{{ $filtros['fecha_hasta'] ?? '' }}">
            </div>
            <div>
                <label for="lote_id" class="form-label">Lote</label>
                <select id="lote_id" name="lote_id" class="form-input">
                    <option value="">Todos</option>
                    @foreach ($lotes as $lote)
                        <option value="{{ $lote->id }}" @selected(($filtros['lote_id'] ?? null) == $lote->id)>{{ $lote->numero_lote }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="cantidad_min" class="form-label">Cantidad minima</label>
                <input id="cantidad_min" name="cantidad_min" type="number" step="0.01" class="form-input" value="{{ $filtros['cantidad_min'] ?? '' }}">
            </div>
            <div>
                <label for="cantidad_max" class="form-label">Cantidad maxima</label>
                <input id="cantidad_max" name="cantidad_max" type="number" step="0.01" class="form-input" value="{{ $filtros['cantidad_max'] ?? '' }}">
            </div>
            <div class="md:col-span-5 flex gap-3">
                <button type="submit" class="btn-primary">Filtrar</button>
                <a href="{{ url()->current() }}" class="btn-secondary">Limpiar</a>
            </div>
        </form>
    </section>

    <section class="table-shell mt-6">
        <div class="overflow-x-auto">
            <table class="table-base">
                <thead class="bg-brand-50 text-left text-xs uppercase tracking-[0.2em] text-brand-900">
                    <tr>
                        <th class="px-6 py-4">Numero de salida</th>
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4">Hora</th>
                        <th class="px-6 py-4">Libras</th>
                        <th class="px-6 py-4">Lote</th>
                        <th class="px-6 py-4">Saldo anterior</th>
                        <th class="px-6 py-4">Saldo restante</th>
                        <th class="px-6 py-4">Editado por</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-100 bg-white">
                    @forelse ($movimientos as $movimiento)
                        <tr>
                            <td class="px-6 py-4 font-semibold text-brand-900">{{ $movimiento->numero_salida }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $movimiento->fecha_salida->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $movimiento->hora_salida }}</td>
                            <td class="px-6 py-4 font-semibold text-brand-900">{{ number_format($movimiento->cantidad_libras, 2) }} lb</td>
                            <td class="px-6 py-4">{{ $movimiento->lote?->numero_lote }}</td>
                            <td class="px-6 py-4">{{ number_format($movimiento->saldo_anterior, 2) }} lb</td>
                            <td class="px-6 py-4">{{ number_format($movimiento->saldo_posterior, 2) }} lb</td>
                            <td class="px-6 py-4 text-slate-600">{{ $movimiento->user?->editor_label ?? 'Sistema' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-slate-500">No se encontraron movimientos con los filtros aplicados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-6">
        {{ $movimientos->links() }}
    </div>
</x-app-layout>
