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

    <div class="space-y-6" x-data="jurusanListView()">
        <div class="card-surface rounded-2xl p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Daftar Jurusan</h3>
                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total: {{ $jurusans->total() }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-sm font-semibold transition"
                        :class="viewMode === 'table' ? 'bg-brand-50 text-brand-700 ring-1 ring-brand-100' : 'text-slate-500 hover:text-brand-600 ring-1 ring-transparent hover:ring-slate-200'"
                        @click="setMode('table')" title="Tampilan tabel">
                        <i class="fa-solid fa-table"></i>
                    </button>
                    <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-sm font-semibold transition"
                        :class="viewMode === 'card' ? 'bg-brand-50 text-brand-700 ring-1 ring-brand-100' : 'text-slate-500 hover:text-brand-600 ring-1 ring-transparent hover:ring-slate-200'"
                        @click="setMode('card')" title="Tampilan kartu">
                        <i class="fa-solid fa-grip"></i>
                    </button>
                </div>
            </div>

            <div class="mt-4" x-show="viewMode === 'table'" x-cloak>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-soft divide-y divide-slate-100">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left">Kode</th>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">Jumlah Kelas</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($jurusans as $jurusan)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-4 py-3 font-semibold text-slate-800">{{ $jurusan->kode_jurusan }}</td>
                                <td class="px-4 py-3 text-slate-800">{{ $jurusan->nama_jurusan }}</td>
                                <td class="px-4 py-3 text-slate-800">
                                    <span class="inline-flex min-w-[3ch] justify-start font-semibold text-slate-900">
                                        {{ $jurusan->kelas_count ?? 0 }}
                                    </span>
                                </td>
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
                                <td colspan="4" class="px-4 py-6 text-center text-slate-500">Belum ada data.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4" x-show="viewMode === 'card'" x-cloak>
                @if ($jurusans->isEmpty())
                <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50/60 px-4 py-6 text-center text-sm text-slate-500">
                    Belum ada data.
                </div>
                @else
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($jurusans as $jurusan)
                    <div class="group rounded-xl border border-slate-200 bg-white p-4 shadow-sm ring-1 ring-transparent transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:ring-brand-100/70">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kode</p>
                                <p class="mt-1 text-lg font-bold text-slate-900">{{ $jurusan->kode_jurusan }}</p>
                                <p class="text-sm text-slate-600">{{ $jurusan->nama_jurusan }}</p>
                            </div>
                            <span class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700 ring-1 ring-brand-100">
                                <i class="fa-solid fa-layer-group"></i> {{ $jurusan->kelas_count ?? 0 }} kelas
                            </span>
                        </div>
                        <div class="mt-3 flex items-center gap-3 text-slate-600">
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
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="mt-4">
                {{ $jurusans->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function jurusanListView() {
                return {
                    viewMode: localStorage.getItem('jurusanViewMode') || 'table',
                    setMode(mode) {
                        this.viewMode = mode;
                        localStorage.setItem('jurusanViewMode', mode);
                    },
                };
            }
        </script>
    @endpush
</x-app-layout>
