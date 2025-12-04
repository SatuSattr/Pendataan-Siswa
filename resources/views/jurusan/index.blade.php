<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/jurusan/index" title="Data Jurusan">
            <x-slot name="actions">
                <button type="button" class="btn-brand" @click="$dispatch('open-add-modal')">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Jurusan
                </button>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="space-y-6" x-data="jurusanListView()" @open-add-modal.window="openAddModal()">
        <div class="card-surface rounded-2xl p-6">
            <form method="GET" action="{{ route('jurusan.index') }}"
                class="flex flex-col gap-4 md:flex-row md:flex-wrap md:items-end">
                <div class="md:flex-1 min-w-[260px]">
                    <label class="block text-sm font-semibold text-slate-700">Cari kode atau nama jurusan</label>
                    <div
                        class="mt-2 flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-3 pr-0 text-slate-800 shadow-sm focus-within:border-brand-400 focus-within:ring-2 focus-within:ring-brand-100">
                        <input type="text" name="search" value="{{ $search }}"
                            class="flex-1 border-0 bg-transparent py-2 text-sm focus:outline-none focus:ring-0 focus:ring-offset-0 focus-visible:ring-0 focus-visible:ring-offset-0"
                            placeholder="Cari...">
                        <a href="{{ route('jurusan.index') }}"
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
                    <h3 class="text-lg font-semibold text-slate-900">Daftar Jurusan</h3>
                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total:
                        {{ $jurusans->total() }}</span>
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
                                <th class="px-4 py-3 text-left">Kode</th>
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">Jumlah Kelas</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($jurusans as $jurusan)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-4 py-3">
                                        <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-brand-600"
                                            x-model="selectedIds" value="{{ $jurusan->id }}">
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-slate-800">{{ $jurusan->kode_jurusan }}</td>
                                    <td class="px-4 py-3 text-slate-800">{{ $jurusan->nama_jurusan }}</td>
                                    <td class="px-4 py-3 text-slate-800">
                                        <span
                                            class="inline-flex min-w-[3ch] justify-start font-semibold text-slate-900">
                                            {{ $jurusan->kelas_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-800">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('jurusan.show', $jurusan) }}"
                                                class="text-brand-600 hover:text-brand-700" title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('jurusan.edit', $jurusan) }}"
                                                class="text-sky-600 hover:text-sky-700" title="Edit"
                                                @click.prevent="openEditModal({
                                                id: {{ $jurusan->id }},
                                                kode_jurusan: @js($jurusan->kode_jurusan),
                                                nama_jurusan: @js($jurusan->nama_jurusan),
                                            })">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('jurusan.destroy', $jurusan) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-700"
                                                    onclick="return confirm('Hapus jurusan ini?')" title="Hapus">
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
                    <div
                        class="rounded-xl border border-dashed border-slate-200 bg-slate-50/60 px-4 py-6 text-center text-sm text-slate-500">
                        Belum ada data.
                    </div>
                @else
                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach ($jurusans as $jurusan)
                            <div
                                class="group relative rounded-xl border border-slate-200 bg-white p-4 shadow-sm ring-1 ring-transparent transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:ring-brand-100/70">
                                <div class="absolute right-3 top-3">
                                    <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-brand-600"
                                        x-model="selectedIds" value="{{ $jurusan->id }}">
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kode</p>
                                        <p class="mt-1 text-lg font-bold text-slate-900">{{ $jurusan->kode_jurusan }}
                                        </p>
                                        <p class="text-sm text-slate-600">{{ $jurusan->nama_jurusan }}</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700 ring-1 ring-brand-100">
                                        <i class="fa-solid fa-layer-group"></i> {{ $jurusan->kelas_count ?? 0 }} kelas
                                    </span>
                                </div>
                                <div class="mt-3 flex items-center gap-3 text-slate-600">
                                    <a href="{{ route('jurusan.show', $jurusan) }}"
                                        class="text-brand-600 hover:text-brand-700" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('jurusan.edit', $jurusan) }}"
                                        class="text-sky-600 hover:text-sky-700" title="Edit"
                                        @click.prevent="openEditModal({
                                    id: {{ $jurusan->id }},
                                    kode_jurusan: @js($jurusan->kode_jurusan),
                                    nama_jurusan: @js($jurusan->nama_jurusan),
                                })">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('jurusan.destroy', $jurusan) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-700"
                                            onclick="return confirm('Hapus jurusan ini?')" title="Hapus">
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

        <template x-teleport="body">
            @include('jurusan.partials.create-modal')
        </template>
        <template x-teleport="body">
            @include('jurusan.partials.edit-modal')
        </template>
        <form x-ref="bulkForm" method="POST" action="{{ route('jurusan.bulk') }}" class="hidden">
            @csrf
            <input type="hidden" name="action" x-ref="bulkActionInput" :value="bulkAction">
            <template x-for="id in selectedIds" :key="id">
                <input type="hidden" name="ids[]" :value="id">
            </template>
        </form>

        <template x-teleport="body">
            <div x-cloak x-show="selectedIds.length > 0"
                class="fixed inset-x-0 bottom-6 z-[95] flex justify-center px-4">
                <div class="flex items-center gap-3 rounded-full bg-white px-4 py-3 shadow-2xl ring-1 ring-slate-200">
                    <span class="text-sm font-semibold text-slate-700">
                        <i class="fa-solid fa-check-double text-brand-600 mr-2"></i>
                        <span x-text="selectedIds.length"></span> dipilih
                    </span>
                    <button type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-rose-50 text-rose-600 ring-1 ring-rose-100 hover:bg-rose-100"
                        title="Hapus terpilih"
                        @click="submitBulk('delete')">
                        <i class="fa-solid fa-trash"></i>
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
            function jurusanListView() {
                const emptyForm = {
                    id: null,
                    kode_jurusan: '',
                    nama_jurusan: '',
                };

                return {
                    viewMode: localStorage.getItem('jurusanViewMode') || 'table',
                    showAddModal: false,
                    showEditModal: false,
                    bulkAction: '',
                    selectedIds: [],
                    currentPageIds: @json($jurusans->pluck('id')),
                    emptyForm,
                    editForm: {
                        ...emptyForm,
                    },
                    updateActionBase: `{{ url('/jurusan') }}`,
                    setMode(mode) {
                        this.viewMode = mode;
                        localStorage.setItem('jurusanViewMode', mode);
                    },
                    openAddModal() {
                        this.showAddModal = true;
                        this.$nextTick(() => this.$refs.addKodeInput?.focus());
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
                        this.$nextTick(() => this.$refs.editKodeInput?.focus());
                    },
                    closeEditModal() {
                        this.showEditModal = false;
                        setTimeout(() => {
                            this.editForm = {
                                ...this.emptyForm
                            };
                        }, 200);
                    },
                    clearSelection() {
                        this.selectedIds = [];
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
                    submitBulk(action) {
                        if (!action || this.selectedIds.length === 0) return;
                        if (this.$refs.bulkActionInput) {
                            this.$refs.bulkActionInput.value = action;
                        }
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
