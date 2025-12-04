<x-guest-layout>
    <div class="mb-6 space-y-3">
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-slate-900">Selamat datang kembali</h1>
            <p class="text-sm text-slate-600">Gunakan kredensial Anda untuk mengakses dashboard pendataan.</p>
        </div>
    </div>

    <x-auth-session-status class="mb-4 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700"
        :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div class="space-y-2">
            <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
            <div
                class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus-within:border-brand-400 focus-within:ring-2 focus-within:ring-brand-100">
                <i class="fa-solid fa-envelope text-slate-400"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username"
                    class="w-full border-0 bg-transparent text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-0"
                    placeholder="nama@email.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="text-sm text-rose-600" />
        </div>

        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label for="password" class="text-sm font-semibold text-slate-700">Kata sandi</label>
            </div>
            <div
                class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus-within:border-brand-400 focus-within:ring-2 focus-within:ring-brand-100">
                <i class="fa-solid fa-lock text-slate-400"></i>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full border-0 bg-transparent text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-0"
                    placeholder="Masukkan kata sandi">
            </div>
            <x-input-error :messages="$errors->get('password')" class="text-sm text-rose-600" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                <input id="remember_me" type="checkbox" name="remember"
                    class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-400">
                <span>Ingat saya</span>
            </label>
        </div>

        <button type="submit"
            class="btn-brand inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl text-base font-semibold shadow-lg shadow-brand-200/60 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-400">
            <i class="fa-solid fa-arrow-right-to-bracket"></i>
            Masuk ke Dashboard
        </button>
    </form>
</x-guest-layout>
