<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#0d1117]">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-[#161b22] border border-[#2a3241] shadow-2xl overflow-hidden sm:rounded-2xl">
            <h2 class="text-[#00c9a7] font-syne font-bold text-2xl text-center mb-8 uppercase tracking-tighter">Frigorlato Login</h2>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label class="block font-bold text-xs text-gray-400 uppercase">Correo Electrónico</label>
                    <input type="email" name="email" class="block mt-1 w-full bg-[#1c2330] border-[#2a3241] text-white rounded-lg shadow-sm focus:ring-[#00c9a7]" required autofocus />
                </div>

                <div class="mt-4">
                    <label class="block font-bold text-xs text-gray-400 uppercase">Contraseña</label>
                    <input type="password" name="password" class="block mt-1 w-full bg-[#1c2330] border-[#2a3241] text-white rounded-lg shadow-sm focus:ring-[#00c9a7]" required />
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full bg-[#00c9a7] text-[#0d1117] font-bold py-3 rounded-xl hover:bg-[#00a388] transition shadow-lg">
                        INGRESAR AL SISTEMA
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>