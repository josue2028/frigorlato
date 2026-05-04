<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="section-title">Gestion de contratos</h1>
            <p class="mt-1 text-sm text-slate-600">Adjunta, consulta, descarga y elimina documentos PDF o DOCX asociados a tus lotes.</p>
        </div>
    </x-slot>

    <section class="card max-w-3xl p-6">
        <form method="POST" action="{{ route('admin.contratos.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="lote_id" class="form-label">Lote asociado</label>
                <select id="lote_id" name="lote_id" class="form-input">
                    <option value="">Sin lote especifico</option>
                    @foreach ($lotes as $lote)
                        <option value="{{ $lote->id }}" @selected(old('lote_id') == $lote->id)>{{ $lote->numero_lote }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="archivo" class="form-label">Archivo del contrato</label>
                <input id="archivo" name="archivo" type="file" class="form-input py-2" accept=".pdf,.docx" required>
                <p class="mt-2 text-sm text-slate-500">Formatos permitidos: PDF y DOCX. Tamano maximo: 5 MB.</p>
            </div>

            <button type="submit" class="btn-primary">Guardar contrato</button>
        </form>
    </section>

    <section class="card mt-6 p-6">
        <form method="GET" action="{{ route('admin.contratos.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="min-w-56">
                <label for="filtro_lote_id" class="form-label">Filtrar por lote</label>
                <select id="filtro_lote_id" name="lote_id" class="form-input">
                    <option value="">Todos</option>
                    @foreach ($lotes as $lote)
                        <option value="{{ $lote->id }}" @selected(($filtros['lote_id'] ?? null) == $lote->id)>{{ $lote->numero_lote }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-primary">Filtrar</button>
            <a href="{{ route('admin.contratos.index') }}" class="btn-secondary">Limpiar</a>
        </form>
    </section>

    <section class="table-shell mt-6">
        <div class="overflow-x-auto">
            <table class="table-base">
                <thead class="bg-brand-50 text-left text-xs uppercase tracking-[0.2em] text-brand-900">
                    <tr>
                        <th class="px-6 py-4">Archivo</th>
                        <th class="px-6 py-4">Lote asociado</th>
                        <th class="px-6 py-4">Cargado</th>
                        <th class="px-6 py-4">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-100 bg-white">
                    @forelse ($contratos as $contrato)
                        <tr>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $contrato->nombre_archivo }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $contrato->lote?->numero_lote ?? 'Sin lote' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $contrato->created_at?->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.contratos.download', $contrato) }}" class="btn-secondary">Descargar</a>
                                    <form method="POST" action="{{ route('admin.contratos.destroy', $contrato) }}" onsubmit="return confirm('Confirma la eliminacion definitiva del contrato.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-secondary border-red-200 text-red-700 hover:bg-red-50">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">No hay contratos registrados con los filtros aplicados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-6">
        {{ $contratos->links() }}
    </div>
</x-app-layout>
