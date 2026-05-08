<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="section-kicker">Documentacion</p>
                <h1 class="section-title mt-3">Gestion de contratos</h1>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">
                    Adjunta archivos por lote, visualizalos en linea y administra la documentacion sin duplicar pasos.
                </p>
            </div>
            <div class="rounded-[1.6rem] bg-brand-900 px-5 py-4 text-white shadow-soft">
                <p class="text-xs uppercase tracking-[0.28em] text-brand-200">Total visible</p>
                <p class="mt-2 text-2xl font-semibold">{{ $contratos->total() }}</p>
            </div>
        </div>
    </x-slot>

    <section class="grid gap-6 xl:grid-cols-[0.95fr_1.05fr]">
        <article class="card p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="section-kicker">Subir archivo</p>
                    <h2 class="mt-2 text-xl font-semibold text-brand-900">Nuevo contrato</h2>
                </div>
                <span class="rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-brand-700">PDF / DOCX</span>
            </div>

            <form method="POST" action="{{ route('admin.contratos.store') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
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

                <button type="submit" class="btn-primary w-full">Guardar contrato</button>
            </form>
        </article>

        <article class="card p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="section-kicker">Consulta</p>
                    <h2 class="mt-2 text-xl font-semibold text-brand-900">Filtrar contratos</h2>
                </div>
                <div class="rounded-[1.5rem] bg-brand-50/80 px-4 py-3 text-sm text-brand-800">
                    Usa la opcion <span class="font-semibold">Ver</span> para abrir el archivo en una nueva pestana.
                </div>
            </div>

            <form method="GET" action="{{ route('admin.contratos.index') }}" class="mt-6 flex flex-wrap items-end gap-4">
                <div class="min-w-56 flex-1">
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
        </article>
    </section>

    <section class="table-shell">
        <div class="flex items-center justify-between border-b border-brand-100/70 px-6 py-5">
            <div>
                <p class="section-kicker">Listado</p>
                <h2 class="mt-2 text-xl font-semibold text-brand-900">Contratos cargados</h2>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table-base">
                <thead class="bg-brand-50/80 text-left text-xs uppercase tracking-[0.24em] text-brand-800">
                    <tr>
                        <th class="px-6 py-4">Archivo</th>
                        <th class="px-6 py-4">Lote</th>
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4">Usuario</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-100/60 bg-white/90">
                    @forelse ($contratos as $contrato)
                        <tr class="hover:bg-brand-50/45">
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $contrato->nombre_archivo }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $contrato->lote?->numero_lote ?? 'Sin lote' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $contrato->created_at?->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $contrato->user?->editor_label ?? 'Sin registro' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap justify-end gap-2">
                                    <a href="{{ route('admin.contratos.show', $contrato) }}" target="_blank" rel="noopener" class="table-action">Ver</a>
                                    <a href="{{ route('admin.contratos.download', $contrato) }}" class="table-action">Descargar</a>
                                    <form method="POST" action="{{ route('admin.contratos.destroy', $contrato) }}" onsubmit="return confirm('Confirma la eliminacion definitiva del contrato.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-action border-red-200 text-red-700 hover:bg-red-50">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500">No hay contratos registrados con los filtros aplicados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{ $contratos->onEachSide(1)->links() }}
</x-app-layout>
