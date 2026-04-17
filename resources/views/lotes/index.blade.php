<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight font-syne">
            📦 Gestión de Lotes
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0d1117] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-[#161b22] border border-[#2a3241] p-6 rounded-xl mb-8">
                <h3 class="text-white font-bold mb-4">Registrar Entrada de Carne</h3>
                <form action="{{ route('lotes.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf
                    <input type="text" name="numero_lote" placeholder="Número de Lote" required 
                           class="bg-[#1c2330] border-[#2a3241] text-white rounded-lg">
                    
                    <input type="number" name="cantidad" step="0.01" placeholder="Cantidad (Lbs)" required 
                           class="bg-[#1c2330] border-[#2a3241] text-white rounded-lg">
                    
                    <input type="date" name="fecha_entrada" required 
                           class="bg-[#1c2330] border-[#2a3241] text-white rounded-lg">
                    
                    <button type="submit" class="md:col-span-3 bg-[#00c9a7] text-[#0d1117] font-bold py-2 rounded-lg hover:bg-[#00a388]">
                        Guardar en Inventario
                    </button>
                </form>
            </div>

            <div class="bg-[#161b22] border border-[#2a3241] rounded-xl overflow-hidden shadow-lg">
                <table class="w-full text-left">
                    <thead class="bg-[#1c2330] text-[#6e7d90] text-xs uppercase">
                        <tr>
                            <th class="px-6 py-4">Lote</th>
                            <th class="px-6 py-4">Entrada</th>
                            <th class="px-6 py-4">Saldo Actual</th>
                            <th class="px-6 py-4">Vencimiento (45d)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#2a3241]">
                        @foreach($lotes as $lote)
                        <tr class="text-white hover:bg-[#1c2330]">
                            <td class="px-6 py-4 font-bold text-[#00c9a7]">{{ $lote->numero_lote }}</td>
                            <td class="px-6 py-4">{{ $lote->cantidad_entrada_libras }} Lbs</td>
                            <td class="px-6 py-4 font-semibold">{{ $lote->saldo_actual_libras }} Lbs</td>
                            <td class="px-6 py-4 text-red-400">{{ $lote->fecha_vencimiento }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>