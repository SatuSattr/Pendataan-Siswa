<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/tahun-ajar/index" title="Data Tahun Ajar">
            <x-slot name="actions">
                <a href="{{ route('tahun-ajar.create') }}" class="btn-brand">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Tahun Ajar
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="space-y-6">
        <div class="card-surface rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Daftar Tahun Ajar</h3>
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total: {{ $tahunAjars->total() }}</span>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full table-soft divide-y divide-slate-100">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left">Kode</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($tahunAjars as $tahunAjar)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-4 py-3 font-semibold text-slate-800">{{ $tahunAjar->kode_tahun_ajar }}</td>
                                <td class="px-4 py-3 text-slate-800">{{ $tahunAjar->nama_tahun_ajar }}</td>
                                <td class="px-4 py-3 text-slate-800">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('tahun-ajar.show', $tahunAjar) }}" class="text-brand-600 hover:text-brand-700" title="Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('tahun-ajar.edit', $tahunAjar) }}" class="text-sky-600 hover:text-sky-700" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('tahun-ajar.destroy', $tahunAjar) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-700" onclick="return confirm('Hapus tahun ajar ini?')" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-slate-500">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $tahunAjars->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
