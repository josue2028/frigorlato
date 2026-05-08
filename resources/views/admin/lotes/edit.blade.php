<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="section-kicker">Edicion</p>
            <h1 class="section-title mt-3">Editar lote</h1>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-600">Solo se permiten cambios en lotes sin movimientos registrados.</p>
        </div>
    </x-slot>

    <section class="card max-w-4xl p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.lotes.update', $lote) }}" class="grid gap-5 md:grid-cols-2">
            @csrf
            @method('PUT')

            <div class="md:col-span-2">
                <label for="numero_lote" class="form-label">Numero de lote</label>
                <input id="numero_lote" name="numero_lote" type="text" class="form-input" value="{{ old('numero_lote', $lote->numero_lote) }}" required>
            </div>

            <div>
                <label for="cantidad_entrada" class="form-label">Cantidad de entrada (lb)</label>
                <input id="cantidad_entrada" name="cantidad_entrada" type="number" step="0.01" min="0.01" class="form-input" value="{{ old('cantidad_entrada', $lote->cantidad_entrada) }}" required>
            </div>

            <div>
                <label for="fecha_entrada" class="form-label">Fecha de entrada</label>
                <input id="fecha_entrada" name="fecha_entrada" type="date" class="form-input" value="{{ old('fecha_entrada', $lote->fecha_entrada->format('Y-m-d')) }}" required>
            </div>

            <div class="md:col-span-2">
                <label class="form-label">Fecha de vencimiento calculada</label>
                <input type="text" class="form-input bg-slate-50" value="{{ old('fecha_vencimiento', $fechaVencimientoCalculada) }}" readonly>
            </div>

            <div class="md:col-span-2 flex flex-wrap gap-3 pt-2">
                <button type="submit" class="btn-primary">Actualizar lote</button>
                <a href="{{ route('admin.lotes.index') }}" class="btn-secondary">Volver</a>
            </div>
        </form>
    </section>
</x-app-layout>
