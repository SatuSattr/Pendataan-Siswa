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

    <div class="space-y-6" x-data="kelasListView()">
        <div class="card-surface rounded-2xl p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Daftar Kelas</h3>
                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total: {{ $kelas->total() }}</span>
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
                                <th class="px-4 py-3 text-left">Nama Kelas</th>
                                <th class="px-4 py-3 text-left">Level</th>
                                <th class="px-4 py-3 text-left">Jurusan</th>
                                <th class="px-4 py-3 text-left">Tahun Ajar</th>
                                <th class="px-4 py-3 text-left">Siswa Aktif</th>
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
                                        <span class="inline-flex min-w-[3ch] justify-start font-semibold text-slate-900">
                                            {{ $item->siswa_count ?? 0 }}
                                        </span>
                                    </td>
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
                                    <td colspan="6" class="px-4 py-6 text-center text-slate-500">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4" x-show="viewMode === 'card'" x-cloak>
                @if ($kelas->isEmpty())
                <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50/60 px-4 py-6 text-center text-sm text-slate-500">
                    Belum ada data.
                </div>
                @else
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($kelas as $item)
                    <div class="group rounded-xl border border-slate-200 bg-white p-4 shadow-sm ring-1 ring-transparent transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:ring-brand-100/70">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kelas</p>
                                <p class="mt-1 text-lg font-bold text-slate-900">{{ $item->nama_kelas }}</p>
                                <p class="text-sm text-slate-600">{{ $item->jurusan->nama_jurusan ?? '-' }}</p>
                            </div>
                            <span class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700 ring-1 ring-brand-100">
                                <i class="fa-solid fa-layer-group"></i> {{ $item->level_kelas }}
                            </span>
                        </div>
                        <div class="mt-3 flex flex-wrap gap-2 text-xs text-slate-600">
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1 ring-1 ring-slate-200">
                                <i class="fa-solid fa-calendar-days text-brand-600"></i> {{ $item->tahunAjar->kode_tahun_ajar ?? '-' }}
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1 ring-1 ring-slate-200">
                                <i class="fa-solid fa-users text-brand-600"></i> {{ $item->siswa_count ?? 0 }} siswa
                            </span>
                        </div>
                        <div class="mt-3 flex items-center gap-3 text-slate-600">
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
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="mt-4">
                {{ $kelas->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function kelasListView() {
                return {
                    viewMode: localStorage.getItem('kelasViewMode') || 'table',
                    setMode(mode) {
                        this.viewMode = mode;
                        localStorage.setItem('kelasViewMode', mode);
                    },
                };
            }
        </script>
    @endpush
</x-app-layout>
