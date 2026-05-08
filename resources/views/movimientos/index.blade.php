<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
            <div>
                <p class="section-kicker">Trazabilidad</p>
                <h1 class="section-title mt-3">{{ $titulo }}</h1>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">
                    Consulta lotes y salidas por separado, y genera un reporte general con rango de fechas cuando lo necesites.
                </p>
            </div>

            @if (request()->routeIs('admin.*'))
                <section class="card w-full max-w-xl p-5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="section-kicker">Reporte general</p>
                            <h2 class="mt-2 text-lg font-semibold text-brand-900">Exportar lotes y salidas</h2>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('admin.historial.export.pdf') }}" class="mt-5 grid gap-4 md:grid-cols-3" x-data
                        onsubmit="
                            const format = this.querySelector('[name=format]').value;
                            this.action = format === 'excel' ? '{{ route('admin.historial.export.excel') }}' : '{{ route('admin.historial.export.pdf') }}';
                        ">
                        <input type="hidden" name="scope" value="general">
                        <div>
                            <label for="general_desde" class="form-label">Fecha desde</label>
                            <input id="general_desde" name="general_desde" type="date" class="form-input" value="{{ $filtrosGeneral['general_desde'] ?? '' }}">
                        </div>
                        <div>
                            <label for="general_hasta" class="form-label">Fecha hasta</label>
                            <input id="general_hasta" name="general_hasta" type="date" class="form-input" value="{{ $filtrosGeneral['general_hasta'] ?? '' }}">
                        </div>
                        <div>
                            <label for="formato_general" class="form-label">Exportar en</label>
                            <select id="formato_general" name="format" class="form-input" onchange="if(this.value){ this.form.requestSubmit(); }">
                                <option value="">Seleccionar</option>
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                            </select>
                        </div>
                    </form>
                </section>
            @endif
        </div>
    </x-slot>

    <section class="grid gap-6 xl:grid-cols-2">
        <article class="card p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="section-kicker">Historial 01</p>
                    <h2 class="mt-2 text-xl font-semibold text-brand-900">Lotes</h2>
                </div>
                <div class="flex items-center gap-3">
                    <span class="pill-tab">{{ $lotesHistorial->total() }} registros</span>
                    <form method="GET" action="{{ route('admin.historial.export.pdf') }}" class="flex items-center gap-2"
                        onsubmit="
                            const format = this.querySelector('[name=format]').value;
                            this.action = format === 'excel' ? '{{ route('admin.historial.export.excel') }}' : '{{ route('admin.historial.export.pdf') }}';
                        ">
                        <input type="hidden" name="scope" value="lotes">
                        <input type="hidden" name="numero_lote" value="{{ $filtrosLotes['numero_lote'] ?? '' }}">
                        <input type="hidden" name="entrada_desde" value="{{ $filtrosLotes['entrada_desde'] ?? '' }}">
                        <input type="hidden" name="entrada_hasta" value="{{ $filtrosLotes['entrada_hasta'] ?? '' }}">
                        <label class="text-sm font-medium text-charcoal">Exportar en</label>
                        <select name="format" class="form-input min-w-36 py-2" onchange="if(this.value){ this.form.requestSubmit(); }">
                            <option value="">Seleccionar</option>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </form>
                </div>
            </div>

            <form method="GET" action="{{ url()->current() }}" class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="numero_lote" class="form-label">Numero de lote</label>
                    <input id="numero_lote" name="numero_lote" type="text" class="form-input" value="{{ $filtrosLotes['numero_lote'] ?? '' }}">
                </div>
                <div>
                    <label for="entrada_desde" class="form-label">Entrada desde</label>
                    <input id="entrada_desde" name="entrada_desde" type="date" class="form-input" value="{{ $filtrosLotes['entrada_desde'] ?? '' }}">
                </div>
                <div>
                    <label for="entrada_hasta" class="form-label">Entrada hasta</label>
                    <input id="entrada_hasta" name="entrada_hasta" type="date" class="form-input" value="{{ $filtrosLotes['entrada_hasta'] ?? '' }}">
                </div>
                <div class="md:col-span-2 flex flex-wrap gap-3">
                    <button type="submit" class="btn-primary">Filtrar lotes</button>
                    <a href="{{ url()->current() }}" class="btn-secondary">Limpiar</a>
                </div>
            </form>

            <div class="mt-6 overflow-x-auto">
                <table class="table-base">
                    <thead class="bg-brand-50/80 text-left text-xs uppercase tracking-[0.24em] text-brand-800">
                        <tr>
                            <th class="px-5 py-4">Lote</th>
                            <th class="px-5 py-4">Entrada</th>
                            <th class="px-5 py-4">Vencimiento</th>
                            <th class="px-5 py-4">Cantidad</th>
                            <th class="px-5 py-4">Salidas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-100/60 bg-white/90">
                        @forelse ($lotesHistorial as $lote)
                            <tr class="hover:bg-brand-50/45">
                                <td class="px-5 py-4 font-semibold text-brand-900">{{ $lote->numero_lote }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $lote->fecha_entrada->format('Y-m-d') }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $lote->fecha_vencimiento->format('Y-m-d') }}</td>
                                <td class="px-5 py-4">{{ number_format($lote->cantidad_entrada, 2) }} lb</td>
                                <td class="px-5 py-4 text-slate-600">{{ $lote->movimientos_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-slate-500">No se encontraron lotes con los filtros aplicados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $lotesHistorial->onEachSide(1)->links() }}
            </div>
        </article>

        <article class="card p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="section-kicker">Historial 02</p>
                    <h2 class="mt-2 text-xl font-semibold text-brand-900">Salidas</h2>
                </div>
                <div class="flex items-center gap-3">
                    <span class="pill-tab">{{ $movimientos->total() }} registros</span>
                    <form method="GET" action="{{ route('admin.historial.export.pdf') }}" class="flex items-center gap-2"
                        onsubmit="
                            const format = this.querySelector('[name=format]').value;
                            this.action = format === 'excel' ? '{{ route('admin.historial.export.excel') }}' : '{{ route('admin.historial.export.pdf') }}';
                        ">
                        <input type="hidden" name="scope" value="salidas">
                        <input type="hidden" name="fecha_desde" value="{{ $filtrosSalidas['fecha_desde'] ?? '' }}">
                        <input type="hidden" name="fecha_hasta" value="{{ $filtrosSalidas['fecha_hasta'] ?? '' }}">
                        <input type="hidden" name="lote_id" value="{{ $filtrosSalidas['lote_id'] ?? '' }}">
                        <input type="hidden" name="cantidad_min" value="{{ $filtrosSalidas['cantidad_min'] ?? '' }}">
                        <input type="hidden" name="cantidad_max" value="{{ $filtrosSalidas['cantidad_max'] ?? '' }}">
                        <label class="text-sm font-medium text-charcoal">Exportar en</label>
                        <select name="format" class="form-input min-w-36 py-2" onchange="if(this.value){ this.form.requestSubmit(); }">
                            <option value="">Seleccionar</option>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </form>
                </div>
            </div>

            <form method="GET" action="{{ url()->current() }}" class="mt-6 grid gap-4 md:grid-cols-2">
                <div>
                    <label for="fecha_desde" class="form-label">Fecha desde</label>
                    <input id="fecha_desde" name="fecha_desde" type="date" class="form-input" value="{{ $filtrosSalidas['fecha_desde'] ?? '' }}">
                </div>
                <div>
                    <label for="fecha_hasta" class="form-label">Fecha hasta</label>
                    <input id="fecha_hasta" name="fecha_hasta" type="date" class="form-input" value="{{ $filtrosSalidas['fecha_hasta'] ?? '' }}">
                </div>
                <div>
                    <label for="lote_id" class="form-label">Lote</label>
                    <select id="lote_id" name="lote_id" class="form-input">
                        <option value="">Todos</option>
                        @foreach ($lotes as $lote)
                            <option value="{{ $lote->id }}" @selected(($filtrosSalidas['lote_id'] ?? null) == $lote->id)>{{ $lote->numero_lote }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="cantidad_min" class="form-label">Cantidad minima</label>
                    <input id="cantidad_min" name="cantidad_min" type="number" step="0.01" class="form-input" value="{{ $filtrosSalidas['cantidad_min'] ?? '' }}">
                </div>
                <div>
                    <label for="cantidad_max" class="form-label">Cantidad maxima</label>
                    <input id="cantidad_max" name="cantidad_max" type="number" step="0.01" class="form-input" value="{{ $filtrosSalidas['cantidad_max'] ?? '' }}">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">Filtrar salidas</button>
                </div>
            </form>

            <div class="mt-6 overflow-x-auto">
                <table class="table-base">
                    <thead class="bg-brand-50/80 text-left text-xs uppercase tracking-[0.24em] text-brand-800">
                        <tr>
                            <th class="px-5 py-4">Salida</th>
                            <th class="px-5 py-4">Fecha</th>
                            <th class="px-5 py-4">Lote</th>
                            <th class="px-5 py-4">Libras</th>
                            <th class="px-5 py-4">Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-100/60 bg-white/90">
                        @forelse ($movimientos as $movimiento)
                            <tr class="hover:bg-brand-50/45">
                                <td class="px-5 py-4 font-semibold text-brand-900">{{ $movimiento->numero_salida }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $movimiento->fecha_salida->format('Y-m-d') }} {{ $movimiento->hora_salida }}</td>
                                <td class="px-5 py-4">{{ $movimiento->lote?->numero_lote }}</td>
                                <td class="px-5 py-4 font-semibold text-brand-900">{{ number_format($movimiento->cantidad_libras, 2) }} lb</td>
                                <td class="px-5 py-4 text-slate-600">{{ number_format($movimiento->saldo_posterior, 2) }} lb</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-slate-500">No se encontraron salidas con los filtros aplicados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $movimientos->onEachSide(1)->links() }}
            </div>
        </article>
    </section>
</x-app-layout>
