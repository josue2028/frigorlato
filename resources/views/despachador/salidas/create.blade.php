<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="section-kicker">Registro</p>
                <h1 class="section-title mt-3">Registrar salida</h1>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">Las salidas se procesan automaticamente usando FIFO y toman primero el inventario mas antiguo disponible.</p>
            </div>
            <a href="{{ route('admin.historial.index') }}" class="btn-secondary">Ver historial</a>
        </div>
    </x-slot>

    <section class="grid gap-6 lg:grid-cols-[0.82fr_1.18fr]">
        <article class="card p-7">
            <p class="section-kicker">Stock actual</p>
            <p class="mt-4 text-4xl font-semibold text-brand-900">{{ number_format($stockTotal, 2) }} <span class="text-lg text-brand-500">lb</span></p>
            <div class="mt-6 rounded-[1.5rem] border border-brand-100 bg-brand-50/80 px-4 py-4 text-sm leading-6 text-slate-600">
                El sistema no permite saldos negativos y descuenta en orden cronologico para conservar la trazabilidad.
            </div>
        </article>

        <article class="card p-7">
            <form method="POST" action="{{ route('salidas.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="cantidad_libras" class="form-label">Cantidad a despachar (lb)</label>
                    <input id="cantidad_libras" name="cantidad_libras" type="number" step="0.01" min="0.01" class="form-input" value="{{ old('cantidad_libras') }}" required>
                </div>

                <div class="rounded-[1.5rem] border border-amber-200 bg-amber-50/80 px-4 py-4 text-sm text-amber-900">
                    Antes de confirmar, valida que la cantidad coincida con la orden fisica de salida.
                </div>

                <button type="submit" class="btn-primary">Registrar salida</button>
            </form>
        </article>
    </section>
</x-app-layout>
