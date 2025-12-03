<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/tahun-ajar/index" title="Data Tahun Ajar">
            <x-slot name="actions">
                <button type="button" class="btn-brand" @click="$dispatch('open-add-modal')">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Tahun Ajar
                </button>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="space-y-6" x-data="tahunAjarList()" @open-add-modal.window="openAddModal()">
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
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($tahunAjars as $tahunAjar)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-4 py-3">
                                        <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-brand-600"
                                            x-model="selectedIds" value="{{ $tahunAjar->id }}">
                                    </td>
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
                                            <a href="{{ route('tahun-ajar.edit', $tahunAjar) }}" class="text-sky-600 hover:text-sky-700" title="Edit"
                                                @click.prevent="openEditModal({
                                                    id: {{ $tahunAjar->id }},
                                                    kode_tahun_ajar: @js($tahunAjar->kode_tahun_ajar),
                                                    nama_tahun_ajar: @js($tahunAjar->nama_tahun_ajar),
                                                })">
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
                    <div class="group relative rounded-xl border border-slate-200 bg-white p-4 shadow-sm ring-1 ring-transparent transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:ring-brand-100/70">
                        <div class="absolute right-3 top-3 z-10">
                            <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-brand-600"
                                x-model="selectedIds" value="{{ $tahunAjar->id }}">
                        </div>
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
                            <a href="{{ route('tahun-ajar.edit', $tahunAjar) }}" class="text-sky-600 hover:text-sky-700" title="Edit"
                                @click.prevent="openEditModal({
                                    id: {{ $tahunAjar->id }},
                                    kode_tahun_ajar: @js($tahunAjar->kode_tahun_ajar),
                                    nama_tahun_ajar: @js($tahunAjar->nama_tahun_ajar),
                                })">
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

        <template x-teleport="body">
            @include('tahun-ajar.partials.create-modal')
        </template>
        <template x-teleport="body">
            @include('tahun-ajar.partials.edit-modal')
        </template>
        <form x-ref="bulkForm" method="POST" action="{{ route('tahun-ajar.bulk') }}" class="hidden">
            @csrf
            <input type="hidden" name="action" :value="bulkAction">
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
                        @click="submitBulk()">
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
            function tahunAjarList() {
                const emptyForm = {
                    id: null,
                    kode_tahun_ajar: '',
                    nama_tahun_ajar: '',
                };

                return {
                    states: @json($tahunAjars->pluck('is_active', 'id')),
                    viewMode: localStorage.getItem('tahunAjarViewMode') || 'table',
                    showAddModal: false,
                    showEditModal: false,
                    bulkAction: 'delete',
                    selectedIds: [],
                    currentPageIds: @json($tahunAjars->pluck('id')),
                    emptyForm,
                    editForm: { ...emptyForm },
                    updateActionBase: `{{ url('/tahun-ajar') }}`,
                    setMode(mode) {
                        this.viewMode = mode;
                        localStorage.setItem('tahunAjarViewMode', mode);
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
                    submitBulk() {
                        if (this.selectedIds.length === 0 || !this.bulkAction) return;
                        this.$refs.bulkForm.submit();
                    },
                    clearSelection() {
                        this.selectedIds = [];
                        this.bulkAction = 'delete';
                    },
                    get isAllCurrentPageSelected() {
                        return this.currentPageIds.length > 0 && this.currentPageIds.every((id) => this.selectedIds.includes(id));
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
                            this.editForm = { ...this.emptyForm };
                        }, 200);
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
                                this.states = prev;
                            });
                    },
                };
            }
        </script>
    @endpush
</x-app-layout>
