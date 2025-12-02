<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/tahun-ajar/show/{{ $tahunAjar->kode_tahun_ajar }}" title="Detail Tahun Ajar" />
    </x-slot>

    <div class="space-y-6">
        <div class="card-surface rounded-2xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-semibold text-slate-600">Kode Tahun Ajar</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">{{ $tahunAjar->kode_tahun_ajar }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-600">Nama Tahun Ajar</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">{{ $tahunAjar->nama_tahun_ajar }}</p>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('tahun-ajar.index') }}" class="inline-flex items-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-brand-300 hover:text-brand-700">
                    Kembali
                </a>
                <a href="{{ route('tahun-ajar.edit', $tahunAjar) }}" class="btn-brand inline-flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
