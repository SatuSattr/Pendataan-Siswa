<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/dashboard" title="Ringkasan Sekolah">
            <x-slot name="actions">
                <a href="{{ route('siswa.index') }}" class="btn-ghost">
                    <i class="fa-regular fa-user"></i>
                    Lihat Siswa
                </a>
                <a href="{{ route('siswa.create') }}" class="btn-brand">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Siswa
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="space-y-8">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="card-surface rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Siswa</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalSiswa }}</p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-600 ring-1 ring-brand-100">
                        <i class="fa-solid fa-users"></i>
                    </span>
                </div>
            </div>
            <div class="card-surface rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Jurusan</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalJurusan }}</p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-600 ring-1 ring-brand-100">
                        <i class="fa-solid fa-diagram-project"></i>
                    </span>
                </div>
            </div>
            <div class="card-surface rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Kelas</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalKelas }}</p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-600 ring-1 ring-brand-100">
                        <i class="fa-solid fa-door-open"></i>
                    </span>
                </div>
            </div>
            <div class="card-surface rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Pengguna</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalUsers }}</p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-600 ring-1 ring-brand-100">
                        <i class="fa-solid fa-user-shield"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="card-surface rounded-2xl p-6">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Navigasi Cepat</h3>
                    <p class="text-sm text-slate-500">Akses cepat ke halaman yang sering digunakan.</p>
                </div>
                <span class="badge-soft">Shortcut</span>
            </div>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ route('siswa.create') }}" class="group flex items-center justify-between rounded-xl border border-slate-200 bg-white/80 px-4 py-3 shadow-sm transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:shadow-brand-100/70">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Tambah Siswa</p>
                        <p class="text-xs text-slate-500">Input siswa baru dengan cepat.</p>
                    </div>
                    <span class="text-brand-600 transition group-hover:translate-x-1">&rarr;</span>
                </a>
                <a href="{{ route('kelas.index') }}" class="group flex items-center justify-between rounded-xl border border-slate-200 bg-white/80 px-4 py-3 shadow-sm transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:shadow-brand-100/70">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Kelola Kelas</p>
                        <p class="text-xs text-slate-500">Tinjau kelas aktif dan rombel.</p>
                    </div>
                    <span class="text-brand-600 transition group-hover:translate-x-1">&rarr;</span>
                </a>
                <a href="{{ route('jurusan.index') }}" class="group flex items-center justify-between rounded-xl border border-slate-200 bg-white/80 px-4 py-3 shadow-sm transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:shadow-brand-100/70">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Kelola Jurusan</p>
                        <p class="text-xs text-slate-500">Perbarui daftar program studi.</p>
                    </div>
                    <span class="text-brand-600 transition group-hover:translate-x-1">&rarr;</span>
                </a>
                <a href="{{ route('tahun-ajar.index') }}" class="group flex items-center justify-between rounded-xl border border-slate-200 bg-white/80 px-4 py-3 shadow-sm transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:shadow-brand-100/70">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Tahun Ajar</p>
                        <p class="text-xs text-slate-500">Kelola periode akademik.</p>
                    </div>
                    <span class="text-brand-600 transition group-hover:translate-x-1">&rarr;</span>
                </a>
                <a href="{{ route('users.index') }}" class="group flex items-center justify-between rounded-xl border border-slate-200 bg-white/80 px-4 py-3 shadow-sm transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:shadow-brand-100/70">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Manajemen Pengguna</p>
                        <p class="text-xs text-slate-500">Atur role dan akses akun.</p>
                    </div>
                    <span class="text-brand-600 transition group-hover:translate-x-1">&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
