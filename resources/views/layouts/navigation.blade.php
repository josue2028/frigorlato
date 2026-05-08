@php
    $user = auth()->user();
    $links = [
        [
            'label' => 'Dashboard',
            'href' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard') || request()->routeIs('dashboard'),
            'icon' => 'home',
        ],
        [
            'label' => 'Lotes',
            'href' => route('admin.lotes.index'),
            'active' => request()->routeIs('admin.lotes.*'),
            'icon' => 'stack',
        ],
        [
            'label' => 'Inventario',
            'href' => route('admin.inventario.index'),
            'active' => request()->routeIs('admin.inventario.*'),
            'icon' => 'cube',
        ],
        [
            'label' => 'Historial',
            'href' => route('admin.historial.index'),
            'active' => request()->routeIs('admin.historial.*'),
            'icon' => 'clock',
        ],
        [
            'label' => 'Contratos',
            'href' => route('admin.contratos.index'),
            'active' => request()->routeIs('admin.contratos.*'),
            'icon' => 'folder',
        ],
        [
            'label' => 'Salidas',
            'href' => route('salidas.create'),
            'active' => request()->routeIs('salidas.*'),
            'icon' => 'send',
        ],
    ];

    $iconPaths = [
        'home' => 'M3 10.5 12 3l9 7.5V21a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-10.5Z',
        'stack' => 'm12 3 9 4.5-9 4.5-9-4.5L12 3Zm-9 8L12 15.5 21 11M3 15.5 12 20l9-4.5',
        'cube' => 'm12 3 7.5 4.5v9L12 21l-7.5-4.5v-9L12 3Zm0 0v18',
        'clock' => 'M12 7.5V12l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
        'folder' => 'M3.75 7.5A2.25 2.25 0 0 1 6 5.25h3l1.5 1.5H18A2.25 2.25 0 0 1 20.25 9v7.5A2.25 2.25 0 0 1 18 18.75H6A2.25 2.25 0 0 1 3.75 16.5v-9Z',
        'send' => 'M3.75 12 19.5 4.5l-4.5 15-3.75-5.25L3.75 12Z',
    ];
@endphp

<nav x-data="{ open: false }">
    <div class="fixed inset-x-0 top-0 z-40 border-b border-white/60 bg-white/80 px-4 py-3 shadow-sm backdrop-blur lg:hidden">
        <div class="flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <x-application-logo class="h-10 w-10 rounded-2xl object-cover shadow-soft" />
                <div>
                    <p class="font-display text-lg font-semibold text-brand-900">Frigorlato</p>
                    <p class="text-xs uppercase tracking-[0.24em] text-brand-500">Control premium</p>
                </div>
            </a>

            <button type="button" @click="open = !open" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-brand-100 bg-white text-brand-900 shadow-sm">
                <span class="sr-only">Abrir menu</span>
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <aside class="sidebar-shell hidden lg:flex">
        <div class="flex items-center gap-3 border-b border-white/15 pb-6">
            <span class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-bone">
                <img src="{{ asset('images/favicon-panel.png') }}" alt="Frigorlato Panel" class="h-10 w-10 rounded-2xl object-cover" />
            </span>
            <div>
                <p class="font-display text-xl font-semibold text-bone">Frigorlato</p>
                <p class="text-xs uppercase tracking-[0.24em] text-brand-100">Panel</p>
            </div>
        </div>

        <div class="mt-6 space-y-2">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}" @class([
                    'sidebar-link',
                    'sidebar-link-active' => $link['active'],
                ]) title="{{ $link['label'] }}" aria-label="{{ $link['label'] }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $iconPaths[$link['icon']] }}" />
                    </svg>
                    <span>{{ $link['label'] }}</span>
                </a>
            @endforeach
        </div>

        <div class="mt-auto rounded-[1.25rem] border border-white/15 bg-brand-700 px-4 py-4 text-sm text-brand-100">
            <p class="font-semibold text-bone">{{ $user?->name }}</p>
            <p class="mt-1 text-xs uppercase tracking-[0.22em] text-brand-100">{{ $user?->role ?? 'usuario' }}</p>
            <p class="mt-3 text-xs leading-5 text-brand-100/90">Acceso rapido a lotes, inventario, contratos y salidas.</p>
        </div>
    </aside>

    <div x-cloak x-show="open" class="fixed inset-0 z-50 bg-[#4A4A4A]/35 lg:hidden">
        <div class="absolute inset-y-0 left-0 w-[88%] max-w-sm bg-brand-600 p-6 text-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-white/15 pb-5">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-[1.2rem] bg-bone">
                        <img src="{{ asset('images/favicon-panel.png') }}" alt="Frigorlato Panel" class="h-9 w-9 rounded-xl object-cover" />
                    </span>
                    <div>
                        <p class="font-display text-xl font-semibold">Frigorlato</p>
                        <p class="text-xs uppercase tracking-[0.28em] text-brand-100">Panel</p>
                    </div>
                </a>

                <button type="button" @click="open = false" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-white/15 bg-brand-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-6 rounded-[1.25rem] border border-white/15 bg-brand-700 p-4">
                <p class="font-semibold">{{ $user?->name }}</p>
                <p class="mt-1 text-xs uppercase tracking-[0.22em] text-brand-100">{{ $user?->role ?? 'usuario' }}</p>
            </div>

            <div class="mt-8 space-y-2">
                @foreach ($links as $link)
                    <a href="{{ $link['href'] }}" @class([
                        'sidebar-link',
                        'sidebar-link-active' => $link['active'],
                    ])>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $iconPaths[$link['icon']] }}" />
                        </svg>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-8">
                @csrf
                <button type="submit" class="sidebar-link w-full justify-center border border-white/15 bg-brand-700 text-white hover:bg-brand-700">
                    Cerrar sesion
                </button>
            </form>
        </div>
    </div>
</nav>
