<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/siswa/create" title="Tambah Siswa">
            <x-slot name="actions">
                <a href="{{ route('siswa.index') }}" class="btn-ghost">
                    <i class="fa-solid fa-table-list"></i>
                    Lihat Data
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_500px] xl:grid-cols-[minmax(0,1fr)_560px]">
        <div class="hidden lg:block">
            <div class="glass-panel rounded-3xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-slate-900">Profil Siswa</h3>
                <p class="mt-2 text-sm text-slate-600">Lengkapi identitas, akademik, dan foto agar data siswa siap dipakai di absensi dan raport.</p>
                <div class="mt-4 grid gap-3 rounded-2xl bg-white/70 p-4 ring-1 ring-slate-100">
                    <div class="flex items-center justify-between text-sm font-semibold text-slate-800">
                        <span>Kolom wajib</span>
                        <span class="badge-soft">Identitas &amp; Akademik</span>
                    </div>
                    <p class="text-sm text-slate-600">Gunakan NISN resmi, pastikan kelas dan tahun ajar sesuai periode berjalan.</p>
                </div>
            </div>
        </div>

        <aside class="lg:col-start-2">
            <div class="glass-panel sticky top-6 rounded-3xl p-6 shadow-xl lg:max-h-[calc(100vh-140px)] lg:overflow-y-auto">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Form Siswa</p>
                        <h3 class="text-lg font-semibold text-slate-900">Tambah Siswa</h3>
                    </div>
                    <a href="{{ route('siswa.index') }}" class="btn-ghost px-3 py-2 text-sm">
                        <i class="fa-solid fa-arrow-left"></i>
                        Batal
                    </a>
                </div>

                <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">NISN</label>
                            <input type="text" name="nisn" value="{{ old('nisn') }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                            @error('nisn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400">
                            @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                                <option value="">Pilih</option>
                                <option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
                                <option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-800">Alamat</label>
                        <textarea name="alamat" rows="3" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
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
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Kelas</label>
                            <select name="kelas_id" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}" @selected(old('kelas_id') == $kelas->id)>{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-800">Foto (opsional)</label>
                        <input type="file" name="foto" class="mt-2 block w-full text-sm text-slate-700">
                        @error('foto')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('siswa.index') }}" class="btn-ghost px-4 py-2">Batal</a>
                        <button type="submit" class="btn-brand px-4 py-2">Simpan</button>
                    </div>
                </form>
            </div>
        </aside>
    </div>
</x-app-layout>
