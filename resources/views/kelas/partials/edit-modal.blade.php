<div x-cloak x-show="showEditModal" class="fixed inset-0 z-[96] flex items-center justify-center px-4" role="dialog"
    aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeEditModal()"></div>

    <form x-show="showEditModal" x-transition method="POST" :action="`${updateActionBase}/${editForm.id}`"
        class="relative w-full max-w-3xl rounded-2xl bg-white max-h-[95vh] overflow-y-auto p-6 shadow-2xl ring-1 ring-slate-200">
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
                <p class="text-xl font-bold text-slate-900">Edit Kelas</p>
                <p class="text-sm text-slate-600">Perbarui nama kelas, level, jurusan, dan tahun ajar tanpa meninggalkan halaman.</p>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700" for="edit_nama_kelas">Nama Kelas</label>
                    <input type="text" name="nama_kelas" id="edit_nama_kelas" x-ref="editNamaInput"
                        x-model="editForm.nama_kelas" placeholder="Contoh: X TKJ 1" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="edit_level_kelas">Level</label>
                    <select name="level_kelas" id="edit_level_kelas" x-model="editForm.level_kelas" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        @foreach (['X', 'XI', 'XII'] as $level)
                            <option value="{{ $level }}">{{ $level }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="edit_jurusan_id">Jurusan</label>
                    <select name="jurusan_id" id="edit_jurusan_id" x-model="editForm.jurusan_id" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        <option value="">Pilih Jurusan</option>
                        @foreach ($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="edit_tahun_ajar_id">Tahun Ajar</label>
                    <select name="tahun_ajar_id" id="edit_tahun_ajar_id" x-model="editForm.tahun_ajar_id" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        <option value="">Pilih Tahun Ajar</option>
                        @foreach ($tahunAjars as $tahunAjar)
                            <option value="{{ $tahunAjar->id }}">{{ $tahunAjar->kode_tahun_ajar }}</option>
                        @endforeach
                    </select>
                </div>
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
