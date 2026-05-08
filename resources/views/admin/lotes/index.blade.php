<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="section-kicker">Lotes</p>
                <h1 class="section-title mt-3">Gestion de lotes</h1>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">Crea, actualiza y elimina lotes sin movimientos asociados, con una tabla mas limpia y paginada.</p>
            </div>
            <a href="{{ route('admin.lotes.create') }}" class="btn-primary">Nuevo lote</a>
        </div>
    </x-slot>

    <section class="table-shell">
        <div class="flex items-center justify-between border-b border-brand-100/70 px-6 py-5">
            <div>
                <p class="section-kicker">Listado</p>
                <h2 class="mt-2 text-xl font-semibold text-brand-900">Lotes registrados</h2>
            </div>
            <span class="pill-tab">{{ $lotes->total() }} registros</span>
        </div>
        <div class="overflow-x-auto">
            <table class="table-base">
                <thead class="bg-brand-50/80 text-left text-xs uppercase tracking-[0.24em] text-brand-800">
                    <tr>
                        <th class="px-6 py-4">Numero</th>
                        <th class="px-6 py-4">Entrada</th>
                        <th class="px-6 py-4">Vencimiento</th>
                        <th class="px-6 py-4">Cantidad</th>
                        <th class="px-6 py-4">Saldo</th>
                        <th class="px-6 py-4">Movimientos</th>
                        <th class="px-6 py-4">Editado por</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-100/60 bg-white/90">
                    @forelse ($lotes as $lote)
                        <tr class="hover:bg-brand-50/45">
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $lote->numero_lote }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $lote->fecha_entrada->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $lote->fecha_vencimiento->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">{{ number_format($lote->cantidad_entrada, 2) }} lb</td>
                            <td class="px-6 py-4">{{ number_format($lote->saldo_disponible, 2) }} lb</td>
                            <td class="px-6 py-4">{{ $lote->movimientos_count }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $lote->user?->editor_label ?? 'Sin registro' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.lotes.edit', $lote) }}" class="table-action">Editar</a>
                                    <form method="POST" action="{{ route('admin.lotes.destroy', $lote) }}" onsubmit="return confirm('Confirma la eliminacion de este lote.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-action border-red-200 text-red-700 hover:bg-red-50">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-slate-500">No hay lotes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{ $lotes->onEachSide(1)->links() }}
</x-app-layout>
