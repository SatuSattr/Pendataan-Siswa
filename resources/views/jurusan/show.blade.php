<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/jurusan/show/{{ $jurusan->nama_jurusan }}" title="Detail Jurusan" />
    </x-slot>

    <div class="space-y-6">
        <div class="card-surface rounded-2xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-semibold text-slate-600">Kode Jurusan</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">{{ $jurusan->kode_jurusan }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-600">Nama Jurusan</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">{{ $jurusan->nama_jurusan }}</p>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('jurusan.index') }}" class="inline-flex items-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-brand-300 hover:text-brand-700">
                    Kembali
                </a>
                <a href="{{ route('jurusan.edit', $jurusan) }}" class="btn-brand inline-flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
