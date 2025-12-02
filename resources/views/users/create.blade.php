<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/users/create" title="Tambah Pengguna">
            <x-slot name="actions">
                <a href="{{ route('users.index') }}" class="btn-ghost">
                    <i class="fa-solid fa-table-list"></i>
                    Lihat Data
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_440px] xl:grid-cols-[minmax(0,1fr)_520px]">
        <div class="hidden lg:block">
            <div class="glass-panel rounded-3xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-slate-900">Hak Akses</h3>
                <p class="mt-2 text-sm text-slate-600">Tetapkan peran yang tepat agar aktivitas pengguna sesuai kebijakan.</p>
                <ul class="mt-4 space-y-2 text-sm text-slate-700">
                    <li class="flex items-start gap-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-brand-400"></span>
                        <span><strong>Admin</strong> dapat mengelola seluruh data.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-brand-200"></span>
                        <span><strong>Staff</strong> fokus pada operasional harian.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-brand-100"></span>
                        <span>Gunakan email aktif untuk reset password.</span>
                    </li>
                </ul>
            </div>
        </div>

        <aside class="lg:col-start-2">
            <div class="glass-panel sticky top-6 rounded-3xl p-6 shadow-xl lg:max-h-[calc(100vh-140px)] lg:overflow-y-auto">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Form Pengguna</p>
                        <h3 class="text-lg font-semibold text-slate-900">Tambah Pengguna</h3>
                    </div>
                    <a href="{{ route('users.index') }}" class="btn-ghost px-3 py-2 text-sm">
                        <i class="fa-solid fa-arrow-left"></i>
                        Batal
                    </a>
                </div>

                <form action="{{ route('users.store') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-800">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-800">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Role</label>
                            <select name="role" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                                @foreach (['admin' => 'Admin', 'staff' => 'Staff'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('role', 'admin') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Password</label>
                            <input type="password" name="password" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-800">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                    </div>
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('users.index') }}" class="btn-ghost px-4 py-2">Batal</a>
                        <button type="submit" class="btn-brand px-4 py-2">Simpan</button>
                    </div>
                </form>
            </div>
        </aside>
    </div>
</x-app-layout>
