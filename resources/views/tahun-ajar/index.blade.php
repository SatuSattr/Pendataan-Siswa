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

    <div class="space-y-6" x-data="tahunAjarList()">
        <div class="card-surface rounded-2xl p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Daftar Tahun Ajar</h3>
                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total: {{ $tahunAjars->total() }}</span>
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
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($tahunAjars as $tahunAjar)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-4 py-3 font-semibold text-slate-800">{{ $tahunAjar->kode_tahun_ajar }}</td>
                                    <td class="px-4 py-3 text-slate-800">{{ $tahunAjar->nama_tahun_ajar }}</td>
                                    <td class="px-4 py-3 text-slate-800">
                                        <button type="button"
                                            class="flex h-6 w-11 items-center rounded-full ring-1 transition"
                                            :class="states[{{ $tahunAjar->id }}] ? 'bg-green-500/80 ring-green-200' : 'bg-slate-200 ring-slate-300'"
                                            @click="toggle({{ $tahunAjar->id }}, '{{ route('tahun-ajar.toggle', $tahunAjar) }}')">
                                            <span class="sr-only">Toggle</span>
                                            <span class="inline-block h-5 w-5 rounded-full bg-white shadow transition"
                                                :class="states[{{ $tahunAjar->id }}] ? 'translate-x-5' : 'translate-x-0'"></span>
                                        </button>
                                    </td>
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
            </div>

            <div class="mt-4" x-show="viewMode === 'card'" x-cloak>
                @if ($tahunAjars->isEmpty())
                <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50/60 px-4 py-6 text-center text-sm text-slate-500">
                    Belum ada data.
                </div>
                @else
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($tahunAjars as $tahunAjar)
                    <div class="group rounded-xl border border-slate-200 bg-white p-4 shadow-sm ring-1 ring-transparent transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:ring-brand-100/70">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kode</p>
                                <p class="mt-1 text-lg font-bold text-slate-900">{{ $tahunAjar->kode_tahun_ajar }}</p>
                                <p class="text-sm text-slate-600">{{ $tahunAjar->nama_tahun_ajar }}</p>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center gap-3 text-slate-600">
                            <button type="button"
                                class="flex h-6 w-11 items-center rounded-full ring-1 transition"
                                :class="states[{{ $tahunAjar->id }}] ? 'bg-green-500/80 ring-green-200' : 'bg-slate-200 ring-slate-300'"
                                @click="toggle({{ $tahunAjar->id }}, '{{ route('tahun-ajar.toggle', $tahunAjar) }}')">
                                <span class="sr-only">Toggle</span>
                                <span class="inline-block h-5 w-5 rounded-full bg-white shadow transition"
                                    :class="states[{{ $tahunAjar->id }}] ? 'translate-x-5' : 'translate-x-0'"></span>
                            </button>
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
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="mt-4">
                {{ $tahunAjars->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function tahunAjarList() {
                return {
                    states: @json($tahunAjars->pluck('is_active', 'id')),
                    viewMode: localStorage.getItem('tahunAjarViewMode') || 'table',
                    setMode(mode) {
                        this.viewMode = mode;
                        localStorage.setItem('tahunAjarViewMode', mode);
                    },
                    toggle(id, url) {
                        const prev = { ...this.states };
                        const next = !this.states[id];
                        const activeCount = Object.values(this.states).filter(Boolean).length;

                        if (!next && activeCount <= 1) {
                            if (window.Swal) {
                                Swal.fire({
                                    toast: true,
                                    icon: 'error',
                                    title: 'Minimal satu tahun ajar harus aktif',
                                    position: 'top-end',
                                    timer: 2200,
                                    showConfirmButton: false,
                                    timerProgressBar: true,
                                });
                            }
                            return;
                        }

                        // Optimistic update: if turning on, set others off
                        Object.keys(this.states).forEach(key => { this.states[key] = false; });
                        this.states[id] = next;

                        fetch(url, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ is_active: next ? 1 : 0 }),
                        }).then((res) => res.ok ? res.json() : Promise.reject())
                            .catch(() => {
                                // revert on error
                                this.states = prev;
                            });
                    },
                };
            }
        </script>
    @endpush
</x-app-layout>
