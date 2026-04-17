<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#00c9a7] leading-tight font-syne uppercase">
            🚚 Registro de Salidas / Despacho
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0d1117]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-[#161b22] border border-[#2a3241] p-6 rounded-2xl mb-8">
                <form action="{{ route('salidas.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @csrf
                    <div>
                        <label class="block text-gray-400 text-xs mb-1">SELECCIONAR LOTE</label>
                        <select name="lote_id" class="w-full bg-[#1c2330] border-[#2a3241] text-white rounded-lg px-3 py-2">
                            @foreach($lotesDisponibles as $lote)
                                <option value="{{ $lote->id }}">
                                    {{ $lote->numero_lote }} (Saldo: {{ $lote->saldo_actual_libras }} Lbs)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-400 text-xs mb-1">CANTIDAD A DESPACHAR</label>
                        <input type="number" step="0.01" name="cantidad" placeholder="Lbs" required class="w-full bg-[#1c2330] border-[#2a3241] text-white rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-400 text-xs mb-1">FECHA</label>
                        <input type="date" name="fecha_salida" required class="w-full bg-[#1c2330] border-[#2a3241] text-white rounded-lg">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-[#00c9a7] text-[#0d1117] font-bold py-2 rounded-lg hover:bg-[#00a388] transition">
                            Registrar Salida
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-[#161b22] border border-[#2a3241] rounded-2xl overflow-hidden shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-[#1c2330] text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="px-6 py-4">Lote Origen</th>
                            <th class="px-6 py-4">Cantidad Salida</th>
                            <th class="px-6 py-4">Fecha Salida</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#2a3241]">
                        @foreach($salidas as $salida)
                        <tr class="text-white">
                            <td class="px-6 py-4 font-bold text-[#00c9a7]">{{ $salida->lote->numero_lote }}</td>
                            <td class="px-6 py-4">{{ $salida->cantidad_salida_libras }} Lbs</td>
                            <td class="px-6 py-4 text-gray-400">{{ $salida->fecha_salida }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>