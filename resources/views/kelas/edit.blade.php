<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/kelas/edit/{{ $kelas->nama_kelas }}" title="Edit Kelas">
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
                <h3 class="text-lg font-semibold text-slate-900">Perbarui Kelas</h3>
                <p class="mt-2 text-sm text-slate-600">Perubahan nama, level, atau jurusan akan mempengaruhi penampilan di jadwal dan data siswa.</p>
                <div class="mt-4 space-y-2 text-sm text-slate-700">
                    <div class="flex items-start gap-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-brand-400"></span>
                        <span>Pertahankan pola penamaan yang sudah dipakai sebelumnya.</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-brand-200"></span>
                        <span>Pastikan level dan tahun ajar sesuai tahun berjalan.</span>
                    </div>
                </div>
            </div>
        </div>

        <aside class="lg:col-start-2">
            <div class="glass-panel sticky top-6 rounded-3xl p-6 shadow-xl lg:max-h-[calc(100vh-140px)] lg:overflow-y-auto">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Form Kelas</p>
                        <h3 class="text-lg font-semibold text-slate-900">Edit Kelas</h3>
                    </div>
                    <a href="{{ route('kelas.index') }}" class="btn-ghost px-3 py-2 text-sm">
                        <i class="fa-solid fa-arrow-left"></i>
                        Batal
                    </a>
                </div>

                <form action="{{ route('kelas.update', $kelas) }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-semibold text-slate-800">Nama Kelas</label>
                        <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                        @error('nama_kelas')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Level</label>
                            <select name="level_kelas" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                                @foreach (['X', 'XI', 'XII'] as $level)
                                    <option value="{{ $level }}" @selected(old('level_kelas', $kelas->level_kelas) === $level)>{{ $level }}</option>
                                @endforeach
                            </select>
                            @error('level_kelas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Jurusan</label>
                            <select name="jurusan_id" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" @selected(old('jurusan_id', $kelas->jurusan_id) == $jurusan->id)>{{ $jurusan->nama_jurusan }}</option>
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
                            @foreach ($tahunAjars as $tahunAjar)
                                <option value="{{ $tahunAjar->id }}" @selected(old('tahun_ajar_id', $kelas->tahun_ajar_id) == $tahunAjar->id)>{{ $tahunAjar->kode_tahun_ajar }}</option>
                            @endforeach
                        </select>
                        @error('tahun_ajar_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('kelas.index') }}" class="btn-ghost px-4 py-2">Batal</a>
                        <button type="submit" class="btn-brand px-4 py-2">Update</button>
                    </div>
                </form>
            </div>
        </aside>
    </div>
</x-app-layout>
