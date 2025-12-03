<div x-cloak x-show="showAddModal" class="fixed inset-0 z-[95] flex items-center justify-center px-4" role="dialog"
    aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeAddModal()"></div>

    <form x-show="showAddModal" x-transition x-ref="addFormEl" method="POST" action="{{ route('users.store') }}"
        class="relative w-full max-w-xl rounded-2xl bg-white max-h-[95vh] overflow-y-auto p-6 shadow-2xl ring-1 ring-slate-200">
        @csrf

        <button type="button"
            class="absolute right-6 top-6 z-20 flex items-center rounded-xl border p-3 border-slate-200 text-slate-700 hover:border-brand-300 hover:text-brand-700"
            @click="closeAddModal()">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="space-y-6">
            <div class="space-y-1">
                <p class="text-xl font-bold text-slate-900">Tambah Pengguna</p>
                <p class="text-sm text-slate-600">Buat akun baru langsung dari halaman daftar.</p>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="add_name">Nama</label>
                    <input type="text" name="name" id="add_name" x-ref="addNameInput" value="{{ old('name') }}"
                        placeholder="Nama pengguna" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                    @error('name')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="add_email">Email</label>
                    <input type="email" name="email" id="add_email" value="{{ old('email') }}" placeholder="user@mail.com"
                        required class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                    @error('email')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="add_role">Role</label>
                    <select name="role" id="add_role" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        @foreach (['admin' => 'Admin', 'staff' => 'Staff'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('role', 'admin') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="add_password">Password</label>
                    <input type="password" name="password" id="add_password" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                    @error('password')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700" for="add_password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="add_password_confirmation" required
                    class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
            </div>

            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-end">
                <button type="button"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 hover:border-brand-300 hover:text-brand-700"
                    @click="closeAddModal()">Batal</button>
                <button type="submit" class="btn-brand inline-flex items-center gap-2 px-5 py-3">
                    <i class="fa-solid fa-plus"></i>
                    Simpan Pengguna
                </button>
            </div>
        </div>
    </form>
</div>
