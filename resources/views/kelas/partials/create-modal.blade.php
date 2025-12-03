<div x-cloak x-show="showAddModal" class="fixed inset-0 z-[95] flex items-center justify-center px-4" role="dialog"
    aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeAddModal()"></div>

    <form x-show="showAddModal" x-transition x-ref="addFormEl" method="POST" action="{{ route('kelas.store') }}"
        class="relative w-full max-w-3xl rounded-2xl bg-white max-h-[95vh] overflow-y-auto p-6 shadow-2xl ring-1 ring-slate-200">
        @csrf

        <button type="button"
            class="absolute right-6 top-6 z-20 flex items-center rounded-xl border p-3 border-slate-200 text-slate-700 hover:border-brand-300 hover:text-brand-700"
            @click="closeAddModal()">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="space-y-6">
            <div class="space-y-1">
                <p class="text-xl font-bold text-slate-900">Tambah Kelas</p>
                <p class="text-sm text-slate-600">Buat kelas baru langsung dari halaman daftar.</p>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700" for="add_nama_kelas">Nama Kelas</label>
                    <input type="text" name="nama_kelas" id="add_nama_kelas" x-ref="addNamaKelasInput"
                        value="{{ old('nama_kelas') }}" placeholder="Contoh: X TKJ 1" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                    @error('nama_kelas')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="add_level_kelas">Level</label>
                    <select name="level_kelas" id="add_level_kelas" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        <option value="">Pilih Level</option>
                        @foreach (['X', 'XI', 'XII'] as $level)
                            <option value="{{ $level }}" @selected(old('level_kelas') === $level)>{{ $level }}</option>
                        @endforeach
                    </select>
                    @error('level_kelas')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="add_jurusan_id">Jurusan</label>
                    <select name="jurusan_id" id="add_jurusan_id" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        <option value="">Pilih Jurusan</option>
                        @foreach ($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" @selected(old('jurusan_id') == $jurusan->id)>{{ $jurusan->nama_jurusan }}</option>
                        @endforeach
                    </select>
                    @error('jurusan_id')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="add_tahun_ajar_id">Tahun Ajar</label>
                    <select name="tahun_ajar_id" id="add_tahun_ajar_id" required
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        <option value="">Pilih Tahun Ajar</option>
                        @foreach ($tahunAjars as $tahunAjar)
                            <option value="{{ $tahunAjar->id }}" @selected(old('tahun_ajar_id') == $tahunAjar->id)>{{ $tahunAjar->kode_tahun_ajar }}</option>
                        @endforeach
                    </select>
                    @error('tahun_ajar_id')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-end">
                <button type="button"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 hover:border-brand-300 hover:text-brand-700"
                    @click="closeAddModal()">Batal</button>
                <button type="submit" class="btn-brand inline-flex items-center gap-2 px-5 py-3">
                    <i class="fa-solid fa-plus"></i>
                    Simpan Kelas
                </button>
            </div>
        </div>
    </form>
</div>
