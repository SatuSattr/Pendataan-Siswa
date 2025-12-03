<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/tahun-ajar/show/{{ $tahunAjar->kode_tahun_ajar }}" title="Detail Tahun Ajar" />
    </x-slot>

    <div class="space-y-6">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-50 via-white to-slate-50 p-6 ring-1 ring-slate-200">
            <div class="absolute -left-10 -top-10 h-40 w-40 rounded-full bg-brand-200/30 blur-2xl"></div>
            <div class="absolute -right-12 -bottom-16 h-48 w-48 rounded-full bg-indigo-100/40 blur-3xl"></div>

            <div class="relative flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-brand-700">Tahun Ajar</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $tahunAjar->kode_tahun_ajar }}</h1>
                    <p class="mt-1 text-sm text-slate-600">{{ $tahunAjar->nama_tahun_ajar }}</p>
                </div>
                <a href="{{ route('tahun-ajar.edit', $tahunAjar) }}" type="button" class="btn-brand p-4 absolute right-0 top-0" @click="openEditModal()">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
            </div>

            <div class="relative mt-5 flex flex-wrap gap-3">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/70 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                    <i class="fa-solid fa-calendar-days text-brand-600"></i> {{ $tahunAjar->kode_tahun_ajar }}
                </span>
                <span class="inline-flex items-center gap-2 rounded-full bg-white/70 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                    <i class="fa-solid fa-book-open text-brand-600"></i> {{ $tahunAjar->nama_tahun_ajar }}
                </span>
                <span class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-xs font-semibold {{ $tahunAjar->is_active ? 'bg-green-100 text-green-700 ring-1 ring-green-200' : 'bg-slate-100 text-slate-700 ring-1 ring-slate-200' }}">
                    <i class="fa-solid {{ $tahunAjar->is_active ? 'fa-check' : 'fa-minus' }}"></i>
                    {{ $tahunAjar->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="card-surface rounded-2xl p-5 shadow-sm ring-1 ring-slate-100">
                <p class="text-sm font-semibold text-slate-600">Kode</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $tahunAjar->kode_tahun_ajar }}</p>
                <p class="text-xs text-slate-500">Penanda periode</p>
            </div>
            <div class="card-surface rounded-2xl p-5 shadow-sm ring-1 ring-slate-100">
                <p class="text-sm font-semibold text-slate-600">Nama Periode</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">{{ $tahunAjar->nama_tahun_ajar }}</p>
                <p class="text-xs text-slate-500">Deskripsi tahun ajar</p>
            </div>
            <div class="card-surface rounded-2xl p-5 shadow-sm ring-1 ring-slate-100">
                <p class="text-sm font-semibold text-slate-600">Status</p>
                <p class="mt-2 text-2xl font-bold {{ $tahunAjar->is_active ? 'text-green-700' : 'text-slate-700' }}">
                    {{ $tahunAjar->is_active ? 'Aktif' : 'Nonaktif' }}</p>
                <p class="text-xs text-slate-500">Hanya satu yang aktif</p>
            </div>
        </div>
    </div>
</x-app-layout>
