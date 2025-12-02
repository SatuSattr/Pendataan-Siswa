<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/jurusan/create" title="Tambah Jurusan">
            <x-slot name="actions">
                <a href="{{ route('jurusan.index') }}" class="btn-ghost">
                    <i class="fa-solid fa-table-list"></i>
                    Lihat Data
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_420px] xl:grid-cols-[minmax(0,1fr)_520px]">
        <div class="hidden lg:block">
            <div class="glass-panel rounded-3xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-slate-900">Ringkasan Jurusan</h3>
                <p class="mt-2 text-sm text-slate-600">Pastikan kode dan nama jurusan konsisten agar data kelas dan siswa tetap terhubung rapi.</p>
                <div class="mt-4 space-y-2 text-sm text-slate-700">
                    <div class="flex items-start gap-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-brand-400"></span>
                        <span>Gunakan kode singkat yang mudah diingat, misalnya <strong>TKJ</strong> atau <strong>DKV</strong>.</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-brand-200"></span>
                        <span>Periksa dulu daftar jurusan untuk menghindari duplikasi nama.</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-brand-100"></span>
                        <span>Kolom wajib akan menampilkan pesan jika ada yang belum benar.</span>
                    </div>
                </div>
            </div>
        </div>

        <aside class="lg:col-start-2">
            <div class="glass-panel sticky top-6 rounded-3xl p-6 shadow-xl lg:max-h-[calc(100vh-140px)] lg:overflow-y-auto">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Form Jurusan</p>
                        <h3 class="text-lg font-semibold text-slate-900">Tambah Jurusan</h3>
                    </div>
                    <a href="{{ route('jurusan.index') }}" class="btn-ghost px-3 py-2 text-sm">
                        <i class="fa-solid fa-arrow-left"></i>
                        Batal
                    </a>
                </div>

                <form action="{{ route('jurusan.store') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-800">Kode Jurusan</label>
                        <input type="text" name="kode_jurusan" value="{{ old('kode_jurusan') }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                        @error('kode_jurusan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-800">Nama Jurusan</label>
                        <input type="text" name="nama_jurusan" value="{{ old('nama_jurusan') }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                        @error('nama_jurusan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('jurusan.index') }}" class="btn-ghost px-4 py-2">Batal</a>
                        <button type="submit" class="btn-brand px-4 py-2">Simpan</button>
                    </div>
                </form>
            </div>
        </aside>
    </div>
</x-app-layout>
