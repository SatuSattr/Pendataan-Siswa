<div x-cloak x-show="showEditModal" class="fixed inset-0 z-[96] flex items-center justify-center px-4" role="dialog"
    aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeEditModal()"></div>

    <form x-show="showEditModal" x-transition method="POST" :action="`${updateActionBase}/${editForm.id}`"
        class="relative w-full max-w-xl rounded-2xl bg-white max-h-[95vh] overflow-y-auto p-6 shadow-2xl ring-1 ring-slate-200">
        @csrf
        @method('PUT')
        <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">

        <button type="button"
            class="absolute right-6 top-6 z-20 flex items-center rounded-xl border p-3 border-slate-200 text-slate-700 hover:border-brand-300 hover:text-brand-700"
            @click="closeEditModal()">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="space-y-6">
            <div class="space-y-1">
                <p class="text-xl font-bold text-slate-900">Edit Pengguna</p>
                <p class="text-sm text-slate-600">Perbarui data pengguna tanpa meninggalkan halaman.</p>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="edit_name">Nama</label>
                    <input type="text" name="name" id="edit_name" x-ref="editNameInput" x-model="editForm.name" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="edit_email">Email</label>
                    <input type="email" name="email" id="edit_email" x-model="editForm.email" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="edit_role">Role</label>
                    <select name="role" id="edit_role" x-model="editForm.role" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        @foreach (['admin' => 'Admin', 'staff' => 'Staff'] as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="edit_password">Password (opsional)</label>
                    <input type="password" name="password" id="edit_password"
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                    <p class="mt-1 text-xs text-slate-500">Biarkan kosong jika tidak diubah.</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700" for="edit_password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="edit_password_confirmation"
                    class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
            </div>

            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-end">
                <button type="button"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 hover:border-brand-300 hover:text-brand-700"
                    @click="closeEditModal()">Batal</button>
                <button type="submit" class="btn-brand inline-flex items-center gap-2 px-5 py-3">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
