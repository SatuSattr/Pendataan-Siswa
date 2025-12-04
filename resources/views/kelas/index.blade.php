<x-app-layout>
    <div x-data="kelasListView()" @open-add-modal.window="openAddModal()" class="space-y-6">
        <x-slot name="header">
            <x-page-header path="/kelas/index" title="Data Kelas">
                <x-slot name="actions">
                    <button type="button" class="btn-brand" @click="$dispatch('open-add-modal')">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Kelas
                    </button>
                </x-slot>
            </x-page-header>
        </x-slot>
        <div class="card-surface rounded-2xl p-6">
            <form method="GET" action="{{ route('kelas.index') }}"
                class="flex flex-col gap-4 md:flex-row md:flex-wrap md:items-end">
                <div class="md:flex-1 min-w-[260px]">
                    <label class="block text-sm font-semibold text-slate-700">Cari nama atau level kelas</label>
                    <div
                        class="mt-2 flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-3 pr-0 text-slate-800 shadow-sm focus-within:border-brand-400 focus-within:ring-2 focus-within:ring-brand-100">
                        <input type="text" name="search" value="{{ $search }}"
                            class="flex-1 border-0 bg-transparent py-2 text-sm focus:outline-none focus:ring-0 focus:ring-offset-0 focus-visible:ring-0 focus-visible:ring-offset-0"
                            placeholder="Cari...">
                        <a href="{{ route('kelas.index') }}"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-slate-500 hover:text-brand-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-400"
                            title="Reset">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                        <button type="submit"
                            class="btn-brand inline-flex h-10 w-10 items-center justify-center shadow-none"
                            title="Cari">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-surface rounded-2xl p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Daftar Kelas</h3>
                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total:
                        {{ $kelas->total() }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-sm font-semibold transition"
                        :class="viewMode === 'table' ? 'bg-brand-50 text-brand-700 ring-1 ring-brand-100' :
                            'text-slate-500 hover:text-brand-600 ring-1 ring-transparent hover:ring-slate-200'"
                        @click="setMode('table')" title="Tampilan tabel">
                        <i class="fa-solid fa-table"></i>
                    </button>
                    <button type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-sm font-semibold transition"
                        :class="viewMode === 'card' ? 'bg-brand-50 text-brand-700 ring-1 ring-brand-100' :
                            'text-slate-500 hover:text-brand-600 ring-1 ring-transparent hover:ring-slate-200'"
                        @click="setMode('card')" title="Tampilan kartu">
                        <i class="fa-solid fa-grip"></i>
                    </button>
                </div>
            </div>

            <div class="mt-4 flex flex-col gap-3" x-show="viewMode === 'table'" x-cloak>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-soft divide-y divide-slate-100">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left w-12">
                                    <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-brand-600"
                                        :checked="isAllCurrentPageSelected"
                                        @change="toggleSelectAll($event)">
                                </th>
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
                                    <td class="px-4 py-3">
                                        <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-brand-600"
                                            x-model="selectedIds" value="{{ $item->id }}">
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-slate-800">{{ $item->nama_kelas }}</td>
                                    <td class="px-4 py-3 text-slate-800">{{ $item->level_kelas }}</td>
                                    <td class="px-4 py-3 text-slate-800">{{ $item->jurusan->nama_jurusan ?? '-' }}</td>
                                    <td class="px-4 py-3 text-slate-800">{{ $item->tahunAjar->kode_tahun_ajar ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-800">
                                        <span
                                            class="inline-flex min-w-[3ch] justify-start font-semibold text-slate-900">
                                            {{ $item->siswa_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-800">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('kelas.show', $item) }}"
                                                class="text-brand-600 hover:text-brand-700" title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('kelas.edit', $item) }}"
                                                class="text-sky-600 hover:text-sky-700" title="Edit"
                                                @click.prevent="openEditModal({
                                                    id: {{ $item->id }},
                                                    nama_kelas: @js($item->nama_kelas),
                                                    level_kelas: @js($item->level_kelas),
                                                    jurusan_id: {{ $item->jurusan_id ?? 'null' }},
                                                    tahun_ajar_id: {{ $item->tahun_ajar_id ?? 'null' }},
                                                })">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('kelas.destroy', $item) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-700"
                                                    onclick="return confirm('Hapus kelas ini?')" title="Hapus">
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
                    <div
                        class="rounded-xl border border-dashed border-slate-200 bg-slate-50/60 px-4 py-6 text-center text-sm text-slate-500">
                        Belum ada data.
                    </div>
                @else
                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach ($kelas as $item)
                            <div
                                class="group relative rounded-xl border border-slate-200 bg-white p-4 shadow-sm ring-1 ring-transparent transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:ring-brand-100/70">
                                <div class="absolute right-3 top-3">
                                    <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-brand-600"
                                        x-model="selectedIds" value="{{ $item->id }}">
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kelas
                                        </p>
                                        <p class="mt-1 text-lg font-bold text-slate-900">{{ $item->nama_kelas }}</p>
                                        <p class="text-sm text-slate-600">{{ $item->jurusan->nama_jurusan ?? '-' }}</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700 ring-1 ring-brand-100">
                                        <i class="fa-solid fa-layer-group"></i> {{ $item->level_kelas }}
                                    </span>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2 text-xs text-slate-600">
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1 ring-1 ring-slate-200">
                                        <i class="fa-solid fa-calendar-days text-brand-600"></i>
                                        {{ $item->tahunAjar->kode_tahun_ajar ?? '-' }}
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1 ring-1 ring-slate-200">
                                        <i class="fa-solid fa-users text-brand-600"></i> {{ $item->siswa_count ?? 0 }}
                                        siswa
                                    </span>
                                </div>
                                <div class="mt-3 flex items-center gap-3 text-slate-600">
                                    <a href="{{ route('kelas.show', $item) }}"
                                        class="text-brand-600 hover:text-brand-700" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kelas.edit', $item) }}" class="text-sky-600 hover:text-sky-700"
                                        title="Edit"
                                        @click.prevent="openEditModal({
                                    id: {{ $item->id }},
                                    nama_kelas: @js($item->nama_kelas),
                                    level_kelas: @js($item->level_kelas),
                                    jurusan_id: {{ $item->jurusan_id ?? 'null' }},
                                    tahun_ajar_id: {{ $item->tahun_ajar_id ?? 'null' }},
                                })">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('kelas.destroy', $item) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-700"
                                            onclick="return confirm('Hapus kelas ini?')" title="Hapus">
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

        <template x-teleport="body">
            @include('kelas.partials.create-modal')
        </template>
        <template x-teleport="body">
            @include('kelas.partials.edit-modal')
        </template>

        <form x-ref="bulkForm" method="POST" action="{{ route('kelas.bulk') }}" class="hidden">
            @csrf
            <input type="hidden" name="action" :value="bulkAction">
            <input type="hidden" name="jurusan_id" :value="bulkJurusanId">
            <input type="hidden" name="level_kelas" :value="bulkLevel">
            <input type="hidden" name="tahun_ajar_id" :value="bulkTahunAjarId">
            <template x-for="id in selectedIds" :key="id">
                <input type="hidden" name="ids[]" :value="id">
            </template>
        </form>

        <template x-teleport="body">
            <div x-cloak x-show="selectedIds.length > 0"
                class="fixed inset-x-0 bottom-6 z-[95] flex justify-center px-4">
                <div class="flex flex-wrap items-center gap-3 rounded-full bg-white px-4 py-3 shadow-2xl ring-1 ring-slate-200">
                    <span class="text-sm font-semibold text-slate-700">
                        <i class="fa-solid fa-check-double text-brand-600 mr-2"></i>
                        <span x-text="selectedIds.length"></span> dipilih
                    </span>
                    <select x-model="bulkAction"
                        class="rounded-full border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200 text-sm px-3 py-2 min-w-[150px]">
                        <option value="">Pilih aksi</option>
                        <option value="delete">Hapus</option>
                        <option value="set_jurusan">Set Jurusan</option>
                        <option value="set_level">Set Level</option>
                        <option value="set_tahun_ajar">Set Tahun Ajar</option>
                    </select>
                    <div x-show="bulkAction === 'set_jurusan'" class="flex items-center">
                        <select x-model="bulkJurusanId"
                            class="rounded-full border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200 text-sm px-3 py-2 min-w-[160px]">
                            <option value="">Pilih jurusan</option>
                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div x-show="bulkAction === 'set_level'" class="flex items-center">
                        <select x-model="bulkLevel"
                            class="rounded-full border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200 text-sm px-3 py-2 min-w-[140px]">
                            <option value="">Pilih level</option>
                            @foreach (['X', 'XI', 'XII'] as $level)
                                <option value="{{ $level }}">{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div x-show="bulkAction === 'set_tahun_ajar'" class="flex items-center">
                        <select x-model="bulkTahunAjarId"
                            class="rounded-full border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200 text-sm px-3 py-2 min-w-[160px]">
                            <option value="">Pilih tahun ajar</option>
                            @foreach ($tahunAjars as $tahunAjar)
                                <option value="{{ $tahunAjar->id }}">{{ $tahunAjar->kode_tahun_ajar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button"
                        class="inline-flex h-10 items-center gap-2 rounded-full bg-brand-600 px-4 text-sm font-semibold text-white shadow hover:bg-brand-700"
                        @click="submitBulk()">
                        <i class="fa-solid fa-play"></i> Jalankan
                    </button>
                    <button type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-50 text-slate-500 ring-1 ring-slate-200 hover:bg-slate-100"
                        title="Batalkan pilihan"
                        @click="clearSelection()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        </template>
    </div>

    @push('scripts')
        <script>
            function kelasListView() {
                const emptyForm = {
                    id: null,
                    nama_kelas: '',
                    level_kelas: '',
                    jurusan_id: '',
                    tahun_ajar_id: '',
                };

                return {
                    viewMode: localStorage.getItem('kelasViewMode') || 'table',
                    showAddModal: false,
                    showEditModal: false,
                    bulkAction: '',
                    bulkJurusanId: '',
                    bulkLevel: '',
                    bulkTahunAjarId: '',
                    selectedIds: [],
                    currentPageIds: @json($kelas->pluck('id')),
                    emptyForm,
                    editForm: {
                        ...emptyForm,
                    },
                    updateActionBase: `{{ url('/kelas') }}`,
                    setMode(mode) {
                        this.viewMode = mode;
                        localStorage.setItem('kelasViewMode', mode);
                    },
                    openAddModal() {
                        this.showAddModal = true;
                        this.$nextTick(() => this.$refs.addNamaKelasInput?.focus());
                    },
                    closeAddModal() {
                        this.showAddModal = false;
                        this.$nextTick(() => {
                            this.$refs.addFormEl?.reset();
                        });
                    },
                    openEditModal(data) {
                        this.editForm = {
                            ...this.emptyForm,
                            ...data,
                        };
                        this.showEditModal = true;
                        this.$nextTick(() => this.$refs.editNamaInput?.focus());
                    },
                    closeEditModal() {
                        this.showEditModal = false;
                        setTimeout(() => {
                            this.editForm = {
                                ...this.emptyForm
                            };
                        }, 200);
                    },
                    toggleSelectAll(event) {
                        const checked = event?.target?.checked;
                        if (checked) {
                            this.currentPageIds.forEach((id) => {
                                if (!this.selectedIds.includes(id)) {
                                    this.selectedIds.push(id);
                                }
                            });
                        } else {
                            this.selectedIds = this.selectedIds.filter(id => !this.currentPageIds.includes(id));
                        }
                    },
                    clearSelection() {
                        this.selectedIds = [];
                        this.bulkAction = '';
                        this.bulkJurusanId = '';
                        this.bulkLevel = '';
                        this.bulkTahunAjarId = '';
                    },
                    submitBulk() {
                        if (this.selectedIds.length === 0 || !this.bulkAction) return;
                        if (this.bulkAction === 'set_jurusan' && !this.bulkJurusanId) return;
                        if (this.bulkAction === 'set_level' && !this.bulkLevel) return;
                        if (this.bulkAction === 'set_tahun_ajar' && !this.bulkTahunAjarId) return;
                        this.$refs.bulkForm.submit();
                    },
                    get isAllCurrentPageSelected() {
                        return this.currentPageIds.length > 0 && this.currentPageIds.every((id) => this.selectedIds.includes(id));
                    },
                };
            }
        </script>
    @endpush
</x-app-layout>
