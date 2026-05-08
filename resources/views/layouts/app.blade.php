<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Frigorlato') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-ivory antialiased">
        <div class="app-stage min-h-screen">
            @include('layouts.navigation')

            <header class="topbar-shell lg:left-[17rem]">
                <div class="flex items-center justify-end gap-3 px-4 py-3 sm:px-6 lg:px-8">
                    <div class="user-badge">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-600 text-sm font-semibold text-white">
                            {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                        </span>
                        <div class="leading-tight">
                            <p class="font-semibold text-brand-700">{{ auth()->user()?->name }}</p>
                            <p class="text-xs uppercase tracking-[0.22em] text-slate-500">{{ auth()->user()?->role ?? 'usuario' }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-secondary px-4 py-2.5">Salir</button>
                    </form>
                </div>
            </header>

            <main class="content-shell px-4 pb-10 pt-24 sm:px-6 lg:ml-[17rem] lg:px-8 lg:pt-24">
                <div class="mx-auto max-w-7xl space-y-6">
                    @if (isset($header))
                        <header class="page-header-shell rounded-[1.5rem] border border-brand-100 bg-bone px-6 py-6 shadow-panel sm:px-8">
                            {{ $header }}
                        </header>
                    @endif

                    @if (session('success'))
                        <div class="rounded-[1.6rem] border border-emerald-200 bg-emerald-50/90 px-5 py-4 text-sm font-medium text-emerald-800 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="rounded-[1.6rem] border border-red-200 bg-red-50/95 px-5 py-4 text-sm font-medium text-red-700 shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="rounded-[1.6rem] border border-red-200 bg-red-50/95 px-5 py-4 text-sm text-red-700 shadow-sm">
                            <p class="font-semibold">Revisa los datos ingresados.</p>
                            <ul class="mt-2 list-disc space-y-1 ps-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
