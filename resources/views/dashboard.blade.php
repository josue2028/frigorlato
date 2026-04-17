<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#00c9a7] leading-tight font-syne uppercase">
            🚀 Dashboard de Operaciones
        </h2>
    </x-slot>

    <div class="py-12 bg-[#0d1117]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-[#161b22] border border-[#2a3241] p-6 rounded-2xl shadow-xl">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Total Inventario</p>
                    <h3 class="text-[#00c9a7] text-3xl font-bold font-syne mt-2">{{ number_format($librasDisponibles ?? 0, 2) }} Lbs</h3>
                </div>

                <div class="bg-[#161b22] border border-[#2a3241] p-6 rounded-2xl shadow-xl">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Lotes Activos</p>
                    <h3 class="text-white text-3xl font-bold font-syne mt-2">{{ $totalLotes ?? 0 }}</h3>
                </div>

                <div class="bg-[#161b22] border border-[#2a3241] p-6 rounded-2xl shadow-xl border-l-4 border-l-red-500">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Alertas Vencimiento</p>
                    <h3 class="text-red-500 text-3xl font-bold font-syne mt-2">{{ $proximosAVencer->count() ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-[#161b22] border border-[#2a3241] rounded-2xl overflow-hidden shadow-2xl">
                <div class="p-5 border-b border-[#2a3241] bg-[#1c2330]">
                    <h3 class="text-white font-bold flex items-center">
                        <span class="mr-2">⚠️</span> Próximos a Vencer (Límite 15 días)
                    </h3>
                </div>
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-500 border-b border-[#2a3241]">
                            <th class="px-6 py-4">CÓDIGO LOTE</th>
                            <th class="px-6 py-4">SALDO</th>
                            <th class="px-6 py-4">VENCIMIENTO</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#2a3241]">
                        @forelse($proximosAVencer ?? [] as $lote)
                            <tr class="hover:bg-[#1c2330] transition">
                                <td class="px-6 py-4 font-bold text-[#00c9a7]">{{ $lote->numero_lote }}</td>
                                <td class="px-6 py-4 text-white">{{ number_format($lote->saldo_actual_libras, 2) }} Lbs</td>
                                <td class="px-6 py-4 text-red-400 font-semibold italic">{{ $lote->fecha_vencimiento->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-500 italic">Todo en orden. No hay vencimientos cercanos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>