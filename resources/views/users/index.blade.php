<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/users/index" title="Manajemen Pengguna">
            <x-slot name="actions">
                <button type="button" class="btn-brand" @click="$dispatch('open-user-add')">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Pengguna
                </button>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="space-y-6" x-data="usersList()" @open-user-add.window="openAddModal()">
        <div class="card-surface rounded-2xl p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Daftar Pengguna</h3>
                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total: {{ $users->total() }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-sm font-semibold transition"
                        :class="viewMode === 'table' ? 'bg-brand-50 text-brand-700 ring-1 ring-brand-100' : 'text-slate-500 hover:text-brand-600 ring-1 ring-transparent hover:ring-slate-200'"
                        @click="setMode('table')" title="Tampilan tabel">
                        <i class="fa-solid fa-table"></i>
                    </button>
                    <button type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-sm font-semibold transition"
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
                                <th class="px-4 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-left">Role</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($users as $user)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-4 py-3">
                                        <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-brand-600"
                                            x-model="selectedIds" value="{{ $user->id }}">
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-slate-800">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-slate-800">{{ $user->email }}</td>
                                    <td class="px-4 py-3 text-slate-800">
                                        <span class="px-2 py-1 rounded-full bg-slate-50 ring-1 ring-slate-200 text-xs font-semibold text-slate-700">{{ $user->role }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-800">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('users.show', $user) }}" class="text-brand-600 hover:text-brand-700" title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user) }}" class="text-sky-600 hover:text-sky-700" title="Edit"
                                                @click.prevent="openEditModal({
                                                    id: {{ $user->id }},
                                                    name: @js($user->name),
                                                    email: @js($user->email),
                                                    role: @js($user->role),
                                                })">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-700" onclick="return confirm('Hapus pengguna ini?')" title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-slate-500">Belum ada pengguna.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4" x-show="viewMode === 'card'" x-cloak>
                @if ($users->isEmpty())
                    <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50/60 px-4 py-6 text-center text-sm text-slate-500">
                        Belum ada pengguna.
                    </div>
                @else
                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach ($users as $user)
                            <div class="group relative rounded-xl border border-slate-200 bg-white p-4 shadow-sm ring-1 ring-transparent transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:ring-brand-100/70">
                                <div class="absolute right-3 top-3 z-10">
                                    <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-brand-600"
                                        x-model="selectedIds" value="{{ $user->id }}">
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Pengguna</p>
                                        <p class="mt-1 text-lg font-bold text-slate-900">{{ $user->name }}</p>
                                        <p class="text-sm text-slate-600">{{ $user->email }}</p>
                                    </div>
                                    <span class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700 ring-1 ring-brand-100">
                                        <i class="fa-solid fa-user-shield"></i> {{ $user->role }}
                                    </span>
                                </div>
                                <div class="mt-3 flex items-center gap-3 text-slate-600">
                                    <a href="{{ route('users.show', $user) }}" class="text-brand-600 hover:text-brand-700" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user) }}" class="text-sky-600 hover:text-sky-700" title="Edit"
                                        @click.prevent="openEditModal({
                                            id: {{ $user->id }},
                                            name: @js($user->name),
        email: @js($user->email),
        role: @js($user->role),
                                        })">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-700" onclick="return confirm('Hapus pengguna ini?')" title="Hapus">
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
                {{ $users->links() }}
            </div>
        </div>

        <template x-teleport="body">
            @include('users.partials.create-modal')
        </template>
        <template x-teleport="body">
            @include('users.partials.edit-modal')
        </template>

        <form x-ref="bulkForm" method="POST" action="{{ route('users.bulk') }}" class="hidden">
            @csrf
            <input type="hidden" name="action" :value="bulkAction">
            <input type="hidden" name="role" :value="bulkRole">
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
                        <option value="set_role">Set Role</option>
                    </select>
                    <div x-show="bulkAction === 'set_role'" class="flex items-center">
                        <select x-model="bulkRole"
                            class="rounded-full border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200 text-sm px-3 py-2 min-w-[160px]">
                            <option value="">Pilih role</option>
                            @foreach (['admin' => 'Admin', 'staff' => 'Staff'] as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
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
            function usersList() {
                const emptyForm = {
                    id: null,
                    name: '',
                    email: '',
                    role: 'admin',
                };

                return {
                    viewMode: localStorage.getItem('usersViewMode') || 'table',
                    showAddModal: false,
                    showEditModal: false,
                    bulkAction: '',
                    bulkRole: '',
                    selectedIds: [],
                    currentPageIds: @json($users->pluck('id')),
                    emptyForm,
                    editForm: { ...emptyForm },
                    updateActionBase: `{{ url('/users') }}`,
                    setMode(mode) {
                        this.viewMode = mode;
                        localStorage.setItem('usersViewMode', mode);
                    },
                    openAddModal() {
                        this.showAddModal = true;
                        this.$nextTick(() => this.$refs.addNameInput?.focus());
                    },
                    closeAddModal() {
                        this.showAddModal = false;
                        this.$nextTick(() => this.$refs.addFormEl?.reset());
                    },
                    openEditModal(data) {
                        this.editForm = { ...this.emptyForm, ...data };
                        this.showEditModal = true;
                        this.$nextTick(() => this.$refs.editNameInput?.focus());
                    },
                    closeEditModal() {
                        this.showEditModal = false;
                        setTimeout(() => {
                            this.editForm = { ...this.emptyForm };
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
                    submitBulk() {
                        if (this.selectedIds.length === 0 || !this.bulkAction) return;
                        if (this.bulkAction === 'set_role' && !this.bulkRole) return;
                        this.$refs.bulkForm.submit();
                    },
                    clearSelection() {
                        this.selectedIds = [];
                        this.bulkAction = '';
                        this.bulkRole = '';
                    },
                    get isAllCurrentPageSelected() {
                        return this.currentPageIds.length > 0 && this.currentPageIds.every((id) => this.selectedIds.includes(id));
                    },
                };
            }
        </script>
    @endpush
</x-app-layout>
