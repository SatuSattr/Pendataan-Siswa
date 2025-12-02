<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/tahun-ajar/create" title="Tambah Tahun Ajar">
            <x-slot name="actions">
                <a href="{{ route('tahun-ajar.index') }}" class="btn-ghost">
                    <i class="fa-solid fa-table-list"></i>
                    Lihat Data
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_420px] xl:grid-cols-[minmax(0,1fr)_520px]">
        <div class="hidden lg:block">
            <div class="glass-panel rounded-3xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-slate-900">Kalender Akademik</h3>
                <p class="mt-2 text-sm text-slate-600">Simpan kode dan nama tahun ajar agar jadwal kelas dan siswa tersusun baik.</p>
                <div class="mt-4 space-y-2 text-sm text-slate-700">
                    <div class="flex items-start gap-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-brand-400"></span>
                        <span>Format kode singkat (misal: 2024/2025) memudahkan pencarian.</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="mt-1 h-2.5 w-2.5 rounded-full bg-brand-200"></span>
                        <span>Nama tahun ajar bisa memuat keterangan semester atau catatan khusus.</span>
                    </div>
                </div>
            </div>
        </div>

        <aside class="lg:col-start-2">
            <div class="glass-panel sticky top-6 rounded-3xl p-6 shadow-xl lg:max-h-[calc(100vh-140px)] lg:overflow-y-auto">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Form Tahun Ajar</p>
                        <h3 class="text-lg font-semibold text-slate-900">Tambah Tahun Ajar</h3>
                    </div>
                    <a href="{{ route('tahun-ajar.index') }}" class="btn-ghost px-3 py-2 text-sm">
                        <i class="fa-solid fa-arrow-left"></i>
                        Batal
                    </a>
                </div>

                <form action="{{ route('tahun-ajar.store') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-800">Kode Tahun Ajar</label>
                        <input type="text" name="kode_tahun_ajar" value="{{ old('kode_tahun_ajar') }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                        @error('kode_tahun_ajar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-800">Nama Tahun Ajar</label>
                        <input type="text" name="nama_tahun_ajar" value="{{ old('nama_tahun_ajar') }}" class="mt-2 block w-full rounded-xl border-slate-200 shadow-sm focus:border-brand-400 focus:ring-brand-400" required>
                        @error('nama_tahun_ajar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('tahun-ajar.index') }}" class="btn-ghost px-4 py-2">Batal</a>
                        <button type="submit" class="btn-brand px-4 py-2">Simpan</button>
                    </div>
                </form>
            </div>
        </aside>
    </div>
</x-app-layout>
