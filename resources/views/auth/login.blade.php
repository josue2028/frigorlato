<x-guest-layout>
    <div class="card overflow-hidden">
        <div class="bg-[linear-gradient(135deg,_#900C0F_0%,_#7C0A0D_55%,_#67080B_100%)] px-8 py-8 text-white">
            <div class="flex items-center gap-4">
                <x-application-logo class="h-14 w-14 rounded-[1.4rem] object-cover shadow-soft ring-1 ring-white/20" />
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-brand-100">Sistema web de trazabilidad</p>
                    <h1 class="mt-2 font-display text-3xl font-semibold text-bone">Frigorlato</h1>
                </div>
            </div>
            <p class="mt-5 text-sm text-brand-100">
                Accede con tu correo y contrasena. El usuario se utiliza para registrar quien realiza cada cambio en el sistema.
            </p>
        </div>

        <div class="space-y-6 px-8 py-8">
            <div class="rounded-[1.5rem] border border-brand-100 bg-brand-50/80 px-4 py-3 text-sm text-brand-900">
                <p class="font-semibold">Credenciales de prueba</p>
                <p class="mt-1">Admin 1: admin1@frigorlato.com / password123</p>
                <p>Admin 2: admin2@frigorlato.com / password123</p>
                <p>Admin 3: admin3@frigorlato.com / password123</p>
            </div>

            <x-auth-session-status class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

            @if (session('error'))
                <div class="rounded-[1.5rem] border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="form-label">Correo electronico</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="form-label">Contrasena</label>
                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-brand-800 hover:text-brand-900" href="{{ route('password.request') }}">
                                Olvide mi contrasena
                            </a>
                        @endif
                    </div>
                    <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password">
                </div>

                <label class="flex items-center gap-3 text-sm text-charcoal">
                    <input type="checkbox" name="remember" class="rounded border-brand-300 text-brand-600 focus:ring-brand-600">
                    <span>Recordar sesion</span>
                </label>

                <button type="submit" class="btn-primary w-full">
                    Ingresar al sistema
                </button>
            </form>

            <div class="flex items-center gap-3 text-xs uppercase tracking-[0.28em] text-slate-400">
                <span class="h-px flex-1 bg-brand-100"></span>
                <span>o</span>
                <span class="h-px flex-1 bg-brand-100"></span>
            </div>

            <a href="{{ route('auth.google') }}" class="flex w-full items-center justify-center gap-3 rounded-[1.5rem] border border-brand-100 bg-bone px-4 py-3 text-sm font-semibold text-brand-700 shadow-sm transition hover:bg-brand-50">
                <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="#EA4335" d="M12 10.2v3.9h5.4c-.2 1.3-1.5 3.9-5.4 3.9-3.2 0-5.9-2.7-5.9-6s2.7-6 5.9-6c1.8 0 3 .8 3.7 1.5l2.5-2.4C16.7 3.7 14.6 3 12 3 7 3 3 7 3 12s4 9 9 9c5.2 0 8.6-3.7 8.6-8.9 0-.6-.1-1.1-.2-1.9H12Z"/>
                    <path fill="#34A853" d="M3 12c0 1.8.7 3.5 1.8 4.8l2.9-2.2c-.4-.7-.7-1.6-.7-2.6s.2-1.8.7-2.6L4.8 7.2A8.9 8.9 0 0 0 3 12Z"/>
                    <path fill="#FBBC05" d="M12 21c2.4 0 4.5-.8 6-2.3l-2.9-2.3c-.8.6-1.8 1-3.1 1-2.5 0-4.7-1.7-5.4-4l-3 2.3C5.1 18.9 8.3 21 12 21Z"/>
                    <path fill="#4285F4" d="M20.6 10.1H12V14h4.9c-.2 1-.8 1.9-1.8 2.5l2.9 2.3c1.7-1.6 2.6-4 2.6-6.8 0-.6-.1-1.2-.2-1.9Z"/>
                </svg>
                <span>Iniciar con Google</span>
            </a>
        </div>
    </div>
</x-guest-layout>
