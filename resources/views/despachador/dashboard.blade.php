<x-app-layout>
    @php
        $panelIcons = [
            'stock' => 'M4.5 6.75h15m-15 5.25h15m-15 5.25h9',
            'fifo' => 'M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
            'alerta' => 'M12 9v4.5m0 3h.008v.008H12V16.5Zm0-13.5a9 9 0 1 1 0 18 9 9 0 0 1 0-18Z',
        ];
    @endphp

    <x-slot name="header">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="section-kicker">Despachos</p>
                <h1 class="section-title mt-3">Panel de salidas y prioridad FIFO</h1>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">
                    Registra salidas rapido, revisa lotes por vencer y mantente enfocado en el inventario que debe salir primero.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('salidas.create') }}" class="btn-primary">Registrar salida</a>
                <a href="{{ route('admin.historial.index') }}" class="btn-secondary">Consultar historial</a>
            </div>
        </div>
    </x-slot>

    <section class="grid gap-5 lg:grid-cols-[1.15fr_0.85fr]">
        <article class="card p-7">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="section-kicker">Stock operativo</p>
                    <p class="mt-5 text-4xl font-semibold text-brand-900">{{ number_format($stockTotal, 2) }} <span class="text-lg text-brand-500">lb</span></p>
                    <p class="mt-2 text-sm text-slate-500">Disponible para despacho.</p>
                </div>
                <span class="metric-icon">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $panelIcons['stock'] }}" />
                    </svg>
                </span>
            </div>
            <div class="mt-5 flex flex-wrap items-end justify-end gap-4">
                <div class="rounded-[1.6rem] bg-brand-600 px-5 py-4 text-white shadow-soft">
                    <p class="text-xs uppercase tracking-[0.28em] text-brand-200">Modo</p>
                    <div class="mt-2 flex items-center gap-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $panelIcons['fifo'] }}" />
                        </svg>
                        <p class="text-lg font-semibold">FIFO activo</p>
                    </div>
                </div>
            </div>
        </article>

        <article class="card p-7">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="section-kicker">Alertas</p>
                    <h2 class="mt-3 text-xl font-semibold text-brand-900">Lotes proximos a vencer</h2>
                </div>
                <span class="metric-icon">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $panelIcons['alerta'] }}" />
                    </svg>
                </span>
            </div>
            <div class="mt-5 space-y-3">
                @forelse ($lotesProximosAVencer as $lote)
                    <div class="rounded-[1.5rem] border border-amber-200 bg-amber-50/90 px-4 py-4">
                        <div class="flex items-center justify-between gap-4">
                            <p class="font-semibold text-slate-800">{{ $lote->numero_lote }}</p>
                            <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-amber-700 shadow-sm">Prioridad alta</span>
                        </div>
                        <p class="mt-2 text-sm text-slate-600">Vence {{ $lote->fecha_vencimiento->format('Y-m-d') }} | Saldo {{ number_format($lote->saldo_disponible, 2) }} lb</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No hay lotes por vencer en los proximos 7 dias.</p>
                @endforelse
            </div>
        </article>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="table-shell">
            <div class="flex items-center justify-between border-b border-brand-100/70 px-6 py-5">
                <div>
                    <p class="section-kicker">Disponibles</p>
                    <h2 class="mt-2 text-xl font-semibold text-brand-900">Lotes listos para salida</h2>
                </div>
                <a href="{{ route('admin.inventario.index') }}" class="btn-ghost">Ver inventario</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table-base">
                    <thead class="bg-brand-50/80 text-left text-xs uppercase tracking-[0.24em] text-brand-800">
                        <tr>
                            <th class="px-6 py-4">Lote</th>
                            <th class="px-6 py-4">Entrada</th>
                            <th class="px-6 py-4">Vencimiento</th>
                            <th class="px-6 py-4">Saldo</th>
                            <th class="px-6 py-4">Usuario</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-100/60 bg-white/90">
                        @forelse ($lotesDisponibles as $lote)
                            @php
                                $porVencer = now()->diffInDays($lote->fecha_vencimiento, false) <= 7;
                            @endphp
                            <tr @class(['bg-amber-50/60' => $porVencer, 'hover:bg-brand-50/45' => ! $porVencer])>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $lote->numero_lote }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $lote->fecha_entrada->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $lote->fecha_vencimiento->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 font-semibold text-brand-900">{{ number_format($lote->saldo_disponible, 2) }} lb</td>
                                <td class="px-6 py-4 text-slate-600">{{ $lote->user?->editor_label ?? 'Sin registro' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">No hay lotes disponibles.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="table-shell">
            <div class="flex items-center justify-between border-b border-brand-100/70 px-6 py-5">
                <div>
                    <p class="section-kicker">Actividad</p>
                    <h2 class="mt-2 text-xl font-semibold text-brand-900">Ultimas salidas</h2>
                </div>
                <a href="{{ route('admin.historial.index') }}" class="btn-ghost">Ver mas</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table-base">
                    <thead class="bg-brand-50/80 text-left text-xs uppercase tracking-[0.24em] text-brand-800">
                        <tr>
                            <th class="px-6 py-4">Salida</th>
                            <th class="px-6 py-4">Lote</th>
                            <th class="px-6 py-4">Libras</th>
                            <th class="px-6 py-4">Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-100/60 bg-white/90">
                        @forelse ($movimientosRecientes as $movimiento)
                            <tr class="hover:bg-brand-50/45">
                                <td class="px-6 py-4 font-semibold text-brand-900">{{ $movimiento->numero_salida }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $movimiento->lote?->numero_lote }}</td>
                                <td class="px-6 py-4">{{ number_format($movimiento->cantidad_libras, 2) }} lb</td>
                                <td class="px-6 py-4">{{ number_format($movimiento->saldo_posterior, 2) }} lb</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-500">Aun no hay movimientos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
