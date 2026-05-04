<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="section-title">Registrar salida</h1>
            <p class="mt-1 text-sm text-slate-600">Las salidas se procesan automaticamente usando FIFO.</p>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
        <section class="card p-6">
            <p class="text-sm text-slate-500">Stock total actual</p>
            <p class="mt-3 text-3xl font-semibold text-brand-900">{{ number_format($stockTotal, 2) }} lb</p>
        </section>

        <section class="card p-6">
            <form method="POST" action="{{ route('salidas.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="cantidad_libras" class="form-label">Cantidad a despachar (lb)</label>
                    <input id="cantidad_libras" name="cantidad_libras" type="number" step="0.01" min="0.01" class="form-input" value="{{ old('cantidad_libras') }}" required>
                </div>

                <div class="rounded-2xl border border-brand-100 bg-brand-50 px-4 py-4 text-sm text-slate-700">
                    El sistema tomara primero el inventario mas antiguo con saldo disponible. No se permitiran saldos negativos.
                </div>

                <button type="submit" class="btn-primary">Registrar Salida</button>
            </form>
        </section>
    </div>
</x-app-layout>
