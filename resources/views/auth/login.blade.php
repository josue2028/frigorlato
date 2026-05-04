<x-guest-layout>
    <div class="card overflow-hidden">
        <div class="bg-brand-900 px-8 py-8 text-bone">
            <p class="text-sm uppercase tracking-[0.3em] text-brand-100">Sistema web de trazabilidad</p>
            <h1 class="mt-3 font-display text-3xl font-semibold text-bone">Frigorlato</h1>
            <p class="mt-3 text-sm text-brand-100">
                Accede con tu correo y contrasena. El usuario se utiliza para registrar quien realiza cada cambio en el sistema.
            </p>
        </div>

        <div class="space-y-6 px-8 py-8">
            <div class="rounded-2xl border border-brand-100 bg-brand-50 px-4 py-3 text-sm text-brand-900">
                <p class="font-semibold">Credenciales de prueba</p>
                <p class="mt-1">Admin 1: admin1@frigorlato.com / password123</p>
                <p>Admin 2: admin2@frigorlato.com / password123</p>
                <p>Admin 3: admin3@frigorlato.com / password123</p>
            </div>

            <x-auth-session-status class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

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

                <label class="flex items-center gap-3 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-brand-300 text-brand-800 focus:ring-brand-700">
                    <span>Recordar sesion</span>
                </label>

                <button type="submit" class="btn-primary w-full">
                    Ingresar al sistema
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
