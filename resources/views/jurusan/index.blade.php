<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/jurusan/index" title="Data Jurusan">
            <x-slot name="actions">
                <a href="{{ route('jurusan.create') }}" class="btn-brand">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Jurusan
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="space-y-6">
        <div class="card-surface rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Daftar Jurusan</h3>
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total: {{ $jurusans->total() }}</span>
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
                        @forelse ($jurusans as $jurusan)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-4 py-3 font-semibold text-slate-800">{{ $jurusan->kode_jurusan }}</td>
                                <td class="px-4 py-3 text-slate-800">{{ $jurusan->nama_jurusan }}</td>
                                <td class="px-4 py-3 text-slate-800">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('jurusan.show', $jurusan) }}" class="text-brand-600 hover:text-brand-700" title="Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('jurusan.edit', $jurusan) }}" class="text-sky-600 hover:text-sky-700" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('jurusan.destroy', $jurusan) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-700" onclick="return confirm('Hapus jurusan ini?')" title="Hapus">
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
                {{ $jurusans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
