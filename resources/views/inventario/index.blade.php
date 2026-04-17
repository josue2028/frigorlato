<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#00c9a7] leading-tight font-syne uppercase">
            🗃️ Inventario General y Stock
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0d1117]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-end">
                <a href="{{ route('inventario.pdf') }}" class="flex items-center gap-2 bg-[#00c9a7] text-[#0d1117] font-bold py-2 px-6 rounded-xl hover:bg-[#00a388] transition shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="File text" />
                    </svg>
                    DESCARGAR REPORTE PDF
                </a>
            </div>

            <div class="bg-[#161b22] border border-[#2a3241] rounded-2xl overflow-hidden shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-[#1c2330] text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="px-6 py-4">Lote</th>
                            <th class="px-6 py-4">Entrada Inicial</th>
                            <th class="px-6 py-4">Saldo Actual</th>
                            <th class="px-6 py-4">Estado</th>
                            <th class="px-6 py-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#2a3241]">
                        @foreach($inventario as $item)
                        <tr class="text-white hover:bg-[#1c2330] transition">
                            <td class="px-6 py-4 font-bold text-[#00c9a7]">{{ $item->numero_lote }}</td>
                            <td class="px-6 py-4">{{ $item->cantidad_entrada_libras }} Lbs</td>
                            <td class="px-6 py-4 font-mono text-lg {{ $item->saldo_actual_libras == 0 ? 'text-gray-500' : 'text-white' }}">
                                {{ $item->saldo_actual_libras }} Lbs
                            </td>
                            <td class="px-6 py-4">
                                @if($item->saldo_actual_libras == 0)
                                    <span class="px-2 py-1 bg-gray-800 text-gray-400 rounded text-xs">AGOTADO</span>
                                @elseif($item->fecha_vencimiento <= now()->addDays(7))
                                    <span class="px-2 py-1 bg-red-900/50 text-red-400 rounded text-xs border border-red-500">CRÍTICO</span>
                                @else
                                    <span class="px-2 py-1 bg-green-900/50 text-green-400 rounded text-xs border border-green-500">OK</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('inventario.show', $item->id) }}" class="text-xs bg-[#2a3241] px-3 py-1 rounded hover:bg-[#00c9a7] hover:text-[#0d1117] transition">
                                    Ver Kardex
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>