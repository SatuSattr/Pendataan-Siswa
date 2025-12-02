<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/kelas/index" title="Data Kelas">
            <x-slot name="actions">
                <a href="{{ route('kelas.create') }}" class="btn-brand">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Kelas
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="space-y-6">
        <div class="card-surface rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Daftar Kelas</h3>
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total: {{ $kelas->total() }}</span>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full table-soft divide-y divide-slate-100">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left">Nama Kelas</th>
                            <th class="px-4 py-3 text-left">Level</th>
                            <th class="px-4 py-3 text-left">Jurusan</th>
                            <th class="px-4 py-3 text-left">Tahun Ajar</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($kelas as $item)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-4 py-3 font-semibold text-slate-800">{{ $item->nama_kelas }}</td>
                                <td class="px-4 py-3 text-slate-800">{{ $item->level_kelas }}</td>
                                <td class="px-4 py-3 text-slate-800">{{ $item->jurusan->nama_jurusan ?? '-' }}</td>
                                <td class="px-4 py-3 text-slate-800">{{ $item->tahunAjar->kode_tahun_ajar ?? '-' }}</td>
                                <td class="px-4 py-3 text-slate-800">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('kelas.show', $item) }}" class="text-brand-600 hover:text-brand-700" title="Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('kelas.edit', $item) }}" class="text-sky-600 hover:text-sky-700" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('kelas.destroy', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-700" onclick="return confirm('Hapus kelas ini?')" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-slate-500">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $kelas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
