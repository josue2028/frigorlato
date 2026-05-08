<x-app-layout>
    @php
        $metricIcons = [
            'lotes' => 'm12 3 9 4.5-9 4.5-9-4.5L12 3Zm-9 8L12 15.5 21 11M3 15.5 12 20l9-4.5',
            'salidas' => 'M3.75 12 19.5 4.5l-4.5 15-3.75-5.25L3.75 12Z',
            'stock' => 'M4.5 6.75h15m-15 5.25h15m-15 5.25h9',
            'alerta' => 'M12 9v4.5m0 3h.008v.008H12V16.5Zm0-13.5a9 9 0 1 1 0 18 9 9 0 0 1 0-18Z',
            'inventario' => 'm12 3 7.5 4.5v9L12 21l-7.5-4.5v-9L12 3Z',
            'contratos' => 'M7.5 3.75h6L18 8.25v10.5A2.25 2.25 0 0 1 15.75 21h-8.25a2.25 2.25 0 0 1-2.25-2.25V6A2.25 2.25 0 0 1 7.5 3.75Z',
            'registro' => 'M12 6v12m6-6H6',
        ];
    @endphp

    <x-slot name="header">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="section-kicker">Centro de control</p>
                <h1 class="section-title mt-3">Operacion central de Frigorlato</h1>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">
                    Supervisa inventario, documentos y trazabilidad desde un panel mas limpio, con foco en lo que vence pronto y en la actividad reciente.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.lotes.create') }}" class="btn-primary">Nuevo lote</a>
                <a href="{{ route('salidas.create') }}" class="btn-secondary">Registrar salida</a>
            </div>
        </div>
    </x-slot>

    <section class="grid gap-5 xl:grid-cols-4 md:grid-cols-2">
        <article class="metric-card">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="section-kicker">Lotes</p>
                    <p class="mt-4 text-4xl font-semibold text-brand-900">{{ $lotesActivos }}</p>
                    <p class="mt-2 text-sm text-slate-500">Activos</p>
                </div>
                <span class="metric-icon">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $metricIcons['lotes'] }}" />
                    </svg>
                </span>
            </div>
        </article>

        <article class="metric-card">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="section-kicker">Salidas</p>
                    <p class="mt-4 text-4xl font-semibold text-brand-900">{{ $salidasRegistradas }}</p>
                    <p class="mt-2 text-sm text-slate-500">Registradas</p>
                </div>
                <span class="metric-icon">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $metricIcons['salidas'] }}" />
                    </svg>
                </span>
            </div>
        </article>

        <article class="metric-card">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="section-kicker">Stock</p>
                    <p class="mt-4 text-4xl font-semibold text-brand-900">{{ number_format($stockTotal, 2) }} <span class="text-lg text-brand-500">lb</span></p>
                    <p class="mt-2 text-sm text-slate-500">Disponible</p>
                </div>
                <span class="metric-icon">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $metricIcons['stock'] }}" />
                    </svg>
                </span>
            </div>
        </article>

        <article class="metric-card">
            <div class="flex items-start justify-between gap-4">
                <p class="section-kicker">Vencimiento</p>
                <span class="metric-icon">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $metricIcons['alerta'] }}" />
                    </svg>
                </span>
            </div>
            @if ($proximoVencimiento)
                <p class="mt-4 text-2xl font-semibold text-brand-900">{{ $proximoVencimiento->numero_lote }}</p>
                <p class="mt-2 text-sm text-slate-500">{{ $proximoVencimiento->fecha_vencimiento->format('Y-m-d') }}</p>
            @else
                <p class="mt-4 text-lg font-semibold text-brand-900">Sin alertas</p>
                <p class="mt-2 text-sm text-slate-500">Todo al dia</p>
            @endif
        </article>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.45fr_0.95fr]">
        <div class="table-shell">
            <div class="flex items-center justify-between border-b border-brand-100/70 px-6 py-5">
                <div>
                    <p class="section-kicker">Actividad</p>
                    <h2 class="mt-2 text-xl font-semibold text-brand-900">Salidas mas recientes</h2>
                </div>
                <a href="{{ route('admin.historial.index') }}" class="btn-ghost">Ver historial completo</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table-base">
                    <thead class="bg-brand-50/80 text-left text-xs uppercase tracking-[0.24em] text-brand-800">
                        <tr>
                            <th class="px-6 py-4">Salida</th>
                            <th class="px-6 py-4">Fecha</th>
                            <th class="px-6 py-4">Lote</th>
                            <th class="px-6 py-4">Libras</th>
                            <th class="px-6 py-4">Saldo</th>
                            <th class="px-6 py-4">Usuario</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-100/60 bg-white/90">
                        @forelse ($movimientosRecientes as $movimiento)
                            <tr class="hover:bg-brand-50/45">
                                <td class="px-6 py-4 font-semibold text-brand-900">{{ $movimiento->numero_salida }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $movimiento->fecha_salida->format('Y-m-d') }} {{ $movimiento->hora_salida }}</td>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $movimiento->lote?->numero_lote }}</td>
                                <td class="px-6 py-4">{{ number_format($movimiento->cantidad_libras, 2) }} lb</td>
                                <td class="px-6 py-4">{{ number_format($movimiento->saldo_posterior, 2) }} lb</td>
                                <td class="px-6 py-4 text-slate-600">{{ $movimiento->user?->editor_label ?? 'Sistema' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-slate-500">Aun no hay movimientos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <section class="card p-6">
                <p class="section-kicker">Accesos rapidos</p>
                <div class="mt-5 grid gap-3">
                    <a href="{{ route('admin.inventario.index') }}" class="pill-tab justify-between">
                        <span class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $metricIcons['inventario'] }}" />
                            </svg>
                            <span>Inventario</span>
                        </span>
                        <span>&rsaquo;</span>
                    </a>
                    <a href="{{ route('admin.contratos.index') }}" class="pill-tab justify-between">
                        <span class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $metricIcons['contratos'] }}" />
                            </svg>
                            <span>Contratos</span>
                        </span>
                        <span>&rsaquo;</span>
                    </a>
                    <a href="{{ route('salidas.create') }}" class="pill-tab justify-between">
                        <span class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $metricIcons['registro'] }}" />
                            </svg>
                            <span>Nueva salida</span>
                        </span>
                        <span>&rsaquo;</span>
                    </a>
                </div>
            </section>

            <section class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="section-kicker">Lotes activos</p>
                        <h2 class="mt-2 text-xl font-semibold text-brand-900">Vistazo operativo</h2>
                    </div>
                    <a href="{{ route('admin.lotes.index') }}" class="btn-ghost">Ver todos</a>
                </div>
                <div class="mt-5 space-y-3">
                    @forelse ($lotesActivosRecientes as $lote)
                        <div class="rounded-[1.5rem] border border-brand-100/80 bg-brand-50/70 px-4 py-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-brand-900">{{ $lote->numero_lote }}</p>
                                    <p class="mt-1 text-sm text-slate-500">Entrada {{ $lote->fecha_entrada->format('Y-m-d') }}</p>
                                </div>
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-brand-800 shadow-sm">
                                    {{ number_format($lote->saldo_disponible, 2) }} lb
                                </span>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-sm text-slate-500">
                                <span>Vence {{ $lote->fecha_vencimiento->format('Y-m-d') }}</span>
                                <span>{{ $lote->user?->editor_label ?? 'Sin registro' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No hay lotes activos disponibles.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </section>
</x-app-layout>
