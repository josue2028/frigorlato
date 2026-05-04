<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="section-title">Gestion de lotes</h1>
                <p class="mt-1 text-sm text-slate-600">Crea, actualiza y elimina lotes sin movimientos asociados.</p>
            </div>
            <a href="{{ route('admin.lotes.create') }}" class="btn-primary">Nuevo lote</a>
        </div>
    </x-slot>

    <section class="table-shell">
        <div class="overflow-x-auto">
            <table class="table-base">
                <thead class="bg-brand-50 text-left text-xs uppercase tracking-[0.2em] text-brand-900">
                    <tr>
                        <th class="px-6 py-4">Numero</th>
                        <th class="px-6 py-4">Entrada</th>
                        <th class="px-6 py-4">Vencimiento</th>
                        <th class="px-6 py-4">Cantidad</th>
                        <th class="px-6 py-4">Saldo</th>
                        <th class="px-6 py-4">Movimientos</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-100 bg-white">
                    @forelse ($lotes as $lote)
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $lote->numero_lote }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $lote->fecha_entrada->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $lote->fecha_vencimiento->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">{{ number_format($lote->cantidad_entrada, 2) }} lb</td>
                            <td class="px-6 py-4">{{ number_format($lote->saldo_disponible, 2) }} lb</td>
                            <td class="px-6 py-4">{{ $lote->movimientos_count }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('admin.lotes.edit', $lote) }}" class="btn-secondary">Editar</a>
                                    <form method="POST" action="{{ route('admin.lotes.destroy', $lote) }}" onsubmit="return confirm('Confirma la eliminacion de este lote.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-700 transition hover:bg-red-100">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-500">No hay lotes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-6">
        {{ $lotes->links() }}
    </div>
</x-app-layout>
