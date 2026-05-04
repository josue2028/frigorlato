@php
    $user = auth()->user();
@endphp

<nav x-data="{ open: false }" class="border-b border-brand-900/20 bg-brand-900 text-bone shadow-sm">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="font-display text-xl font-semibold tracking-wide text-bone">
                    Frigorlato
                </a>

                <div class="hidden items-center gap-2 md:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard') || request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('admin.lotes.index')" :active="request()->routeIs('admin.lotes.*')">
                        Lotes
                    </x-nav-link>
                    <x-nav-link :href="route('admin.inventario.index')" :active="request()->routeIs('admin.inventario.*')">
                        Ver inventario
                    </x-nav-link>
                    <x-nav-link :href="route('admin.historial.index')" :active="request()->routeIs('admin.historial.*')">
                        Ver historial
                    </x-nav-link>
                    <x-nav-link :href="route('admin.contratos.index')" :active="request()->routeIs('admin.contratos.*')">
                        Contratos
                    </x-nav-link>
                    <x-nav-link :href="route('salidas.create')" :active="request()->routeIs('salidas.*')">
                        Gestionar salidas
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden items-center gap-4 md:flex">
                <div class="text-right text-sm">
                    <p class="font-semibold text-bone">{{ $user?->name }}</p>
                    <p class="text-xs uppercase tracking-[0.2em] text-brand-100">usuario activo</p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-secondary border-white/30 bg-white/10 text-bone hover:bg-white/20">
                        Cerrar sesion
                    </button>
                </form>
            </div>

            <button
                type="button"
                @click="open = !open"
                class="inline-flex items-center rounded-lg p-2 text-bone transition hover:bg-white/10 md:hidden"
            >
                <span class="sr-only">Abrir menu</span>
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div x-cloak x-show="open" class="border-t border-white/10 bg-brand-800/95 md:hidden">
        <div class="space-y-1 px-4 py-4">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard') || request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.lotes.index')" :active="request()->routeIs('admin.lotes.*')">
                Lotes
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.inventario.index')" :active="request()->routeIs('admin.inventario.*')">
                Ver inventario
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.historial.index')" :active="request()->routeIs('admin.historial.*')">
                Ver historial
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.contratos.index')" :active="request()->routeIs('admin.contratos.*')">
                Contratos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('salidas.create')" :active="request()->routeIs('salidas.*')">
                Gestionar salidas
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-white/10 px-4 py-4 text-sm text-bone">
            <p class="font-semibold">{{ $user?->name }}</p>
            <p class="text-xs uppercase tracking-[0.2em] text-brand-100">usuario activo</p>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="btn-secondary w-full border-white/30 bg-white/10 text-bone hover:bg-white/20">
                    Cerrar sesion
                </button>
            </form>
        </div>
    </div>
</nav>
