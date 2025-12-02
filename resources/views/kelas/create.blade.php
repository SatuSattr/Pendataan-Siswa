<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/kelas/create" title="Tambah Kelas">
            <x-slot name="actions">
                <a href="{{ route('kelas.index') }}" class="btn-ghost">
                    <i class="fa-solid fa-table-list"></i>
                    Lihat Data
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_440px] xl:grid-cols-[minmax(0,1fr)_540px]">
        <div class="hidden lg:block">
            <div class="glass-panel rounded-3xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-slate-900">Kelas di Tahun Ajar</h3>
                <p class="mt-2 text-sm text-slate-600">Susun nama, level, dan jurusan agar penempatan siswa mudah dilacak.</p>
                <div class="mt-4 grid gap-3 rounded-2xl bg-white/70 p-4 ring-1 ring-slate-100">
                    <div class="flex items-center justify-between text-sm font-semibold text-slate-800">
                        <span>Level</span>
                        <span class="badge-soft">{{ implode(', ', ['X', 'XI', 'XII']) }}</span>
                    </div>
                    <p class="text-sm text-slate-600">Gunakan kombinasi nama + level + jurusan untuk menjaga penamaan konsisten (contoh: X TKJ 1).</p>
                </div>
            </div>
        </div>

        <aside class="lg:col-start-2">
            <div class="glass-panel sticky top-6 rounded-3xl p-6 shadow-xl lg:max-h-[calc(100vh-140px)] lg:overflow-y-auto">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Form Kelas</p>
                        <h3 class="text-lg font-semibold text-slate-900">Tambah Kelas</h3>
                    </div>
                    <a href="{{ route('kelas.index') }}" class="btn-ghost px-3 py-2 text-sm">
                        <i class="fa-solid fa-arrow-left"></i>
                        Batal
                    </a>
                </div>

                <form action="{{ route('kelas.store') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-800">Nama Kelas</label>
                        <input type="text" name="nama_kelas" value="{{ old('nama_kelas') }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                        @error('nama_kelas')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Level</label>
                            <select name="level_kelas" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                                <option value="">Pilih Level</option>
                                @foreach (['X', 'XI', 'XII'] as $level)
                                    <option value="{{ $level }}" @selected(old('level_kelas') === $level)>{{ $level }}</option>
                                @endforeach
                            </select>
                            @error('level_kelas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Jurusan</label>
                            <select name="jurusan_id" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" @selected(old('jurusan_id') == $jurusan->id)>{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-800">Tahun Ajar</label>
                        <select name="tahun_ajar_id" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                            <option value="">Pilih Tahun Ajar</option>
                            @foreach ($tahunAjars as $tahunAjar)
                                <option value="{{ $tahunAjar->id }}" @selected(old('tahun_ajar_id') == $tahunAjar->id)>{{ $tahunAjar->kode_tahun_ajar }}</option>
                            @endforeach
                        </select>
                        @error('tahun_ajar_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('kelas.index') }}" class="btn-ghost px-4 py-2">Batal</a>
                        <button type="submit" class="btn-brand px-4 py-2">Simpan</button>
                    </div>
                </form>
            </div>
        </aside>
    </div>
</x-app-layout>
