<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/siswa/edit/{{ $siswa->nama }}" title="Edit Siswa">
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
                <h3 class="text-lg font-semibold text-slate-900">Perbarui Profil Siswa</h3>
                <p class="mt-2 text-sm text-slate-600">Perubahan kelas atau tahun ajar akan mengatur ulang riwayat aktif secara otomatis.</p>
                <div class="mt-4 space-y-2 text-sm text-slate-700">
                    <div class="flex items-start gap-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-brand-400"></span>
                        <span>Pastikan NISN, kelas, dan tahun ajar sesuai periode berjalan.</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-brand-200"></span>
                        <span>Foto baru opsional; jika dikosongkan, foto lama tetap dipakai.</span>
                    </div>
                </div>
            </div>
        </div>

        <aside class="lg:col-start-2">
            <div class="glass-panel sticky top-6 rounded-3xl p-6 shadow-xl lg:max-h-[calc(100vh-140px)] lg:overflow-y-auto">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Form Siswa</p>
                        <h3 class="text-lg font-semibold text-slate-900">Edit Siswa</h3>
                    </div>
                    <a href="{{ route('siswa.index') }}" class="btn-ghost px-3 py-2 text-sm">
                        <i class="fa-solid fa-arrow-left"></i>
                        Batal
                    </a>
                </div>

                <form action="{{ route('siswa.update', $siswa) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">NISN</label>
                            <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                            @error('nisn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($siswa->tanggal_lahir)->format('Y-m-d')) }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400">
                            @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                                <option value="L" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) === 'L')>Laki-laki</option>
                                <option value="P" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) === 'P')>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-800">Alamat</label>
                        <textarea name="alamat" rows="3" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400">{{ old('alamat', $siswa->alamat) }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Jurusan</label>
                            <select name="jurusan_id" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" @selected(old('jurusan_id', $siswa->jurusan_id) == $jurusan->id)>{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Kelas (aktif)</label>
                            <select name="kelas_id" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                                @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}" @selected(old('kelas_id', optional($activeDetail)->kelas_id) == $kelas->id)>{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-800">Tahun Ajar (aktif)</label>
                            <select name="tahun_ajar_id" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                                @foreach ($tahunAjars as $tahunAjar)
                                    <option value="{{ $tahunAjar->id }}" @selected(old('tahun_ajar_id', optional($activeDetail)->tahun_ajar_id ?? $siswa->tahun_ajar_id) == $tahunAjar->id)>{{ $tahunAjar->kode_tahun_ajar }}</option>
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
                        @if ($siswa->foto_path)
                            <div class="mt-2 flex items-center gap-3">
                                <img src="{{ asset('storage/' . $siswa->foto_path) }}" alt="Foto {{ $siswa->nama }}" class="h-16 w-16 rounded object-cover ring-1 ring-slate-200">
                                <p class="text-xs text-slate-500">Biarkan kosong jika tidak ingin mengganti.</p>
                            </div>
                        @endif
                        @error('foto')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-600 ring-1 ring-slate-100">
                        Mengubah kelas atau tahun ajar akan menonaktifkan riwayat kelas sebelumnya dan membuat riwayat baru secara otomatis.
                    </div>
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('siswa.index') }}" class="btn-ghost px-4 py-2">Batal</a>
                        <button type="submit" class="btn-brand px-4 py-2">Update</button>
                    </div>
                </form>
            </div>
        </aside>
    </div>
</x-app-layout>
